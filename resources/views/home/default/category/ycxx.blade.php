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
            <!-- Tab切换 S -->
            <div class="slideTxtBox slideTxtBox1">
                <div class="hd">
                    <ul>
                        @php($cList = $category->getSons($parentCategory['id'], 1))
                        @foreach($cList as $c)
                        <li><a href="{{$c['url']}}" @if($c['id'] == $category->id) style="color: #ce000c;border-bottom: 2px solid #ce000c;" @endif>{{$c['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="bd">
                    <ul class="tp00 overflow ">
                        @foreach($list as $content)
                        <li @if($loop->iteration % 3 == 0) class="last" @endif>
                            <div class="tp">
                                <a href="{{$content['url']}}">
                                    <img src="{{$content['image']}}" />
                                    <div class="txt">
                                        <h3>{{$content['title']}}</h3>
                                    </div>
                                </a>
                            </div>
                            @php($showTime = explode("\n", $content['show_time']))
                            @php($fares = explode("\n", $content['fares']))
                            <div class="tp1">
                                <h5>{{$showTime[0]}}</h5>
                                <div class="tp2">
                                    <span class="fl">票价：{{min($fares)}}@if(count($fares) > 1)-{{max($fares)}}@endif元</span>
                                    <a href="{{$content['booking']}}" class="fr">订票</a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Tab切换 E -->
            <!--分页-->
        {{ $list->links('home.default.public.page') }}
            <!--end-->
        </div>
        <!--左侧end-->

        <!--右侧-->
        <div class="about-right fr">
            @include('home.default.public.right-lanmu')
            @include('home.default.public.right-jydt', ['class' => 'mt25'])
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