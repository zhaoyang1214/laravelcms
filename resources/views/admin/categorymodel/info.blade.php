@extends('admin.layouts.common')

@section('content')
<div class="x-body">
        <form class="layui-form">
          <div class="layui-form-item">
              <label for="name" class="layui-form-label">模型名称</label>
              <div class="layui-input-inline">
                  <input type="text" id="name" name="name" value="{{ $info->name }}" lay-verify="required" autocomplete="off" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="status" class="layui-form-label">状态</label>
              <div class="layui-input-inline">
                  <input type="checkbox" name="status" value="1" lay-skin="switch" lay-text="ON|OFF" @if($info->status) checked @endif>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="befrom" class="layui-form-label">内容来源<br/>(一行一个)</label>
              <div class="layui-input-inline">
                  <textarea name="befrom" class="layui-textarea">{{ $info->befrom }}</textarea>
              </div>
          </div>
          @csrf
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label"></label>
              @if($categorymodelEditPower)
              <input type="hidden" name="id" value="{{ $info->id }}" />
              <button  class="layui-btn" lay-filter="edit" lay-submit="">修改</button>
              @endif
          </div>
      </form>
    </div>
    <script>
        layui.use(['form'], function(){
          var form = layui.form
          var layer = layui.layer;
          //监听提交
          form.on('submit(edit)', function(data){
        	  var requestData = data.field;
              requestData.status = requestData.status ? 1 : 0;
            $.ajax({
    			type:'post',
    			url:'/admin/categorymodel/edit',
    			data:data.field,
    			dataType: "json",
    			success: function(data){
    				if(data.status == 10000) {
    					x_admin_close(true);
                    } else {
                   		layer.msg(data.message);
                    }
    			},
                error: function (XMLHttpResponse, textStatus, errorThrown) {
                	layer.msg('修改失败');
                }
    		});
        	layer.msg('正在修改 . . .', {shade:0.2});
        	return false;
          });
          
          
        });
    </script>
  </body>
@endsection