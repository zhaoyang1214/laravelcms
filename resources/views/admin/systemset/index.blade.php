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
					<div class="layui-input-inline input-xlarge">
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
					<div class="layui-input-inline input-xlarge">
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
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">前台模板主题</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="theme" value="{{ config('system.theme') }}" autocomplete="off" placeholder="请输入前台模板主题" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">针对views/home/目录下的文件夹</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">首页模板</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="index_tpl" value="{{ config('system.index_tpl') }}" autocomplete="off" placeholder="请输入首页模板" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">定义首页访问的模板，默认为index/index</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">搜索模板</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="search_tpl" value="{{ config('system.search_tpl') }}" autocomplete="off" placeholder="请输入搜索模板" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">定义网站搜索的模板，默认为search/index</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">TAG主页模板</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="tags_index_tpl" value="{{ config('system.tags_index_tpl') }}" autocomplete="off" placeholder="请输入TAG主页模板" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">定义网站TAG集合页的模板，默认为tags/index</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">TAG详情页模板</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="tags_info_tpl" value="{{ config('system.tags_info_tpl') }}" autocomplete="off" placeholder="请输入TAG详情页模板" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">定义TAG详情页模板，默认为tags/info</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">搜索结果分页数</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="tpl_seach_page" value="{{ config('system.tpl_seach_page') }}" autocomplete="off" placeholder="请输入搜索结果分页数" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">针对搜索结果的每页分页数</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">TAG主页分页数</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="tpl_tags_index_page" value="{{ config('system.tpl_tags_index_page') }}" autocomplete="off" placeholder="请输入TAG主页分页数" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">TAG集合页每页显示数量</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">TAG内容分页数</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="tpl_tags_page" value="{{ config('system.tpl_tags_page') }}" autocomplete="off" placeholder="请输入TAG内容分页数" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">TAG内容列表每页显示数量</div>
				</div>
			</form>
		</div>
		<div class="layui-tab-item">
			<form class="layui-form">
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">上传文件</label>
					<div class="layui-input-inline input-xlarge">
						<input type="checkbox" name="upload_switch" value="1" lay-skin="switch" lay-text="ON|OFF" @if(config('system.upload_switch')) checked @endif class="autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">后台不受此项影响</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">上传大小</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="file_size" value="{{ config('system.file_size') }}" autocomplete="off" placeholder="请输入上传大小" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">单位:M</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">批量上传数</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="file_num" value="{{ config('system.file_num') }}" autocomplete="off" placeholder="请输入批量上传数" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux"></div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">上传图片格式</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="image_type" value="{{ config('system.image_type') }}" autocomplete="off" placeholder="请输入上传图片格式" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">英文逗号(,)分开</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">上传视频格式</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="video_type" value="{{ config('system.video_type') }}" autocomplete="off" placeholder="请输入上传视频格式" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">英文逗号(,)分开</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">上传文件格式</label>
					<div class="layui-input-inline input-xlarge">
						<input type="text" name="file_type" value="{{ config('system.file_type') }}" autocomplete="off" placeholder="请输入上传文件格式" class="layui-input autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">英文逗号(,)分开</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">默认缩图开关</label>
					<div class="layui-input-inline input-xlarge">
						<input type="checkbox" name="thumbnail_switch" value="1" lay-skin="switch" lay-text="ON|OFF" @if(config('system.thumbnail_switch')) checked @endif class="autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">开关只针对上传时的缩图选项勾选</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">默认缩图方式</label>
					<div class="layui-input-inline input-xlarge">
						<input type="radio" name="thumbnail_cutout" value="1" title="裁剪"
							@if(config('system.thumbnail_cutout') == 1) checked @endif> <input
							type="radio" name="thumbnail_cutout" value="2" title="按比例"
							@if(config('system.thumbnail_cutout') == 2) checked @endif>
					</div>
					<div class="layui-form-mid layui-word-aux">开关只针对上传时的缩图选项勾选</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">默认缩图尺寸</label>
					<div class="layui-input-inline input-xlarge">
    						<div class="layui-input-inline input-medium">
    							<input type="text" name="thumbnail_maxwidth" value="{{ config('system.thumbnail_maxwidth') }}" placeholder="请输入最大宽度" autocomplete="off" class="layui-input autosave">
    						</div>
    						<div class="layui-input-inline input-medium">
    							<input type="text" name="thumbnail_maxheight" value="{{ config('system.thumbnail_maxheight') }}" placeholder="请输入最大高度" autocomplete="off" class="layui-input autosave">
    						</div>
					</div>
					<div class="layui-form-mid layui-word-aux">单位:px</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">默认水印开关</label>
					<div class="layui-input-inline input-xlarge">
						<input type="checkbox" name="watermark_switch" value="1" lay-skin="switch" lay-text="ON|OFF" @if(config('system.watermark_switch')) checked @endif class="autosave">
					</div>
					<div class="layui-form-mid layui-word-aux">开关只针对上传时的缩图选项勾选</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">默认水印位置</label>
					<div class="layui-input-inline input-xlarge">
						<div class="layui-input-inline input-small">
						<select name="watermark_place">
							<option value="0" @if(config('system.watermark_place') == 0) selected="selected" @endif >随机</option>
							<option value="1" @if(config('system.watermark_place') == 1) selected="selected" @endif >左上</option>
							<option value="2" @if(config('system.watermark_place') == 2) selected="selected" @endif >中上</option>
							<option value="3" @if(config('system.watermark_place') == 3) selected="selected" @endif >右上</option>
							<option value="4" @if(config('system.watermark_place') == 4) selected="selected" @endif >左中</option>
							<option value="5" @if(config('system.watermark_place') == 5) selected="selected" @endif >正中</option>
							<option value="6" @if(config('system.watermark_place') == 6) selected="selected" @endif >右中</option>
							<option value="7" @if(config('system.watermark_place') == 7) selected="selected" @endif >左下</option>
							<option value="8" @if(config('system.watermark_place') == 8) selected="selected" @endif >中下</option>
							<option value="9" @if(config('system.watermark_place') == 9) selected="selected" @endif >右下</option>
						</select>
					</div>
					</div>
					<div class="layui-form-mid layui-word-aux">开关只针对上传时的缩图选项勾选</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label form-label-large">水印图片</label>
					<div class="layui-input-inline input-xlarge">
    					<div class="layui-input-inline input-large">
    						<input type="text" name="watermark_image" id="watermark_image" value="{{ config('system.watermark_image') }}" autocomplete="off" placeholder="请上传水印图片" class="layui-input autosave layui-disabled">
    					</div>
    					<div class="layui-input-inline input-mini">
        					<button type="button" class="layui-btn" id="update-watermark">上传图片</button>
    					</div>
					</div>
					<div class="layui-form-mid layui-word-aux"></div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
@if($systemsetSavePower)
$("input,textarea").change(function() {
	console.log($(this).attr('name'));
	console.log($(this).val());
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
function saveConfig(name, value) {
	$.ajax({
		type:'post',
		url:'/admin/systemset/save',
		data:{name:name,value:value,_token:'{{csrf_token()}}'},
		dataType: "json",
		success: function(data){
			layer.msg(data.message);
		},
        error: function (XMLHttpResponse, textStatus, errorThrown) {
        	layer.msg('保存失败');
        }
	});
}

$("#update-watermark").click(function() {
	var watermarkImageObj = $("#watermark_image");
	var watermarkImage = watermarkImageObj.val();
	var height = $(window).height() - 2;
	layer.open({
        type: 2,
        title: ['上传水印图片', 'font-weight: bold;font-size:larger;'],
        area: ['818px', height < '668' ? (height + 'px') : '668px'],
        shade: 0,
        maxmin:true,
        content: '/admin/ueditor/getUpfileHtml?type=image&id=watermark_image',
        zIndex: layer.zIndex,
        end: function() {
            if(watermarkImage != watermarkImageObj.val()) {
            	watermarkImageObj.change();
            }
        }
      });
});
@endif

</script>
@endsection