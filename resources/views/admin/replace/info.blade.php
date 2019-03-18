@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="key" class="layui-form-label form-label-medium">被替换内容</label>
			<div class="layui-input-inline">
				<input type="text" id="key" name="key" value="@isset($info){{ $info->key }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="content" class="layui-form-label form-label-medium">替换后内容</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="content" name="content" value="@isset($info){{ $info->content }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="num" class="layui-form-label form-label-medium">替换次数</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="num" name="num" value="@isset($info){{ $info->num }}@else 1 @endisset" lay-verify="number" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">0表示不限制次数</div>
		</div>
		<div class="layui-form-item">
			<label for="status" class="layui-form-label form-label-medium">状态</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="status" lay-filter="status" value="1" title="开启" @if(!isset($info) || $info->status == 1)checked @endif>
      			<input type="radio" name="status" lay-filter="status" value="0" title="关闭"  @if(isset($info) && $info->status == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux">关闭则不替换</div>
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
        	  var num = parseInt(requestData.num);
        	  requestData.num = num > 0 ? num : 0;
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
