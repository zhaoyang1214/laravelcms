@extends('admin.layouts.common')
<style type="text/css">
.info {
    height: 30px;
    padding-left: 20px;
    padding-right: 20px;
}
.info h3 {
    font-size: 20px;
    float: left;
    margin: 0;
    padding: 0;
    padding-right: 10px;
    font-weight: bold;
	color: rgb(77, 77, 77);
}
.info small {
    margin: 0;
    padding: 0;
    float: left;
    padding-top: 8px;
    color: #999;
    font-size: 12px;
}
</style>
@section('content')
<div class="x-body">
	<xblock>
		<div class="info">
			<h3>{{ $category->name }} - 内容管理</h3>
    		<small>使用以下功能进行内容操作</small>
    	</div>
	</xblock>
	<div class="layui-row" style="margin-bottom: 20px;">
        <form class="layui-form layui-col-md12" action="/admin/content/index/{{ $category->id}}">
			<div class="layui-inline">
				<label class="layui-form-label form-label-small">排序：</label>
				<div class="layui-input-inline input-medium">
					<select name="sequence" id="sequence"> 
                      	<option value="1" @if($sequence==1)selected="selected" @endif >更新时间 新->旧</option>
    					<option value="2" @if($sequence==2)selected="selected" @endif >更新时间 旧->新</option>
                        <option value="3" @if($sequence==3)selected="selected" @endif >内容ID 大->小</option>
                        <option value="4" @if($sequence==4)selected="selected" @endif >内容ID 小->大</option>
                        <option value="5" @if($sequence==5)selected="selected" @endif >添加时间 新->旧</option>
                        <option value="6" @if($sequence==6)selected="selected" @endif >添加时间 旧->新</option>
                        <option value="7" @if($sequence==7)selected="selected" @endif >访问次数 多->少</option>
                        <option value="8" @if($sequence==8)selected="selected" @endif >访问次数 少->多</option>
                    </select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label form-label-small">状态：</label>
				<div class="layui-input-inline input-small">
					<select name="status" id="status"> 
                      	<option value="1" @if($status==1)selected="selected" @endif >已发布</option>
    					<option value="0" @if($status==0)selected="selected" @endif >未发布</option>
                    </select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">推荐位：</label>
				<div class="layui-input-inline input-small">
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
				<div class="layui-input-inline input-medium">
					<input name="search" type="text" id="search" class="layui-input" value="{{$search}}" />
				</div>
			</div>
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
	
      <div class="layui-row" style="margin-bottom: 20px;">
      <form  class="layui-form layui-col-md12" lay-filter="operate">
      	@if($contentAddPower)
		<button class="layui-btn" onclick="x_admin_show('{{ $category->name }} - 内容添加','/admin/content/add/{{ $category->id }}', 850)">添加内容</button>
		@endif
		@if($contentAuditPower)
		<button class="layui-btn audit" data-status="1">发布</button>
		<button class="layui-btn audit" data-status="0">草稿</button>
		@endif
		@if($contentDeletePower)
		<button class="layui-btn del">删除</button>
		@endif
		@if($contentMovePower)
		<div class="layui-inline">
			<div class="layui-input-inline">
				<select id="category_id">
                  <option value="0">======选择栏目======</option>
                  @foreach($categoryList as $value)
              	  <option value="{{ $value['id'] }}" @if($value['type']==1 || $value['category_model_id'] != $category->category_model_id)style="background-color:#ccc"  disabled="disabled" @endif>{!! $value['cname'] !!}</option>
                  {@endforeach
                </select>
			</div>
		</div>
		<button class="layui-btn" id="move">移动</button>
		@endif
		</form>
	</div>
	<table class="layui-table">
		<thead>
			<tr>
				<th width="20px"><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>
				<th width="40"><center>ID</center></th>
                <th width="">标题</th>
                <th width="40"><center>审核</center></th>
                <th width="50">访问量</th>
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
					<span>
                        <a href="//{{ config('system.siteurl') }}/content/{{ $data->urltitle }}" target="_blank">{{ $data->title }}</a>
                        @if (!empty($data->image))
                        <a href="javascript:void(0);" rel="{{ $data->image }}" class="class_pic">
                        <img align="AbsMiddle" src="/admin/images/ico/pic.png" width="14" height="14" alt="" /></a>
                        @endif
                    </span>
					@if (!empty($data->position))
						@foreach (explode(',', $data->position) as $value)
						<font color="red">[{{ $positionList[$value]['name'] }}]</font>
						@endforeach
					@endif
					@if ($contentQuickEditPower)
					<a class="layui-btn layui-btn-normal layui-btn-xs quickeditor" style=" display:none" onclick="x_admin_show('快速编辑','/admin/content/quickEdit/{{ $data->id }}', 850)">[快速编辑]</a>
					@endif
				</td>
				<td><center>@if($data->status==1)<font color=green><b>√</b></font>@else<font color=red><b>×</b></font>@endif</center>
                <td><a href="//">{{ $data->views }}</a></td>
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
//缩略图
$(".class_pic").powerFloat({
    targetMode: "ajax"
});
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

    $(".del").click(function(){
        var ids = '';
        var obj = '';
        if ($(this)[0].hasAttribute('data-id')) {
            ids = $(this).attr('data-id');
            obj = $(this);
        } else {
            var data = tableCheck.getData();
            if(data.length <= 0) {
                layer.msg('请选择要删除的内容');
                return false;
            }
            for(var i=0; i<data.length; i++) {
                if(i > 0) {
                    ids += ',';
                }
                ids += data[i];
            }
        }
        layer.confirm('确认要删除选中的内容吗？',function(index){
            $.ajax({
                type:'post',
                url:'/admin/content/delete',
                data:{ids:ids, _token:"{{ csrf_token() }}"},
                dataType: "json",
                success: function(data){
                    if(data.status == 10000) {
                        if (typeof obj === 'object') {
                            obj.parents('tr').remove();
                        } else {
                            $(".layui-form-checked").not('.header').parents('tr').remove();
                        }
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

    $("#move").click(function(){
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
        var categoryId = $("#category_id").val();
        if (categoryId === 0) {
            layer.msg('请选择栏目');
            return;
        }
        $.ajax({
            type:'post',
            url:'/admin/content/move',
            data:{ids:ids,category_id:categoryId,_token:"{{ csrf_token() }}"},
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
});
</script>
@endsection