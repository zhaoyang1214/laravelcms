@extends('admin.layouts.common')

@section('content')
<div class="x-body">
	<xblock>
		<button class="layui-btn" onclick="location.href='/admin/tags/index';">TAG管理</button>
		@if($tagsgroupIndexPower)
			<button class="layui-btn" onclick="location.href='/admin/tagsgroup/index';">TAG分组管理</button>
		@endif
		@if($tagsgroupAddPower)
			<button class="layui-btn" onclick="x_admin_show('添加TAG组','/admin/tagsgroup/add', 850)">TAG分组添加</button>
		@endif
	</xblock>
	<div class="layui-row">
        <form class="layui-form layui-col-md12 x-so" action="/admin/tags/index">
			<div class="layui-inline">
				<label class="layui-form-label form-label-small">排序：</label>
				<div class="layui-input-inline">
					<select name="sequence" id="sequence">
						<option value="0" @if($sequence==0) selected="selected" @endif>默认</option>
						<option value="1" @if($sequence==1) selected="selected" @endif>点击率 高->低</option>
						<option value="2" @if($sequence==2) selected="selected" @endif>点击率 低->高</option>
					</select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">分组筛选：</label>
				<div class="layui-input-inline">
					<select name="tags_group_id" id="tags_group_id">
                      <option value="-1" >全部</option>
                      <option value="0" @if($tagsGroupId==0) selected="selected" @endif >未分组</option>
                      @foreach($tagsGroupList as $tagsGroup)
                  	  <option value="{{ $tagsGroup->id }}"  @if($tagsGroupId==$tagsGroup->id) selected="selected" @endif >{{ $tagsGroup->name }}</option>
                      {@endforeach
                    </select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label form-label-small">名称：</label>
				<div class="layui-input-inline">
					<input name="name" type="text" id="name" class="layui-input" value="{{$name}}" />
				</div>
			</div>
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <div class="layui-row">
      <form  class="layui-form layui-col-md12 x-so" lay-filter="operate">
		<button class="layui-btn" id="del">删除</button>
		<div class="layui-inline">
			<div class="layui-input-inline">
				<select id="tags_group_id2">
                  <option value="0">选择分组</option>
                  @foreach($tagsGroupList as $tagsGroup)
              	  <option value="{{ $tagsGroup->id }}" >{{ $tagsGroup->name }}</option>
                  {@endforeach
                </select>
			</div>
		</div>
		<button class="layui-btn" id="grouping">分组</button>
		</form>
	</div>
	<table class="layui-table">
		<thead>
			<tr>
				<th width="20px"><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>
				<th>序号</th>
				<th>名称</th>
				<th>分组</th>
				<th>点击数</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($datas as $data)
			<tr>
				<td>
				<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{ $data->id }}'><i class="layui-icon">&#xe605;</i></div>
				</td>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $data->name }}</td>
				<td>{{ $data->tags_group_name }}</td>
				<td>{{ $data->click }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div id="page"></div>
</div>
<script>
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
        	location.href = "/admin/tags/index?page=" + obj.curr;
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
		  layer.msg('请选择要删除的TAG');
	  } 
	  var ids = '';
	  for(var i=0; i<data.length; i++) {
		  if(i > 0) {
			  ids += ',';
		  }
		  ids += data[i];
	  }
	  layer.confirm('确认要删除选中的TAG吗？',function(index){
		  $.ajax({
  			type:'post',
  			url:'/admin/tags/delete',
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

  $("#grouping").click(function(){
	  var data = tableCheck.getData();
	  console.log(data);
	  if(data.length <= 0) {
		  layer.msg('请选择要分组的TAG');
		  return;
	  } 
	  var ids = '';
	  for(var i=0; i<data.length; i++) {
		  if(i > 0) {
			  ids += ',';
		  }
		  ids += data[i];
	  }
	  var tagsGroupId = $("#tags_group_id2").val();
	  if(tagsGroupId == 0) {
		  layer.msg('请指定分组');
		  return;
	  }
		  
	  $.ajax({
		type:'post',
		url:'/admin/tags/grouping',
		data:{ids:ids,tags_group_id:tagsGroupId,_token:"{{ csrf_token() }}"},
		dataType: "json",
		success: function(data){
			if(data.status == 10000) {
				window.location.reload();
	          layer.msg('分组成功!',{icon:1,time:1000});
          } else {
         		layer.msg(data.message);
          }
		},
    	error: function (XMLHttpResponse, textStatus, errorThrown) {
      	    layer.msg('分组失败');
        }
	});
  	layer.msg('正在分组 . . .', {shade:0.2});
  });

  form.on('submit(operate)',function(data){
	    return false;
	});
});
</script>
@endsection