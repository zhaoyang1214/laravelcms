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
           <label>欢迎登陆：admin [超级管理]</label>
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
          <li class="layui-nav-item to-index"><a href="/">前台首页</a></li>
        </ul>
        
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-home"></i>
                    <cite>首页管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="{{ url('admin/index/test') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>系统设置</cite>
                            
                        </a>
                    </li >
                    <li>
                        <a _href="{{ url('admin/index/test1') }}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>栏目模型</cite>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a _href="{{ url('admin/index/test2') }}">
                    <i class="layui-icon layui-icon-component"></i>
                    <cite>栏目管理</cite>
                </a>
            </li>
            <li>
                <a _href="">
                    <i class="layui-icon layui-icon-read"></i>
                    <cite>内容管理</cite>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-senior"></i>
                    <cite>扩展管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="order-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>扩展模型</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="order-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>自定义变量</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="order-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>内容替换</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="order-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>TAG管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="order-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>推荐位管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="order-list.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>附件管理</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-form"></i>
                    <cite>表单管理</cite>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-auz"></i>
                    <cite>系统管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="city.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理组管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="city.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="city.html">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>后台登录记录</cite>
                        </a>
                    </li >
                </ul>
            </li>
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
</html>