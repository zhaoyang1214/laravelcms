@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		<button class="layui-btn" onclick="location.href='/admin/form/index';">表单管理</button>
		@if($formAddPower)
		<button class="layui-btn" onclick="x_admin_show('添加表单','/admin/form/add', 850)">表单添加</button>
		@endif
	</xblock>
	<table class="layui-table">
		<thead>
			<tr>
				<th>序号</th>
				<th>表单编号</th>
				<th>表单名称</th>
				<th>表名</th>
				<th>表单顺序</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($datas as $data)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $data->no }}</td>
				<td>{{ $data->name }}</td>
				<td>{{ $data->table }}</td>
				<td>{{ $data->sequence }}</td>
				<td>
					@if($formfieldIndexPower)
					<a class="layui-btn layui-btn-normal layui-btn-xs" href="/admin/formfield/index/{{ $data->id }}"><i class="layui-icon layui-icon-read"></i>字段管理</a>
					@endif
					@if($formdataIndexPower)
					<a class="layui-btn layui-btn-normal layui-btn-xs" href="/admin/formdata/index/{{ $data->id }}"><i class="layui-icon layui-icon-read"></i>数据管理</a>
					@endif
					@if($formInfoPower)
					<a class="layui-btn layui-btn-normal layui-btn-xs" onclick="x_admin_show('查看表单','/admin/form/info/{{ $data->id }}', 850)"><i class="layui-icon layui-icon-edit"></i>查看</a>
					@endif
					@if($formDeletePower)
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
        	location.href = "/admin/form/index?page=" + obj.curr;
        }
        if(obj.count == 0) {
			$("#page").hide();
        }
	}
  });
  $(".del").click(function(){
	  var obj = $(this);
	  var id = obj.attr("data-id");
	  layer.confirm('删除该表单，数据也会随之删除，确认要删除吗？',function(index){
		  $.ajax({
  			type:'post',
  			url:'/admin/form/delete',
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