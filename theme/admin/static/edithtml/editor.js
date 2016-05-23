!function(i){"function"==typeof define&&define.amd?define(["jquery"],i):"object"==typeof exports?module.exports=i(require("jquery")):i(jQuery)}(function($){"use strict";function i(i,t){var o=$('<div class="minicolors" />'),a=$.minicolors.defaults,s=i.attr("data-opacity"),n;i.data("minicolors-initialized")||(t=$.extend(!0,{},a,t),o.addClass("minicolors-theme-"+t.theme).toggleClass("minicolors-with-opacity",t.opacity).toggleClass("minicolors-no-data-uris",t.dataUris!==!0),void 0!==t.position&&$.each(t.position.split(" "),function(){o.addClass("minicolors-position-"+this)}),n="rgb"===t.format?t.opacity?"25":"20":t.keywords?"11":"7",i.addClass("minicolors-input").data("minicolors-initialized",!1).data("minicolors-settings",t).prop("size",n).wrap(o).after('<div class="minicolors-panel minicolors-slider-'+t.control+'"><div class="minicolors-slider minicolors-sprite"><div class="minicolors-picker"></div></div><div class="minicolors-opacity-slider minicolors-sprite"><div class="minicolors-picker"></div></div><div class="minicolors-grid minicolors-sprite"><div class="minicolors-grid-inner"></div><div class="minicolors-picker"><div></div></div></div></div>'),t.inline||(i.after('<span class="minicolors-swatch minicolors-sprite"><span class="minicolors-swatch-color"></span></span>'),i.next(".minicolors-swatch").on("click",function(t){t.preventDefault(),i.focus()})),i.parent().find(".minicolors-panel").on("selectstart",function(){return!1}).end(),t.inline&&i.parent().addClass("minicolors-inline"),r(i,!1),i.data("minicolors-initialized",!0))}function t(i){var t=i.parent();i.removeData("minicolors-initialized").removeData("minicolors-settings").removeProp("size").removeClass("minicolors-input"),t.before(i).remove()}function o(i){var t=i.parent(),o=t.find(".minicolors-panel"),s=i.data("minicolors-settings");!i.data("minicolors-initialized")||i.prop("disabled")||t.hasClass("minicolors-inline")||t.hasClass("minicolors-focus")||(a(),t.addClass("minicolors-focus"),o.stop(!0,!0).fadeIn(s.showSpeed,function(){s.show&&s.show.call(i.get(0))}))}function a(){$(".minicolors-focus").each(function(){var i=$(this),t=i.find(".minicolors-input"),o=i.find(".minicolors-panel"),a=t.data("minicolors-settings");o.fadeOut(a.hideSpeed,function(){a.hide&&a.hide.call(t.get(0)),i.removeClass("minicolors-focus")})})}function s(i,t,o){var a=i.parents(".minicolors").find(".minicolors-input"),s=a.data("minicolors-settings"),r=i.find("[class$=-picker]"),e=i.offset().left,c=i.offset().top,l=Math.round(t.pageX-e),h=Math.round(t.pageY-c),d=o?s.animationSpeed:0,u,p,g,m;t.originalEvent.changedTouches&&(l=t.originalEvent.changedTouches[0].pageX-e,h=t.originalEvent.changedTouches[0].pageY-c),0>l&&(l=0),0>h&&(h=0),l>i.width()&&(l=i.width()),h>i.height()&&(h=i.height()),i.parent().is(".minicolors-slider-wheel")&&r.parent().is(".minicolors-grid")&&(u=75-l,p=75-h,g=Math.sqrt(u*u+p*p),m=Math.atan2(p,u),0>m&&(m+=2*Math.PI),g>75&&(g=75,l=75-75*Math.cos(m),h=75-75*Math.sin(m)),l=Math.round(l),h=Math.round(h)),i.is(".minicolors-grid")?r.stop(!0).animate({top:h+"px",left:l+"px"},d,s.animationEasing,function(){n(a,i)}):r.stop(!0).animate({top:h+"px"},d,s.animationEasing,function(){n(a,i)})}function n(i,t){function o(i,t){var o,a;return i.length&&t?(o=i.offset().left,a=i.offset().top,{x:o-t.offset().left+i.outerWidth()/2,y:a-t.offset().top+i.outerHeight()/2}):null}var a,s,n,r,c,l,d,u=i.val(),p=i.attr("data-opacity"),m,f=i.parent(),v=i.data("minicolors-settings"),b=f.find(".minicolors-swatch"),y=f.find(".minicolors-grid"),C=f.find(".minicolors-slider"),M=f.find(".minicolors-opacity-slider"),x=y.find("[class$=-picker]"),I=C.find("[class$=-picker]"),S=M.find("[class$=-picker]"),z=o(x,y),F=o(I,C),j=o(S,M);if(t.is(".minicolors-grid, .minicolors-slider, .minicolors-opacity-slider")){switch(v.control){case"wheel":r=y.width()/2-z.x,c=y.height()/2-z.y,l=Math.sqrt(r*r+c*c),d=Math.atan2(c,r),0>d&&(d+=2*Math.PI),l>75&&(l=75,z.x=69-75*Math.cos(d),z.y=69-75*Math.sin(d)),s=g(l/.75,0,100),a=g(180*d/Math.PI,0,360),n=g(100-Math.floor(F.y*(100/C.height())),0,100),u=w({h:a,s:s,b:n}),C.css("backgroundColor",w({h:a,s:s,b:100}));break;case"saturation":a=g(parseInt(z.x*(360/y.width()),10),0,360),s=g(100-Math.floor(F.y*(100/C.height())),0,100),n=g(100-Math.floor(z.y*(100/y.height())),0,100),u=w({h:a,s:s,b:n}),C.css("backgroundColor",w({h:a,s:100,b:n})),f.find(".minicolors-grid-inner").css("opacity",s/100);break;case"brightness":a=g(parseInt(z.x*(360/y.width()),10),0,360),s=g(100-Math.floor(z.y*(100/y.height())),0,100),n=g(100-Math.floor(F.y*(100/C.height())),0,100),u=w({h:a,s:s,b:n}),C.css("backgroundColor",w({h:a,s:s,b:100})),f.find(".minicolors-grid-inner").css("opacity",1-n/100);break;default:a=g(360-parseInt(F.y*(360/C.height()),10),0,360),s=g(Math.floor(z.x*(100/y.width())),0,100),n=g(100-Math.floor(z.y*(100/y.height())),0,100),u=w({h:a,s:s,b:n}),y.css("backgroundColor",w({h:a,s:100,b:100}))}if(p=v.opacity?parseFloat(1-j.y/M.height()).toFixed(2):1,v.opacity&&i.attr("data-opacity",p),"rgb"===v.format){var D=k(u),p=""===i.attr("data-opacity")?1:g(parseFloat(i.attr("data-opacity")).toFixed(2),0,1);(isNaN(p)||!v.opacity)&&(p=1),m=i.minicolors("rgbObject").a<=1&&D&&v.opacity?"rgba("+D.r+", "+D.g+", "+D.b+", "+parseFloat(p)+")":"rgb("+D.r+", "+D.g+", "+D.b+")"}else m=h(u,v.letterCase);i.val(m)}b.find("span").css({backgroundColor:u,opacity:p}),e(i,m,p)}function r(i,t){var o,a,s,n,r,c,l,v,y,M,k=i.parent(),x=i.data("minicolors-settings"),I=k.find(".minicolors-swatch"),S=k.find(".minicolors-grid"),z=k.find(".minicolors-slider"),F=k.find(".minicolors-opacity-slider"),j=S.find("[class$=-picker]"),D=z.find("[class$=-picker]"),T=F.find("[class$=-picker]");switch(m(i.val())?(o=b(i.val()),r=g(parseFloat(f(i.val())).toFixed(2),0,1),r&&i.attr("data-opacity",r)):o=h(d(i.val(),!0),x.letterCase),o||(o=h(p(x.defaultValue,!0),x.letterCase)),a=C(o),n=x.keywords?$.map(x.keywords.split(","),function(i){return $.trim(i.toLowerCase())}):[],c=""!==i.val()&&$.inArray(i.val().toLowerCase(),n)>-1?h(i.val()):m(i.val())?u(i.val()):o,t||i.val(c),x.opacity&&(s=""===i.attr("data-opacity")?1:g(parseFloat(i.attr("data-opacity")).toFixed(2),0,1),isNaN(s)&&(s=1),i.attr("data-opacity",s),I.find("span").css("opacity",s),v=g(F.height()-F.height()*s,0,F.height()),T.css("top",v+"px")),"transparent"===i.val().toLowerCase()&&I.find("span").css("opacity",0),I.find("span").css("backgroundColor",o),x.control){case"wheel":y=g(Math.ceil(.75*a.s),0,S.height()/2),M=a.h*Math.PI/180,l=g(75-Math.cos(M)*y,0,S.width()),v=g(75-Math.sin(M)*y,0,S.height()),j.css({top:v+"px",left:l+"px"}),v=150-a.b/(100/S.height()),""===o&&(v=0),D.css("top",v+"px"),z.css("backgroundColor",w({h:a.h,s:a.s,b:100}));break;case"saturation":l=g(5*a.h/12,0,150),v=g(S.height()-Math.ceil(a.b/(100/S.height())),0,S.height()),j.css({top:v+"px",left:l+"px"}),v=g(z.height()-a.s*(z.height()/100),0,z.height()),D.css("top",v+"px"),z.css("backgroundColor",w({h:a.h,s:100,b:a.b})),k.find(".minicolors-grid-inner").css("opacity",a.s/100);break;case"brightness":l=g(5*a.h/12,0,150),v=g(S.height()-Math.ceil(a.s/(100/S.height())),0,S.height()),j.css({top:v+"px",left:l+"px"}),v=g(z.height()-a.b*(z.height()/100),0,z.height()),D.css("top",v+"px"),z.css("backgroundColor",w({h:a.h,s:a.s,b:100})),k.find(".minicolors-grid-inner").css("opacity",1-a.b/100);break;default:l=g(Math.ceil(a.s/(100/S.width())),0,S.width()),v=g(S.height()-Math.ceil(a.b/(100/S.height())),0,S.height()),j.css({top:v+"px",left:l+"px"}),v=g(z.height()-a.h/(360/z.height()),0,z.height()),D.css("top",v+"px"),S.css("backgroundColor",w({h:a.h,s:100,b:100}))}i.data("minicolors-initialized")&&e(i,c,s)}function e(i,t,o){var a=i.data("minicolors-settings"),s=i.data("minicolors-lastChange");s&&s.value===t&&s.opacity===o||(i.data("minicolors-lastChange",{value:t,opacity:o}),a.change&&(a.changeDelay?(clearTimeout(i.data("minicolors-changeTimeout")),i.data("minicolors-changeTimeout",setTimeout(function(){a.change.call(i.get(0),t,o)},a.changeDelay))):a.change.call(i.get(0),t,o)),i.trigger("change").trigger("input"))}function c(i){var t=d($(i).val(),!0),o=k(t),a=$(i).attr("data-opacity");return o?(void 0!==a&&$.extend(o,{a:parseFloat(a)}),o):null}function l(i,t){var o=d($(i).val(),!0),a=k(o),s=$(i).attr("data-opacity");return a?(void 0===s&&(s=1),t?"rgba("+a.r+", "+a.g+", "+a.b+", "+parseFloat(s)+")":"rgb("+a.r+", "+a.g+", "+a.b+")"):null}function h(i,t){return"uppercase"===t?i.toUpperCase():i.toLowerCase()}function d(i,t){return i=i.replace(/^#/g,""),i.match(/^[A-F0-9]{3,6}/gi)?3!==i.length&&6!==i.length?"":(3===i.length&&t&&(i=i[0]+i[0]+i[1]+i[1]+i[2]+i[2]),"#"+i):""}function u(i,t){var o=i.replace(/[^\d,.]/g,""),a=o.split(","),s;return a[0]=g(parseInt(a[0],10),0,255),a[1]=g(parseInt(a[1],10),0,255),a[2]=g(parseInt(a[2],10),0,255),a[3]&&(a[3]=g(parseFloat(a[3],10),0,1)),t?{r:a[0],g:a[1],b:a[2],a:a[3]?a[3]:null}:"undefined"!=typeof a[3]&&a[3]<=1?"rgba("+a[0]+", "+a[1]+", "+a[2]+", "+a[3]+")":"rgb("+a[0]+", "+a[1]+", "+a[2]+")"}function p(i,t){return m(i)?u(i):d(i,t)}function g(i,t,o){return t>i&&(i=t),i>o&&(i=o),i}function m(i){var t=i.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);return t&&4===t.length?!0:!1}function f(i){var i=i.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+(\.\d{1,2})?|\.\d{1,2})[\s+]?/i);return i&&6===i.length?i[4]:"1"}function v(i){var t={},o=Math.round(i.h),a=Math.round(255*i.s/100),s=Math.round(255*i.b/100);if(0===a)t.r=t.g=t.b=s;else{var n=s,r=(255-a)*s/255,e=(n-r)*(o%60)/60;360===o&&(o=0),60>o?(t.r=n,t.b=r,t.g=r+e):120>o?(t.g=n,t.b=r,t.r=n-e):180>o?(t.g=n,t.r=r,t.b=r+e):240>o?(t.b=n,t.r=r,t.g=n-e):300>o?(t.b=n,t.g=r,t.r=r+e):360>o?(t.r=n,t.g=r,t.b=n-e):(t.r=0,t.g=0,t.b=0)}return{r:Math.round(t.r),g:Math.round(t.g),b:Math.round(t.b)}}function b(i){return i=i.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i),i&&4===i.length?"#"+("0"+parseInt(i[1],10).toString(16)).slice(-2)+("0"+parseInt(i[2],10).toString(16)).slice(-2)+("0"+parseInt(i[3],10).toString(16)).slice(-2):""}function y(i){var t=[i.r.toString(16),i.g.toString(16),i.b.toString(16)];return $.each(t,function(i,o){1===o.length&&(t[i]="0"+o)}),"#"+t.join("")}function w(i){return y(v(i))}function C(i){var t=M(k(i));return 0===t.s&&(t.h=360),t}function M(i){var t={h:0,s:0,b:0},o=Math.min(i.r,i.g,i.b),a=Math.max(i.r,i.g,i.b),s=a-o;return t.b=a,t.s=0!==a?255*s/a:0,0!==t.s?i.r===a?t.h=(i.g-i.b)/s:i.g===a?t.h=2+(i.b-i.r)/s:t.h=4+(i.r-i.g)/s:t.h=-1,t.h*=60,t.h<0&&(t.h+=360),t.s*=100/255,t.b*=100/255,t}function k(i){return i=parseInt(i.indexOf("#")>-1?i.substring(1):i,16),{r:i>>16,g:(65280&i)>>8,b:255&i}}$.minicolors={defaults:{animationSpeed:50,animationEasing:"swing",change:null,changeDelay:0,control:"hue",dataUris:!0,defaultValue:"",format:"hex",hide:null,hideSpeed:100,inline:!1,keywords:"",letterCase:"lowercase",opacity:!1,position:"bottom left",show:null,showSpeed:100,theme:"default"}},$.extend($.fn,{minicolors:function(s,n){switch(s){case"destroy":return $(this).each(function(){t($(this))}),$(this);case"hide":return a(),$(this);case"opacity":return void 0===n?$(this).attr("data-opacity"):($(this).each(function(){r($(this).attr("data-opacity",n))}),$(this));case"rgbObject":return c($(this),"rgbaObject"===s);case"rgbString":case"rgbaString":return l($(this),"rgbaString"===s);case"settings":return void 0===n?$(this).data("minicolors-settings"):($(this).each(function(){var i=$(this).data("minicolors-settings")||{};t($(this)),$(this).minicolors($.extend(!0,i,n))}),$(this));case"show":return o($(this).eq(0)),$(this);case"value":return void 0===n?$(this).val():($(this).each(function(){"object"==typeof n?(n.opacity&&$(this).attr("data-opacity",g(n.opacity,0,1)),n.color&&$(this).val(n.color)):$(this).val(n),r($(this))}),$(this));default:return"create"!==s&&(n=s),$(this).each(function(){i($(this),n)}),$(this)}}}),$(document).on("mousedown.minicolors touchstart.minicolors",function(i){$(i.target).parents().add(i.target).hasClass("minicolors")||a()}).on("mousedown.minicolors touchstart.minicolors",".minicolors-grid, .minicolors-slider, .minicolors-opacity-slider",function(i){var t=$(this);i.preventDefault(),$(document).data("minicolors-target",t),s(t,i,!0)}).on("mousemove.minicolors touchmove.minicolors",function(i){var t=$(document).data("minicolors-target");t&&s(t,i)}).on("mouseup.minicolors touchend.minicolors",function(){$(this).removeData("minicolors-target")}).on("mousedown.minicolors touchstart.minicolors",".minicolors-swatch",function(i){var t=$(this).parent().find(".minicolors-input");i.preventDefault(),o(t)}).on("focus.minicolors",".minicolors-input",function(){var i=$(this);i.data("minicolors-initialized")&&o(i)}).on("blur.minicolors",".minicolors-input",function(){var i=$(this),t=i.data("minicolors-settings"),o,a,s,n,r;i.data("minicolors-initialized")&&(o=t.keywords?$.map(t.keywords.split(","),function(i){return $.trim(i.toLowerCase())}):[],""!==i.val()&&$.inArray(i.val().toLowerCase(),o)>-1?r=i.val():(m(i.val())?s=u(i.val(),!0):(a=d(i.val(),!0),s=a?k(a):null),r=null===s?t.defaultValue:"rgb"===t.format?u(t.opacity?"rgba("+s.r+","+s.g+","+s.b+","+i.attr("data-opacity")+")":"rgb("+s.r+","+s.g+","+s.b+")"):y(s)),n=t.opacity?i.attr("data-opacity"):1,"transparent"===r.toLowerCase()&&(n=0),i.closest(".minicolors").find(".minicolors-swatch > span").css("opacity",n),i.val(r),""===i.val()&&i.val(p(t.defaultValue,!0)),i.val(h(i.val(),t.letterCase)))}).on("keydown.minicolors",".minicolors-input",function(i){var t=$(this);if(t.data("minicolors-initialized"))switch(i.keyCode){case 9:a();break;case 13:case 27:a(),t.blur()}}).on("keyup.minicolors",".minicolors-input",function(){var i=$(this);i.data("minicolors-initialized")&&r(i,!0)}).on("paste.minicolors",".minicolors-input",function(){var i=$(this);i.data("minicolors-initialized")&&setTimeout(function(){r(i,!0)},1)})});
(function($){
    var excludeBootstrap= ['col-','hidden','row','modal','padding0','margin0','dialog-active'];
    Array.prototype.includeOf = function (str){
        for (var i = 0; i < this.length; i++) {
            var item = this[i];
            if(item.indexOf(str) !=-1 || str.indexOf(item)!=-1){
                return true;
            }
        };
        return false;
    }
    String.prototype.replaceAll=function (find,replace){
        return this.replace(new RegExp(find, 'g'), replace);
    }
    $.fn.getPath = function( path ) {
        if ( typeof path == 'undefined' ) path = '';
        if ( this.is('html') )
            return 'html'+ path;
        var cur = this.get(0).nodeName.toLowerCase();
        var id    = this.attr('id'),
            clazz = this.attr('class');
        if ( typeof id != 'undefined' )
            cur += '#' + id;
        if ( typeof clazz != 'undefined' )
        {
            var arr = clazz.split(/[\s\n]+/);
            if(clazz.trim().length>0){
                for(var i =0;i<arr.length;i++){
                    if(excludeBootstrap.includeOf(arr[i].toLowerCase())){
                        continue;
                    }
              if(arr[i].trim().length>0){      cur +="."+arr[i];}
                }
            }
        }
        var v = ' > ' +cur+path;
        return this.parent().getPath(v);
        
    }
    $.fn.getSimplePath = function(){
        var id    = this.attr('id'),clazz = this.attr('class');
        clazz = clazz!=undefined ?clazz:"";
        var cur = this.get(0).nodeName.toLowerCase();
        var arr = clazz.split(/[\s\n]+/);
        cur = cur+(id!=undefined?"#"+id:"");
        if(clazz.trim().length>0){
            for(var i =0;i<arr.length;i++){
                if(excludeBootstrap.includeOf(arr[i].toLowerCase())){
                    continue;
                }
                if(arr[i].trim().length>0){      cur +="."+arr[i];}
            }
        }
        return cur;

    }
    function getMatchedStyle(elem, property){
    // element property has highest priority
    var val = elem.style.getPropertyValue(property);

    // if it's important, we are done
    if(elem.style.getPropertyPriority(property))
        return val;

    // get matched rules
    var rules = getMatchedCSSRules(elem);

    // iterate the rules backwards
    // rules are ordered by priority, highest last
    for(var i = rules.length; i --> 0;){
        var r = rules[i];

        var important = r.style.getPropertyPriority(property);

        // if set, only reset if important
        if(val == null || important){
            val = r.style.getPropertyValue(property);

            // done if important
            if(important)
                break;
        }
    }

    return val;
}

    $.fn.getMatchedStyle = function(prop){
        var elem = this.get(0);
        var val = elem.style.getPropertyValue(property);
        if(elem.style.getPropertyPriority(property))
            return val;
        var rules = getMatchedCSSRules(elem);
        for(var i = rules.length; i --> 0;){
            var r = rules[i];

            var important = r.style.getPropertyPriority(property);
            if(val == null || important){
                val = r.style.getPropertyValue(property);
                if(important)
                    break;
            }
        }

        return val;
    }

    $.fn.getStyleObject = function(){
        var dom = this.get(0);
        var style;
        var returns = {};
        if(window.getComputedStyle){
            var camelize = function(a,b){
                return b.toUpperCase();
            };
            style = window.getComputedStyle(dom, null);
            for(var i = 0, l = style.length; i < l; i++){
                var prop = style[i];
                var camel = prop.replace(/\-([a-z])/g, camelize);
                var val = style.getPropertyValue(prop);
                returns[camel] = val;
            };
            return returns;
        };
        if(style = dom.currentStyle){
            for(var prop in style){
                returns[prop] = style[prop];
            };
            return returns;
        };
        return this.css();
    }



})(jQuery);
    var camelize = function(a,b){return '-'+a.toLowerCase(); };
    var excludeElementHover = ['.rightmenu'];
    var globalElementHover = undefined;
    
    var staticStyle =["font-weight","color","font-size",'width','height','background-color','left','top','right','bottom','position','margin','padding','max-width','max-height',
'min-height','min-width','word-spacing','z-index','display','visibility','border-color','border-width','margin-top','margin-bottom','margin-left','margin-right',
'padding-top','padding-bottom','padding-left','padding-right']
    $(function() {
        $(document).mouseover(function(e) {
            if($('body').hasClass('dialog-active') || $('.rightmenu').is(":visible")){
                return;
            }
            var x = e.clientX, y = e.clientY,
                elementOnMouseOver = document.elementFromPoint(x, y);
                globalElementHover = elementOnMouseOver;
                $(elementOnMouseOver).append('<span class="spanclass">'+$(elementOnMouseOver).getSimplePath()+'</span>');
                $(elementOnMouseOver).css({'outline':'1px solid #000'});
                $(elementOnMouseOver).mouseout(function() {
                    $( this ).css({'outline':'none'});
                    $('.spanclass').remove();
                });
        });
        $(document).click(function(event) { 
            if(!$(event.target).closest('.rightmenu').length) {
                if($('.rightmenu').is(":visible")) {
                    $('.rightmenu').hide()
                }
            }        
        })
        $(document).bind("contextmenu", function (event) {
            event.preventDefault();

            $(".rightmenu").show(400).
                css({
                    top: event.pageY + "px",
                    left: event.pageX + "px"
                });
        });
        /*click right click*/
        $('.rightmenu').on('click', 'li', function(event) {
            event.preventDefault();
            var action = $(this).attr('dt-action');
            switch(action){
                case 'editstyle':
                openDialog();
                openStyleDialog();
                break;
            }
        });
    });
    function openStyleDialog(){
        if(globalElementHover!=undefined){
            var arrStyle = $(globalElementHover).getStyleObject();
            var str="";
            var path = $(globalElementHover).getPath();
            $('.tablestyle').attr('dt-path',path);
            for (var i in arrStyle) {
                var style = arrStyle[i];
                i = i.replace(/[A-Z]/g, camelize);    
                if($.inArray(i, staticStyle)!=-1){
                    
                    str +="<tr>";
                    str +="<td style='width:80px;'>"+i+"</td>";
                    var type = " type='text' ";
                    if($.isNumeric(i.toLowerCase().replaceAll('px'))){
                        type = " type='number' ";
                    }
                    else if( i.toLowerCase().indexOf('color')!=-1){
                        type="type='text' class='colorpicker' ";
                    }
                    str +="<td><input dt-key = '"+i+"' "+type+" placeholder='' value ='"+style+"'></td>";
                    str +="</tr>";
                }
            };
            
            $('.tablestyle').html(str);
            initColorPicker();
        }
    }
    function openDialog(title,html){
        $('.bg-dialog .dialog table').html(html);
        $('.bg-dialog h3.title').text(title);
        $('body').addClass('dialog-active');
        $('.bg-dialog').fadeIn(500);
    }
    function closeDialog(){
        $('body').removeClass('dialog-active');
        $('.bg-dialog').fadeOut(500);
    }


function createElementStyle(){
    if($('#stylenow').length==0){
        $('body').append('<style id="stylenow"></style>');    
    }
    var arrInputs = $('.tablestyle tr td input');
    var style = $('.tablestyle').attr('dt-path')+"{";
    for (var i = 0; i < arrInputs.length; i++) {
        var item = arrInputs[i];
        style +=$(item).attr('dt-key')+":"+$(item).val()+";"
    };
    style += "}";
    $('#stylenow').append(style);
    $('.tablestyle').html('');
    closeDialog();
}
function submitServer(){
    $('bg-load').fadeIn(500);
    $.ajax({
        url: 'Vindex/editStyle',
        type: 'POST',
        data: {style:$('#stylenow').html()},
    })
    .done(function(e) {
        alert(e);
        $('bg-load').delay(500).fadeOut(500);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
}
function initColorPicker(){
    $('.colorpicker').minicolors({
        control: 'hue',
        defaultValue: $(this).attr('data-defaultValue') || '',
        format: $(this).attr('data-format') || 'hex',
        keywords: $(this).attr('data-keywords') || '',
        inline: $(this).attr('data-inline') === 'true',
        letterCase: $(this).attr('data-letterCase') || 'lowercase',
        opacity: $(this).attr('data-opacity'),
        position: $(this).attr('data-position') || 'bottom left',
        change: function(hex, opacity) {
            var log;
            try {
                log = hex ? hex : 'transparent';
                if( opacity ) log += ', ' + opacity;
                console.log(log);
            } catch(e) {}
        },
        theme: 'default'
    });
}