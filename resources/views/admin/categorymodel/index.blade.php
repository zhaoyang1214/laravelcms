@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		<button class="layui-btn" lay-submit="" lay-filter="sreach" onclick="location.reload();">栏目模型列表</button>
	</xblock>
	<table class="layui-table" lay-filter="category-model">
		<thead>
			<tr>
				<th>ID</th>
				<th>模型名称</th>
				<th>模型状态</th>
				<th>模型操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($categoryModelList as $categoryModel)
			<tr>
				<td>{{ $categoryModel->id }}</td>
				<td>{{ $categoryModel->name }}</td>
				<td>@if($categoryModel->status)开启 @else 关闭 @endif</td>
				<td>
					@if($categorymodelInfoPower)
					<a class="layui-btn layui-btn-primary layui-btn-xs" onclick="x_admin_show('查看栏目模型','/admin/categorymodel/info/{{ $categoryModel->id }}')" >查看</a>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection