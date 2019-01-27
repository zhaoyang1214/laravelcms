@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-medium">表单名称</label>
			<div class="layui-input-inline">
				<input type="text" id="name" name="name" value="@isset($info){{ $info->name }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-medium">表名</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="table" name="table" value="@isset($info){{ $info->table }}@endisset" lay-verify="required" autocomplete="off" class="layui-input @if($action == 'edit')layui-disabled layui-bg-gray @endif" @if($action == 'edit')disabled  @endif>
			</div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-medium">表单顺序</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="sequence" name="sequence" value="@isset($info){{ $info->sequence }}@else{{ '0' }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">数字越小越靠前</div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-medium">内容排序</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="sort" name="sort" value="@isset($info){{ $info->sort }}@else id DESC @endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">会自动创建自增主键id</div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-medium">前台表单</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="display" lay-filter="display" value="1" title="是" @if(!isset($info) || $info->display == 1)checked @endif>
      			<input type="radio" name="display" lay-filter="display" value="0" title="否"  @if(isset($info) && $info->display == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux">是否在前台显示此表单的分页列表内容</div>
		</div>
		<div id="reception" @if(isset($info) && $info->display == 0)style="display: none;" @endif>
			<div class="layui-form-item">
    			<label for="name" class="layui-form-label form-label-medium">前台提交返回</label>
    			<div class="layui-input-inline input-large">
    				<input type="radio" name="return_type" value="0" title="JS消息框" @if(!isset($info) || $info->return_type == 0)checked @endif>
          			<input type="radio" name="return_type" value="1" title="JSON"  @if(isset($info) && $info->return_type == 1)checked @endif>
    			</div>
    			<div class="layui-form-mid layui-word-aux">前台表单提交后的动作</div>
    		</div>
    		<div class="layui-form-item">
    			<label for="name" class="layui-form-label form-label-medium">提交成功后消息</label>
    			<div class="layui-input-inline input-large">
    				<input type="text" id="return_msg" name="return_msg" value="@isset($info){{ $info->return_msg }}@else 提交成功 @endisset" autocomplete="off" class="layui-input">
    			</div>
    			<div class="layui-form-mid layui-word-aux">表单提交成功后返回的消息</div>
    		</div>
    		<div class="layui-form-item">
    			<label for="name" class="layui-form-label form-label-medium">成功后返回地址</label>
    			<div class="layui-input-inline input-large">
    				<input type="text" id="return_url" name="return_url" value="@isset($info){{ $info->return_url }}@endisset" autocomplete="off" class="layui-input">
    			</div>
    			<div class="layui-form-mid layui-word-aux">表单提交成功后返回的消息(留空返回当前表单)</div>
    		</div>
    		<div class="layui-form-item">
    			<label for="name" class="layui-form-label form-label-medium">前台分页数</label>
    			<div class="layui-input-inline input-large">
    				<input type="text" name="page" value="@isset($info){{ $info->page }}@else{{ '10' }}@endisset" autocomplete="off" class="layui-input">
    			</div>
    			<div class="layui-form-mid layui-word-aux">前台列表显示的分页数</div>
    		</div>
    		<div class="layui-form-item">
    			<label for="name" class="layui-form-label form-label-medium">前台列表条件</label>
    			<div class="layui-input-inline input-large">
    				<input type="text" id="condition" name="condition" value="@isset($info){{ $info->condition }}@endisset" autocomplete="off" class="layui-input">
    			</div>
    			<div class="layui-form-mid layui-word-aux"></div>
    		</div>
    		<div class="layui-form-item">
    			<label for="name" class="layui-form-label form-label-medium">前台模板</label>
    			<div class="layui-input-inline input-large">
    				<input type="text" id="tpl" name="tpl" value="@isset($info){{ $info->tpl }}@endisset" autocomplete="off" class="layui-input">
    			</div>
    			<div class="layui-form-mid layui-word-aux">为空话外部调用默认模板(from/index)</div>
    		</div>
    		<div class="layui-form-item">
    			<label for="status" class="layui-form-label form-label-medium">图片验证码	</label>
    			<div class="layui-input-inline input-large">
    				<input type="checkbox" name="is_captcha" value="1" lay-skin="switch" lay-text="ON|OFF" @if(!isset($info) || $info->is_captcha==1)checked @endisset>
    			</div>
    		</div>
		</div>
		<div class="layui-form-item">
			<label for="L_repass" class="layui-form-label form-label-medium"></label>
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
        	  @if($action == 'edit')
              delete requestData.table;
              @endif
              requestData.is_captcha = requestData.is_captcha ? 1 : 0;
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
