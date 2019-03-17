@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="title" class="layui-form-label form-label-medium">描述</label>
			<div class="layui-input-inline">
				<input type="text" id="title" name="title" value="@isset($info){{ $info->title }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="sign" class="layui-form-label form-label-medium">标识</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="sign" name="sign" value="@isset($info){{ $info->sign }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="rm_html" class="layui-form-label form-label-medium">去除html标签</label>
			<div class="layui-input-inline input-xxlarge">
      			<input type="radio" name="rm_html" lay-filter="rm_html" value="0" title="否"  @if(!isset($info) || $info->rm_html == 0)checked @endif>
				<input type="radio" name="rm_html" lay-filter="rm_html" value="1" title="去除最外层p标签" @if(isset($info) && $info->rm_html == 1)checked @endif>
				<input type="radio" name="rm_html" lay-filter="rm_html" value="2" title="去除所有html标签" @if(isset($info) && $info->rm_html == 2)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="content" class="layui-form-label form-label-medium">内容</label>
    		<div class="layui-input-inline input-xxxxlarge">
				<script src="/admin/js/ueditor.config.js" type="text/javascript"></script>
         		<script src="/lib/ueditor/ueditor.all.js" type="text/javascript"></script>
         		<script src="/lib/ueditor/lang/zh-cn/zh-cn.js" type="text/javascript"></script>
         		<script name="content" id="content" type="text/plain" style="width:100%; height:400px;">@isset($info){!! htmlspecialchars_decode($info->content) !!}@endisset</script>
         		<script type="text/javascript">UE.getEditor("content", {"serverUrl":"/admin/ueditor/index?origin=4"});</script>
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label form-label-medium"></label>
			@if($actionPower) 
				@csrf
				@if(isset($info)) 
				<input type="hidden" name="id" value="{{ $info->id }}" /> 
				@endif
				<button class="layui-btn" lay-filter="submit" lay-submit="">{{ $actionName }}</button>
			@endif
		</div>
	</form>
</div>
<script>
        layui.use(['form'], function(){
          	var form = layui.form
          	var layer = layui.layer;

          	form.on('radio(display)', function(data){
            	if(data.value == 1) {
            		$('#reception').show();
               	} else {
               		$('#reception').hide();
                }
       		});
          //监听提交
          form.on('submit(submit)', function(data){
        	  var requestData = data.field;
              $.ajax({
  				type:'post',
      			url:'{{ $actionUrl }}',
      			data:requestData,
      			dataType: "json",
      			success: function(data){
      				if(data.status == 10000) {
      					x_admin_close(true);
                    } else {
                     	layer.msg(data.message);
                    }
      			},
                error: function (XMLHttpResponse, textStatus, errorThrown) {
                  	layer.msg('{{ $actionName }}失败');
                }
      		});
          	layer.msg('正在{{ $actionName }} . . .', {shade:0.2});
          	return false;
          });
        });
    </script>
</body>
@endsection
