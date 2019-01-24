@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		<button class="layui-btn" lay-submit="" lay-filter="sreach" onclick="location.href='/admin/admin/index';">管理员管理</button>
		@if($adminAddPower)
		<button class="layui-btn" lay-submit="" lay-filter="sreach" onclick="x_admin_show('添加管理员','/admin/admin/add', 650)">管理员添加</button>
		@endif
	</xblock>
	<table class="layui-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>管理员账号</th>
				<th>管理员名称</th>
				<th>管理组</th>
				<th>创建时间</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $admin)
			<tr>
				<td>{{ $admin->id }}</td>
				<td>{{ $admin->username }}</td>
				<td>{{ $admin->nickname }}</td>
				<td>{{ $admin->admin_group_name }}</td>
				<td>{{ $admin->regtime }}</td>
				<td>@if($admin->status==1)正常 @else 禁用 @endif</td>
				<td>
					@if($adminInfoPower && $adminGroupInfo['grade'] < $admin->grade)
					<a class="layui-btn layui-btn-normal layui-btn-xs" onclick="x_admin_show('查看管理员','/admin/admin/info/{{ $admin->id }}', 650)"><i class="layui-icon layui-icon-edit"></i>查看</a>
					@endif
					@if($adminEditInfoPower && ($adminGroupInfo['grade'] < $admin->grade || $adminInfo['id'] == $admin->id))
					<a class="layui-btn layui-btn-normal layui-btn-xs" onclick="x_admin_show('修改资料','/admin/admin/editInfo/{{ $admin->id }}', 650)"><i class="layui-icon layui-icon-edit"></i>修改资料</a>
					@endif
					@if($adminDeletePower && $adminGroupInfo['grade'] < $admin->grade)
					<a class="layui-btn layui-btn-danger layui-btn-xs del" data-id="{{ $admin->id }}"><i class="layui-icon layui-icon-delete"></i>删除</a>
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
        	location.href = "/admin/admin/index?page=" + obj.curr;
        }
    }
  });
  $(".del").click(function(){
	  var obj = $(this);
	  var id = obj.attr("data-id");
	  layer.confirm('确认要删除吗？',function(index){
		  $.ajax({
  			type:'post',
  			url:'/admin/admin/delete',
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