@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="name" class="layui-form-label form-label-medium">标题</label>
            <div class="layui-input-inline input-xlarge">
                <input type="text" id="title" name="title" lay-verify="required" value="@isset($info){{ $info->title }}@endisset" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
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
            <label for="urltitle" class="layui-form-label form-label-medium">英文URL名称</label>
            <div class="layui-input-inline input-xlarge">
                <input type="text" id="urltitle" name="urltitle" value="@isset($info){{ $info->urltitle }}@endisset" autocomplete="off" class="layui-input">
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
        <div class="layui-form-item">
            <label for="update_time" class="layui-form-label form-label-medium">更新时间</label>
            <div class="layui-input-inline input-xlarge">
                <input type="text" id="update_time" name="update_time" value="" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
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
        <div class="layui-form-item">
            <label class="layui-form-label form-label-medium"></label>
            @csrf
            <input type="hidden" name="id" value="{{ $info->id }}" />
            <button class="layui-btn" lay-filter="submit" lay-submit="">{{ $actionName }}</button>
        </div>
    </form>
</div>

<script type="text/javascript">
layui.use(['form', 'laydate'], function(){
  	var form = layui.form
  	var layer = layui.layer;
    var laydate = layui.laydate;

    laydate.render({
        elem: '#update_time',
        trigger: 'click',
        type: 'datetime',
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

//页面执行
$(document).ready(function() {
	$("#keywords_tag").attr("style", "color: rgb(102, 102, 102); width: 310px; height: 28px; border: 1px solid rgb(230, 230, 230); border-radius: 2px;");
});

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
