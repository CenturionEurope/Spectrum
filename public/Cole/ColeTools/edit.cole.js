/*
	ColeTools
	(c) Peter Day 2018	
*/


// Create Base64 Object
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

// Load Swal2
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.Sweetalert2=t()}(this,function(){"use strict";var e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")},n=function(){function e(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(t,n,o){return n&&e(t.prototype,n),o&&e(t,o),t}}(),o=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e[o]=n[o])}return e},r=function e(t,n,o){null===t&&(t=Function.prototype);var r=Object.getOwnPropertyDescriptor(t,n);if(void 0===r){var i=Object.getPrototypeOf(t);return null===i?void 0:e(i,n,o)}if("value"in r)return r.value;var a=r.get;return void 0!==a?a.call(o):void 0},i=function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)},a=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t},s=function(e,t){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return function(e,t){var n=[],o=!0,r=!1,i=void 0;try{for(var a,s=e[Symbol.iterator]();!(o=(a=s.next()).done)&&(n.push(a.value),!t||n.length!==t);o=!0);}catch(e){r=!0,i=e}finally{try{!o&&s.return&&s.return()}finally{if(r)throw i}}return n}(e,t);throw new TypeError("Invalid attempt to destructure non-iterable instance")},u="SweetAlert2:",l=function(e){var t=[];return e instanceof Map?e.forEach(function(e,n){t.push([n,e])}):Object.keys(e).forEach(function(n){t.push([n,e[n]])}),t},c=function(e){console.warn(u+" "+e)},d=function(e){console.error(u+" "+e)},p=[],f=function(e){-1===p.indexOf(e)&&(p.push(e),c(e))},m=function(e){return"function"==typeof e?e():e},h=function(t){return"object"===(void 0===t?"undefined":e(t))&&"function"==typeof t.then},v=Object.freeze({cancel:"cancel",backdrop:"overlay",close:"close",esc:"esc",timer:"timer"}),b=function(e){var t={};for(var n in e)t[e[n]]="swal2-"+e[n];return t},g=b(["container","shown","iosfix","popup","modal","no-backdrop","toast","toast-shown","fade","show","hide","noanimation","close","title","header","content","actions","confirm","cancel","footer","icon","icon-text","image","input","has-input","file","range","select","radio","checkbox","textarea","inputerror","validationerror","progresssteps","activeprogressstep","progresscircle","progressline","loading","styled","top","top-start","top-end","top-left","top-right","center","center-start","center-end","center-left","center-right","bottom","bottom-start","bottom-end","bottom-left","bottom-right","grow-row","grow-column","grow-fullscreen"]),y=b(["success","warning","info","question","error"]),w={previousActiveElement:null,previousBodyPadding:null},C=function(e,t){return!!e.classList&&e.classList.contains(t)},x=function(e){if(e.focus(),"file"!==e.type){var t=e.value;e.value="",e.value=t}},k=function(e,t,n){e&&t&&("string"==typeof t&&(t=t.split(/\s+/).filter(Boolean)),t.forEach(function(t){e.forEach?e.forEach(function(e){n?e.classList.add(t):e.classList.remove(t)}):n?e.classList.add(t):e.classList.remove(t)}))},B=function(e,t){k(e,t,!0)},A=function(e,t){k(e,t,!1)},E=function(e,t){for(var n=0;n<e.childNodes.length;n++)if(C(e.childNodes[n],t))return e.childNodes[n]},O=function(e){e.style.opacity="",e.style.display=e.id===g.content?"block":"flex"},S=function(e){e.style.opacity="",e.style.display="none"},P=function(e){for(;e.firstChild;)e.removeChild(e.firstChild)},L=function(e){return e&&(e.offsetWidth||e.offsetHeight||e.getClientRects().length)},j=function(e,t){e.style.removeProperty?e.style.removeProperty(t):e.style.removeAttribute(t)},T=function(){return document.body.querySelector("."+g.container)},V=function(e){var t=T();return t?t.querySelector("."+e):null},q=function(){return V(g.popup)},_=function(){return q().querySelectorAll("."+g.icon)},D=function(){return V(g.title)},I=function(){return V(g.content)},R=function(){return V(g.image)},M=function(){return V(g.progresssteps)},N=function(){return V(g.validationerror)},H=function(){return V(g.confirm)},W=function(){return V(g.cancel)},z=function(){return V(g.actions)},U=function(){return V(g.footer)},K=function(){return V(g.close)},F=function(){var e=Array.prototype.slice.call(q().querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])')).sort(function(e,t){return(e=parseInt(e.getAttribute("tabindex")))>(t=parseInt(t.getAttribute("tabindex")))?1:e<t?-1:0}),t=Array.prototype.slice.call(q().querySelectorAll('a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex="0"], [contenteditable], audio[controls], video[controls]'));return function(e){for(var t=[],n=0;n<e.length;n++)-1===t.indexOf(e[n])&&t.push(e[n]);return t}(e.concat(t))},Z=function(){return!document.body.classList.contains(g["toast-shown"])},Q=function(){return"undefined"==typeof window||"undefined"==typeof document},Y=('\n <div aria-labelledby="'+g.title+'" aria-describedby="'+g.content+'" class="'+g.popup+'" tabindex="-1">\n   <div class="'+g.header+'">\n     <ul class="'+g.progresssteps+'"></ul>\n     <div class="'+g.icon+" "+y.error+'">\n       <span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span>\n     </div>\n     <div class="'+g.icon+" "+y.question+'">\n       <span class="'+g["icon-text"]+'">?</span>\n      </div>\n     <div class="'+g.icon+" "+y.warning+'">\n       <span class="'+g["icon-text"]+'">!</span>\n      </div>\n     <div class="'+g.icon+" "+y.info+'">\n       <span class="'+g["icon-text"]+'">i</span>\n      </div>\n     <div class="'+g.icon+" "+y.success+'">\n       <div class="swal2-success-circular-line-left"></div>\n       <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>\n       <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>\n       <div class="swal2-success-circular-line-right"></div>\n     </div>\n     <img class="'+g.image+'" />\n     <h2 class="'+g.title+'" id="'+g.title+'"></h2>\n     <button type="button" class="'+g.close+'">×</button>\n   </div>\n   <div class="'+g.content+'">\n     <div id="'+g.content+'"></div>\n     <input class="'+g.input+'" />\n     <input type="file" class="'+g.file+'" />\n     <div class="'+g.range+'">\n       <input type="range" />\n       <output></output>\n     </div>\n     <select class="'+g.select+'"></select>\n     <div class="'+g.radio+'"></div>\n     <label for="'+g.checkbox+'" class="'+g.checkbox+'">\n       <input type="checkbox" />\n     </label>\n     <textarea class="'+g.textarea+'"></textarea>\n     <div class="'+g.validationerror+'" id="'+g.validationerror+'"></div>\n   </div>\n   <div class="'+g.actions+'">\n     <button type="button" class="'+g.confirm+'">OK</button>\n     <button type="button" class="'+g.cancel+'">Cancel</button>\n   </div>\n   <div class="'+g.footer+'">\n   </div>\n </div>\n').replace(/(^|\n)\s*/g,""),$=function(e){var t=T();if(t&&(t.parentNode.removeChild(t),A([document.documentElement,document.body],[g["no-backdrop"],g["has-input"],g["toast-shown"]])),!Q()){var n=document.createElement("div");n.className=g.container,n.innerHTML=Y,("string"==typeof e.target?document.querySelector(e.target):e.target).appendChild(n);var o=q(),r=I(),i=E(r,g.input),a=E(r,g.file),s=r.querySelector("."+g.range+" input"),u=r.querySelector("."+g.range+" output"),l=E(r,g.select),c=r.querySelector("."+g.checkbox+" input"),p=E(r,g.textarea);o.setAttribute("role",e.toast?"alert":"dialog"),o.setAttribute("aria-live",e.toast?"polite":"assertive"),e.toast||o.setAttribute("aria-modal","true");var f=function(){xe.isVisible()&&xe.resetValidationError()};return i.oninput=f,a.onchange=f,l.onchange=f,c.onchange=f,p.oninput=f,s.oninput=function(){f(),u.value=s.value},s.onchange=function(){f(),s.nextSibling.value=s.value},o}d("SweetAlert2 requires document to initialize")},J=function(t,n){if(!t)return S(n);if("object"===(void 0===t?"undefined":e(t)))if(n.innerHTML="",0 in t)for(var o=0;o in t;o++)n.appendChild(t[o].cloneNode(!0));else n.appendChild(t.cloneNode(!0));else t&&(n.innerHTML=t);O(n)},X=function(){if(Q())return!1;var e=document.createElement("div"),t={WebkitAnimation:"webkitAnimationEnd",OAnimation:"oAnimationEnd oanimationend",animation:"animationend"};for(var n in t)if(t.hasOwnProperty(n)&&void 0!==e.style[n])return t[n];return!1}(),G=function(){null===w.previousBodyPadding&&document.body.scrollHeight>window.innerHeight&&(w.previousBodyPadding=document.body.style.paddingRight,document.body.style.paddingRight=function(){if("ontouchstart"in window||navigator.msMaxTouchPoints)return 0;var e=document.createElement("div");e.style.width="50px",e.style.height="50px",e.style.overflow="scroll",document.body.appendChild(e);var t=e.offsetWidth-e.clientWidth;return document.body.removeChild(e),t}()+"px")},ee={},te=function(e,t){var n=T(),o=q();if(o){null!==e&&"function"==typeof e&&e(o),A(o,g.show),B(o,g.hide),clearTimeout(o.timeout),document.body.classList.contains(g["toast-shown"])||(!function(){if(w.previousActiveElement&&w.previousActiveElement.focus){var e=window.scrollX,t=window.scrollY;w.previousActiveElement.focus(),void 0!==e&&void 0!==t&&window.scrollTo(e,t)}}(),window.onkeydown=ee.previousWindowKeyDown,ee.windowOnkeydownOverridden=!1);var r=function(){n.parentNode&&n.parentNode.removeChild(n),A([document.documentElement,document.body],[g.shown,g["no-backdrop"],g["has-input"],g["toast-shown"]]),Z()&&(null!==w.previousBodyPadding&&(document.body.style.paddingRight=w.previousBodyPadding,w.previousBodyPadding=null),function(){if(C(document.body,g.iosfix)){var e=parseInt(document.body.style.top,10);A(document.body,g.iosfix),document.body.style.top="",document.body.scrollTop=-1*e}}()),null!==t&&"function"==typeof t&&setTimeout(function(){t()})};X&&!C(o,g.noanimation)?o.addEventListener(X,function e(){o.removeEventListener(X,e),C(o,g.hide)&&r()}):r()}};function ne(e){var t=function e(){for(var t=arguments.length,n=Array(t),o=0;o<t;o++)n[o]=arguments[o];if(!(this instanceof e))return new(Function.prototype.bind.apply(e,[null].concat(n)));Object.getPrototypeOf(e).apply(this,n)};return t.prototype=o(Object.create(e.prototype),{constructor:t}),Object.setPrototypeOf(t,e),t}var oe={title:"",titleText:"",text:"",html:"",footer:"",type:null,toast:!1,customClass:"",target:"body",backdrop:!0,animation:!0,allowOutsideClick:!0,allowEscapeKey:!0,allowEnterKey:!0,showConfirmButton:!0,showCancelButton:!1,preConfirm:null,confirmButtonText:"OK",confirmButtonAriaLabel:"",confirmButtonColor:null,confirmButtonClass:null,cancelButtonText:"Cancel",cancelButtonAriaLabel:"",cancelButtonColor:null,cancelButtonClass:null,buttonsStyling:!0,reverseButtons:!1,focusConfirm:!0,focusCancel:!1,showCloseButton:!1,closeButtonAriaLabel:"Close this dialog",showLoaderOnConfirm:!1,imageUrl:null,imageWidth:null,imageHeight:null,imageAlt:"",imageClass:null,timer:null,width:null,padding:null,background:null,input:null,inputPlaceholder:"",inputValue:"",inputOptions:{},inputAutoTrim:!0,inputClass:null,inputAttributes:{},inputValidator:null,grow:!1,position:"center",progressSteps:[],currentProgressStep:null,progressStepsDistance:null,onBeforeOpen:null,onAfterClose:null,onOpen:null,onClose:null,useRejections:!1,expectRejections:!1},re=["useRejections","expectRejections"],ie=function(e){return oe.hasOwnProperty(e)||"extraParams"===e},ae=function(e){return-1!==re.indexOf(e)},se=function(e){for(var t in e)ie(t)||c('Unknown parameter "'+t+'"'),ae(t)&&f('The parameter "'+t+'" is deprecated and will be removed in the next major release.')},ue='"setDefaults" & "resetDefaults" methods are deprecated in favor of "mixin" method and will be removed in the next major release. For new projects, use "mixin". For past projects already using "setDefaults", support will be provided through an additional package.',le={};var ce=[],de=function(){var e=q();e||xe(""),e=q();var t=z(),n=H(),o=W();O(t),O(n),B([e,t],g.loading),n.disabled=!0,o.disabled=!0,e.setAttribute("data-loading",!0),e.setAttribute("aria-busy",!0),e.focus()};var pe=Object.freeze({isValidParameter:ie,isDeprecatedParameter:ae,argsToParams:function(t){var n={};switch(e(t[0])){case"string":["title","html","type"].forEach(function(e,o){void 0!==t[o]&&(n[e]=t[o])});break;case"object":o(n,t[0]);break;default:return d('Unexpected type of argument! Expected "string" or "object", got '+e(t[0])),!1}return n},adaptInputValidator:function(e){return function(t,n){return e.call(this,t,n).then(function(){},function(e){return e})}},close:te,closePopup:te,closeModal:te,closeToast:te,isVisible:function(){return!!q()},clickConfirm:function(){return H().click()},clickCancel:function(){return W().click()},getPopup:q,getTitle:D,getContent:I,getImage:R,getButtonsWrapper:function(){return f("swal.getButtonsWrapper() is deprecated and will be removed in the next major release, use swal.getActions() instead"),V(g.actions)},getActions:z,getConfirmButton:H,getCancelButton:W,getFooter:U,isLoading:function(){return q().hasAttribute("data-loading")},mixin:function(e){return ne(function(s){function u(){return t(this,u),a(this,(u.__proto__||Object.getPrototypeOf(u)).apply(this,arguments))}return i(u,this),n(u,[{key:"_main",value:function(t){return r(u.prototype.__proto__||Object.getPrototypeOf(u.prototype),"_main",this).call(this,o({},e,t))}}]),u}())},queue:function(e){var t=this;ce=e;var n=function(){ce=[],document.body.removeAttribute("data-swal2-queue-step")},o=[];return new Promise(function(e,r){!function r(i,a){i<ce.length?(document.body.setAttribute("data-swal2-queue-step",i),t(ce[i]).then(function(t){void 0!==t.value?(o.push(t.value),r(i+1,a)):(n(),e({dismiss:t.dismiss}))})):(n(),e({value:o}))}(0)})},getQueueStep:function(){return document.body.getAttribute("data-swal2-queue-step")},insertQueueStep:function(e,t){return t&&t<ce.length?ce.splice(t,0,e):ce.push(e)},deleteQueueStep:function(e){void 0!==ce[e]&&ce.splice(e,1)},showLoading:de,enableLoading:de,fire:function(){for(var e=arguments.length,t=Array(e),n=0;n<e;n++)t[n]=arguments[n];return new(Function.prototype.bind.apply(this,[null].concat(t)))}}),fe={promise:new WeakMap,innerParams:new WeakMap,domCache:new WeakMap};function me(){var e=fe.innerParams.get(this),t=fe.domCache.get(this);e.showConfirmButton||(S(t.confirmButton),e.showCancelButton||S(t.actions)),A([t.popup,t.actions],g.loading),t.popup.removeAttribute("aria-busy"),t.popup.removeAttribute("data-loading"),t.confirmButton.disabled=!1,t.cancelButton.disabled=!1}var he={email:function(e){return/^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(e)?Promise.resolve():Promise.reject("Invalid email address")},url:function(e){return/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&//=]*)$/.test(e)?Promise.resolve():Promise.reject("Invalid URL")}};var ve=function(e,t,n){var o=T(),r=q();null!==t&&"function"==typeof t&&t(r),e?(B(r,g.show),B(o,g.fade),A(r,g.hide)):A(r,g.fade),O(r),o.style.overflowY="hidden",X&&!C(r,g.noanimation)?r.addEventListener(X,function e(){r.removeEventListener(X,e),o.style.overflowY="auto"}):o.style.overflowY="auto",B([document.documentElement,document.body,o],g.shown),Z()&&(G(),function(){if(/iPad|iPhone|iPod/.test(navigator.userAgent)&&!window.MSStream&&!C(document.body,g.iosfix)){var e=document.body.scrollTop;document.body.style.top=-1*e+"px",B(document.body,g.iosfix)}}()),w.previousActiveElement=document.activeElement,null!==n&&"function"==typeof n&&setTimeout(function(){n(r)})};var be=Object.freeze({hideLoading:me,disableLoading:me,getInput:function(e){var t=fe.innerParams.get(this),n=fe.domCache.get(this);if(!(e=e||t.input))return null;switch(e){case"select":case"textarea":case"file":return E(n.content,g[e]);case"checkbox":return n.popup.querySelector("."+g.checkbox+" input");case"radio":return n.popup.querySelector("."+g.radio+" input:checked")||n.popup.querySelector("."+g.radio+" input:first-child");case"range":return n.popup.querySelector("."+g.range+" input");default:return E(n.content,g.input)}},enableButtons:function(){var e=fe.domCache.get(this);e.confirmButton.disabled=!1,e.cancelButton.disabled=!1},disableButtons:function(){var e=fe.domCache.get(this);e.confirmButton.disabled=!0,e.cancelButton.disabled=!0},enableConfirmButton:function(){fe.domCache.get(this).confirmButton.disabled=!1},disableConfirmButton:function(){fe.domCache.get(this).confirmButton.disabled=!0},enableInput:function(){var e=this.getInput();if(!e)return!1;if("radio"===e.type)for(var t=e.parentNode.parentNode.querySelectorAll("input"),n=0;n<t.length;n++)t[n].disabled=!1;else e.disabled=!1},disableInput:function(){var e=this.getInput();if(!e)return!1;if(e&&"radio"===e.type)for(var t=e.parentNode.parentNode.querySelectorAll("input"),n=0;n<t.length;n++)t[n].disabled=!0;else e.disabled=!0},showValidationError:function(e){var t=fe.domCache.get(this);t.validationError.innerHTML=e;var n=window.getComputedStyle(t.popup);t.validationError.style.marginLeft="-"+n.getPropertyValue("padding-left"),t.validationError.style.marginRight="-"+n.getPropertyValue("padding-right"),O(t.validationError);var o=this.getInput();o&&(o.setAttribute("aria-invalid",!0),o.setAttribute("aria-describedBy",g.validationerror),x(o),B(o,g.inputerror))},resetValidationError:function(){var e=fe.domCache.get(this);e.validationError&&S(e.validationError);var t=this.getInput();t&&(t.removeAttribute("aria-invalid"),t.removeAttribute("aria-describedBy"),A(t,g.inputerror))},_main:function(t){var n=this;se(t);var r=o({},oe,t);!function(e){e.inputValidator||Object.keys(he).forEach(function(t){e.input===t&&(e.inputValidator=e.expectRejections?he[t]:xe.adaptInputValidator(he[t]))}),(!e.target||"string"==typeof e.target&&!document.querySelector(e.target)||"string"!=typeof e.target&&!e.target.appendChild)&&(c('Target parameter is not valid, defaulting to "body"'),e.target="body");var t=void 0,n=q(),o="string"==typeof e.target?document.querySelector(e.target):e.target;t=n&&o&&n.parentNode!==o.parentNode?$(e):n||$(e),e.width&&(t.style.width="number"==typeof e.width?e.width+"px":e.width),e.padding&&(t.style.padding="number"==typeof e.padding?e.padding+"px":e.padding),e.background&&(t.style.background=e.background);for(var r=window.getComputedStyle(t).getPropertyValue("background-color"),i=t.querySelectorAll("[class^=swal2-success-circular-line], .swal2-success-fix"),a=0;a<i.length;a++)i[a].style.backgroundColor=r;var s=T(),u=D(),l=I().querySelector("#"+g.content),p=z(),f=H(),m=W(),h=K(),v=U();if(e.titleText?u.innerText=e.titleText:e.title&&(u.innerHTML=e.title.split("\n").join("<br />")),"string"==typeof e.backdrop?T().style.background=e.backdrop:e.backdrop||B([document.documentElement,document.body],g["no-backdrop"]),e.html?J(e.html,l):e.text?(l.textContent=e.text,O(l)):S(l),e.position in g?B(s,g[e.position]):(c('The "position" parameter is not valid, defaulting to "center"'),B(s,g.center)),e.grow&&"string"==typeof e.grow){var b="grow-"+e.grow;b in g&&B(s,g[b])}"function"==typeof e.animation&&(e.animation=e.animation.call()),e.showCloseButton?(h.setAttribute("aria-label",e.closeButtonAriaLabel),O(h)):S(h),t.className=g.popup,e.toast?(B([document.documentElement,document.body],g["toast-shown"]),B(t,g.toast)):B(t,g.modal),e.customClass&&B(t,e.customClass);var w=M(),C=parseInt(null===e.currentProgressStep?xe.getQueueStep():e.currentProgressStep,10);e.progressSteps&&e.progressSteps.length?(O(w),P(w),C>=e.progressSteps.length&&c("Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"),e.progressSteps.forEach(function(t,n){var o=document.createElement("li");if(B(o,g.progresscircle),o.innerHTML=t,n===C&&B(o,g.activeprogressstep),w.appendChild(o),n!==e.progressSteps.length-1){var r=document.createElement("li");B(r,g.progressline),e.progressStepsDistance&&(r.style.width=e.progressStepsDistance),w.appendChild(r)}})):S(w);for(var x=_(),k=0;k<x.length;k++)S(x[k]);if(e.type){var E=!1;for(var L in y)if(e.type===L){E=!0;break}if(!E)return d("Unknown alert type: "+e.type),!1;var V=t.querySelector("."+g.icon+"."+y[e.type]);O(V),e.animation&&B(V,"swal2-animate-"+e.type+"-icon")}var N=R();if(e.imageUrl?(N.setAttribute("src",e.imageUrl),N.setAttribute("alt",e.imageAlt),O(N),e.imageWidth?N.setAttribute("width",e.imageWidth):N.removeAttribute("width"),e.imageHeight?N.setAttribute("height",e.imageHeight):N.removeAttribute("height"),N.className=g.image,e.imageClass&&B(N,e.imageClass)):S(N),e.showCancelButton?m.style.display="inline-block":S(m),e.showConfirmButton?j(f,"display"):S(f),e.showConfirmButton||e.showCancelButton?O(p):S(p),f.innerHTML=e.confirmButtonText,m.innerHTML=e.cancelButtonText,f.setAttribute("aria-label",e.confirmButtonAriaLabel),m.setAttribute("aria-label",e.cancelButtonAriaLabel),f.className=g.confirm,B(f,e.confirmButtonClass),m.className=g.cancel,B(m,e.cancelButtonClass),e.buttonsStyling){B([f,m],g.styled),e.confirmButtonColor&&(f.style.backgroundColor=e.confirmButtonColor),e.cancelButtonColor&&(m.style.backgroundColor=e.cancelButtonColor);var F=window.getComputedStyle(f).getPropertyValue("background-color");f.style.borderLeftColor=F,f.style.borderRightColor=F}else A([f,m],g.styled),f.style.backgroundColor=f.style.borderLeftColor=f.style.borderRightColor="",m.style.backgroundColor=m.style.borderLeftColor=m.style.borderRightColor="";J(e.footer,v),!0===e.animation?A(t,g.noanimation):B(t,g.noanimation),e.showLoaderOnConfirm&&!e.preConfirm&&c("showLoaderOnConfirm is set to true, but preConfirm is not defined.\nshowLoaderOnConfirm should be used together with preConfirm, see usage example:\nhttps://sweetalert2.github.io/#ajax-request")}(r),Object.freeze(r),fe.innerParams.set(this,r);var i={popup:q(),container:T(),content:I(),actions:z(),confirmButton:H(),cancelButton:W(),closeButton:K(),validationError:N(),progressSteps:M()};fe.domCache.set(this,i);var a=this.constructor;return new Promise(function(t,o){var u=function(e){a.closePopup(r.onClose,r.onAfterClose),r.useRejections?t(e):t({value:e})},c=function(e){a.closePopup(r.onClose,r.onAfterClose),r.useRejections?o(e):t({dismiss:e})},p=function(e){a.closePopup(r.onClose,r.onAfterClose),o(e)};r.timer&&(i.popup.timeout=setTimeout(function(){return c("timer")},r.timer)),r.input&&setTimeout(function(){var e=n.getInput();e&&x(e)},0);for(var f=function(e){if(r.showLoaderOnConfirm&&a.showLoading(),r.preConfirm){n.resetValidationError();var t=Promise.resolve().then(function(){return r.preConfirm(e,r.extraParams)});r.expectRejections?t.then(function(t){return u(t||e)},function(e){n.hideLoading(),e&&n.showValidationError(e)}):t.then(function(t){L(i.validationError)||!1===t?n.hideLoading():u(t||e)},function(e){return p(e)})}else u(e)},v=function(e){var t=e||window.event,o=t.target||t.srcElement,s=i.confirmButton,u=i.cancelButton,l=s&&(s===o||s.contains(o)),d=u&&(u===o||u.contains(o));switch(t.type){case"click":if(l&&a.isVisible())if(n.disableButtons(),r.input){var m=function(){var e=n.getInput();if(!e)return null;switch(r.input){case"checkbox":return e.checked?1:0;case"radio":return e.checked?e.value:null;case"file":return e.files.length?e.files[0]:null;default:return r.inputAutoTrim?e.value.trim():e.value}}();if(r.inputValidator){n.disableInput();var h=Promise.resolve().then(function(){return r.inputValidator(m,r.extraParams)});r.expectRejections?h.then(function(){n.enableButtons(),n.enableInput(),f(m)},function(e){n.enableButtons(),n.enableInput(),e&&n.showValidationError(e)}):h.then(function(e){n.enableButtons(),n.enableInput(),e?n.showValidationError(e):f(m)},function(e){return p(e)})}else f(m)}else f(!0);else d&&a.isVisible()&&(n.disableButtons(),c(a.DismissReason.cancel))}},b=i.popup.querySelectorAll("button"),y=0;y<b.length;y++)b[y].onclick=v,b[y].onmouseover=v,b[y].onmouseout=v,b[y].onmousedown=v;if(i.closeButton.onclick=function(){c(a.DismissReason.close)},r.toast)i.popup.onclick=function(e){r.showConfirmButton||r.showCancelButton||r.showCloseButton||r.input||(a.closePopup(r.onClose,r.onAfterClose),c(a.DismissReason.close))};else{var w=!1;i.popup.onmousedown=function(){i.container.onmouseup=function(e){i.container.onmouseup=void 0,e.target===i.container&&(w=!0)}},i.container.onmousedown=function(){i.popup.onmouseup=function(e){i.popup.onmouseup=void 0,(e.target===i.popup||i.popup.contains(e.target))&&(w=!0)}},i.container.onclick=function(e){w?w=!1:e.target===i.container&&m(r.allowOutsideClick)&&c(a.DismissReason.backdrop)}}r.reverseButtons?i.confirmButton.parentNode.insertBefore(i.cancelButton,i.confirmButton):i.confirmButton.parentNode.insertBefore(i.confirmButton,i.cancelButton);var C=function(e,t){for(var n=F(r.focusCancel),o=0;o<n.length;o++){(e+=t)===n.length?e=0:-1===e&&(e=n.length-1);var i=n[e];if(L(i))return i.focus()}};r.toast&&ee.windowOnkeydownOverridden&&(window.onkeydown=ee.previousWindowKeyDown,ee.windowOnkeydownOverridden=!1),r.toast||ee.windowOnkeydownOverridden||(ee.previousWindowKeyDown=window.onkeydown,ee.windowOnkeydownOverridden=!0,window.onkeydown=function(e){var t=e||window.event;if("Enter"!==t.key||t.isComposing)if("Tab"===t.key){for(var o=t.target||t.srcElement,s=F(r.focusCancel),u=-1,l=0;l<s.length;l++)if(o===s[l]){u=l;break}t.shiftKey?C(u,-1):C(u,1),t.stopPropagation(),t.preventDefault()}else-1!==["ArrowLeft","ArrowRight","ArrowUp","ArrowDown","Left","Right","Up","Down"].indexOf(t.key)?document.activeElement===i.confirmButton&&L(i.cancelButton)?i.cancelButton.focus():document.activeElement===i.cancelButton&&L(i.confirmButton)&&i.confirmButton.focus():"Escape"!==t.key&&"Esc"!==t.key||!0!==m(r.allowEscapeKey)||c(a.DismissReason.esc);else if(t.target===n.getInput()){if(-1!==["textarea","file"].indexOf(r.input))return;a.clickConfirm(),t.preventDefault()}}),n.enableButtons(),n.hideLoading(),n.resetValidationError(),r.input&&B(document.body,g["has-input"]);for(var k=["input","file","range","select","radio","checkbox","textarea"],A=void 0,P=0;P<k.length;P++){var j=g[k[P]],T=E(i.content,j);if(A=n.getInput(k[P])){for(var V in A.attributes)if(A.attributes.hasOwnProperty(V)){var q=A.attributes[V].name;"type"!==q&&"value"!==q&&A.removeAttribute(q)}for(var _ in r.inputAttributes)A.setAttribute(_,r.inputAttributes[_])}T.className=j,r.inputClass&&B(T,r.inputClass),S(T)}var D=void 0;switch(r.input){case"text":case"email":case"password":case"number":case"tel":case"url":(A=E(i.content,g.input)).value=r.inputValue,A.placeholder=r.inputPlaceholder,A.type=r.input,O(A);break;case"file":(A=E(i.content,g.file)).placeholder=r.inputPlaceholder,A.type=r.input,O(A);break;case"range":var I=E(i.content,g.range),R=I.querySelector("input"),M=I.querySelector("output");R.value=r.inputValue,R.type=r.input,M.value=r.inputValue,O(I);break;case"select":var N=E(i.content,g.select);if(N.innerHTML="",r.inputPlaceholder){var H=document.createElement("option");H.innerHTML=r.inputPlaceholder,H.value="",H.disabled=!0,H.selected=!0,N.appendChild(H)}D=function(e){e.forEach(function(e){var t=s(e,2),n=t[0],o=t[1],i=document.createElement("option");i.value=n,i.innerHTML=o,r.inputValue.toString()===n.toString()&&(i.selected=!0),N.appendChild(i)}),O(N),N.focus()};break;case"radio":var W=E(i.content,g.radio);W.innerHTML="",D=function(e){e.forEach(function(e){var t=s(e,2),n=t[0],o=t[1],i=document.createElement("input"),a=document.createElement("label");i.type="radio",i.name=g.radio,i.value=n,r.inputValue.toString()===n.toString()&&(i.checked=!0),a.innerHTML=o,a.insertBefore(i,a.firstChild),W.appendChild(a)}),O(W);var t=W.querySelectorAll("input");t.length&&t[0].focus()};break;case"checkbox":var z=E(i.content,g.checkbox),U=n.getInput("checkbox");U.type="checkbox",U.value=1,U.id=g.checkbox,U.checked=Boolean(r.inputValue);var K=z.getElementsByTagName("span");K.length&&z.removeChild(K[0]),(K=document.createElement("span")).innerHTML=r.inputPlaceholder,z.appendChild(K),O(z);break;case"textarea":var Z=E(i.content,g.textarea);Z.value=r.inputValue,Z.placeholder=r.inputPlaceholder,O(Z);break;case null:break;default:d('Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "'+r.input+'"')}if("select"===r.input||"radio"===r.input){var Q=function(e){return D(l(e))};h(r.inputOptions)?(a.showLoading(),r.inputOptions.then(function(e){n.hideLoading(),Q(e)})):"object"===e(r.inputOptions)?Q(r.inputOptions):d("Unexpected type of inputOptions! Expected object, Map or Promise, got "+e(r.inputOptions))}else-1!==["text","email","number","tel","textarea"].indexOf(r.input)&&h(r.inputValue)&&(a.showLoading(),S(A),r.inputValue.then(function(e){A.value="number"===r.input?parseFloat(e)||0:e+"",O(A),n.hideLoading()}).catch(function(e){d("Error in inputValue promise: "+e),A.value="",O(A),n.hideLoading()}));ve(r.animation,r.onBeforeOpen,r.onOpen),r.toast||(m(r.allowEnterKey)?r.focusCancel&&L(i.cancelButton)?i.cancelButton.focus():r.focusConfirm&&L(i.confirmButton)?i.confirmButton.focus():C(-1,1):document.activeElement&&document.activeElement.blur()),i.container.scrollTop=0})}}),ge=void 0;function ye(){if("undefined"!=typeof window){"undefined"==typeof Promise&&d("This package requires a Promise library, please include a shim to enable it in this browser (See: https://github.com/sweetalert2/sweetalert2/wiki/Migration-from-SweetAlert-to-SweetAlert2#1-ie-support)");for(var e=arguments.length,t=Array(e),n=0;n<e;n++)t[n]=arguments[n];if(void 0===t[0])return d("SweetAlert2 expects at least 1 attribute!"),!1;ge=this;var o=Object.freeze(this.constructor.argsToParams(t));Object.defineProperties(this,{params:{value:o,writable:!1,enumerable:!0}});var r=this._main(this.params);fe.promise.set(this,r)}}ye.prototype.then=function(e,t){return fe.promise.get(this).then(e,t)},ye.prototype.catch=function(e){return fe.promise.get(this).catch(e)},ye.prototype.finally=function(e){return fe.promise.get(this).finally(e)},o(ye.prototype,be),o(ye,pe),Object.keys(be).forEach(function(e){ye[e]=function(){var t;if(ge)return(t=ge)[e].apply(t,arguments)}}),ye.DismissReason=v,ye.noop=function(){},ye.version="7.19.0";var we,Ce,xe=ne((we=ye,Ce=function(s){function u(){return t(this,u),a(this,(u.__proto__||Object.getPrototypeOf(u)).apply(this,arguments))}return i(u,we),n(u,[{key:"_main",value:function(e){return r(u.prototype.__proto__||Object.getPrototypeOf(u.prototype),"_main",this).call(this,o({},le,e))}}],[{key:"setDefaults",value:function(t){if(f(ue),!t||"object"!==(void 0===t?"undefined":e(t)))throw new TypeError("SweetAlert2: The argument for setDefaults() is required and has to be a object");se(t),Object.keys(t).forEach(function(e){we.isValidParameter(e)&&(le[e]=t[e])})}},{key:"resetDefaults",value:function(){f(ue),le={}}}]),u}(),"undefined"!=typeof window&&"object"===e(window._swalDefaults)&&Ce.setDefaults(window._swalDefaults),Ce));return xe.default=xe,xe}),"undefined"!=typeof window&&window.Sweetalert2&&(window.swal=window.sweetAlert=window.Swal=window.SweetAlert=window.Sweetalert2);


if(!window.jQuery){
   alert('Cole: You do not appear to be running jQuery on your Website. Please define jQuery 2.0.0 or later before you load ColeTools.\n\n\nColeTools was unable to boot.');
}

var initload = false;
var OldValues = [];

Cole = {
	Boot: function(){
		// Load This page's data
		$.get(document.location.href + "&ColeJSON=true", function(data, status){
			Cole.Data = data;
			$('body').wrapInner('<div class="ColeEdit" />');
			var FixedFind = $('*').filter(function () { 
				return $(this).css('position') == 'fixed';
			});
			FixedFind.each(function() {
				$( this ).hide();
			});
	
			$('body').append('<div class="ColeToolkit"></div>')
			
			 // Load edit CSS
			 $('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', 'https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.css'));
			 $('head').append( $('<link rel="stylesheet" type="text/css" />').attr('href', Cole.Data.Settings.ColeURL + '/Cole/ColeTools/edit.cole.css'));
				 
			// Construct edit environment
			var ColeEditEnvironment = '<form id="ColeUpload" action="/Cole/Pages/ImgUpload" method="post" enctype="multipart/form-data">';
			ColeEditEnvironment += '<input type="file" name="fileToUpload" id="fileToUpload">';
			ColeEditEnvironment += '<input type="submit" name="submit">';
			ColeEditEnvironment += '</form>';
			
			// Images:Folders
			ColeEditEnvironment += '<div class="ColeImage Folders" data-page="' + Cole.Data.Page.PageMeta.Url + '">';
				ColeEditEnvironment += '<div class="Actions">';
					ColeEditEnvironment += '<div class="ButtonContainer">';
						ColeEditEnvironment += '<div class="Button" data-action="back"><i class="zmdi zmdi-arrow-left"></i></div>';
					ColeEditEnvironment += '</div>';
					ColeEditEnvironment += '<div class="ButtonContainer">';
						ColeEditEnvironment += '<div class="Button" data-action="upload"><i class="zmdi zmdi-upload"></i></div>';
					ColeEditEnvironment += '</div>';
					ColeEditEnvironment += '<div class="ButtonContainer">';
						ColeEditEnvironment += '<div class="Button" data-action="newfolder"><i class="zmdi zmdi-folder"></i></div>';
					ColeEditEnvironment += '</div>';
					ColeEditEnvironment += '<div class="ButtonContainer">';
						ColeEditEnvironment += '<div class="Button" data-action="cancel"><i class="zmdi zmdi-close"></i></div>';
					ColeEditEnvironment += '</div>';
				ColeEditEnvironment += '</div>';
				ColeEditEnvironment += '<ul class="Picker">';
				ColeEditEnvironment += '</ul>';
			ColeEditEnvironment += '</div>';
	
			// Images:Images
			ColeEditEnvironment += '<div class="ColeImage Files" data-page="' + Cole.Data.Page.PageMeta.Url + '">';
				
				ColeEditEnvironment += '<ul class="Picker">';
				ColeEditEnvironment += '</ul>';
				
			ColeEditEnvironment += '</div>';
	
			// BIT:Dates
			ColeEditEnvironment += '<div class="ColeBit Dates">';
				ColeEditEnvironment += '<div class="Actions">';
					ColeEditEnvironment += '<div class="ButtonContainer">';
						ColeEditEnvironment += '<div class="Button" data-action="cancel"><i class="zmdi zmdi-close"></i></div>';
					ColeEditEnvironment += '</div>';
				ColeEditEnvironment += '</div>';
				ColeEditEnvironment += '<ul class="Picker">';
				ColeEditEnvironment += '</ul>';
			ColeEditEnvironment += '</div>';

			// Cole:Panels
			ColeEditEnvironment += '<div class="ColePanels PanelList">';
				ColeEditEnvironment += '<div class="Actions">';
					ColeEditEnvironment += '<div class="ButtonContainer">';
						ColeEditEnvironment += '<div class="Button" data-action="cancel"><i class="zmdi zmdi-close"></i></div>';
					ColeEditEnvironment += '</div>';
				ColeEditEnvironment += '</div>';
				ColeEditEnvironment += '<ul class="Picker">';
				ColeEditEnvironment += '</ul>';
			ColeEditEnvironment += '</div>';
	
	
			// Write the toolkit to the page
			$('body').append(ColeEditEnvironment);
			
			
			ColeToolkit = '<div class="ControlsContainer">';
				ColeToolkit += '<button class="Controls" data-control="bold"><i class="zmdi zmdi-format-bold"></i></button>';
				ColeToolkit += '<button class="Controls" data-control="italic"><i class="zmdi zmdi-format-italic"></i></button>';
				ColeToolkit += '<button class="Controls" data-control="underline"><i class="zmdi zmdi-format-underlined"></i></button>';
				ColeToolkit += '<button class="Controls" data-control="bit"><i class="zmdi zmdi-time-restore"></i></button>';
			ColeToolkit += '</div>';
	
			ColeToolkit += '<div class="ColeTool" data-page="' + Cole.Data.Page.PageMeta.Url + '">';
			ColeToolkit += '<i class="zmdi zmdi-check"></i>';
				ColeToolkit += '<i class="zmdi zmdi-hourglass-alt"></i>';	
				ColeToolkit += '<i class="zmdi zmdi-mood-bad"></i>';
				ColeToolkit += '<i class="zmdi zmdi-thumb-up"></i>';
			ColeToolkit += '</div>';
			
			// Write the toolkit to the page
			$('.ColeToolkit').append(ColeToolkit);
			
			// Cycle round img.Cole.Image with parent a's and hash them out
			$( ".ColeEdit a" ).each(function() {
				$( this ).attr('href','#'); // hash the link
				$( this ).removeAttr("target"); // remove targets
				
			});
	
			
	
			$('div.ColeEdit .Cole').mouseup(function() {
				var isBold = false;
				if (document.queryCommandState) {
					isBold = document.queryCommandState("bold");
				}
				if(isBold){
					$('div.ControlsContainer button[data-control=bold]').addClass('active');
				}else{
					$('div.ControlsContainer button[data-control=bold]').removeClass('active');
				}
	
				var isItalic = false;
				if (document.queryCommandState) {
					isItalic = document.queryCommandState("italic");
				}
				if(isItalic){
					$('div.ControlsContainer button[data-control=italic]').addClass('active');
				}else{
					$('div.ControlsContainer button[data-control=italic]').removeClass('active');
				}
	
				var isUnderline = false;
				if (document.queryCommandState) {
					isUnderline = document.queryCommandState("underline");
				}
				if(isUnderline){
					$('div.ControlsContainer button[data-control=underline]').addClass('active');
				}else{
					$('div.ControlsContainer button[data-control=underline]').removeClass('active');
				}
	
				
			});
	
			$('div.ColeEdit .Cole').blur(function() {
				$('div.ControlsContainer button').removeClass('active');
			});
		
			
			Cole.Update.Check();

			Cole.Editor.Boot();
			Cole.Images.Boot();
			Cole.BackInTime.Boot();			
			Cole.Panels.Boot();



			console.log( "Cole: ColeTools initialised" );
			
		});
	},
	"Settings": {
		initload: false,
	},
	"Picker": {
		Path: [],
		Field: '',
		BackgroundMode: false,
		Browse: function(Path){
			console.log(Path);
			if (typeof Path === 'undefined' || !Path){
				Path = '';
			}else{
				Path = Path.join("/");
			}
			$('form#ColeUpload input#Path').val('Cole/Images/' + Path);
			$('.ColeImage.Files ul.Picker,.ColeImage.Folders ul.Picker').html('');
			
			$.get("/Cole/Pages/ImgBrowse/" + Path, function(api, status){
				var fadeAnimation = 0;
				$.each( api, function( key, value ) {			
					if(value.isDir){
						var output = '<li data-dir="true" data-filename="' + value.name + '">';
						var truncTitle = $.trim(value.name).substring(0, 50).trim(this) + '...'			
						output += '<label>' + truncTitle + '</label>';
						output += '</li>';
						$('.ColeImage.Folders ul.Picker').append(output);
					}
					if(!value.isDir){
						var output = '<li data-dir="false" data-filename="' + value.name + '">';
						output += '<img data-file="Cole/Images/' + Path + '/' + value.name + '" src="/Cole/Pages/ImgPickerThumbnail?u=' + Path + '/' + value.name + '" style="display:none;" />';
						output += '</li>';
						$('.ColeImage.Files ul.Picker').append(output);
						setTimeout(function(){
							$('.ColeImage.Files ul.Picker li[data-filename="' + value.name + '"] img').fadeIn('slow');
						}, fadeAnimation);
						fadeAnimation = fadeAnimation + 250;
					}
				});
			});
		}
	},
	"Update": {
		Check: function(){
			$('.ColeEdit,.ColeTool').addClass('Saving');
			$('.ColeTool i').hide();
			$('.ColeTool i.zmdi-hourglass-alt').show();
			$.get("/Cole/Update/Query", function(api) {
				$('.ColeEdit,.ColeTool').removeClass('Saving');
				$('.ColeTool i').hide();
				$('.ColeTool i.zmdi-check').show();
			}).fail(function(e) {
				$('.ColeEdit,.ColeTool').removeClass('Saving');
				$('.ColeTool i').hide();
				$('.ColeTool i.zmdi-check').show();
				console.log('Cole Error on Update:',e);
			});
		}
	},
	"Editor": {
		Boot: function(){
			$('div.ControlsContainer button[data-control=bold]').click(function(){
				document.execCommand('bold');
				$(this).toggleClass('active');
			});
			$('div.ControlsContainer button[data-control=italic]').click(function(){
				document.execCommand('italic');
				$(this).toggleClass('active');
			});
			$('div.ControlsContainer button[data-control=underline]').click(function(){
				document.execCommand('underline');
				$(this).toggleClass('active');
			});
	
			$('div.ControlsContainer button[data-control=bit]').click(function(){
				Cole.BackInTime.Get();
			});
			$('body').on('click', '.ColeTool', function() {
				Cole.BackInTime.Backup();
			});
			$('.ColeTool i.zmdi-check').show(); // init	
		},
		Save: function(){

			var PageFields = {};
			$( ".Cole" ).each(function() {
				if(!$(this).is( "img" )){
					if(!$(this).hasClass( "Panels" )){
						// Skip images and panels as these are saved on the fly
						var Field = $( this ).data( "field" );
						var Value = $( this ).html();
						PageFields[Field] = Base64.encode(Value);
					}
				}
			});
			console.log(PageFields);
			if(PageFields.length==0){		
				Cole.Editor.Response('Bad');
				setTimeout(function(){
					// Nothing to save (A Error)
					swal(
						'Cole',
						'There are no Page Fields setup. You need to add some fields to this page that can be manipulated before saving',
						'warning'
					);
					console.log(e);
				}, 1000);	
			}else{
				setTimeout(function(){
					$.post(Cole.Data.Settings.ColeURL + "/api/pages/save",
					{
						Secret: Cole.Data.EditToken,
						Page: $('.ColeTool').data('page'),
						Fields: PageFields
					},
					function(api, status){
						console.log(api);
						if(status=="success"){
							if(api.Outcome=="Success"){
								Cole.Editor.Response('Good');			        
							}else{
								Cole.Editor.Response('Bad');
								setTimeout(function(){
									// The system manually provided reason for crash (B Error)
									swal(
										'Cole',
										'A B-Type Error occurred whilst saving the page.\n\n' + e.responseJSON.exception,
										'error'
									);
								}, 1000);
							}
						}else{
							Cole.Editor.Response('Bad');
							setTimeout(function(){
								// The AJAX call did not issue success header (C Error)
								swal(
									'Cole',
									'A C-Type Error occurred whilst saving the page.\n\n' + e.responseJSON.exception,
									'error'
								);
							}, 1000);
						}
					}).fail(function(e) {
						 Cole.Editor.Response('Bad');
						 setTimeout(function(){
							 // A Laravel exception was called (D Error)				
							swal(
								'Cole',
								'A Laravel Error occurred whilst saving the page.\n\n' + e.responseJSON.exception,
								'error'
							);
							console.log(e);
						 }, 1000);
					});
				}, 750);
			}
		},
		Response: function(Response){
			if(Response=='Bad'){
				$('.ColeEdit').removeClass('Saving');
				$('.ColeEdit').removeClass('Saving');
				$('.ColeTool').addClass('Bad');
				$('.ColeTool i').hide();
		
				$('.ColeTool i.zmdi-mood-bad').show();
			}
			if(Response=='Good'){
				$('.ColeEdit').removeClass('Saving');
				$('.ColeEdit').removeClass('Saving');
				$('.ColeTool').addClass('Good');
							
				$('.ColeTool i').hide();
				$('.ColeTool i.zmdi-thumb-up').show();
			}
				
			
			setTimeout(function(){
				$('.ColeEdit').removeClass('Saving');
				$('.ColeTool').removeClass('Bad');
				$('.ColeTool').removeClass('Good');
				
				$('.ColeTool i').hide();
				$('.ColeTool i.zmdi-check').show();
			}, 2000);
		}
	},
	"Images": {
		Boot: function(){
			$( ".Cole:not(.Image):not(.Panels)" ).each(function() {
				$(this).attr('contenteditable',true);
			});
			$( ".Cole.Image" ).click(function() {
				Cole.Picker.BackgroundMode = !$(this).is('img');
		
				
				$('.ColeImage.Folders,.ColeImage.Files').fadeIn();
				$('.ColeTool,.ColeToolkit').hide();
				// Load base folder view
				
				
				console.log('Cole: Background-mode set to: ' + Cole.Picker.BackgroundMode);
				
				Cole.Picker.Path = []; // Reset the path
				Cole.Picker.Field = $(this).data('field');
				Cole.Picker.Browse();
			});					
			$('body').on('click', '.ColeImage.Folders ul li,.ColeImage.Files ul li', function() {
				if($(this).data('dir')){
					Cole.Picker.Path.push($(this).data('filename'));
					Cole.Picker.Browse(Cole.Picker.Path);
				}else{		
					var Url = $('.ColeTool').data('page');
					var Tag = Cole.Picker.Field;
					var Value = $(this).find('img').attr('data-file');
					Value = Value.replace('Cole/Images/', '');
					
					if(Cole.Picker.BackgroundMode){
						$('div.Cole.Image[data-field=' + Cole.Picker.Field + ']').css('background-image','url(' + $(this).find('img').attr('data-file') + ')');	
					}else{
						$('img.Cole.Image[data-field=' + Cole.Picker.Field + ']').attr('src',$(this).find('img').attr('data-file'));	
					}
					
					$.post("/Cole/Pages/ImgSave",
					{
						Url: Url,
						Tag: Tag,
						Value: Value
					},
					function(data, status){
						console.log(data);
					});
				
					$( ".ColeImage.Folders .Button[data-action=cancel]" ).click(); // close the picker
					
				}
			});		
			$('body').on('click', '.ColeImage.Folders .Actions .Button[data-action=back]', function() {
				if(Cole.Picker.Path.length!=0){
					Cole.Picker.Path.splice(-1,1);
					Cole.Picker.Browse(Cole.Picker.Path);
				}
			});
			$('body').on('click', '.ColeImage.Folders .Actions .Button[data-action=cancel]', function() {
				$('.ColeImage.Folders,.ColeImage.Files').hide();
				$('.ColeTool,.ColeToolkit').show();
			});
			$('body').on('click', '.ColeImage.Folders .Actions .Button[data-action=newfolder]', function() {
				var folder = prompt("Please type a new folder name");
				if (folder != null) {
					$.post("/Cole/Pages/ImgFolderMake",
					{
						Folder: folder,
						Path: Cole.Picker.Path.join("/")
					},
					function(api, status){
						console.log(api);
						if(status=="success"){
							if(api.Outcome=="Success"){
								Cole.Picker.Browse(Cole.Picker.Path);
							}else{
								swal(
									'Cole',
									'Sorry, an error occurred whilst creating the new folder. ' + api.Reason,
									'error'
								);
							}
						}else{
							swal(
								'Cole',
								'Sorry, an unknown error occurred whilst creating the new folder.',
								'error'
							);
						}
					});
					
				}
			});
			$('body').on('click', '.ColeImage.Folders .Actions .Button[data-action=upload]', function() {
				console.log('Picker path is ' + 'Cole/Images/' + Cole.Picker.Path.join("/"));
				$('form#ColeUpload input#fileToUpload').click();
			});	
		
			var files;
			$('form#ColeUpload input#fileToUpload').on('change', prepareUpload);
			function prepareUpload(event){
			  files = event.target.files;
			  $('form#ColeUpload').submit();
			}
			
			$('form#ColeUpload').on('submit', uploadFiles);
			function uploadFiles(event){
				$('.ColeImage.Folders,.ColeImage.Files').fadeOut('fast');
				event.stopPropagation(); // Stop stuff happening
				event.preventDefault(); // Totally stop stuff happening
				
		
				// Create a formdata object and add the files
				var data = new FormData();
				$.each(files, function(key, value)
				{
					data.append(key, value);
				});
			
				$.ajax({
					url: '/Cole/Pages/ImgUpload?files',
					type: 'POST',
					data: data,
					cache: false,
					dataType: 'json',
					processData: false, // Don't process the files
					contentType: false, // Set content type to false as jQuery will tell the server its a query string request
					success: function(data, textStatus, jqXHR)
					{
						if(typeof data.error === 'undefined'){
							// Success so call function to process the form
							submitForm(event, data);
						}else{
							// Handle errors here
							console.log('ERRORS: ' + JSON.stringify(data));
							swal(
								'Cole',
								'Sorry, an error occurred uploading this image. Please try again or select another image.',
								'error'
							);
							$('.ColeImage.Folders,.ColeImage.Files').fadeIn('fast');
						}
					},
					error: function(jqXHR, textStatus, errorThrown)
					{
						// Handle errors here
						console.log('ERRORS: ' + jqXHR, textStatus, errorThrown);
						swal(
							'Cole',
							'Sorry, an error occurred uploading this image. Please try again or select another image.',
							'error'
						);
						$('.ColeImage.Folders,.ColeImage.Files').fadeIn('fast');
					}
				});
			}
			function submitForm(event, data){
			  // Create a jQuery object from the form
				$form = $(event.target);
			
				// Serialize the form data
				var formData = $form.serialize();
			
				// You should sterilise the file names
				$.each(data.files, function(key, value){
					formData = formData + '&filenames[]=' + value;
				});
				$.ajax({
					url: '/Cole/Pages/ImgUpload',
					type: 'POST',
					data: formData,
					cache: false,
					dataType: 'json',
					success: function(data, textStatus, jqXHR){
						if(typeof data.error === 'undefined'){
							// Success so call function to process the form
							console.log('Success! Moving new upload to active dir...');
							   var FormattedPath = Cole.Picker.Path.join("/");
							   $.post("/Cole/Pages/ImgMoveFile",
							{
								File: data.formData.filenames[0],
								MoveTo: FormattedPath
							},
							function(data, status){
								$('.ColeImage.Folders,.ColeImage.Files').fadeIn('fast');
								Cole.Picker.Browse(Cole.Picker.Path); // Refresh the dir
							});
							   
											
						}else{
							// Handle errors here
							console.log('ERRORS: ' + data.error);
							swal(
								'Cole',
								'Sorry, an error occurred uploading this image. Please try again or select another image.',
								'error'
							);
						}
					},
					error: function(jqXHR, textStatus, errorThrown){
						// Handle errors here
						swal(
							'Cole',
							'Sorry, an error occurred uploading this image. Please try again or select another image.',
							'error'
						);
					}
				});
			}
		}
	},
	"BackInTime": {
		Boot: function(){
			$('body').on('click', '.ColeBit.Dates .Button[data-action=cancel]', function() {
				$('.ColeBit.Dates').hide();
				$('.ColeTool,.ColeToolkit').show();
				$('.ColeEdit').removeClass('Saving');
			});
		
			$('body').on('click', '.ColeBit.Dates ul.Picker li', function() {
				Cole.BackInTime.Preview($(this).data('backupid'));
				$('.ColeEdit').removeClass('Saving');
			});
		},
		Get: function(){
			$('.ColeTool,.ColeToolkit').hide();
			$.get( Cole.Data.Settings.ColeURL + "/api/pages/bit/get/" + Cole.Data.Page.PageMeta.id + "?Secret=" + Cole.Data.EditToken, function(api) {
				if(api.length==0){
					swal(
						'Cole',
						'You do not have any BackInTime Backups for this page. To backup, Click the Save Page button.',
						'warning'
					);
					$('.ColeTool,.ColeToolkit').show();
				}else{
					// Boot BIT
					$('.ColeBit.Dates').fadeIn();
					$('.ColeBit.Dates ul').html('');
					$('.ColeEdit').addClass('Saving');
					$.each( api, function( key, value ) {
						$('.ColeBit.Dates ul').append('<li data-backupid="' + value.id + '"><label>' + dateFormat(new Date(value.DateTime), "dd/mm/yyyy h:MM:ssTT") + '</label></li>');
					});
				}
			});
		},
		Backup: function(PageID){
			$('.ColeEdit,.ColeTool').addClass('Saving');
			$('.ColeTool i').hide();
			$('.ColeTool i.zmdi-hourglass-alt').show();
			$.get(Cole.Data.Settings.ColeURL + "/api/pages/bit/backup/" + Cole.Data.Page.PageMeta.id + "?Secret=" + Cole.Data.EditToken, function(){
				console.log('Cole: BackInTime Backup Created');
				Cole.Editor.Save();
			});
			
		},
		Restore: function(BackupID){
			// Remember to pass Cole.Data.EditToken			
			$('.ColeBit.Dates').hide();
			$('.ColeEdit,.ColeTool').addClass('Saving');
			$('.ColeTool i').hide();
			$('.ColeTool i.zmdi-hourglass-alt').show();
			$.get(Cole.Data.Settings.ColeURL + "/api/pages/bit/restore/" + BackupID + "?Secret=" + Cole.Data.EditToken, function(){
				swal({
					title: 'Cole',
					text: "The page has been restored",
					type: 'success',
					showCancelButton: false,
					allowOutsideClick: false,
					}).then((result) => {
					if (result.value) {
						location.reload();
					}
				});
			});
		},
		Preview: function(BackupID){
			$('.ColeTool,.ColeToolkit').hide();
			$('.ColeBit.Dates').hide();
			$.get( Cole.Data.Settings.ColeURL + "/api/pages/bit/backup/get/" + BackupID + "?Secret=" + Cole.Data.EditToken, function(api) {
				$('.swal2-shown').css('overflowY','auto');
				if(api.Outcome=="Success"){
					// Store old copies
					OldValues = []; // Reset
					$( ".Cole" ).each(function( index ) {
						OldValues.push ({
							Tag: $(this).attr('data-field'),
							Value: Base64.encode($(this).html())
						});
					});

					// Loop round values and put them in the values
					$.each( api.BackupData, function( key, value ) {
						$('.Cole[data-field=' + value.Tag + ']').html(Base64.decode(value.Value));
					});
					swal({
						position: 'top-end',
						type: 'question',
						title: 'Cole',
						showConfirmButton: true,
						showCancelButton: true,
						text: 'Check how the backup looks. If you are ready to restore it, Click Restore. Otherwise, click Cancel',
						confirmButtonText: 'Restore',
						allowOutsideClick: false,
						backdrop: false,
					}).then((result) => {
						// Reset swal2 scroll
						$('.swal2-shown').css('overflowY','hidden');
						$('body,html').css('overflowY','auto');
						
						$('.ColeBit.Dates').show();
						if (result.value) {
							Cole.BackInTime.Restore(BackupID);
						} else if (
						  // Read more about handling dismissals
						  result.dismiss === swal.DismissReason.cancel
						) {
							// Restore old versions
							$.each( OldValues, function( key, value ) {
								$('.Cole[data-field=' + value.Tag + ']').html(Base64.decode(value.Value));
							});

							$('.ColeBit.Dates').show();
						}
					  })
				}else{

				}
			});
		}
	},
	"Panels" : {
		Boot: function(){
			$('body').on('click', 'div.Cole.Panels div.New', function() {
				Cole.Panels.Picker();
			});
			$('body').on('click', '.ColePanels.PanelList .Button[data-action=cancel]', function() {
				$('.ColePanels.PanelList').hide();
				$('.ColeTool,.ColeToolkit').show();
				$('.ColeEdit').removeClass('Saving');
			});
			$('body').on('click', '.Cole.Panels .Panel .Remove', function() {
				var thisUid = $(this).parent().attr('data-paneluid');
				swal({
					title: 'Cole',
					text: "Are you sure you want to delete this panel?\n\nThis will not remove any text added, but just the panel.",
					type: 'warning',
					showCancelButton: true,
				}).then((result) => {
					if (result.value) {
						var ThisPanelID = $(this).parent().attr('data-panelid');
						// Remove from this page's Panels object
						$.post(Cole.Data.Settings.ColeURL + "/api/pages/panels/delete",{
							Secret: Cole.Data.EditToken,
							PageID: Cole.Data.Page.PageMeta.id,
							PanelID: ThisPanelID,
							Uid: thisUid
						},
						function(api, status){
							console.log(api);
						});
					
						$(this).parent().slideUp('fast');
						setTimeout(function(){
							$(this).parent().remove(); // remove from the dom
						}, 500);
					}
				})				
			});
			$('body').on('click', '.ColePanels.PanelList ul li', function() {
				Cole.Panels.Insert($(this).attr('data-panelid'));
			});
		},
		Picker: function(){
			$('.ColeTool,.ColeToolkit').hide();
			$('.ColePanels.PanelList').fadeIn();
			$('.ColePanels.PanelList ul.Picker').html('');
			$('.ColeEdit').addClass('Saving');
			// List the panels
			$.get(Cole.Data.Settings.ColeURL + "/api/pages/panels/list?Secret=" + Cole.Data.EditToken, function(api, status){
				console.log(api);
				$.each(api, function( key, value ) {
					$('.ColePanels.PanelList ul.Picker').append('<li data-panelid="' + value.id + '"><label>' + value.Name + '</label></li>');
				});
			});
		},
		Insert: function(PanelID){
			$('.ColePanels.PanelList').hide();
			$('.ColeTool,.ColeToolkit').show();
			$('.ColeEdit').removeClass('Saving');
			$.post("/Cole/Panels/Load",{
				id: PanelID,
				PageID: Cole.Data.Page.PageMeta.id,
				Cole: JSON.stringify(Cole.Data)
			},function(data, status){
				$.get(Cole.Data.Settings.ColeURL + "/api/pages/panels/uid/get?Secret=" + Cole.Data.EditToken, function(uid, status){
					$('.Cole.Panels div.PanelListContainer').append('<div class="Panel" data-paneluid="' + uid + '" data-panelid="' + PanelID + '"><div class="Remove"><i class="zmdi zmdi-delete"></i></div>' + data + '</div>');
				});				
			});
		}
	}
};

$(function() {
	Cole.Boot();
});

var dateFormat = function () {
    var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
        timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
        timezoneClip = /[^-+\dA-Z]/g,
        pad = function (val, len) {
            val = String(val);
            len = len || 2;
            while (val.length < len) val = "0" + val;
            return val;
        };

    // Regexes and supporting functions are cached through closure
    return function (date, mask, utc) {
        var dF = dateFormat;

        // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
        if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
            mask = date;
            date = undefined;
        }

        // Passing date through Date applies Date.parse, if necessary
        date = date ? new Date(date) : new Date;
        if (isNaN(date)) throw SyntaxError("invalid date");

        mask = String(dF.masks[mask] || mask || dF.masks["default"]);

        // Allow setting the utc argument via the mask
        if (mask.slice(0, 4) == "UTC:") {
            mask = mask.slice(4);
            utc = true;
        }

        var _ = utc ? "getUTC" : "get",
            d = date[_ + "Date"](),
            D = date[_ + "Day"](),
            m = date[_ + "Month"](),
            y = date[_ + "FullYear"](),
            H = date[_ + "Hours"](),
            M = date[_ + "Minutes"](),
            s = date[_ + "Seconds"](),
            L = date[_ + "Milliseconds"](),
            o = utc ? 0 : date.getTimezoneOffset(),
            flags = {
                d:    d,
                dd:   pad(d),
                ddd:  dF.i18n.dayNames[D],
                dddd: dF.i18n.dayNames[D + 7],
                m:    m + 1,
                mm:   pad(m + 1),
                mmm:  dF.i18n.monthNames[m],
                mmmm: dF.i18n.monthNames[m + 12],
                yy:   String(y).slice(2),
                yyyy: y,
                h:    H % 12 || 12,
                hh:   pad(H % 12 || 12),
                H:    H,
                HH:   pad(H),
                M:    M,
                MM:   pad(M),
                s:    s,
                ss:   pad(s),
                l:    pad(L, 3),
                L:    pad(L > 99 ? Math.round(L / 10) : L),
                t:    H < 12 ? "a"  : "p",
                tt:   H < 12 ? "am" : "pm",
                T:    H < 12 ? "A"  : "P",
                TT:   H < 12 ? "AM" : "PM",
                Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
            };

        return mask.replace(token, function ($0) {
            return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
        });
    };
}();

// Some common format strings
dateFormat.masks = {
    "default":      "ddd mmm dd yyyy HH:MM:ss",
    shortDate:      "m/d/yy",
    mediumDate:     "mmm d, yyyy",
    longDate:       "mmmm d, yyyy",
    fullDate:       "dddd, mmmm d, yyyy",
    shortTime:      "h:MM TT",
    mediumTime:     "h:MM:ss TT",
    longTime:       "h:MM:ss TT Z",
    isoDate:        "yyyy-mm-dd",
    isoTime:        "HH:MM:ss",
    isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
    isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
    dayNames: [
        "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
        "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
    ],
    monthNames: [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
        "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
    ]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
    return dateFormat(this, mask, utc);
};