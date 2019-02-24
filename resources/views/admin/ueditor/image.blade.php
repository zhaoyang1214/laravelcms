@extends('admin.layouts.common')

@section('head')
<link rel="stylesheet" type="text/css" href="/lib/imgcropping/css/cropper.min.css">
<link rel="stylesheet" type="text/css" href="/lib/imgcropping/css/ImgCropping.css">
<style type="text/css">
.watermark {
	margin-left:30px;
}
.watermark select{
	border: 1px solid #cccccc;
    color: #3E3E3E;
    padding: 5px;
    line-height: 18px;
    height: auto;
    width: auto;
}
</style>
@endsection

@section('content')
<div class="x-body">
	<div class="layui-row">
		<div class="tailoring-container">
			    <div class="tailoring-content">
			            <div class="tailoring-content-one">
			                <label title="上传图片" for="chooseImg" class="l-btn choose-btn">
			                    <input type="file" accept="image/jpg,image/jpeg,image/png" name="file" id="chooseImg" class="hidden" onchange="selectImg(this)">
			                  	  选择图片
			                </label>
			                <label class="choose-btn tip" >
			                   		 当前裁剪图片大小：<span>0 KB</span> &nbsp;&nbsp;&nbsp;&nbsp;最大允许上传：{{ config('system.file_size') * 1024 }} KB
			                </label>
			                <label class="choose-btn watermark">
			                	<label for="watermark_switch">添加水印：</label>
    			                <input id="watermark_switch" type="checkbox" name="watermark_switch" @if(config('system.watermark_switch')) checked="checked" @endif value="1">
          &nbsp;&nbsp;
          						<label for="watermark_place">水印位置：</label>
          						<select id="watermark_place" name="watermark_place">
                                    <option value="0" @if(config('system.watermark_place') == 0)selected @endif>随机</option>
                                    <option value="1" @if(config('system.watermark_place') == 1)selected @endif>左上</option>
                                    <option value="2" @if(config('system.watermark_place') == 2)selected @endif>中上</option>
                                    <option value="3" @if(config('system.watermark_place') == 3)selected @endif>右上</option>
                                    <option value="4" @if(config('system.watermark_place') == 4)selected @endif>左中</option>
                                    <option value="5" @if(config('system.watermark_place') == 5)selected @endif>正中</option>
                                    <option value="6" @if(config('system.watermark_place') == 6)selected @endif>右中</option>
                                    <option value="7" @if(config('system.watermark_place') == 7)selected @endif>左下</option>
                                    <option value="8" @if(config('system.watermark_place') == 8)selected @endif>中下</option>
                                    <option value="9" @if(config('system.watermark_place') == 9)selected @endif>右下</option>
                                  </select>
			                </label>
				</div>
			            <div class="tailoring-content-two">
			                <div class="tailoring-box-parcel">
			                    <img id="tailoringImg">
			                </div>
			                <div class="preview-box-parcel">
			                    <p>图片预览：</p>
			                    <div class="square previewImg"></div>
			                    <div class="circular previewImg"></div>
			                </div>
			            </div>
			            <div class="tailoring-content-three">
			                <button class="l-btn cropper-reset-btn">复位</button>
			                <button class="l-btn cropper-rotate-btn">旋转</button>
			                <button class="l-btn cropper-scaleX-btn">换向</button>
			                <button class="l-btn sureCut" id="sureCut">确定</button>
			                <span>
			                	宽：
			                <input type="text" name="width" id="width" value="0"/> X 
			                	高：
			                <input type="text" name="height" id="height" value="0"/>
			                <button class="l-btn" id="setWidthHeight">设置剪裁大小</button>
			                </span>
			            </div>
			        </div>
			</div>
	</div>
</div>

<script src="/lib/imgcropping/js/cropper.min.js"></script>
<script type="text/javascript">
//弹出框水平垂直居中
(window.onresize = function () {
    var win_height = $(window).height();
    var win_width = $(window).width();
    if (win_width <= 768){
        $(".tailoring-content").css({
            "top": (win_height - $(".tailoring-content").outerHeight())/2,
            "left": 0
        });
    }else{
        $(".tailoring-content").css({
            "top": (win_height - $(".tailoring-content").outerHeight())/2,
            "left": (win_width - $(".tailoring-content").outerWidth())/2
        });
    }
})();

//弹出图片裁剪框
$("#replaceImg").on("click",function () {
    $(".tailoring-container").toggle();
});
//图像上传
function selectImg(file) {
    if (!file.files || !file.files[0]){
        return;
    }
    var reader = new FileReader();
    reader.onload = function (evt) {
        var replaceSrc = evt.target.result;
        //更换cropper的图片
        $('#tailoringImg').cropper('replace', replaceSrc,false);//默认false，适应高度，不失真
    }
    reader.readAsDataURL(file.files[0]);
}
//cropper图片裁剪
 $('#tailoringImg').cropper({
    aspectRatio: 1/1,//默认比例
    preview: '.previewImg',//预览视图
    guides: true,  //裁剪框的虚线(九宫格)
    autoCropArea: 1,  //0-1之间的数值，定义自动剪裁区域的大小，默认0.8
    movable: true, //是否允许移动图片
    dragCrop: true,  //是否允许移除当前的剪裁框，并通过拖动来新建一个剪裁框区域
    movable: true,  //是否允许移动剪裁框
    resizable: true,  //是否允许改变裁剪框的大小
    zoomable: true,  //是否允许缩放图片大小
    mouseWheelZoom: true,  //是否允许通过鼠标滚轮来缩放图片
    touchDragZoom: true,  //是否允许通过触摸移动来缩放图片
    rotatable: true,  //是否允许旋转图片
    crop: function(e) {
        // 输出结果数据裁剪图像。
        $("#width").val(e.width.toFixed(2));
        $("#height").val(e.height.toFixed(2));
        var cas = $('#tailoringImg').cropper('getCroppedCanvas');//获取被裁剪后的canvas
        var base64url = cas.toDataURL('image/png'); //转换为base64地址形式
        var reader = new FileReader();
        reader.onload = function (evt) {  //图片加载完成   
        	var size = parseFloat(evt.total/1024);
        	$(".tip span").text(size.toFixed(2) + ' KB');
        };
        reader.readAsDataURL(dataURLtoBlob(base64url));
        /*var base64url = cas.toDataURL('image/png').split(",");
        $(".tip span").text(base64url[1].length - base64url[1].length/8*2 + ' KB');*/
    },
    /* cropend: function(e) {
    	var cas = $('#tailoringImg').cropper('getCroppedCanvas');//获取被裁剪后的canvas
        var base64url = cas.toDataURL('image/png'); //转换为base64地址形式
        var reader = new FileReader();
        reader.onload = function (evt) {  //图片加载完成   
        	var size = parseFloat(evt.total/1024);
        	$(".tip span").text(size.toFixed(2) + ' KB');
        };
        reader.readAsDataURL(dataURLtoBlob(base64url));
    }, */
    ready: function(e) {
    	$('#tailoringImg').cropper('setAspectRatio', e.currentTarget.width/e.currentTarget.height);
    	$('#tailoringImg').cropper('setData',{width:e.currentTarget.width,height:e.currentTarget.height});
    }
}); 

$('#setWidthHeight').click(function(){
	var file = $("#chooseImg").get(0);
	if (!file.files || !file.files[0]){
        return;
    }
	var width = parseFloat($("#width").val()).toFixed(2);
	if(width <= 0) {
		width = 1;
	}
	$("#width").val(width);
	var height = parseFloat($("#height").val()).toFixed(2);
	if(height <= 0) {
		height = 1;
	}
	$("#height").val(height);
	$('#tailoringImg').cropper('setAspectRatio', width/height);
	$('#tailoringImg').cropper('setData',{width:parseFloat(width),height:parseFloat(height)});
});
//旋转
$(".cropper-rotate-btn").on("click",function () {
    $('#tailoringImg').cropper("rotate", 45);
});
//复位
$(".cropper-reset-btn").on("click",function () {
    $('#tailoringImg').cropper("reset");
});
//换向
var flagX = true;
$(".cropper-scaleX-btn").on("click",function () {
    if(flagX){
        $('#tailoringImg').cropper("scaleX", -1);
        flagX = false;
    }else{
        $('#tailoringImg').cropper("scaleX", 1);
        flagX = true;
    }
    flagX != flagX;
});

//裁剪后的处理
$("#sureCut").on("click",function () {
    if ($("#tailoringImg").attr("src") == null ){
        return false;
    }else{
    	layer.msg('正在上传...', {time:60000,shade:0.5});
        setTimeout(function(){
        	var cas = $('#tailoringImg').cropper('getCroppedCanvas');//获取被裁剪后的canvas
            var base64url = cas.toDataURL('image/png').split(","); //转换为base64地址形式
            var watermark_switch = $("#watermark_switch").is(":checked") ? 1 : 0;
			var maxFileSize = "{{ config('system.file_size') }}" * 1024;
			var nowFileSize = (base64url[1].length - base64url[1].length/8*2) / 1024;
			console.log(nowFileSize);
			console.log(maxFileSize);
            if(nowFileSize > maxFileSize) {
            	layer.msg('图片大小超过上限', {time:1000});
            	return false;
            }
            $.ajax({
    			type:'post',
    			url:"/admin/ueditor/index?origin={{ $origin }}&action=uploadscrawl",
    			data:{ {{ $fieldName }}:base64url[1], watermark_switch:watermark_switch, watermark_place:$("#watermark_place :selected").val()},
    			dataType: "json",
    			async:true,
    			success: function(data){
    				if(data.state == 'SUCCESS'){
    					layer.msg('上传完毕', {time:1000});
    			    	$('#{{ $id }}', parent.document).val(data.url);
    					var index = parent.layer.getFrameIndex(window.name); 
    			    	parent.layer.close(index);
    				}else{
    					layer.msg(data.state);
    				}
    			}
    		});
        }, 1); 
    }
});

//关闭裁剪框
function closeTailor() {
    $(".tailoring-container").toggle();
}

function dataURLtoBlob(dataurl) {
    var arr = dataurl.split(','),
    bstr = atob(arr[1]),
    n = bstr.length,
    u8arr = new Uint8Array(n);
    if(arr[0] === 'data:'){
    	return new Blob();
    }
    var mime = arr[0].match(/:(.*?);/)[1];
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new Blob([u8arr], {
        type: mime
    });
}

</script>
@endsection