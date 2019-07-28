@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
	<div class="layui-card-header">栏目总数：{{ $categoryCount }}个，内容总数：{{ $datas->total() }}条，未审核内容{{ $notAuditCount }}条</div>
	</xblock>
	<div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="/admin/content/list">
			<div class="layui-inline">
				<label class="layui-form-label form-label-medium">当前列表：</label>
				<div class="layui-input-inline" style="line-height: 38px;">
					<font color=green>@if($position==0 && $search=='')未审核内容@else筛选内容@endif</font>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">推荐位：</label>
				<div class="layui-input-inline">
					<select name="position" id="position"> 
                      <option value="0">全部</option>
                      @foreach ($positionList as $value)
                      <option value="{{$value['id']}}" @if($position==$value['id']) selected="selected" @endif >{{ $value['name'] }}</option>
                      {@endforeach
                    </select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label form-label-medium">内容标题：</label>
				<div class="layui-input-inline">
					<input name="search" type="text" id="search" class="layui-input" value="{{$search}}" />
				</div>
			</div>
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
	
      <div class="layui-row">
      <form  class="layui-form layui-col-md12 x-so" lay-filter="operate">
      	@if($contentAuditPower)
		<button class="layui-btn audit" data-status="1">发布</button>
		<button class="layui-btn audit" data-status="0">草稿</button>
		@endif
		</form>
	</div>
	<table class="layui-table">
		<thead>
			<tr>
				<th width="20px"><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>
				<th width="40"><center>ID</center></th>
                <th width="">标题</th>
                <th width="">栏目</th>
                <th width="40"><center>审核</center></th>
                <th width="130"><center>更新时间</center></th>
                <th width="120"><center>操作</center></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($datas as $data)
			<tr>
				<td>
				<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $data->id }}'><i class="layui-icon">&#xe605;</i></div>
				</td>
				<td><center>{{ $data->id }}</center></td>
				<td>
					<span>{{ $data->title }}</span>
					@if (!empty($data->position))
						@foreach (explode(',', $data->position) as $value)
						<font color="red">[{{ $positionList[$value]['name'] }}]</font>
						@endforeach
					@endif
					@if ($contentQuickEditPower)
					<a class="layui-btn layui-btn-normal layui-btn-xs quickeditor" style=" display:none" onclick="x_admin_show('快速编辑','content/quickEdit/{{ $data->id }}', 850)">[快速编辑]</a>
					@endif
				</td>
				<td><a href="#">{{ $data->category_name }}</a></td>
				<td><center>@if($data->status==1)<font color=green><b>√</b></font>@else<font color=red><b>×</b></font>@endif</center>
				</td>
				<td><center>{{ $data->update_time }}</center></td>
				<td>
					@if($contentInfoPower)
					<a class="layui-btn layui-btn-normal layui-btn-xs" onclick="x_admin_show('查看内容','/admin/content/info/{{ $data->id }}', 850)"><i class="layui-icon layui-icon-edit"></i>查看</a>
					@endif
					@if($contentDeletePower)
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
//快速编辑
$('tr').hover(
	function () {
		$(this).find('.quickeditor').show();
	},
	function () {
		$(this).find('.quickeditor').hide();
	}
);
layui.use(['laypage', 'layer', 'jquery', 'form'], function(){
  var laypage = layui.laypage;
  var layer = layui.layer;
  var $ = layui.jquery;
  var form = layui.form;
  laypage.render({
    elem: 'page',
    count: {{ $datas->total() }},
    limit: {{ $datas->perPage() }},
    curr: {{ $datas->currentPage() }},
    jump: function(obj, first){
        if(!first) {
        	layer.load();
        	location.href = "/admin/content/index?page=" + obj.curr;
        }
        if(obj.count == 0) {
			$("#page").hide();
        }
	}
  });
  
  $("#del").click(function(){
	  var data = tableCheck.getData();
	  console.log(data);
	  if(data.length <= 0) {
		  layer.msg('请选择要删除的内容');
	  } 
	  var ids = '';
	  for(var i=0; i<data.length; i++) {
		  if(i > 0) {
			  ids += ',';
		  }
		  ids += data[i];
	  }
	  layer.confirm('确认要删除选中的内容吗？',function(index){
		  $.ajax({
  			type:'post',
  			url:'/admin/content/delete',
  			data:{ids:ids, _token:"{{ csrf_token() }}"},
  			dataType: "json",
  			success: function(data){
  				if(data.status == 10000) {
  					  $(".layui-form-checked").not('.header').parents('tr').remove();
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

  $(".audit").click(function(){
	  var data = tableCheck.getData();
	  console.log(data);
	  if(data.length <= 0) {
		  layer.msg('请选择要操作的内容');
		  return;
	  } 
	  var ids = '';
	  for(var i=0; i<data.length; i++) {
		  if(i > 0) {
			  ids += ',';
		  }
		  ids += data[i];
	  }
	  var status = $(this).attr('data-status');
	  console.log(status);
	  $.ajax({
		type:'post',
		url:'/admin/content/audit',
		data:{ids:ids,status:status,_token:"{{ csrf_token() }}"},
		dataType: "json",
		success: function(data){
			if(data.status == 10000) {
				window.location.reload();
	          layer.msg('操作成功!',{icon:1,time:1000});
          } else {
         		layer.msg(data.message);
          }
		},
    	error: function (XMLHttpResponse, textStatus, errorThrown) {
      	    layer.msg('操作失败');
        }
	});
  	layer.msg('正在操作 . . .', {shade:0.2});
  });

  form.on('submit(operate)',function(data){
	    return false;
	});
});
</script>
@endsection