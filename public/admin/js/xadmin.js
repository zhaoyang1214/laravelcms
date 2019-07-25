$(function () {
    //加载弹出层
    layui.use(['form','element'],
    function() {
        layer = layui.layer;
        element = layui.element;
    });

    //触发事件
  var tab = {
        tabAdd: function(title,url,id){
          //新增一个Tab项
          element.tabAdd('xbs_tab', {
            title: title 
            ,content: '<iframe tab-id="'+id+'" frameborder="0" src="'+url+'" scrolling="yes" class="x-iframe"></iframe>'
            ,id: id
          })
        }
        ,tabDelete: function(othis){
          //删除指定Tab项
          element.tabDelete('xbs_tab', '44'); //删除：“商品管理”
          
          
          othis.addClass('layui-btn-disabled');
        }
        ,tabChange: function(id){
          //切换到指定Tab项
          element.tabChange('xbs_tab', id); //切换到：用户管理
        }
      };


    tableCheck = {
        init:function  () {
            $(".layui-form-checkbox").click(function(event) {
                if($(this).hasClass('layui-form-checked')){
                    $(this).removeClass('layui-form-checked');
                    if($(this).hasClass('header')){
                        $(".layui-form-checkbox").removeClass('layui-form-checked');
                    }
                }else{
                    $(this).addClass('layui-form-checked');
                    if($(this).hasClass('header')){
                        $(".layui-form-checkbox").addClass('layui-form-checked');
                    }
                }
                
            });
        },
        getData:function  () {
            var obj = $(".layui-form-checked").not('.header');
            var arr=[];
            obj.each(function(index, el) {
                arr.push(obj.eq(index).attr('data-id'));
            });
            return arr;
        }
    }

    //开启表格多选
    tableCheck.init();
      

    $('.container .left_open i').click(function(event) {
        if($('.left-nav').css('left')=='0px'){
            $('.left-nav').animate({left: '-221px'}, 100);
            $('.page-content').animate({left: '0px'}, 100);
            $('.page-content-bg').hide();
        }else{
            $('.left-nav').animate({left: '0px'}, 100);
            $('.page-content').animate({left: '221px'}, 100);
            if($(window).width()<768){
                $('.page-content-bg').show();
            }
        }

    });

    $('.page-content-bg').click(function(event) {
        $('.left-nav').animate({left: '-221px'}, 100);
        $('.page-content').animate({left: '0px'}, 100);
        $(this).hide();
    });

    $('.layui-tab-close').click(function(event) {
        $('.layui-tab-title li').eq(0).find('i').remove();
    });

   $("tbody.x-cate tr[fid!='0']").hide();
    // 栏目多级显示效果
    $('.x-show').click(function () {
        if($(this).attr('status')=='true'){
            $(this).html('&#xe625;'); 
            $(this).attr('status','false');
            cateId = $(this).parents('tr').attr('cate-id');
            $("tbody tr[fid="+cateId+"]").show();
       }else{
            cateIds = [];
            $(this).html('&#xe623;');
            $(this).attr('status','true');
            cateId = $(this).parents('tr').attr('cate-id');
            getCateId(cateId);
            for (var i in cateIds) {
                $("tbody tr[cate-id="+cateIds[i]+"]").hide().find('.x-show').html('&#xe623;').attr('status','true');
            }
       }
    })

    //左侧菜单效果
    // $('#content').bind("click",function(event){
    $('.left-nav #nav li').click(function (event) {

        if($(this).children('.sub-menu').length){
            if($(this).hasClass('open')){
                $(this).removeClass('open');
                $(this).find('.nav_right').html('&#xe697;');
                $(this).children('.sub-menu').stop().slideUp();
                $(this).siblings().children('.sub-menu').slideUp();
            }else{
                $(this).addClass('open');
                $(this).children('a').find('.nav_right').html('&#xe6a6;');
                $(this).children('.sub-menu').stop().slideDown();
                $(this).siblings().children('.sub-menu').stop().slideUp();
                $(this).siblings().find('.nav_right').html('&#xe697;');
                $(this).siblings().removeClass('open');
            }
        }else{

            var url = $(this).children('a').attr('_href');
            var title = $(this).find('cite').html();
            var index  = $('.left-nav #nav li').index($(this));

            for (var i = 0; i <$('.x-iframe').length; i++) {
                if($('.x-iframe').eq(i).attr('tab-id')==index+1){
                    tab.tabChange(index+1);
                    event.stopPropagation();
                    return;
                }
            };
            
            tab.tabAdd(title,url,index+1);
            tab.tabChange(index+1);
        }
        
        event.stopPropagation();
         
    })
    
})
var cateIds = [];
function getCateId(cateId) {
    
    $("tbody tr[fid="+cateId+"]").each(function(index, el) {
        id = $(el).attr('cate-id');
        cateIds.push(id);
        getCateId(id);
    });
}

/*弹出层*/
/*
    参数解释：
    title   标题
    url     请求的url
    id      需要操作的数据id
    w       弹出层宽度（缺省调默认值）
    h       弹出层高度（缺省调默认值）
*/
function x_admin_show(title,url,w,h){
    if (title == null || title == '') {
        title=false;
    };
    if (url == null || url == '') {
        url="404.html";
    };
    if (w == null || w == '') {
        w=($(window).width()*0.9);
    };
    if (h == null || h == '') {
        h=($(window).height() - 50);
    };
    layer.open({
        type: 2,
        area: [w+'px', h +'px'],
        fix: false, //不固定
        maxmin: true,
        shadeClose: true,
        shade:0.4,
        title: title,
        content: url
    });
}

/*关闭弹出框口*/
function x_admin_close(reload = false){
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    if(reload) {
    	parent.location.reload();
    }
}

(function(a){a.fn.powerFloat=function(d){return a(this).each(function(){var f=a.extend({},b,d||{});var g=function(i,h){if(c.target&&c.target.css("display")!=="none"){c.targetHide()}c.s=i;c.trigger=h},e;switch(f.eventType){case"hover":a(this).hover(function(){if(c.timerHold){c.flagDisplay=true}var h=parseInt(f.showDelay,10);g(f,a(this));if(h){if(e){clearTimeout(e)}e=setTimeout(function(){c.targetGet.call(c)},h)}else{c.targetGet()}},function(){if(e){clearTimeout(e)}if(c.timerHold){clearTimeout(c.timerHold)}c.flagDisplay=false;c.targetHold()});if(f.hoverFollow){a(this).mousemove(function(h){c.cacheData.left=h.pageX;c.cacheData.top=h.pageY;c.targetGet.call(c);return false})}break;case"click":a(this).click(function(h){if(c.display&&c.trigger&&h.target===c.trigger.get(0)){c.flagDisplay=false;c.displayDetect()}else{g(f,a(this));c.targetGet();if(!a(document).data("mouseupBind")){a(document).bind("mouseup",function(k){var i=false;if(c.trigger){var j=c.target.attr("id");if(!j){j="R_"+Math.random();c.target.attr("id",j)}a(k.target).parents().each(function(){if(a(this).attr("id")===j){i=true}});if(f.eventType==="click"&&c.display&&k.target!=c.trigger.get(0)&&!i){c.flagDisplay=false;c.displayDetect()}}return false}).data("mouseupBind",true)}}});break;case"focus":a(this).focus(function(){var h=a(this);setTimeout(function(){g(f,h);c.targetGet()},200)}).blur(function(){c.flagDisplay=false;setTimeout(function(){c.displayDetect()},190)});break;default:g(f,a(this));c.targetGet();a(document).unbind("mouseup").data("mouseupBind",false)}})};var c={targetGet:function(){if(!this.trigger){return this}var h=this.trigger.attr(this.s.targetAttr),g=this.s.target;switch(this.s.targetMode){case"common":if(g){var i=typeof(g);if(i==="object"){if(g.size()){c.target=g.eq(0)}}else{if(i==="string"){if(a(g).size()){c.target=a(g).eq(0)}}}}else{if(h&&a("#"+h).size()){c.target=a("#"+h)}}if(c.target){c.targetShow()}else{return this}break;case"ajax":var d=g||h;this.targetProtect=false;if(!d){return}if(!c.cacheData[d]){c.loading()}var f=new Image();f.onload=function(){var m=f.width,q=f.height;var p=a(window).width(),s=a(window).height();var r=m/q,o=p/s;if(r>o){if(m>p/2){m=p/2;q=m/r}}else{if(q>s/2){q=s/2;m=q*r}}var n='<img class="float_ajax_image" src="'+d+'" width="'+m+'" height = "'+q+'" />';c.cacheData[d]=true;c.target=a(n);c.targetShow()};f.onerror=function(){if(/(\.jpg|\.png|\.gif|\.bmp|\.jpeg)$/i.test(d)){c.target=a('<div class="float_ajax_error">图片加载失败。</div>');c.targetShow()}else{a.ajax({url:d,success:function(m){if(typeof(m)==="string"){c.cacheData[d]=true;c.target=a('<div class="float_ajax_data">'+m+"</div>");c.targetShow()}},error:function(){c.target=a('<div class="float_ajax_error">数据没有加载成功。</div>');c.targetShow()}})}};f.src=d;break;case"list":var k='<ul class="float_list_ul">',j;if(a.isArray(g)&&(j=g.length)){a.each(g,function(n,p){var o="",r="",q,m;if(n===0){r=' class="float_list_li_first"'}if(n===j-1){r=' class="float_list_li_last"'}if(typeof(p)==="object"&&(q=p.text.toString())){if(m=(p.href||"javascript:")){o='<a href="'+m+'" class="float_list_a">'+q+"</a>"}else{o=q}}else{if(typeof(p)==="string"&&p){o=p}}if(o){k+="<li"+r+">"+o+"</li>"}})}else{k+='<li class="float_list_null">列表无数据。</li>'}k+="</ul>";c.target=a(k);this.targetProtect=false;c.targetShow();break;case"remind":var l=g||h;this.targetProtect=false;if(typeof(l)==="string"){c.target=a("<span>"+l+"</span>");c.targetShow()}break;default:var e=g||h,i=typeof(e);if(e){if(i==="string"){if(/<.*>/.test(e)){c.target=a("<div>"+e+"</div>");this.targetProtect=false}else{if(a(e).size()){c.target=a(e).eq(0);this.targetProtect=true}else{if(a("#"+e).size()){c.target=a("#"+e).eq(0);this.targetProtect=true}else{c.target=a("<div>"+e+"</div>");this.targetProtect=false}}}c.targetShow()}else{if(i==="object"){if(!a.isArray(e)&&e.size()){c.target=e.eq(0);this.targetProtect=true;c.targetShow()}}}}}return this},container:function(){var d=this.s.container,e=this.s.targetMode||"mode";if(e==="ajax"||e==="remind"){this.s.sharpAngle=true}else{this.s.sharpAngle=false}if(this.s.reverseSharp){this.s.sharpAngle=!this.s.sharpAngle}if(e!=="common"){if(d===null){d="plugin"}if(d==="plugin"){if(!a("#floatBox_"+e).size()){a('<div id="floatBox_'+e+'" class="float_'+e+'_box"></div>').appendTo(a("body")).hide()}d=a("#floatBox_"+e)}if(d&&typeof(d)!=="string"&&d.size()){if(this.targetProtect){c.target.show().css("position","static")}c.target=d.empty().append(c.target)}}return this},setWidth:function(){var d=this.s.width;if(d==="auto"){if(this.target.get(0).style.width){this.target.css("width","auto")}}else{if(d==="inherit"){this.target.width(this.trigger.width())}else{this.target.css("width",d)}}return this},position:function(){if(!this.trigger||!this.target){return this}var h,x=0,k=0,m=0,y=0,s,o,e,E,u,q,f=this.target.data("height"),C=this.target.data("width"),r=a(window).scrollTop(),B=parseInt(this.s.offsets.x,10)||0,A=parseInt(this.s.offsets.y,10)||0,w=this.cacheData;if(!f){f=this.target.outerHeight();if(this.s.hoverFollow){this.target.data("height",f)}}if(!C){C=this.target.outerWidth();if(this.s.hoverFollow){this.target.data("width",C)}}h=this.trigger.offset();x=this.trigger.outerHeight();k=this.trigger.outerWidth();s=h.left;o=h.top;var l=function(){if(s<0){s=0}else{if(s+x>a(window).width()){s=a(window).width()=x}}},i=function(){if(o<0){o=0}else{if(o+x>a(document).height()){o=a(document).height()-x}}};if(this.s.hoverFollow&&w.left&&w.top){if(this.s.hoverFollow==="x"){s=w.left;l()}else{if(this.s.hoverFollow==="y"){o=w.top;i()}else{s=w.left;o=w.top;l();i()}}}var g=["4-1","1-4","5-7","2-3","2-1","6-8","3-4","4-3","8-6","1-2","7-5","3-2"],v=this.s.position,d=false,j;a.each(g,function(F,G){if(G===v){d=true;return}});if(!d){v="4-1"}var D=function(F){var G="bottom";switch(F){case"1-4":case"5-7":case"2-3":G="top";break;case"2-1":case"6-8":case"3-4":G="right";break;case"1-2":case"8-6":case"4-3":G="left";break;case"4-1":case"7-5":case"3-2":G="bottom";break}return G};var n=function(F){if(F==="5-7"||F==="6-8"||F==="8-6"||F==="7-5"){return true}return false};var t=function(H){var I=0,F=0,G=(c.s.sharpAngle&&c.corner)?true:false;if(H==="right"){F=s+k+C+B;if(G){F+=c.corner.width()}if(F>a(window).width()){return false}}else{if(H==="bottom"){I=o+x+f+A;if(G){I+=c.corner.height()}if(I>r+a(window).height()){return false}}else{if(H==="top"){I=f+A;if(G){I+=c.corner.height()}if(I>o-r){return false}}else{if(H==="left"){F=C+B;if(G){F+=c.corner.width()}if(F>s){return false}}}}}return true};j=D(v);if(this.s.sharpAngle){this.createSharp(j)}if(this.s.edgeAdjust){if(t(j)){(function(){if(n(v)){return}var G={top:{right:"2-3",left:"1-4"},right:{top:"2-1",bottom:"3-4"},bottom:{right:"3-2",left:"4-1"},left:{top:"1-2",bottom:"4-3"}};var H=G[j],F;if(H){for(F in H){if(!t(F)){v=H[F]}}}})()}else{(function(){if(n(v)){var G={"5-7":"7-5","7-5":"5-7","6-8":"8-6","8-6":"6-8"};v=G[v]}else{var H={top:{left:"3-2",right:"4-1"},right:{bottom:"1-2",top:"4-3"},bottom:{left:"2-3",right:"1-4"},left:{bottom:"2-1",top:"3-4"}};var I=H[j],F=[];for(name in I){F.push(name)}if(t(F[0])||!t(F[1])){v=I[F[0]]}else{v=I[F[1]]}}})()}}var z=D(v),p=v.split("-")[0];if(this.s.sharpAngle){this.createSharp(z);m=this.corner.width(),y=this.corner.height()}if(this.s.hoverFollow){if(this.s.hoverFollow==="x"){e=s+B;if(p==="1"||p==="8"||p==="4"){e=s-(C-k)/2+B}else{e=s-(C-k)+B}if(p==="1"||p==="5"||p==="2"){E=o-A-f-y;q=o-y-A-1}else{E=o+x+A+y;q=o+x+A+1}u=h.left-(m-k)/2}else{if(this.s.hoverFollow==="y"){if(p==="1"||p==="5"||p==="2"){E=o-(f-x)/2+A}else{E=o-(f-x)+A}if(p==="1"||p==="8"||p==="4"){e=s-C-B-m;u=s-m-B-1}else{e=s+k-B+m;u=s+k+B+1}q=h.top-(y-x)/2}else{e=s+B;E=o+A}}}else{switch(z){case"top":E=o-A-f-y;if(p=="1"){e=s-B}else{if(p==="5"){e=s-(C-k)/2-B}else{e=s-(C-k)-B}}q=o-y-A-1;u=s-(m-k)/2;break;case"right":e=s+k+B+m;if(p=="2"){E=o+A}else{if(p==="6"){E=o-(f-x)/2+A}else{E=o-(f-x)+A}}u=s+k+B+1;q=o-(y-x)/2;break;case"bottom":E=o+x+A+y;if(p=="4"){e=s+B}else{if(p==="7"){e=s-(C-k)/2+B}else{e=s-(C-k)+B}}q=o+x+A+1;u=s-(m-k)/2;break;case"left":e=s-C-B-m;if(p=="2"){E=o-A}else{if(p==="6"){E=o-(C-k)/2-A}else{E=o-(f-x)-A}}u=e+m;q=o-(C-m)/2;break}}if(y&&m&&this.corner){this.corner.css({left:u,top:q,zIndex:this.s.zIndex+1})}this.target.css({position:"absolute",left:e,top:E,zIndex:this.s.zIndex});return this},createSharp:function(g){var j,k,f="",d="";var i={left:"right",right:"left",bottom:"top",top:"bottom"},e=i[g]||"top";if(this.target){j=this.target.css("background-color");if(parseInt(this.target.css("border-"+e+"-width"))>0){k=this.target.css("border-"+e+"-color")}if(k&&k!=="transparent"){f='style="color:'+k+';"'}else{f='style="display:none;"'}if(j&&j!=="transparent"){d='style="color:'+j+';"'}else{d='style="display:none;"'}}var h='<div id="floatCorner_'+g+'" class="float_corner float_corner_'+g+'"><span class="corner corner_1" '+f+'>◆</span><span class="corner corner_2" '+d+">◆</span></div>";if(!a("#floatCorner_"+g).size()){a("body").append(a(h))}this.corner=a("#floatCorner_"+g);return this},targetHold:function(){if(this.s.hoverHold){var d=parseInt(this.s.hideDelay,10)||200;if(this.target){this.target.hover(function(){c.flagDisplay=true},function(){if(c.timerHold){clearTimeout(c.timerHold)}c.flagDisplay=false;c.targetHold()})}c.timerHold=setTimeout(function(){c.displayDetect.call(c)},d)}else{this.displayDetect()}return this},loading:function(){this.target=a('<div class="float_loading"></div>');this.targetShow();this.target.removeData("width").removeData("height");return this},displayDetect:function(){if(!this.flagDisplay&&this.display){this.targetHide();this.timerHold=null}return this},targetShow:function(){c.cornerClear();this.display=true;this.container().setWidth().position();this.target.show();if(a.isFunction(this.s.showCall)){this.s.showCall.call(this.trigger,this.target)}return this},targetHide:function(){this.display=false;this.targetClear();this.cornerClear();if(a.isFunction(this.s.hideCall)){this.s.hideCall.call(this.trigger)}this.target=null;this.trigger=null;this.s={};this.targetProtect=false;return this},targetClear:function(){if(this.target){if(this.target.data("width")){this.target.removeData("width").removeData("height")}if(this.targetProtect){this.target.children().hide().appendTo(a("body"))}this.target.unbind().hide()}},cornerClear:function(){if(this.corner){this.corner.remove()}},target:null,trigger:null,s:{},cacheData:{},targetProtect:false};a.powerFloat={};a.powerFloat.hide=function(){c.targetHide()};var b={width:"auto",offsets:{x:0,y:0},zIndex:999,eventType:"hover",showDelay:0,hideDelay:0,hoverHold:true,hoverFollow:false,targetMode:"common",target:null,targetAttr:"rel",container:null,reverseSharp:false,position:"4-1",edgeAdjust:true,showCall:a.noop,hideCall:a.noop}})(jQuery);

function advanced(){
	$('.advanced').toggle();
}

//soColorPacker 1.0 
(function(a){a.fn.extend({soColorPacker:function(c){c=a.extend({changeTarget:null,textChange:true,colorChange:1,selfBgChange:false,size:2,x:0,y:20,styleClass:null,callback:function(){}},c||{});function b(){var d=a('<div class="colorPackerBox"></div>');var g=["FF","CC","99","66","33","00"];var l=[],m="";for(var h=0;h<6;h++){m+='<div class="div_cellBox">';for(var f=0;f<6;f++){for(var e=0;e<6;e++){var n=g[h]+g[f]+g[e];m+='<span class="span_colorCell" style="background-color:#'+n+'" rel="#'+n+'"></span>'}}m+="</div>"}m+='<div class="overShowbox"><span class="span_overBg"></span><span class="span_overValue"></span><span class="span_close">关闭</span></div>';d.append(m);return d}return this.each(function(){var d;a.data(a(this).get(0),"colorPackSa",{hasColorPacker:false});a(this).click(function(h){var j=a(h.target);if(false==a.data(j.get(0),"colorPackSa").hasColorPacker){a.data(j.get(0),"colorPackSa",{hasColorPacker:true});d=b();a("body").append(d);if(a.fn.bgIframe){a(d).bgiframe()}if(c.styleClass){a(d).addClass(c.styleClass)}if(c.size==1){a(d).width(162);a(".div_cellBox",d).width(54);a(".span_colorCell",d).css({width:"8px",height:"8px"})}if(c.size==3){a(d).width(270);a(".div_cellBox",d).width(90);a(".span_colorCell",d).css({width:"14px",height:"14px"})}var g=j.findPosition();var f=(parseInt(c.x)?parseInt(c.x):0)+g[0];var k=(parseInt(c.y)?parseInt(c.y):0)+g[1];a(d).css({position:"absolute",left:f,top:k});var e;e=(c.changeTarget)?a(c.changeTarget):j;if(e.val().indexOf("#")==0){var i=e.val();a(".span_overBg",d).css("backgroundColor",i);a(".span_overValue",d).text(i)}a(".span_colorCell",d).bind("click",function(){var l=a(this).attr("rel");if(c.colorChange==1){e.css("color",l)}if(c.colorChange==2){e.css("backgroundColor",l)}if(c.selfBgChange){j.css("backgroundColor",l)}if(c.textChange){if(e.is("input")&&"text"==e.attr("type")){e.val(l)}else{e.text(l)}}c.callback({color:l});l=null;d.remove();d=null;a.data(j.get(0),"colorPackSa",{hasColorPacker:false})}).bind("mouseover",function(){var l=a(this).attr("rel");a(".span_overBg",d).css("backgroundColor",l);a(".span_overValue",d).text(l);l=null});a(".span_close",d).bind("click",function(){d.remove();d=null;a.data(j.get(0),"colorPackSa",{hasColorPacker:false})})}})})},findPosition:function(){var b=a(this).get(0);var c=curtop=0;if(b.offsetParent){do{c+=b.offsetLeft;curtop+=b.offsetTop}while(b=b.offsetParent);return[c,curtop]}else{return false}}})})(jQuery);
//Tags Input Plugin
(function(a){var b=new Array;var c=new Array;a.fn.doAutosize=function(b){var c=a(this).data("minwidth"),d=a(this).data("maxwidth"),e="",f=a(this),g=a("#"+a(this).data("tester_id"));if(e===(e=f.val())){return}var h=e.replace(/&/g,"&").replace(/\s/g," ").replace(/</g,"<").replace(/>/g,">");g.html(h);var i=g.width(),j=i+b.comfortZone>=c?i+b.comfortZone:c,k=f.width(),l=j<k&&j>=c||j>c&&j<d;if(l){f.width(j)}};a.fn.resetAutosize=function(b){var c=a(this).data("minwidth")||b.minInputWidth||a(this).width(),d=a(this).data("maxwidth")||b.maxInputWidth||a(this).closest(".tagsinput").width()-b.inputPadding,e="",f=a(this),g=a("<tester/>").css({position:"absolute",top:-9999,left:-9999,width:"auto",fontSize:f.css("fontSize"),fontFamily:f.css("fontFamily"),fontWeight:f.css("fontWeight"),letterSpacing:f.css("letterSpacing"),whiteSpace:"nowrap"}),h=a(this).attr("id")+"_autosize_tester";if(!a("#"+h).length>0){g.attr("id",h);g.appendTo("body")}f.data("minwidth",c);f.data("maxwidth",d);f.data("tester_id",h);f.css("width",c)};a.fn.addTag=function(d,e){e=jQuery.extend({focus:false,callback:true},e);this.each(function(){var f=a(this).attr("id");var g=a(this).val().split(b[f]);if(g[0]==""){g=new Array}d=jQuery.trim(d);if(e.unique){var h=a(g).tagExist(d);if(h==true){a("#"+f+"_tag").addClass("not_valid")}}else{var h=false}if(d!=""&&h!=true){a("<span>").addClass("tag").append(a("<span>").text(d).append("  "),a("<a>",{href:"#",title:"Removing tag",text:"x"}).click(function(){return a("#"+f).removeTag(escape(d))})).insertBefore("#"+f+"_addTag");g.push(d);a("#"+f+"_tag").val("");if(e.focus){a("#"+f+"_tag").focus()}else{a("#"+f+"_tag").blur()}a.fn.tagsInput.updateTagsField(this,g);if(e.callback&&c[f]&&c[f]["onAddTag"]){var i=c[f]["onAddTag"];i.call(this,d)}if(c[f]&&c[f]["onChange"]){var j=g.length;var i=c[f]["onChange"];i.call(this,a(this),g[j-1])}}});return false};a.fn.removeTag=function(d){d=unescape(d);this.each(function(){var e=a(this).attr("id");var f=a(this).val().split(b[e]);a("#"+e+"_tagsinput .tag").remove();str="";for(i=0;i<f.length;i++){if(f[i]!=d){str=str+b[e]+f[i]}}a.fn.tagsInput.importTags(this,str);if(c[e]&&c[e]["onRemoveTag"]){var g=c[e]["onRemoveTag"];g.call(this,d)}});return false};a.fn.tagExist=function(b){return jQuery.inArray(b,a(this))>=0};a.fn.importTags=function(b){id=a(this).attr("id");a("#"+id+"_tagsinput .tag").remove();a.fn.tagsInput.importTags(this,b)};a.fn.tagsInput=function(d){var e=jQuery.extend({interactive:true,defaultText:"add a tag",minChars:0,width:"300px",height:"100px",autocomplete:{selectFirst:false},hide:true,delimiter:",",unique:true,removeWithBackspace:true,placeholderColor:"#666666",autosize:true,comfortZone:20,inputPadding:6*2},d);this.each(function(){if(e.hide){a(this).hide()}var d=a(this).attr("id");if(!d||b[a(this).attr("id")]){d=a(this).attr("id","tags"+(new Date).getTime()).attr("id")}var f=jQuery.extend({pid:d,real_input:"#"+d,holder:"#"+d+"_tagsinput",input_wrapper:"#"+d+"_addTag",fake_input:"#"+d+"_tag"},e);b[d]=f.delimiter;if(e.onAddTag||e.onRemoveTag||e.onChange){c[d]=new Array;c[d]["onAddTag"]=e.onAddTag;c[d]["onRemoveTag"]=e.onRemoveTag;c[d]["onChange"]=e.onChange}var g='<div id="'+d+'_tagsinput" class="tagsinput"><div id="'+d+'_addTag">';if(e.interactive){g=g+'<input id="'+d+'_tag" value="" data-default="'+e.defaultText+'" />'}g=g+'</div><div class="tags_clear"></div></div>';a(g).insertAfter(this);a(f.holder).css("width",e.width);a(f.holder).css("height",e.height);if(a(f.real_input).val()!=""){a.fn.tagsInput.importTags(a(f.real_input),a(f.real_input).val())}if(e.interactive){a(f.fake_input).val(a(f.fake_input).attr("data-default"));a(f.fake_input).css("color",e.placeholderColor);a(f.fake_input).resetAutosize(e);a(f.holder).bind("click",f,function(b){a(b.data.fake_input).focus()});a(f.fake_input).bind("focus",f,function(b){if(a(b.data.fake_input).val()==a(b.data.fake_input).attr("data-default")){a(b.data.fake_input).val("")}a(b.data.fake_input).css("color","#000000")});if(e.autocomplete_url!=undefined){autocomplete_options={source:e.autocomplete_url};for(attrname in e.autocomplete){autocomplete_options[attrname]=e.autocomplete[attrname]}if(jQuery.Autocompleter!==undefined){a(f.fake_input).autocomplete(e.autocomplete_url,e.autocomplete);a(f.fake_input).bind("result",f,function(b,c,f){if(c){a("#"+d).addTag(c[0]+"",{focus:true,unique:e.unique})}})}else if(jQuery.ui.autocomplete!==undefined){a(f.fake_input).autocomplete(autocomplete_options);a(f.fake_input).bind("autocompleteselect",f,function(b,c){a(b.data.real_input).addTag(c.item.value,{focus:true,unique:e.unique});return false})}}else{a(f.fake_input).bind("blur",f,function(b){var c=a(this).attr("data-default");if(a(b.data.fake_input).val()!=""&&a(b.data.fake_input).val()!=c){if(b.data.minChars<=a(b.data.fake_input).val().length&&(!b.data.maxChars||b.data.maxChars>=a(b.data.fake_input).val().length))a(b.data.real_input).addTag(a(b.data.fake_input).val(),{focus:true,unique:e.unique})}else{a(b.data.fake_input).val(a(b.data.fake_input).attr("data-default"));a(b.data.fake_input).css("color",e.placeholderColor)}return false})}a(f.fake_input).bind("keypress",f,function(b){if(b.which==b.data.delimiter.charCodeAt(0)||b.which==13){b.preventDefault();if(b.data.minChars<=a(b.data.fake_input).val().length&&(!b.data.maxChars||b.data.maxChars>=a(b.data.fake_input).val().length))a(b.data.real_input).addTag(a(b.data.fake_input).val(),{focus:true,unique:e.unique});a(b.data.fake_input).resetAutosize(e);return false}else if(b.data.autosize){a(b.data.fake_input).doAutosize(e)}});f.removeWithBackspace&&a(f.fake_input).bind("keydown",function(b){if(b.keyCode==8&&a(this).val()==""){b.preventDefault();var c=a(this).closest(".tagsinput").find(".tag:last").text();var d=a(this).attr("id").replace(/_tag$/,"");c=c.replace(/[\s]+x$/,"");a("#"+d).removeTag(escape(c));a(this).trigger("focus")}});a(f.fake_input).blur();if(f.unique){a(f.fake_input).keydown(function(b){if(b.keyCode==8||String.fromCharCode(b.which).match(/\w+|[áéíóúÁÉÍÓÚñÑ,/]+/)){a(this).removeClass("not_valid")}})}}});return this};a.fn.tagsInput.updateTagsField=function(c,d){var e=a(c).attr("id");a(c).val(d.join(b[e]))};a.fn.tagsInput.importTags=function(d,e){a(d).val("");var f=a(d).attr("id");var g=e.split(b[f]);for(i=0;i<g.length;i++){a(d).addTag(g[i],{focus:false,callback:false})}if(c[f]&&c[f]["onChange"]){var h=c[f]["onChange"];h.call(d,d,g[i])}}})(jQuery);
