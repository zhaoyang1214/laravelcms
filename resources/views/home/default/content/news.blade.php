@include('home.default.public.header')

<body>
<!--顶部-->
@include('home.default.public.nav')
<!--end-->

<!--内容-->
<div class="clear"></div>
<div class="index2 overflow">
    <div class="about">
        <!--左侧内容-->
        <div class="index-left1 fl mt25">
            <div class="news1">
                <h3>{{$content->title}}</h3>
                <em>来源：{{$content->copyfrom}} &nbsp;&nbsp;&nbsp;刊发时间：{{date('Y-m-d', strtotime($content->update_time))}}</em>
                {!! $content->content !!}
            </div>
            @if(trim($paginator->links('home.default.public.page')))
            <div style="height: 80px;">{{ $paginator->links('home.default.public.page') }}</div>
            @endif
            <div class="page">
                @if($prevContent)
                <a href="{{$prevContent->url}}">上一篇：{{$prevContent->title}}</a>
                @else
                <a>上一篇：无</a>
                @endif
                @if($nextContent)
                <a href="{{$nextContent->url}}">下一篇：{{$nextContent->title}}</a>
                @else
                <a>下一篇：无</a>
                @endif
            </div>
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
<div class="clear"></div>
@include('home.default.public.footer')
<!--end-->

</body>
</html>
