@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		@if($formIndexPower)
		<button class="layui-btn" onclick="location.href='/admin/form/index';">表单管理</button>
		@endif
		<button class="layui-btn" onclick="location.href='/admin/formdata/index/{{ $formInfo->id }}';">{{ $formInfo->name }} - 表单数据管理</button>
		@if($formdataAddPower)
		<button class="layui-btn" onclick="x_admin_show('添加表单数据','/admin/formdata/add/{{ $formInfo->id }}', 1000)">{{ $formInfo->name }} - 表单数据添加</button>
		@endif
	</xblock>
	<table class="layui-table">
		<thead>
			<tr>
				<th>序号</th>
				@foreach ($formFieldList as $formField)
				<th>{{ $formField->name }}</th>
				@endforeach
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $formData)
			<tr>
				<td>{{ $loop->iteration }}</td>
				@foreach ($formFieldList as $formField)
				<td>{!! $formField->getFieldValue($formData) !!}</td>
				@endforeach
				<td>
					@if($formdataInfoPower)
					<a class="layui-btn layui-btn-normal layui-btn-xs" onclick="x_admin_show('查看表单数据','/admin/formdata/info/{{ $formInfo->id }}/{{ $formData->id }}', 850)"><i class="layui-icon layui-icon-edit"></i>查看</a>
					@endif
					@if($formdataDeletePower)
					<a class="layui-btn layui-btn-danger layui-btn-xs del" data-id="{{ $formData->id }}"><i class="layui-icon layui-icon-delete"></i>删除</a>
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
	        	location.href = "/admin/formdata/index/{{ $formInfo->id }}?page=" + obj.curr;
	        }
	        if(obj.count == 0) {
				$("#page").hide();
	        }
		}
	  });
  $(".del").click(function(){
	  var obj = $(this);
	  var id = obj.attr("data-id");
	  layer.confirm('确认要删除吗？',function(index){
		  $.ajax({
  			type:'post',
  			url:'/admin/formdata/delete',
  			data:{id:id, form_id:"{{$formInfo->id}}", _token:"{{ csrf_token() }}"},
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