@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		@if($formIndexPower)
		<button class="layui-btn" onclick="location.href='/admin/form/index';">表单管理</button>
		@endif
		<button class="layui-btn" onclick="location.href='/admin/formfield/index/{{ $formInfo->id }}';">{{ $formInfo->name }} - 表单字段管理</button>
		@if($formfieldAddPower)
		<button class="layui-btn" onclick="x_admin_show('添加表单字段','/admin/formfield/add/{{ $formInfo->id }}', 850)">{{ $formInfo->name }} - 表单字段添加</button>
		@endif
	</xblock>
	<table class="layui-table">
		<thead>
			<tr>
				<th>序号</th>
				<th>字段描述</th>
				<th>字段名</th>
				<th>字段类型</th>
				<th>字段属性</th>
				<th>字段顺序</th>
				<th>后台列表显示</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($datas as $data)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $data->name }}</td>
				<td>{{ $data->field }}</td>
				<td>{{ $formField->getTypeProperty($data->type, false) }}</td>
				<td>{{ $formField->getTypeProperty($data->type, $data->property) }}</td>
				<td>{{ $data->sequence }}</td>
				<td>@if($data->admin_display) 是 @else 否  @endif</td>
				<td>
					@if($formfieldInfoPower)
					<a class="layui-btn layui-btn-normal layui-btn-xs" onclick="x_admin_show('查看表单字段','/admin/formfield/info/{{ $data->id }}', 850)"><i class="layui-icon layui-icon-edit"></i>查看</a>
					@endif
					@if($formfieldDeletePower)
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
  $(".del").click(function(){
	  var obj = $(this);
	  var id = obj.attr("data-id");
	  layer.confirm('删除该字段，数据也会随之删除，确认要删除吗？',function(index){
		  $.ajax({
  			type:'post',
  			url:'/admin/formfield/delete',
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