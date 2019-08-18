@extends('admin.layouts.common') 

@section('content')
<form class="layui-form">
<div class="layui-tab layui-tab-brief">
	<ul class="layui-tab-title">
		<li class="layui-this">基本内容</li>
		<li>高级信息</li>
		<li>扩展信息</li>
	</ul>
	<div class="layui-tab-content">
		<div class="layui-tab-item layui-show">
				<div class="layui-form-item">
        			<label for="pid" class="layui-form-label form-label-medium">栏目</label>
        			<div class="layui-input-inline input-xlarge" style="z-index: 1000;">
        				<select name="category_id" id="category_id" lay-filter="category_id" style="width: 300px">
        					<option value="0">=====选择栏目=====</option>
        					@foreach($categoryList as $value)
        					<option value="{{ $value['id'] }}" @if($value['type']==1 || $value['category_model_id'] != $category->category_model_id)disabled @endif @if(isset($info) && $info['category_id']==$value['id'])selected @endif>{!! $value['cname'] !!}</option>
        					@endforeach
        				</select>
        			</div>
        			<div class="layui-form-mid layui-word-aux"></div>
        		</div>
        		<div class="layui-form-item">
        			<label for="name" class="layui-form-label form-label-medium">标题</label>
        			<div class="layui-input-inline input-xlarge">
        				<input type="text" id="title" name="title" lay-verify="required" value="@isset($info){{ $info->title }}@endisset" autocomplete="off" class="layui-input">
        			</div>
        			<div class="layui-form-mid layui-word-aux">
        				<div class="corol_button"></div>
                        <div onclick="fontbold()" class="bold_button"></div>
                        <input id="font_color" name="font_color" type="hidden" value="@isset($info){{ $info->font_color }}@endisset" />
                        <input id="font_bold" name="font_bold" type="hidden" value="@isset($info){{ $info->font_bold }}@else 0 @endisset" />
        			</div>
        		</div>
        		<div class="layui-form-item">
        			<label for="name" class="layui-form-label form-label-medium">推荐位</label>
        			<div class="layui-input-inline input-xxxxlarge">
        				<?php
            $positionArr = (isset($info) && ! empty($info->position)) ? explode(',', $info->position) : []?>
        				@foreach($positionList as $value)
        				<input type="checkbox" id="position{{$loop->index}}" name="position[]"  value="{{ $value->id }}" title='{{ $value->name }}' @if(in_array($value->id, $positionArr))checked="checked"@endif  class='keep'>
        				@endforeach
        			</div>
        			<div class="layui-form-mid layui-word-aux"></div>
        		</div>
        		<div class="layui-form-item">
        			<label for="image" class="layui-form-label form-label-medium">内容形象图</label>
        			<div class="layui-input-inline input-xxxxlarge">
        				<div class="layui-input-inline input-large">
                					<input type="text" name="image" id="image"  value="@isset($info){{ $info->image }}@endisset" autocomplete="off" placeholder="请选择图片" class="layui-input layui-disabled">
                				</div>
                				<div class="layui-input-inline input-xlarge">
                					<button type="button" class="layui-btn" id="upload-image">上传图片</button>
                					<button type="button" class="layui-btn" onclick="get_one_pic()">提取第一张图</button>
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
                                        content: '/admin/ueditor/getUpfileHtml?type=image&origin=2&id=image',
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
                 		<script name="content" id="content" type="text/plain" style="width:100%; height:400px;">@if(isset($contentData) && !empty($contentData)){!! htmlspecialchars_decode($contentData->content) !!}@endif</script>
                 		<script type="text/javascript">UE.getEditor("content", {"serverUrl":"/admin/ueditor/index?origin=2"});</script>
        			</div>
        			<div class="layui-form-mid layui-word-aux"></div>
        		</div>
        		<div class="layui-form-item">
        			<label for="copyfrom" class="layui-form-label form-label-medium">内容来源</label>
        			<div class="layui-input-inline input-xlarge">
        				<input type="text" id="copyfrom" name="copyfrom" value="@isset($info){{ $info->copyfrom }}@endisset" autocomplete="off" class="layui-input">
        			</div>
        			<div class="layui-form-mid layui-word-aux">
        			</div>
        		</div>
        		<div class="layui-form-item layui-form-text">
					<label class="layui-form-label form-label-medium">描述</label>
					<div class="layui-input-inline input-xlarge">
						<textarea name="description" class="layui-textarea" id="description">@isset($info){{ $info->description }}@endisset</textarea>
					</div>
					<div class="layui-form-mid layui-word-aux">
						<button type="button" class="layui-btn" onclick="javascript:get_description()">提取描述</button>
					</div>
				</div>
				<div class="layui-form-item">
        			<label for="keywords" class="layui-form-label form-label-medium">关键词</label>
        			<div class="layui-input-inline input-xlarge">
        				<input type="text" id="keywords" name="keywords" value="@isset($info){{ $info->keywords }}@endisset" autocomplete="off" class="layui-input">
        			</div>
        			<div class="layui-input-inline input-xlarge">
        				<button type="button" class="layui-btn" onclick="javascript:get_keywords()">提取关键词</button>
        				<input type="checkbox" id="taglink" name="taglink"  value="1" title='内容自动链接' @if(isset($info->taglink) && $info->taglink==1)checked="checked"@endif  class='keep'>
        			</div>
        		</div>
                @if($contentAuditPower)
                <div class="layui-form-item layui-form-text">
                    <label for="status" class="layui-form-label form-label-medium">状态</label>
                    <div class="layui-input-inline input-xlarge">
						<input type='radio' name='status' value='1' title='发布' @if(isset($info) && $info->status == 1)checked @endif>
						<input type='radio' name='status' value='0' title='草稿' @if(!isset($info) || $info->status == 0)checked @endif>
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                    </div>
                </div>
                @endif
		</div>
		<div class="layui-tab-item">
			<div class="layui-form-item">
				<label for="subtitle" class="layui-form-label form-label-medium">副标题</label>
				<div class="layui-input-inline input-xlarge">
					<input type="text" id="subtitle" name="subtitle" value="@isset($info){{ $info->subtitle }}@endisset" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="urltitle" class="layui-form-label form-label-medium">英文URL名称</label>
				<div class="layui-input-inline input-xlarge">
					<input type="text" id="urltitle" name="urltitle" value="@isset($info){{ $info->urltitle }}@endisset" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="views" class="layui-form-label form-label-medium">访问量</label>
				<div class="layui-input-inline input-xlarge">
					<input type="text" id="views" name="views" value="@isset($info){{ $info->views }}@else{{0}}@endisset" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">
					内容浏览量
				</div>
			</div>
			<div class="layui-form-item">
				<label for="sequence" class="layui-form-label form-label-medium">顺序</label>
				<div class="layui-input-inline input-xlarge">
					<input type="text" id="sequence" name="sequence" value="@isset($info){{ $info->sequence }}@else{{0}}@endisset" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">
					(自定义顺序，升序)
				</div>
			</div>
			<div class="layui-form-item">
				<label for="jump_url" class="layui-form-label form-label-medium">跳转到</label>
				<div class="layui-input-inline input-xlarge">
					<input type="text" id="jump_url" name="jump_url" value="@isset($info){{ $info->jump_url }}@endisset" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">
					URL链接
				</div>
			</div>
			<div class="layui-form-item">
				<label for="update_time" class="layui-form-label form-label-medium">更新时间</label>
				<div class="layui-input-inline input-xlarge">
					<input type="text" id="update_time" name="update_time" value="" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">
				</div>
			</div>
            <div class="layui-form-item">
                <label for="tpl" class="layui-form-label form-label-medium">内容模板</label>
                <div class="layui-input-inline input-xlarge">
                    <input type="text" id="tpl" name="tpl" value="@isset($info){{ $info->tpl }}@endisset" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    留空采用栏目指定模板
                </div>
            </div>
		</div>
		<div class="layui-tab-item">
            @foreach($expandFieldList as $expandField)
                {!! $expandField->getFieldHtml($expandData ?? null) !!}
            @endforeach
		</div>
	</div>
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
<script type="text/javascript">
layui.use(['form', 'laydate'], function(){
  	var form = layui.form
  	var layer = layui.layer;
    var laydate = layui.laydate;

    laydate.render({
        elem: '#update_time',
        type: 'datetime',
        trigger: 'click',
        format: "yyyy-MM-dd HH:mm:ss"
    });

  //监听提交
  form.on('submit(submit)', function(data){
	  var requestData = data.field;
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

function fontbold()
{
	if($('#font_bold').val()==0){
		$('#title').css("font-weight",'bold');
		$('#font_bold').val(1);
		}else{
		$('#title').css("font-weight",'normal');	
		$('#font_bold').val(0);
	}
}

$('.corol_button').soColorPacker({
	textChange:false, 
callback:function(c){
	$('#title').css("color", c.color);
	$('#font_color').val(c.color);
	}
});
function get_one_pic(){
	var content=UE.getEditor('content').getAllHtml();
	var imgreg = /<img.*?(?:>|\/>)/gi;
	var srcreg = /src=[\'\"]?([^\'\"]*)[\'\"]?/i;
	var arr = content.match(imgreg);
	if(arr == null) {
		return false;
	}
	var src = arr[0].match(srcreg);
	$("#image").val(src[1]);
}
//内容来源列表
function befrom_list(id){
	
    <?php
    
    $befromlist = empty($categoryModel->befrom) ? [] : explode("\n", $categoryModel->befrom);
    ?>
	var list = [ 
	@foreach($befromlist as $value)
	{
		href: "javascript:;\" onclick=\"befrom_val('"+id+"','{{ $value }}');\"",
		text: "{{ $value }}"
	},
	@endforeach
	{
		text: "请选择内容来源"
	}];
	return list;
	
}
//来源赋值
function befrom_val(id,val){
	$('#'+id).val(val);
	$.powerFloat.hide();
	return false;
}
//页面执行
$(document).ready(function() {
	//来源选择
	$("#copyfrom").powerFloat({
		width: 220,
		eventType: "click",
		edgeAdjust:false,
		target:befrom_list('copyfrom'),
		targetMode: "list"
	}); 
	$("#keywords_tag").attr("style", "color: rgb(102, 102, 102); width: 310px; height: 28px; border: 1px solid rgb(230, 230, 230); border-radius: 2px;");
});
function get_description(){
	var content=UE.getEditor('content').getContent();
	content=content.substring(0,1000);
	content=content.replace(/\s+/g," ")
	content=content.replace(/[\r\n]/g," ");
	content = content.replace(/<\/?[^>]*>/g,'');
	if(content.length > 250){
	    content = content.substring(0,250);
	}
	$("#description").val(content);
}
//TAG
$('#keywords').tagsInput(
{
	'defaultText':'关键词会转为tag'
});

function get_keywords(){	
	$.ajax({
		type:'post',
		url:'/admin/content/getKeywords',
		data:{text:$('#title').val()+ ' ' +$('#description').val(),_token:'{{csrf_token()}}'},
		dataType: "json",
		success: function(data){
			var msg = '';
			for(var i=0;i<data.length;i++) {
				if(msg!='') {
					msg += ',';
				}
				msg += data[i].word;
			}
			console.log(msg);
			$('#keywords').importTags(msg);
			layer.msg('关键词获取完毕');
		},
        error: function (XMLHttpResponse, textStatus, errorThrown) {
        	
        }
	});
}
</script>
@endsection
