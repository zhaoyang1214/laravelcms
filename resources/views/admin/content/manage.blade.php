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
    <link href="/lib/ztree/css/zTreeStyle.css" rel="stylesheet" type="text/css" />
    <script src="/lib/ztree/jquery.ztree.js"></script>
    <script src="/lib/ztree/jquery.ztree.exhide.js"></script>
    <script src="/lib/ztree/jquery.ztree.excheck.js"></script>
    <style type="text/css">
        .layui-side {
	        background-color: #eef1f8;
        	width: 160px;
        }
        
        #main_right {
        	position: absolute;
            left: 160px;
            right: 0;
            top: 0px;
            bottom: 0px;
            _height: 100%;
            overflow: auto;
        	border-left: 1px solid #c1d1dc;
        }
        #main {
    	    width: 100%;
            height: 100%;
            overflow: auto;
            overflow-x: hidden;
            border: none;
        	display: block;
        }
        .menu li {
            line-height: 25px;
        	margin: 0;
            padding: 0;
            list-style: none;
        }
        .menu li a {
            padding-left: 40px;
            width: 140px;
            display: block;
            color: #5b617d;
            background-image: url(/admin/images/nav_line.gif);
            background-repeat: no-repeat;
            background-position: 25px center;
        }
        .menu li .selected {
            background-color: #E6ECF2;
        }
        a, a:hover {
            text-decoration: none;
        }
    </style>
  </head>

<body>
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="layui-side">
      <div class="layui-side-scroll">
          <ul class="load menu">
          	@foreach($authList as $auth)
        	<li><a href="/admin/{{ $auth['controller'] }}/{{ $auth['action'] }}" @if($loop->first)class="selected"@endif target="main">{{ $auth['name'] }}</a></li>
        	@endforeach
        </ul>
        <ul id="tree" class="ztree"></ul>
      </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div id="main_right">
      <iframe id="main" name="main" src="/admin/{{$authList[0]['controller']}}/{{$authList[0]['action']}}" frameborder="0"></iframe>
    </div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
<script>
var zTree;
var setting = {
    view: {
        showLine: true,
        selectedMulti: false
    },
    data: {
        simpleData: {
            enable: true,
            idKey: "id",
            pIdKey: "pid",
            rootPId: ""
        }
    },
	callback: {
		onClick: onClick
	}
};
var zNodes = {!! $categoryList !!};

function onClick(e,treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj("tree");
	if(treeNode.url==null){
		zTree.expandNode(treeNode);
	}
	
}
$(document).ready(function() {
    var t = $("#tree");
    t = $.fn.zTree.init(t, setting, zNodes);
});
</script>   
</body>
</html>