<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>laravel后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/xadmin.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/layui/layui.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('admin/js/xadmin.js') }}"></script>
    @yield('head')
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    @yield('content')
    <div class="layui-footer">当前脚本运行时间： {{ round(microtime(true) - LARAVEL_START, 4) }} 秒</div>
  </body>
  
</html>