"use strict";(self.__LOADABLE_LOADED_CHUNKS__=self.__LOADABLE_LOADED_CHUNKS__||[]).push([[1512],{74055:function(e,t,a){a.r(t),a.d(t,{default:function(){return O}});var l=a(67294),i=a(69931),m=a.n(i),n=a(34163),r=a(1072),c=a(8545),s=a(87332),g=a(93948),u=a(98225),o=a(2517),I=a(72356),d=a(38602),h=a(84894),E="ImageWithTextItem-accentColor--3tWZP",T="ImageWithTextItem-content--5jwMO",p="ImageWithTextItem-hasAccentColor--1Ics0",x="ImageWithTextItem-image--5T4vg",W="ImageWithTextItem-text--1Ppin";const y=Object.freeze({HORIZONTAL:"Horizontal",VERTICAL:"Vertical"}),f=Object.freeze({LARGE:"Large",MEDIUM:"Medium"}),v=Object.freeze({LOW:"50%",MEDIUM:"75%",HIGH:"100%"}),L=e=>{const{accentColor:t,description:a,eyebrow:i,buttons:c,imageQuality:s,imageSize:L,largeImage:N,largeImageQualityMedium:A,largeImageQualityHigh:O,mediumImage:b,mediumImageQualityMedium:H,mediumImageQualityHigh:M,title:C,hasLargeTitle:_,layout:D,flipImageAndText:Q,seoTitleTag:R,enteredOnce:U,noAppear:Z,onRef:j}=e,k=R||"h2",w=D===y.HORIZONTAL,z=L===f.LARGE,G=(0,u.H)(t),B=m()({[h.h1]:_,[h.h2]:!_},"ImageWithTextItem-title--1vW7M"),P=m()(h.d1,{"ImageWithTextItem-hasButtons--6EwQw":c}),S=m()(h.jT,"ImageWithTextItem-eyebrow--1qTvt"),V=m()("ImageWithTextItem-contentWrapper--80M5B",{"ImageWithTextItem-layoutHorizontal--4uEqu":w,"ImageWithTextItem-layoutVertical--5sOeH":!w,"ImageWithTextItem-hasRoundedCorners--TuYDr":!w&&!!G,"ImageWithTextItem-flipImageAndText--329yL":Q,enteredOnce:U,noAppear:Z}),q=m()(T,{"ImageWithTextItem-imageLeft--2gRQj":w&&!Q,"ImageWithTextItem-imageRight--GCa9V":w&&Q,[p]:!!G,"ImageWithTextItem-hasLargeImage--2bx4D":z||!1}),K=m()(T,{[p]:!!G}),F=()=>l.createElement("div",null,i&&l.createElement("div",{className:S},i),C&&l.createElement(k,{className:B},C),a&&l.createElement(d.default,{extraClassName:P,body:a}),c&&l.createElement("div",{className:"ImageWithTextItem-buttons--rpc4j"},c.map(((e,t)=>{var a;return l.createElement(n.Experience,{key:e.text,text:e.text,link:(null===(a=e.longURL)||void 0===a?void 0:a.longURL)||e.url,stageUrl:e.stageUrl,intent:t%2?"primary":"tertiary",component:o.Z,experiences:(0,r.u)(e.experiences),id:e.contentful_id})})))),J=(e,t,a)=>{if(!e&&!t&&!a)return null;let i;switch(s){case v.HIGH:i=l.createElement(I.Z,{image:a,src:e.file.url,alt:a.description});break;case v.MEDIUM:i=l.createElement(I.Z,{image:t,src:e.file.url,alt:t.description});break;default:i=l.createElement(I.Z,{image:e,src:e.file.url,alt:e.description})}return i};return l.createElement("div",{ref:j,className:V},l.createElement(g.rp,null,l.createElement("div",{className:K},l.createElement("div",{className:x},J(b,H,M),D&&l.createElement("span",{className:E,style:{backgroundColor:G}})),l.createElement("div",{className:W,style:{backgroundColor:G}},F()))),l.createElement(g.hd,null,l.createElement(l.Fragment,null,l.createElement("div",{className:q},l.createElement("div",{className:x},!0===z?J(N,A,O):J(b,H,M)),l.createElement("div",{className:W},F())),l.createElement("span",{className:E,style:{backgroundColor:G}}))))};L.defaultProps={accentColor:{},buttons:null,description:null,eyebrow:null,flipImageAndText:!1,hasLargeTitle:!1,imageQuality:v.LOW,imageSize:f.MEDIUM,largeImage:null,largeImageQualityMedium:null,largeImageQualityHigh:null,layout:null,mediumImage:null,mediumImageQualityMedium:null,mediumImageQualityHigh:null,seoTitleTag:"h2",title:null};var N=(0,s.Z)()(L);const A=e=>{const{description:t,enteredOnce:a,imageWithTextElements:i,noAppear:s,onRef:g,title:u,seoTitleTag:o,layout:I}=e,d=o||"h1",E=m()("ImageWithText-imageWithText--7gjpJ",{enteredOnce:a,noAppear:s}),T=m()("ImageWithText-description--4inXI",h.d1),p=m()({"ImageWithText-headerClass--4lgAn":u||t});return l.createElement(c.Z,{ref:g},l.createElement("div",{className:E},(u||t)&&l.createElement("div",{className:p},u&&l.createElement(d,{className:h.h1},u),t&&l.createElement("div",{className:T},t.description)),i&&l.createElement("div",{className:"ImageWithText-imageWithTextElements--6LbG7"},i.map((e=>l.createElement(n.Experience,Object.assign({key:e.title},e,{layout:I,component:N,experiences:(0,r.u)(e.experiences),id:e.contentful_id})))))))};A.defaultProps={description:null,imageWithTextElements:null,layout:null,seoTitleTag:"h1",title:null};var O=(0,s.Z)()(A)}}]);