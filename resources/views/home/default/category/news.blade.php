@include('home.default.public.header')
<body>
<!--顶部-->
@include('home.default.public.nav')
<!--end-->

<!--内容-->
<div class="clear"></div>
<div class="index2">
    <div class="about">
        <!--左侧内容-->
        <div class="index-left1 fl mt25">
            <div class="news">
                @foreach($list as $content)
                <dl class="overflow">
                    <dt><img src="{{$content['image']}}" /></dt>
                    <dd>
                        <h3><a href="{{$content['url']}}">{{$content['title']}}</a></h3>
                        <span>{{date('Y-m-d', strtotime($content['update_time']))}}</span>
                        <p class="text_overflow3">{{$content['description']}}</p>
                        <a href="{{$content['url']}}" class="a1"><img src="/home/default/img/j3.png" />&nbsp;更多</a>
                    </dd>
                </dl>
                @endforeach
            </div>
            {{ $list->links('home.default.public.page') }}
        </div>
        <!--左侧end-->

        <!--右侧-->
        <div class="about-right fr">
            @include('home.default.public.right-lanmu')
            @include('home.default.public.right-rmyc')
            @include('home.default.public.right-swhz')
        </div>
        <!--end-->
    </div>

</div>
<!--end-->

<!--底部-->
@include('home.default.public.footer')
<!--end-->

</body>
</html>
