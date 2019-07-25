@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		<button class="layui-btn" onclick="location.href='/admin/category/index';">栏目管理</button>
		@foreach($list as $v)
		<button class="layui-btn" onclick="x_admin_show('添加加{{ $v['name'] }}','/admin/{{ $v['category'] }}/add', 850)">添加{{ $v['name'] }}栏目</button>
		@endforeach
	</xblock>
	<table class="layui-table">
		<thead>
			<tr>
				<th width="10%"><center>ID</center></th>
                <th width="15%">栏目名称</th>
                <th width="20%">url名称</th>
                <th width="10%"><center>顺序</center></th>
                <th width="10%"><center>栏目显示</center></th>
                <th width="10%"><center>栏目属性</center></th>
                <th width="10%"><center>栏目类型</center></th>
                <th width="15%"><center>栏目操作</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($datas as $data)
			<tr>
				<td><center>{{ $data['id'] }}</center></td>
                <td>
                <a href="/category/{{ $data['urlname'] }}" target="_blank">{!! $data['cname'] !!}</a>
                @if(!empty($data['image']))
                <a href="javascript:;" rel="{{ $data['image'] }}" class="class_pic"><img align="AbsMiddle" src="/admin/images/ico/pic.png" width="14" height="14" alt="{{ $data['name'] }}" /></a>
                @endif
                </td>
                <td>{{ $data['urlname'] }}</td>
                <td><center>
                @if($categorySequencePower)
                <input type="text" value="{{ $data['sequence'] }}" class="sequence" onblur="sequence({{ $data['id'] }},$(this).val())" />
                @else
                {{ $data['sequence'] }}
                @endif
                </center></td>
                <td><center>
                @if($data['is_show'])
                <font color=green><b>√</b></font>
                @else
                <font color=red><b>×</b></font>
                @endif
                </center></td>
                <td><center>
                @if($data['type']==1)
                	频道
                @elseif($data['type']==2)
                	列表
                @endif
                </center></td>
                <td><center>{{ $categoryModelList[$data['category_model_id']]['name'] }}</center></td>
                <td>
					<a class="layui-btn layui-btn-normal layui-btn-xs" onclick="x_admin_show('查看栏目','/admin/{{ $categoryModelList[$data['category_model_id']]['category']}}/info/{{$data['id'] }}', 850)"><i class="layui-icon layui-icon-edit"></i>查看</a>
					<a class="layui-btn layui-btn-danger layui-btn-xs" href="javascript:void(0);" onclick="del('/admin/{{ $categoryModelList[$data['category_model_id']]['category']}}/delete',{{ $data['id'] }},this)"><i class="layui-icon layui-icon-delete"></i>删除</a>
                 </td>
             </tr>
      		@endforeach
		</tbody>
	</table>
	<div id="page"></div>
</div>
<script>
//栏目形象图
$(".class_pic").powerFloat({
    targetMode: "ajax"
});
layui.use(['layer', 'jquery'], function(){
  var layer = layui.layer;
  var $ = layui.jquery;
});

function del(url,id,obj) {
	  layer.confirm('删除此栏目会删除栏目下的内容！',function(index){
		  $.ajax({
			type:'post',
			url:url,
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
}

//栏目排序
function sequence(id,sequence){
	$.ajax({
		type:'post',
		url:'/admin/category/sequence',
		data:{id:id,sequence:sequence,_token:'{{csrf_token()}}'},
		dataType: "json",
		success: function(data){
			layer.msg(data.message);
			window.location.href='/admin/category/index';
		},
        error: function (XMLHttpResponse, textStatus, errorThrown) {
        	layer.msg('保存失败');
        }
	});
}
</script>
@endsection