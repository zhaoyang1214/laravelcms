@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="name" class="layui-form-label">管理组</label>
			<div class="layui-input-inline">
				<select name="admin_group_id">
					@foreach($adminGroupList as $adminGroup)
					<option value="{{ $adminGroup->id }}" @if(isset($info) && $info->admin_group_id==$adminGroup->id)selected @endif>{{ $adminGroup->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label">账号</label>
			<div class="layui-input-inline">
				<input type="text" id="username" name="username" value="@isset($info){{ $info->username }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">请输入5-20位数字、字母、 _、@、.</div>
		</div>
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
			<label for="status" class="layui-form-label">状态</label>
			<div class="layui-input-inline">
				<input type="checkbox" name="status" value="1" lay-skin="switch" lay-text="ON|OFF" @if(!isset($info) || $info->status==1)checked @endisset>
			</div>
		</div>
		<div class="layui-form-item">
			<label for="L_repass" class="layui-form-label"></label>
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
          //监听提交
          form.on('submit(submit)', function(data){
        	  var requestData = data.field;
              requestData.status = requestData.status ? 1 : 0;
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
