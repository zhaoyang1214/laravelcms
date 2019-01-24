@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="name" class="layui-form-label">昵称</label>
			<div class="layui-input-inline">
				<input type="text" id="nickname" name="nickname" value="@isset($info){{ $info->nickname }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label">密码</label>
			<div class="layui-input-inline">
				<input type="password" id="password" name="password" value="" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">密码长度为6-20位</div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label">确认密码</label>
			<div class="layui-input-inline">
				<input type="password" id="password_confirmation" name="password_confirmation" value="" autocomplete="off" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label for="L_repass" class="layui-form-label"></label>
			@csrf
			@if(isset($info)) 
			<input type="hidden" name="id" value="{{ $info->id }}" /> 
			@endif
			<button class="layui-btn" lay-filter="submit" lay-submit="">修改</button>
		</div>
	</form>
</div>
<script>
        layui.use(['form'], function(){
          var form = layui.form
          var layer = layui.layer;
          //监听提交
          form.on('submit(submit)', function(data){
        	  var requestData = data.field;
              $.ajax({
  				type:'post',
      			url:'/admin/admin/editInfo',
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
                  	layer.msg('修改失败');
                }
      		});
          	layer.msg('正在修改 . . .', {shade:0.2});
          	return false;
          });
        });
    </script>
</body>
@endsection
