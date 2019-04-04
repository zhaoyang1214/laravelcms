@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		<button class="layui-btn" onclick="location.href='/admin/upload/index';">附件管理</button>
	</xblock>
	<div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="/admin/upload/index">
			<div class="layui-inline">
				<label class="layui-form-label"> 文件格式：</label>
				<div class="layui-input-inline">
					<select name="ext">
                    	<option value="0" >全部</option>
                    	<option value="1" @if($ext==1) selected="selected" @endif  >图片</option>
                        <option value="2" @if($ext==2) selected="selected" @endif  >媒体</option>
                        <option value="3" @if($ext==3) selected="selected" @endif  >文档</option>
                        <option value="4" @if($ext==4) selected="selected" @endif  >压缩</option>
                        <option value="5" @if($ext==5) selected="selected" @endif  >其他</option>
                    </select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">所属模块：</label>
				<div class="layui-input-inline">
					<select name="module" id="module">
						<option value="0">全部模块</option>
                    	@foreach($modules as $key => $value)
                        <option value="{{ $key }}"  @if($module==$key) selected="selected" @endif >{{ $value }}</option>
                        {@endforeach
                    </select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">文件名称：</label>
				<div class="layui-input-inline">
					<input name="title" type="text" id="title" class="layui-input" value="{{$title}}" />
				</div>
			</div>
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
	<table class="layui-table">
		<thead>
			<tr>
				<th>序号</th>
				<th>文件名称</th>
				<th>上传时间</th>
				<th>模块</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($datas as $data)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td><a href="{{ $data->file }}" target="_blank"> @if(!empty($title)){!! str_replace($title, "<font color='red'>$title</font>", $data->title) !!}@else {{ $data->title }}@endif</a>
        &nbsp;&nbsp;<a href="{{ $data->title }}" download="{{$data->title}}.{{$data->ext}}">[下载]</a></td>
				<td>{{ $data->time }}</td>
				<td>{{ $data->getModule($data->module) }}</td>
				<td>
					@if($uploadDeletePower)
					<a class="layui-btn layui-btn-danger layui-btn-xs del" data-id="{{ $data->id }}"><i class="layui-icon layui-icon-delete"></i>删除</a>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div id="page"></div>
</div>
<script>
layui.use(['laypage', 'layer', 'jquery'], function(){
  var laypage = layui.laypage;
  var layer = layui.layer;
  var $ = layui.jquery;
  laypage.render({
    elem: 'page',
    count: {{ $datas->total() }},
    limit: {{ $datas->perPage() }},
    curr: {{ $datas->currentPage() }},
    jump: function(obj, first){
        if(!first) {
        	layer.load();
        	location.href = "/admin/upload/index?page=" + obj.curr;
        }
        if(obj.count == 0) {
			$("#page").hide();
        }
	}
  });
  $(".del").click(function(){
	  var obj = $(this);
	  var id = obj.attr("data-id");
	  layer.confirm('确认要删除该附件吗？',function(index){
		  $.ajax({
  			type:'post',
  			url:'/admin/upload/delete',
  			data:{id:id, _token:"{{ csrf_token() }}"},
  			dataType: "json",
  			success: function(data){
  				if(data.status == 10000) {
    				$(obj).parents("tr").remove();
      		          layer.msg('删除成功!',{icon:1,time:1000});
                  } else {
                 		layer.msg(data.message);
                  }
  			},
            error: function (XMLHttpResponse, textStatus, errorThrown) {
          	    layer.msg('删除失败');
            }
  		});
      	layer.msg('正在删除 . . .', {shade:0.2});
      	return false;
      });
  });
});
</script>
@endsection