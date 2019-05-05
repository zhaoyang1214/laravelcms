@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-medium">推荐位名称</label>
			<div class="layui-input-inline">
				<input type="text" id="name" name="name" value="@isset($info){{ $info->name }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="sequence" class="layui-form-label form-label-medium">推荐位顺序</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="sequence" name="sequence" value="@isset($info){{ $info->sequence }}@else 0 @endisset" lay-verify="number" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">针对后台的显示顺序(顺序排列)，升序</div>
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
