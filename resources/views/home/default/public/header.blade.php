<div class="wbox">
    <div class="header overflow">
        <div class="logo fl"><a href="/"><img src="home/{{config('system.theme')}}/img/logo.png" /></a></div>
        <div class="sou fr overflow">
            <div class="sou1 fl"><img src="home/{{config('system.theme')}}/img/x.png" /><a href="javascript:void(0);" onclick="AddFavorite('我的网站',location.href)">收藏本站</a></div>
            <div class="sou2 fr">
                <form class="sou3" name='form' method="get" action="/search">
                    <input type="text" name='keyword' value="" class="text1" />
                    <input type="image" src="home/{{config('system.theme')}}/img/sou.png" onclick="form.submit"/>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end-->

<!--导航-->
<div class="clear"></div>
<div class="topNav">
    <div class="topNav-width clearfix">
        <dl class="tnLeft">
            <dd><h3><a href="/">网站首页</a></h3></dd>
            @foreach($model->getModel('category')->getGroup(0, 1) as $category)
                @if($category['id'] == 1)
                    <dd>
                        <h3><a href="{{$category['url']}}">{{$category['name']}}</a></h3>
                        <ul>
                            @foreach($model->getModel('category')->getSons($category['id'], 1) as $cg)
                                <li><a href="{{$cg['url']}}">{{$cg['name']}}</a></li>
                            @endforeach
                        </ul>
                    </dd>
                @else
                    <dd><h3><a href="{{$category['url']}}">{{$category['name']}}</a></h3></dd>
                @endif
            @endforeach
        </dl>
    </div>
</div>
<script type="text/javascript">
    jQuery(".topNav").slide({
        type:"menu", //效果类型
        titCell:"dd", // 鼠标触发对象
        targetCell:"ul", // 效果对象，必须被titCell包含
        delayTime:0, // 效果时间
        defaultPlay:false,  //默认不执行
        returnDefault:true // 返回默认
    });
    function AddFavorite(title, url) {
        try {
            window.external.addFavorite(url, title);
        } catch (e) {
            try {
                window.sidebar.addPanel(title, url, "");
            } catch (e) {
                alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
            }
        }
    }
</script>