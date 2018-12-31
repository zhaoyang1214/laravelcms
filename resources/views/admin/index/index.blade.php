<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台管理系统</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/xadmin.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/lib/layui/layui.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('admin/js/xadmin.js') }}"></script>

</head>
<body>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="">LaravelCMS</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
           <label>欢迎登陆：{{ $adminInfo['nickname'] }} [{{ $adminInfo['username'] }}]</label>
          </li>
          <li class="layui-nav-item">
           <a href="javascript:loginOut();">退出</a>
          </li>
          <li class="layui-nav-item">
            <a href="javascript:;">清除缓存</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a href="javascript:clearCache('0');">清除所有缓存</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item to-index"><a href="/" target="_blank">前台首页</a></li>
        </ul>
        
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
        	@foreach ($authList as $auth)
        	@if (empty($auth['controller']))
        	<li>
                <a href="javascript:;">
                    <i class="layui-icon {{ $auth['icon'] }}"></i>
                    <cite>{{ $auth['name'] }}</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                	@foreach ($auth['childs'] as $child)
                    <li>
                        <a _href="admin/{{ $child['controller'] }}/{{ $child['action'] }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>{{ $child['name'] }}</cite>
                            
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @else
        	<li>
                <a _href="admin/">
                    <i class="layui-icon {{ $auth['icon'] }}"></i>
                    <cite>{{ $auth['name'] }}</cite>
                </a>
            </li>
            @endif
        	@endforeach
        </ul>
      </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home layui-this"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src="{{ url('admin/index/home') }}" frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
</body>
<script type="text/javascript">
function loginOut(){
	layer.confirm('是否确定退出?', {icon: 3, title:'退出确认', maxWidth:200}, function(index) {
		window.location.href="{{ url('admin/admin/loginOut') }}";
		layer.close(index);
		layer.msg('正在退出 . . .', {shade:0.2});
	}); 
}
</script>
</html>