@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		<button class="layui-btn" lay-submit="" lay-filter="sreach" onclick="location.href='/admin/admingroup/index';">管理组管理</button>
		@if($admingroupAddPower)
		<button class="layui-btn" lay-submit="" lay-filter="sreach" onclick="x_admin_show('添加管理组','/admin/admingroup/add', 900)">管理组添加</button>
		@endif
	</xblock>
	<table class="layui-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>管理组名称</th>
				<th>级别</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $admingroup)
			<tr>
				<td>{{ $admingroup->id }}</td>
				<td>{{ $admingroup->name }}</td>
				<td>{{ $admingroup->grade }}</td>
				<td>
					@if($admingroupInfoPower && $adminGroupInfo['grade'] < $admingroup->grade)
					<a class="layui-btn layui-btn-normal layui-btn-xs" onclick="x_admin_show('查看管理组','/admin/admingroup/info/{{ $admingroup->id }}', 900)"><i class="layui-icon layui-icon-edit"></i>查看</a>
					@endif
					@if($admingroupDeletePower && $adminGroupInfo['grade'] < $admingroup->grade)
					<a class="layui-btn layui-btn-danger layui-btn-xs del" data-id="{{ $admingroup->id }}"><i class="layui-icon layui-icon-delete"></i>删除</a>
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
    count: {{ $data->total() }},
    limit: {{ $data->perPage() }},
    curr: {{ $data->currentPage() }},
    jump: function(obj, first){
        if(!first) {
        	layer.load();
        	location.href = "/admin/admingroup/index?page=" + obj.curr;
        }
    }
  });
  $(".del").click(function(){
	  var obj = $(this);
	  var id = obj.attr("data-id");
	  layer.confirm('确认要删除吗？',function(index){
		  $.ajax({
  			type:'post',
  			url:'/admin/admingroup/delete',
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