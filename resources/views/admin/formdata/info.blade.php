@extends('admin.layouts.common') 

@section('content')
<div class="x-body">
	<form class="layui-form">
		@foreach($formFieldList as $formField)
			{!! $formField->getFieldHtml($formData ?? null) !!}
		@endforeach
		<div class="layui-form-item">
			<label class="layui-form-label form-label-large"></label>
			@if($actionPower) 
				@csrf
				<input type="hidden" name="form_id" value="@if(isset($formId)){{ $formId }}@elseif(isset($formData)){{ $formData->form_id }}@endif" /> 
				@if(isset($formData)) 
				<input type="hidden" name="id" value="{{ $formData->id }}" /> 
				@endif
				<button class="layui-btn" lay-filter="submit" lay-submit="">{{ $actionName }}</button>
			@endif
		</div>
	</form>
</div>
<script>
        layui.use(['form', 'layer', 'laydate'], function(){
          	var form = layui.form
          	var layer = layui.layer;
         	

          //监听提交
          form.on('submit(submit)', function(data){
        	  var requestData = data.field;
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
