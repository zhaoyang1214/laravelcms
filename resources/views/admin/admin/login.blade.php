<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台登录</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/xadmin.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/layui/layui.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('admin/js/xadmin.js') }}"></script>

</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" >
        	@csrf
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              form.on('submit(login)', function(data){
            	  $.ajax({
            			type:'post',
            			url:'/admin/admin/login',
            			data:data.field,
            			dataType: "json",
            			success: function(data){
            				if(data.status == 10000) {
                            	top.location.href='/admin/index/index';
                            } else {
                           		layer.msg(data.message);
                            }
            			},
                        error: function (XMLHttpResponse, textStatus, errorThrown) {
                        	layer.msg('登录失败');
                        }
            		});
                	layer.msg('正在登陆 . . .', {shade:0.2});
                	return false;
              });
            });
        });
    </script>
   
</body>
</html>