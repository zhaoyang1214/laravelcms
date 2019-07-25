@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="pid" class="layui-form-label form-label-medium">上级栏目</label>
			<div class="layui-input-inline">
				<select name="pid" id="pid" lay-filter="pid" style="width: 300px">
					<option value="0">=====顶级栏目=====</option>
					@foreach($categoryList as $value)
					<option value="{{ $value['id'] }}" @if(isset($info) && $info['pid']==$value['id'])selected @endif>{!! $value['cname'] !!}</option>
					@endforeach
				</select>
			</div>
			<div class="layui-input-inline">
			<label class="layui-form-label"><a href="javascript:;" onclick="advanced()">高级设置</a></label>
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-medium">跳转页面名称</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="name" name="name" lay-verify="required" value="@isset($info){{ $info->name }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item advanced">
			<label for="subname" class="layui-form-label form-label-medium">副名称</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="subname" name="subname" value="@isset($info){{ $info->subname }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item advanced">
			<label for="urlname" class="layui-form-label form-label-medium">跳转页面URL</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="urlname" name="urlname" value="@isset($info){{ $info->urlname }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="image" class="layui-form-label form-label-medium">跳转页面形象图</label>
			<div class="layui-input-inline input-xlarge">
				<div class="layui-input-inline input-large">
        					<input type="text" name="image" id="image"  value="@isset($info){{ $info->image }}@endisset" autocomplete="off" placeholder="请选择图片" class="layui-input layui-disabled">
        				</div>
        				<div class="layui-input-inline input-mini">
        					<button type="button" class="layui-btn" id="upload-image">上传图片</button>
        				</div>
        				<script type="text/javascript">
                		$("#upload-image").click(function() {
                        	var height = $(window).height() - 2;
                        	layer.open({
                                type: 2,
                                title: ['上传图片', 'font-weight: bold;font-size:larger;'],
                                area: ['818px', height < '668' ? (height + 'px') : '668px'],
                                shade: 0,
                                maxmin:true,
                                content: '/admin/ueditor/getUpfileHtml?type=image&origin=1&id=image',
                                zIndex: layer.zIndex
                              });
                        });
                		</script>
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-medium">跳转到</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="url" name="url" lay-verify="required" value="@if(isset($categoryJump) && !empty($categoryJump)){{ $categoryJump->url }}@endif" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item advanced">
			<label for="is_show" class="layui-form-label form-label-medium">跳转页面显示</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="is_show" value="1" title="显示" @if(!isset($info) || $info->is_show == 1)checked @endif>
      			<input type="radio" name="is_show" value="0" title="隐藏"  @if(isset($info) && $info->is_show == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux">控制跳转页面调用的显示与隐藏</div>
		</div>
		<div class="layui-form-item">
			<label for="sequence" class="layui-form-label form-label-medium">栏目顺序</label>
			<div class="layui-input-inline input-large">
				<input type="text" name="sequence" value="@isset($info){{ $info->sequence }}@else{{ '0' }}@endisset" lay-verify="required|number" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">数字越小越靠前</div>
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
