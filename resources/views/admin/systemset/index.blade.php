@extends('admin.layouts.common')

@section('content')
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
  <legend>系统设置</legend>
</fieldset>

<div class="layui-tab layui-tab-brief">
	<ul class="layui-tab-title">
		<li class="layui-this">站点设置</li>
		<li>性能设置</li>
		<li>模板设置</li>
		<li>上传设置</li>
	</ul>
	<div class="layui-tab-content">
		<div class="layui-tab-item layui-show">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">网站名称</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="sitename" value="{{ config('system.sitename') }}" autocomplete="off" placeholder="请输入网站名称" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.sitename') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">网站副标题</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="seoname" value="{{ config('system.seoname') }}" autocomplete="off" placeholder="请输入网站副标题" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.seoname') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">网站域名</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="siteurl" value="{{ config('system.siteurl') }}" autocomplete="off" placeholder="请输入网站域名" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.siteurl') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">站点关键词</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="keywords" value="{{ config('system.keywords') }}" autocomplete="off" placeholder="请输入站点关键词" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.keywords') }}</div>
				</div>
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label form-label-large">站点描述</label>
					<div class="layui-input-inline input-xlarge">
						<textarea name="description" placeholder="请输入站点描述" class="layui-textarea autosave">{{ config('system.description') }}</textarea>
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.description') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">站长邮箱</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="masteremail" value="{{ config('system.masteremail') }}" autocomplete="off" placeholder="请输入站长邮箱" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.masteremail') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">版权信息</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="copyright" value="{{ config('system.copyright') }}" autocomplete="off" placeholder="请输入版权信息" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.copyright') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">备案号</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="registered_no" value="{{ config('system.registered_no') }}" autocomplete="off" placeholder="请输入备案号" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.registered_no') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">客服电话</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="telephone" value="{{ config('system.telephone') }}" autocomplete="off" placeholder="请输入客服电话" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.telephone') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">联系人</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="linkman" value="{{ config('system.linkman') }}" autocomplete="off" placeholder="请输入联系人" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.linkman') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">传真</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="fax" value="{{ config('system.fax') }}" autocomplete="off" placeholder="请输入传真" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.fax') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">QQ</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="qq" value="{{ config('system.qq') }}" autocomplete="off" placeholder="请输入QQ" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.qq') }}</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">地址</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="addr" value="{{ config('system.addr') }}" autocomplete="off" placeholder="请输入地址" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">{<span>{</span> config('system.addr') }}</div>
				</div>
			</form>
		</div>
		<div class="layui-tab-item">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">数据库缓存</label>
					<div class="layui-input-inline input-medium">
						<input type="checkbox" name="db_cache" value="1" lay-skin="switch" lay-text="ON|OFF" @if(config('system.db_cache')) checked @endif class="autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">针对前台</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">数据库缓存时间</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="db_cache_time" value="{{ config('system.db_cache_time') }}" lay-verify="number" autocomplete="off" placeholder="请输入数据库缓存时间" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">(单位：秒) 开启数据库缓存后有效</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">视图缓存</label>
					<div class="layui-input-inline input-medium">
						<input type="checkbox" name="view_cache" value="1" lay-skin="switch" lay-text="ON|OFF" @if(config('system.view_cache')) checked @endif class="autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">针对前台</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">首页缓存时间</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="html_index_cache_time" value="{{ config('system.html_index_cache_time') }}" lay-verify="number" autocomplete="off" placeholder="请输入首页缓存时间" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">(单位：秒) 开启视图缓存后有效</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">其他页缓存时间</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="html_other_cache_time" value="{{ config('system.html_other_cache_time') }}" lay-verify="number" autocomplete="off" placeholder="请输入其他页缓存时间" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">(单位：秒) 开启视图缓存后有效</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">搜索页缓存时间</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="html_search_cache_time" value="{{ config('system.html_search_cache_time') }}" lay-verify="number" autocomplete="off" placeholder="请输入搜索页缓存时间" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">(单位：秒) 开启视图缓存后有效</div>
				</div>
			</form>
		</div>
		<div class="layui-tab-item">
			<form class="layui-form">
			
			</form>
		</div>
		<div class="layui-tab-item">内容4</div>
		<div class="layui-tab-item">内容5</div>
	</div>
</div>
<script type="text/javascript">
$("input,textarea").change(function() {
	saveConfig($(this).attr('name'), $(this).val());
});

layui.use(["form"], function() {
	var form =layui.form;
	form.on('select()', function(data){
		saveConfig($(data.elem).attr("name"), data.value);
	});

	form.on('switch()', function(data){
		saveConfig($(data.elem).attr("name"), Number(data.elem.checked));
	});

	form.on('radio()', function(data){
		saveConfig($(data.elem).attr("name"), data.value);
	});
});
function saveConfig(key, value) {
	console.log(key + " === " + value);
	layer.msg('保存成功', {"time":500});
	return ;
	$.ajax({
		type:'post',
		url:'/admin/Systemset/save',
		data:{key:key,value:value,_token:'{{csrf_token()}}'},
		dataType: "json",
		success: function(data){
			layer.msg(data.message);
		},
        error: function (XMLHttpResponse, textStatus, errorThrown) {
        	layer.msg('保存失败');
        }
	});
}

</script>
@endsection