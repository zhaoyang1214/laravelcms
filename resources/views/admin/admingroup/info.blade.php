@extends('admin.layouts.common')

@section('head')
<link href="/lib/ztree/css/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/lib/ztree/jquery.ztree.js"></script>
<script src="/lib/ztree/jquery.ztree.exhide.js"></script>
<script src="/lib/ztree/jquery.ztree.excheck.js"></script>
@endsection

@section('content')
<div class="x-body">
        <form class="layui-form">
		<div class="layui-tab layui-tab-brief">
			<ul class="layui-tab-title">
				<li class="layui-this">基本信息</li>
				<li id="akeep4" @if(isset($info) && $info->keep & 4)style="display: none;" @endif>功能操作权限</li>
				<li id="akeep2" @if(isset($info) && $info->keep & 2)style="display: none;" @endif>栏目操作权限</li>
				<li id="akeep1" @if(isset($info) && $info->keep & 1)style="display: none;" @endif>多功能表单权限</li>
			</ul>
			<div class="layui-tab-content">
				<div class="layui-tab-item layui-show">
					<div class="layui-form-item">
						<label for="name" class="layui-form-label form-label-large">管理组名称</label>
						<div class="layui-input-inline">
							<input type="text" id="name" name="name" value="@if(isset($info)){{ $info->name }} @endif" maxlength="50" lay-verify="required" autocomplete="off" class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label for="name" class="layui-form-label form-label-large">管理等级</label>
						<div class="layui-input-inline">
							<input type="text" id="grade" name="grade" value="@if(isset($info)){{ $info->grade }} @endif" maxlength="2" placeholder="请填写 {{ $adminGroupInfo['grade'] + 1 }} - 99 之间的整数" lay-verify="number" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-form-mid layui-word-aux">请填写 {{ $adminGroupInfo['grade'] + 1 }} - 99 之间的整数</div>
					</div>
					<div class="layui-form-item">
                        <label class="layui-form-label form-label-large">无需校验的权限</label>
                        <div class="layui-input-inline input-xlarge2">
                          @if($adminGroupInfo['keep'] & 4)
                          <input type="checkbox" name="keep[]" value="4" class="keep" title="功能操作" lay-filter="keep" @if(isset($info) && $info->keep & 4)checked @endif>
                          @endif
                          @if($adminGroupInfo['keep'] & 2)
                          <input type="checkbox" name="keep[]" value="2" class="keep" title="栏目操作" lay-filter="keep" @if(isset($info) && $info->keep & 2)checked @endif>
                          @endif
                          @if($adminGroupInfo['keep'] & 1)
                          <input type="checkbox" name="keep[]" value="1" class="keep" title="多功能表单" lay-filter="keep" @if(isset($info) && $info->keep & 1)checked @endif>
                          @endif
                        </div>
                        <div class="layui-form-mid layui-word-aux input-large">若不选择，系统会根据“功能操作权限”、“栏目操作权限”、“多功能表单操作权限”所勾选的权限进行访问限制</div>
                    </div>
				</div>
				<div class="layui-tab-item">
					<div class="layui-form-item">
                        <label class="layui-form-label form-label-large">功能操作权限</label>
                        <div class="layui-input-inline input-xlarge2">
                          <ul id="adminAuthTree" class="ztree"></ul>
                        </div>
                    </div>
				</div>
				<div class="layui-tab-item">
					<div class="layui-form-item">
                        <label class="layui-form-label form-label-large">栏目操作权限</label>
                        <div class="layui-input-inline input-xlarge2">
                          <ul id="cateGoryTree" class="ztree"></ul>
                        </div>
                    </div>
				</div>
				<div class="layui-tab-item">
					<div class="layui-form-item">
                        <label class="layui-form-label form-label-large">多功能表单权限</label>
                        <div class="layui-input-inline input-xlarge2">
                          <ul id="formTree" class="ztree"></ul>
                        </div>
                    </div>
				</div>
			</div>
		</div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label"></label>
              @if($actionPower)
              @csrf
              @if(isset($info))
              <input type="hidden" name="id" value="{{ $info->id }}" />
              @endif
              <button  class="layui-btn" lay-filter="submit" lay-submit="">{{ $actionName }}</button>
              @endif
          </div>
	</form>
    </div>
    <script>
    layui.use(["form", "jquery"], function() {
    	var form = layui.form;
    	var $ = layui.jquery;
    	var layer = layui.layer;

    	form.on('checkbox(keep)', function(data){
        	var obj = $('#akeep' + data.value);
        	if(data.elem.checked) {
        		obj.hide();
           	} else {
           		obj.show();
            }
    	});

        form.on('submit(submit)', function(data){
    		var adminAuthCheckedNodes = $.fn.zTree.getZTreeObj("adminAuthTree").getCheckedNodes(true);
    		var adminAuthIds = "";
    		for (var i = 0; i < adminAuthCheckedNodes.length; i++) {
    			adminAuthIds += (i>0 ? ',' : '') + adminAuthCheckedNodes[i].id;
    	    }
    		// console.log(adminAuthIds);
            
    		var cateGoryCheckedNodes = $.fn.zTree.getZTreeObj("cateGoryTree").getCheckedNodes(true);
    		var categoryIds = "";
    		for (var i = 0; i < cateGoryCheckedNodes.length; i++) {
    			categoryIds += (i>0 ? ',' : '') + cateGoryCheckedNodes[i].id;
    	    }
    		// console.log(categoryIds);
    		
    		var formCheckedNodes = $.fn.zTree.getZTreeObj("formTree").getCheckedNodes(true);
    		var formIds = "";
    		for (var i = 0; i < formCheckedNodes.length; i++) {
    			formIds += (i>0 ? ',' : '') + formCheckedNodes[i].id;
    	    }
    		// console.log(formIds);

    		var requestData = data.field;
    		requestData.admin_auth_ids = adminAuthIds;
    		requestData.category_ids = categoryIds;
    		requestData.form_ids = formIds;
    		var keep=0;
            $(".keep").each(function () {
                if ($(this).is(":checked")) {
                	keep = keep|$(this).val();
                }
            });
      	    console.log(keep);
        	requestData.keep = keep;
      	    console.log(requestData);
            $.ajax({
  				type:'post',
      			url:'{{ $actionUrl }}',
      			data:requestData,
      			dataType: "json",
      			success: function(data){
      				if(data.status == 10000) {
      					x_admin_close(true);
                    } else {
                     	layer.msg(data.message);
                    }
      			},
                error: function (XMLHttpResponse, textStatus, errorThrown) {
                  	layer.msg('{{ $actionName }}失败');
                }
      		});
          	layer.msg('正在{{ $actionName }} . . .', {shade:0.2});
          	return false;
    		
      	  
        });
    });

    var cateGorySetting = {
    	    view: {
    			nameIsHTML: true
    	    },
    		check: {
    	            enable: true
    	    },
    	    data: {
    			key: {
    				title:"name"
    			},
    	        simpleData: {
    	            enable: true,
    	            idKey: "id",
    	            pIdKey: "pid",
    	            rootPId: 0
    	        }
    	    }
    	};
    	var cateGoryNodes = {!! $cateGoryTree !!};

    	var formSetting = {
    	    view: {
    			nameIsHTML: true
    	    },
    		check: {
    	            enable: true
    	    },
    	    data: {
    			key: {
    				title:"name"
    			},
    			
    	        simpleData: {
    	            enable: true,
    	            idKey: "id",
    	            pIdKey: "",
    	            rootPId: ""
    	        }
    	    }
    	};
    	var formNodes = {!! $formTree !!};


    	var adminAuthSetting = {
    	    view: {
    			nameIsHTML: true
    	    },
    		check: {
    	            enable: true
    	    },
    	    data: {
    			key: {
    				title:"note"
    			},
    			
    	        simpleData: {
    	            enable: true,
    	            idKey: "id",
    	            pIdKey: "pid",
    	            rootPId: 0
    	        }
    	    }
    	};
    	var adminAuthNodes = {!! $adminAuthTree !!};

    	$(document).ready(function() {
    	    $.fn.zTree.init($("#cateGoryTree"), cateGorySetting, cateGoryNodes);
    	    $.fn.zTree.init($("#formTree"), formSetting, formNodes);
    	    $.fn.zTree.init($("#adminAuthTree"), adminAuthSetting, adminAuthNodes);
    	});
        /* layui.use(['form'], function(){
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
          
          
        }); */
    </script>
  </body>
@endsection