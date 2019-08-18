@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="pid" class="layui-form-label form-label-medium">上级栏目</label>
			<div class="layui-input-inline" style="z-index: 1000;">
				<select name="pid" id="pid" lay-filter="pid" style="width: 300px;">
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
			<label for="name" class="layui-form-label form-label-medium">单页面名称</label>
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
			<label for="urlname" class="layui-form-label form-label-medium">单页面URL</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="urlname" name="urlname" value="@isset($info){{ $info->urlname }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="image" class="layui-form-label form-label-medium">单页面形象图</label>
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
			<label for="content" class="layui-form-label form-label-medium">内容<br><br><br>使用"[page]"分页</label>
    		<div class="layui-input-inline input-xxxxlarge">
				<script src="/admin/js/ueditor.config.js" type="text/javascript"></script>
         		<script src="/lib/ueditor/ueditor.all.js" type="text/javascript"></script>
         		<script src="/lib/ueditor/lang/zh-cn/zh-cn.js" type="text/javascript"></script>
         		<script name="content" id="content" type="text/plain" style="width:100%; height:400px;">@if(isset($categoryPage) && !empty($categoryPage)){!! htmlspecialchars_decode($categoryPage->content) !!}@endif</script>
         		<script type="text/javascript">UE.getEditor("content", {"serverUrl":"/admin/ueditor/index?origin=1"});</script>
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item advanced">
			<label for="keywords" class="layui-form-label form-label-medium">关键词</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="keywords" name="keywords" value="@isset($info){{ $info->keywords }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">以,号分割</div>
		</div>
		<div class="layui-form-item advanced">
			<label for="description" class="layui-form-label form-label-medium">描述</label>
			<div class="layui-input-inline input-large">
				<textarea name="description" id="description" class="layui-textarea">@isset($info){{ $info->description }}@endisset</textarea>
			</div>
			<div class="layui-form-mid layui-word-aux">对本栏目的简单介绍</div>
		</div>
		<div class="layui-form-item advanced">
			<label for="seo_content" class="layui-form-label form-label-medium">SEO内容</label>
			<div class="layui-input-inline input-large">
				<textarea name="seo_content" id="seo_content" class="layui-textarea">@isset($info){{ $info->seo_content }}@endisset</textarea>
			</div>
			<div class="layui-form-mid layui-word-aux">meta标签</div>
		</div>
		<div class="layui-form-item advanced">
			<label for="is_show" class="layui-form-label form-label-medium">单页面显示</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="is_show" value="1" title="显示" @if(!isset($info) || $info->is_show == 1)checked @endif>
      			<input type="radio" name="is_show" value="0" title="隐藏"  @if(isset($info) && $info->is_show == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux">控制单页面调用的显示与隐藏</div>
		</div>
		<div class="layui-form-item">
			<label for="sequence" class="layui-form-label form-label-medium">栏目顺序</label>
			<div class="layui-input-inline input-large">
				<input type="text" name="sequence" value="@isset($info){{ $info->sequence }}@else{{ '0' }}@endisset" lay-verify="required|number" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">数字越小越靠前</div>
		</div>
		<div class="layui-form-item">
			<label for="category_tpl" class="layui-form-label form-label-medium">单页面模板</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="category_tpl" name="category_tpl" value="@isset($info){{ $info->category_tpl }}@else{{ 'categorypage/index' }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">用于单页面的显示</div>
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
