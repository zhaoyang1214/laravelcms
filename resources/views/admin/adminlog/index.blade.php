@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<table class="layui-table">
		<thead>
			<tr>
				<th>序号</th>
				<th>登录时间</th>
				<th>ip</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $adminlog)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $adminlog->logintime }}</td>
				<td>{{ $adminlog->ip }}</td>
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
        	location.href = "/admin/adminlog/index?page=" + obj.curr;
        }
    }
  });
});
</script>
@endsection