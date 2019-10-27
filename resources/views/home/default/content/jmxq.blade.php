@include('home.default.public.header')

<body>
<!--顶部-->
@include('home.default.public.nav')
<!--end-->

<div class="wbox" style="background:#fff;margin-top:15px;">
    <div class="jiemu overflow">
        <div class="jiemu-left">
            <img src="{{$content->image}}" width="221" height="294" />
        </div>
        <div class="jiemu-right">
            <h3>{{$content->title}}</h3>
            @php($showTime = explode("\n", $expandData->show_time))
            @php($fares = explode("\n", $expandData->fares))
            @php(sort($fares))
            <div class="jiemu1">
                @foreach($showTime as $value)
                <span>{{$value}}</span>
                @endforeach
            </div>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table">
                <tr>
                    <td width="40%"><em>地点：</em>{{$expandData->address}}  </td>
                    <td><em>票价：</em>
                        @foreach($fares as $value)
                        <span>{{$value}}元</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td><em>演出团体：</em>{{$expandData->performance_groups}} </td>
                    <td><em>演出类型：</em>{{$expandData->performance_type}}</td>
                </tr>
                <tr>
                    <td><em>说明：</em>{{$expandData->inportant}}</td>
                </tr>
            </table>
            <div class="tp5"><a href="{{$expandData->booking}}">订票</a></div>
        </div>
    </div>
</div>


<!--内容-->
<div class="clear"></div>
<div class="index2">
    <div class="about">
        <!--左侧内容-->
        <div class="index-left1 fl mt25">
            <div class="jiemu2">
                <h3>节目介绍</h3>
                {!! $content->content !!}
            </div>
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
