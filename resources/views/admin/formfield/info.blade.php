@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		<div class="layui-form-item">
			<label for="name" class="layui-form-label form-label-large">字段描述</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="name" name="name" value="@isset($info){{ $info->name }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="field" class="layui-form-label form-label-large">字段名</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="field" name="field" value="@isset($info){{ $info->field }}@endisset" lay-verify="required" autocomplete="off" class="layui-input @if($action == 'edit')layui-disabled layui-bg-gray @endif" @if($action == 'edit')disabled  @endif>
			</div>
			<div class="layui-form-mid layui-word-aux">只能为2-50位字母和下划线（_）</div>
		</div>
		<div class="layui-form-item">
			<label for="type" class="layui-form-label form-label-large">字段类型</label>
			<div class="layui-input-inline input-large">
				<select name="type" id="type" lay-filter="type">
					@foreach($typeProperty as $key => $value)
					<option value="{{ $key }}" @if(isset($info) && $info->type==$key)selected @endif>{{ $value['text'] }}</option>
					@endforeach
				</select>
			</div>
			<div class="layui-form-mid layui-word-aux" id="type-msg"></div>
		</div>
		<div class="layui-form-item">
			<label for="property" class="layui-form-label form-label-large">字段属性</label>
			<div class="layui-input-inline input-large">
				<select name="property" id="property" lay-filter="property">
					@php
					$type = isset($info) ? $info->type : 1;
					@endphp
					@foreach($typeProperty[$type]['property'] as $key => $value)
					<option value="{{ $key }}" @if(isset($info) && $info->property==$key)selected @endif>{{ $value }}</option>
					@endforeach
				</select>
			</div>
			<div class="layui-form-mid layui-word-aux" id="property-msg"></div>
		</div>
		<div class="layui-form-item">
			<label for="len" class="layui-form-label form-label-large">字段长度</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="len" name="len" value="@isset($info){{ $info->len }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux" id="len-msg"></div>
		</div>
		<div class="layui-form-item">
			<label for="decimal" class="layui-form-label form-label-large">小数点位数</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="decimal" name="decimal" value="@isset($info){{ $info->decimal }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux" id="decimal-msg"></div>
		</div>
		<div class="layui-form-item">
			<label for="default" class="layui-form-label form-label-large">默认内容</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="default" name="default" value="@isset($info){{ $info->default }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux" id="default-msg"></div>
		</div>
		<div class="layui-form-item">
			<label for="tip" class="layui-form-label form-label-large">字段提示</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="tip" name="tip" value="@isset($info){{ $info->tip }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux" id="tip-msg"></div>
		</div>
		<div class="layui-form-item">
			<label for="sequence" class="layui-form-label form-label-large">字段顺序</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="sequence" name="sequence" value="@isset($info){{ $info->sequence }}@else{{ '0' }}@endisset" lay-verify="required" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">数字越小越靠前</div>
		</div>
		<div class="layui-form-item">
			<label for="regex" class="layui-form-label form-label-large">验证规则</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="regex" name="regex" value="@isset($info){{ $info->regex }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">正则表达式，例如验证手机号：/^1[3-9]\d{9}$/</div>
		</div>
		<div class="layui-form-item">
			<label for="is_unique" class="layui-form-label form-label-large">是否唯一</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="is_unique" lay-filter="is_unique" value="1" title="是" @if(isset($info) && $info->is_unique == 1)checked @endif>
      			<input type="radio" name="is_unique" lay-filter="is_unique" value="0" title="否"  @if(!isset($info) || $info->is_unique == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux">不允许有重复数据，会添加唯一索引</div>
		</div>
		<div class="layui-form-item">
			<label for="is_must" class="layui-form-label form-label-large">是否必填</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="is_must" lay-filter="is_must" value="1" title="是" @if(isset($info) && $info->is_must == 1)checked @endif>
      			<input type="radio" name="is_must" lay-filter="is_must" value="0" title="否"  @if(!isset($info) || $info->is_must == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="is_index" class="layui-form-label form-label-large">添加普通索引</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="is_index" lay-filter="is_index" value="1" title="是" @if(isset($info) && $info->is_index == 1)checked @endif>
      			<input type="radio" name="is_index" lay-filter="is_index" value="0" title="否"  @if(!isset($info) || $info->is_index == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="admin_display" class="layui-form-label form-label-large">后台列表显示</label>
			<div class="layui-input-inline input-large">
				<input type="radio" name="admin_display" lay-filter="admin_display" value="1" title="是" @if(isset($info) && $info->admin_display == 1)checked @endif>
      			<input type="radio" name="admin_display" lay-filter="admin_display" value="0" title="否"  @if(!isset($info) || $info->admin_display == 0)checked @endif>
			</div>
			<div class="layui-form-mid layui-word-aux"></div>
		</div>
		<div class="layui-form-item">
			<label for="admin_display_len" class="layui-form-label form-label-large">后台列表显示长度</label>
			<div class="layui-input-inline input-large">
				<input type="text" id="admin_display_len" name="admin_display_len" value="@isset($info){{ $info->admin_display_len }}@else{{ 0 }}@endisset" autocomplete="off" class="layui-input">
			</div>
			<div class="layui-form-mid layui-word-aux">仅针对varchar和text，为0则不限制长度</div>
		</div>
		<div class="layui-form-item">
			<label for="config" class="layui-form-label form-label-large">字段配置</label>
			<div class="layui-input-inline input-large">
				<textarea id="config" name="config" class="layui-textarea">@isset($info){{ $info->config }}@endif</textarea>
			</div>
			<div class="layui-form-mid layui-word-aux" id="config-msg"></div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label form-label-large"></label>
			@if($actionPower) 
				@csrf
				<input type="hidden" name="form_id" value="{{ $formId }}" /> 
				@if(isset($info)) 
				<input type="hidden" name="id" value="{{ $info->id }}" /> 
				@endif
				<button class="layui-btn" lay-filter="submit" lay-submit="">{{ $actionName }}</button>
			@endif
		</div>
	</form>
</div>
<script>
		var typeProperty = @json($typeProperty);
		function setPropertyOption(form) {
			var typeObj = $("#type");
			var type = typeObj.val();
			var propertyList = typeProperty[type]['property'];
			var propertyOptions = '';
			for (i in propertyList) {
    			var selected = type==3 && i==3 ? 'selected="selected"' : '';
				propertyOptions += '<option value="' + i + '" ' + selected + '>' + propertyList[i] + '</option>';
			}
			$("#property").empty().append(propertyOptions); 
			form.render();
		}

		function setOther(reSetValue = false) {
			var type = $("#type").val();
			var property = $("#property").val();
			
			$("#property-msg").html('');
			$("#len").removeClass('layui-bg-gray');
			$("#len").attr('readonly', false);
			$("#len-msg").html('');
			$("#decimal").removeClass('layui-bg-gray');
			$("#decimal").attr('readonly', false);
			$("#decimal-msg").html('');
			$("#default").removeClass('layui-bg-gray');
			$("#default").attr('readonly', false);
			$("#default-msg").html('');
			$("#config").removeClass('layui-bg-gray');
			$("#config").attr('readonly', false);
			$("#config-msg").html('');
			
			switch(type) {
				case '1':
					switch(property) {
						case '1':
							$("#property-msg").html('字符串');
							$("#len-msg").html('1 - 21844');
							$("#decimal").addClass('layui-bg-gray');
							$("#decimal").attr('readonly', true);
							$("#config").addClass('layui-bg-gray');
							$("#config").attr('readonly', true);
							if(reSetValue) {
								$("#len").val(250);
								$("#decimal").val(0);
								$("#config").val('');
							}
							break;
						case '2':
							$("#property-msg").html('整型（-2147483648 到 2147483647）');
							$("#len-msg").html('1 - 11');
							$("#decimal").addClass('layui-bg-gray');
							$("#decimal").attr('readonly', true);
							$("#default-msg").html('默认值只能为整数，允许为空');
							$("#config").addClass('layui-bg-gray');
							$("#config").attr('readonly', true);
							if(reSetValue) {
								$("#len").val(11);
								$("#decimal").val(0);
								$("#config").val('');
							}
							break;
						case '4':
							$("#property-msg").html('日期（xxxx-xx-xx xx:xx:xx）');
							$("#len").addClass('layui-bg-gray');
							$("#len").attr('readonly', true);
							$("#decimal").addClass('layui-bg-gray');
							$("#decimal").attr('readonly', true);
							$("#default-msg").html('默认值只能设置为 xxxx-xx-xx xx:xx:xx 格式，允许为空');
							$("#config-msg").html('配置后台显示格式和时间选择器格式(json)，默认：<br/>{"php":"Y-m-d H:i:s","js":"yyyy-MM-dd HH:mm:ss"}');
							if(reSetValue) {
								$("#len").val(0);
								$("#decimal").val(0);
								$("#config").val('{"php":"Y-m-d H:i:s","js":"yyyy-MM-dd HH:mm:ss"}');
							}
							break;
						case '5':
							$("#property-msg").html('定点小数（M，D）');
							$("#len-msg").html('整数部分（M）：1 - 65（默认 10）');
							$("#decimal-msg").html('小数部分（D）:1 - 30（默认 0）');
							$("#default-msg").html('默认值只能设为整数或小数，允许为空');
							$("#config").addClass('layui-bg-gray');
							$("#config").attr('readonly', true);
							if(reSetValue) {
								$("#len").val(10);
								$("#decimal").val(0);
								$("#config").val('');
							}
							break;
					}
					break;
				case '2':
				case '3':
					switch(property) {
    					case '1':
    						$("#property-msg").html('字符串');
    						$("#len-msg").html('1 - 21844');
    						$("#decimal").addClass('layui-bg-gray');
    						$("#decimal").attr('readonly', true);
    						$("#config").addClass('layui-bg-gray');
    						$("#config").attr('readonly', true);
    						if(reSetValue) {
    							$("#len").val(20480);
    							$("#decimal").val(0);
    							$("#config").val('');
    						}
    						break;
    					case '3':
    						$("#property-msg").html('文本（65,535 bytes）');
    						$("#len").addClass('layui-bg-gray');
    						$("#len").attr('readonly', true);
    						$("#decimal").addClass('layui-bg-gray');
    						$("#decimal").attr('readonly', true);
    						$("#default").addClass('layui-bg-gray');
    						$("#default").attr('readonly', true);
    						$("#config").addClass('layui-bg-gray');
    						$("#config").attr('readonly', true);
    						if(reSetValue) {
    							$("#len").val(0);
    							$("#decimal").val(0);
    							$("#config").val('');
    						}
    						break;
    				}
					break;
				case '4':
				case '5':
					switch(property) {
    					case '1':
    						$("#property-msg").html('字符串');
    						$("#len-msg").html('1 - 21844');
    						$("#decimal").addClass('layui-bg-gray');
    						$("#decimal").attr('readonly', true);
    						$("#config").addClass('layui-bg-gray');
    						$("#config").attr('readonly', true);
    						if(reSetValue) {
    							$("#len").val(250);
    							$("#decimal").val(0);
    							$("#config").val('');
    						}
    						break;
    				}
					break;
				case '6':
					switch(property) {
    					case '1':
    						$("#property-msg").html('字符串');
    						$("#len-msg").html('1 - 21844，每张图片（加截图）建议长度为200-250');
    						$("#decimal").addClass('layui-bg-gray');
    						$("#decimal").attr('readonly', true);
    						$("#config").addClass('layui-bg-gray');
    						$("#config").attr('readonly', true);
    						if(reSetValue) {
    							$("#len").val(2500);
    							$("#decimal").val(0);
    							$("#config").val('');
    						}
    						break;
    					case '3':
    						$("#property-msg").html('文本（65,535 bytes）');
    						$("#len").addClass('layui-bg-gray');
    						$("#len").attr('readonly', true);
    						$("#decimal").addClass('layui-bg-gray');
    						$("#decimal").attr('readonly', true);
    						$("#default").addClass('layui-bg-gray');
    						$("#default").attr('readonly', true);
    						$("#config").addClass('layui-bg-gray');
    						$("#config").attr('readonly', true);
    						if(reSetValue) {
    							$("#len").val(0);
    							$("#decimal").val(0);
    							$("#config").val('');
    						}
    						break;
    				}
					break;
				case '7':
				case '8':
					switch(property) {
    					case '1':
    						$("#property-msg").html('字符串');
    						$("#len-msg").html('1 - 21844');
    						$("#decimal").addClass('layui-bg-gray');
    						$("#decimal").attr('readonly', true);
    						$("#config-msg").html('需要配置选项参数，格式如下（json）:<br>{"female":"女","male":"男"}');
    						if(reSetValue) {
    							$("#len").val(250);
    							$("#decimal").val(0);
    							$("#config").val('');
    						}
    						break;
    					case '2':
    						$("#property-msg").html('整型（-2147483648 到 2147483647）');
    						$("#len-msg").html('1 - 11');
    						$("#decimal").addClass('layui-bg-gray');
    						$("#decimal").attr('readonly', true);
    						$("#default-msg").html('默认值只能为整数，允许为空');
    						$("#config-msg").html('需要配置选项参数，格式如下（json）:<br>{"0":"女","1":"男"}');
    						if(reSetValue) {
    							$("#len").val(11);
    							$("#decimal").val(0);
    							$("#config").val('');
    						}
    						break;
    					}
					break;
				case '9':
					switch(property) {
    					case '1':
    						$("#property-msg").html('字符串');
    						$("#len-msg").html('1 - 21844');
    						$("#decimal").addClass('layui-bg-gray');
    						$("#decimal").attr('readonly', true);
    						$("#default-msg").html('多个默认值请用英文逗号分开，例如（1,2,3）');
    						$("#config-msg").html('需要配置选项参数，格式如下（json）:<br>{"1":"写作","2":"阅读","3":"游戏"}<br>或{"write":"写作","read":"阅读","game":"游戏"}');
    						if(reSetValue) {
    							$("#len").val(250);
    							$("#decimal").val(0);
    							$("#config").val('');
    						}
    						break;
    				}
					break;
			}
		}

		function isUniqueChange(form) {
			var isUnique = $("input[name='is_unique']:checked").val();
			console.log(isUnique);
			if(isUnique == 1) {
				$("input[name='is_must'][value=1]").attr('checked',true);
				$("input[name='is_must']").attr("disabled", true);
				$("input[name='is_index'][value=0]").attr('checked',true);
				$("input[name='is_index']").attr("disabled", true);
			} else {
				$("input[name='is_must']").attr("disabled", false);
				$("input[name='is_index']").attr("disabled", false);
			}
			form.render();
		}
		
        layui.use(['form'], function(){
          	var form = layui.form
          	var layer = layui.layer;

          	setOther(@if($action=='add')true @else false @endif);
          	isUniqueChange(form);
          	form.on('select(type)', function(data){
          		setPropertyOption(form);
          		setOther(true);
            });

          	form.on('select(property)', function(data){
          		setOther(true);
            });
          	
          	form.on('radio(is_unique)', function(data){
          		isUniqueChange(form);
       		});
          //监听提交
          form.on('submit(submit)', function(data){
        	  var requestData = data.field;
        	  @if($action == 'edit')
              delete requestData.field;
              @endif
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
    </script>
</body>
@endsection
