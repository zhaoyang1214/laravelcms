@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="pid" class="layui-form-label form-label-medium">上级栏目</label>
			<div class="layui-input-inline" style="z-index: 1000;">
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
			<label for="name" class="layui-form-label form-label-medium">栏目名称</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="name" name="name" lay-verify="required" value="@isset($info){{ $info->name }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item advanced">
			<label for="subname" class="layui-form-label form-label-medium">副栏目名称</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="subname" name="subname" value="@isset($info){{ $info->subname }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item advanced">
			<label for="urlname" class="layui-form-label form-label-medium">栏目URL优化</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="urlname" name="urlname" value="@isset($info){{ $info->urlname }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="image" class="layui-form-label form-label-medium">栏目形象图</label>
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
		<div class="layui-form-item">
			<label for="type" class="layui-form-label form-label-medium">栏目属性</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="type" value="1" title="频道页" @if(isset($info) && $info->type == 1)checked @endif>
      			<input type="radio" name="type" value="2" title="列表页"  @if(!isset($info) || $info->type == 2)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux">频道页无法发布内容，列表页可以发布内容</div>
		</div>
		<div class="layui-form-item advanced">
			<label for="is_show" class="layui-form-label form-label-medium">栏目显示</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="is_show" value="1" title="显示" @if(!isset($info) || $info->is_show == 1)checked @endif>
      			<input type="radio" name="is_show" value="0" title="隐藏"  @if(isset($info) && $info->is_show == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux">控制栏目调用的显示与隐藏</div>
		</div>
		<div class="layui-form-item">
			<label for="page" class="layui-form-label form-label-medium">内容分页数</label>
			<div class="layui-input-inline input-large">
				<input type="text" name="page" value="@isset($info){{ $info->page }}@else{{ '10' }}@endisset" lay-verify="required|number" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">栏目下内容每页多少条</div>
		</div>
		<div class="layui-form-item">
			<label for="sequence" class="layui-form-label form-label-medium">栏目顺序</label>
			<div class="layui-input-inline input-large">
				<input type="text" name="sequence" value="@isset($info){{ $info->sequence }}@else{{ '0' }}@endisset" lay-verify="required|number" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">数字越小越靠前</div>
		</div>
		<div class="layui-form-item advanced">
			<label for="content_order" class="layui-form-label form-label-medium">内容排序</label>
			<div class="layui-input-inline input-large">
				<select name="content_order" id="content_order" >
					<option value="1" @if(isset($info) && $info->content_order==1)selected @endif>内容更新时间 新->旧</option>
					<option value="2" @if(isset($info) && $info->content_order==2)selected @endif>内容更新时间 旧->新</option>
					<option value="3" @if(isset($info) && $info->content_order==3)selected @endif>内容发布时间 新->旧</option>
					<option value="4" @if(isset($info) && $info->content_order==4)selected @endif>内容发布时间 旧->新</option>
					<option value="5" @if(isset($info) && $info->content_order==5)selected @endif>内容自定义排序 大->小</option>
					<option value="6" @if(isset($info) && $info->content_order==6)selected @endif>内容自定义排序 小->大</option>
				</select>
			</div>
			<div class="layui-form-mid layui-word-aux">针对该栏目下内容的排序方式</div>
		</div>
		<div class="layui-form-item">
			<label for="category_tpl" class="layui-form-label form-label-medium">栏目模板</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="category_tpl" name="category_tpl" value="@isset($info){{ $info->category_tpl }}@else{{ 'category/index' }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">用于频道或列表的显示</div>
		</div>
		<div class="layui-form-item">
			<label for="content_tpl" class="layui-form-label form-label-medium">内容模板</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="content_tpl" name="content_tpl" value="@isset($info){{ $info->content_tpl }}@else{{ 'content/index' }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">用于该栏目下的内容显示</div>
		</div>
		<div class="layui-form-item advanced">
			<label for="expand_id" class="layui-form-label form-label-medium">扩展模型</label>
			<div class="layui-input-inline input-large">
				<select name="expand_id" id="expand_id" >
					<option value="0">无</option>
					@foreach($expandList as $expand)
					<option value="{{ $expand->id }}" @if(isset($info) && $info['expand_id']==$expand->id)selected @endif>{{ $expand->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="layui-form-mid layui-word-aux">用于附加内容字段</div>
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
