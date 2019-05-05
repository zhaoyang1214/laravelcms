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
