@include('home.default.public.header')

<body>
<!--顶部-->
@include('home.default.public.nav')
<!--end-->

<!--banner-->
<div class="wbox index0">
    <!--图片-->
    <div id="iFocus" class="fl">
        <ul>
            @php ($list = $model->getModel('FormData')->getAllByTableName('index_banner'))
            @foreach($list as $data)
            <li><a href="{{$data->url}}" target="_blank"><img src="{{$data->pic}}" /></a></li>
            @endforeach
        </ul>
        <div class="btnBg"></div>
        <div class="btn">
            @foreach($list as $data)
            <span>{{$loop->iteration}}</span>
            @endforeach
        </div>
    </div>
    <script type="text/javascript">
        jQuery("#iFocus li a").hover(function(){ $(this).css("opacity",1).siblings().css("opacity",0.7) },function(){ $(this).css("opacity",1).siblings().css("opacity",1) });//鼠标移到图片上时聚焦效果
        jQuery("#iFocus").slide({ titCell:".btn span", mainCell:"ul",effect:"left", autoPlay:true});
    </script>
    <!--end-->
    <!--右侧内容-->
    <div class="index1 fl">
        <div class="weix">
            <dl>
                @php ($qrCode = $model->getModel('FormData')->getAllByTableName('qr_code'))
                <dt><img src="{{$qrCode[0]->url}}" /></dt>
                <dd>扫描官方二维码<br />了解更多演出信息</dd>
            </dl>
        </div>
        <div class="weix1">
            <ul>
                @foreach($model->getModel('content')->getListByCategoryId(10, 3, 1) as $v)
                <li>
                    <a class="text_overflow2" href="{{$v->url}}">{{$v->title}}</a>
                    <h5>{{date('Y-m-d', strtotime($v->update_time))}}</h5>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!--end-->
</div>
<!--end-->

<!--内容-->
<div class="clear"></div>
<div class="index2">
    <div class="index-left fl">
        <!-- Tab切换 S -->
        <div class="slideTxtBox">
            <div class="hd">
                <ul>
                    <li><a>热门演出</a></li>
                    <li><a>节目预告</a></li>
                    <li><a>节目单</a></li>
                </ul>
            </div>
            <div class="bd">
                <ul class="tp0 overflow">
                    @foreach($model->getModel('content')->getListByPositions(1, 6, [12, 13], true) as $content)
                    <li @if($loop->iteration % 3 == 0) class="last" @endif>
                        <div class="tp">
                            <a href="{{$content['url']}}">
                                <img src="{{$content['image']}}" />
                                <div class="txt">
                                    <h3>{{$content['title']}}</h3>
                                </div>
                            </a>
                        </div>
                        @php($expandData = $model->getModel('expandData')->setTableName('program')->getInfoCache('content_id', $content['id']))
                        @php($showTime = explode("\n", $expandData->show_time))
                        @php($fares = explode("\n", $expandData->fares))
                        <div class="tp1">
                            <h5>{{$showTime[0]}}</h5>
                            <div class="tp2">
                                <span class="fl">票价：{{min($fares)}}@if(count($fares) > 1)-{{max($fares)}}@endif元</span>
                                <a href="{{$expandData->booking}}" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="tp0 overflow">
                    @foreach($model->cacheGet($model->getModel('content')->getListQuery([12, 14, 15, 16], 2)->where('c.program_type', 2)) as $content)
                    <li @if($loop->iteration % 3 == 0) class="last" @endif>
                        <div class="tp">
                            <a href="{{$content->url}}">
                                <img src="{{$content->image}}" />
                                <div class="txt">
                                    <h3>{{$content->title}}</h3>
                                </div>
                            </a>
                        </div>
                        @php($showTime = explode("\n", $content->show_time))
                        @php($fares = explode("\n", $content->fares))
                        <div class="tp1">
                            <h5>{{$showTime[0]}}</h5>
                            <div class="tp2">
                                <span class="fl">票价：{{min($fares)}}@if(count($fares) > 1)-{{max($fares)}}@endif元</span>
                                <a href="{{$expandData->booking}}" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="tp0 overflow">
                    @foreach($model->cacheGet($model->getModel('content')->getListQuery([12, 14, 15, 16], 2)->where('c.program_type', 1)) as $content)
                        <li @if($loop->iteration % 3 == 0) class="last" @endif>
                            <div class="tp">
                                <a href="{{$content->url}}">
                                    <img src="{{$content->image}}" />
                                    <div class="txt">
                                        <h3>{{$content->title}}</h3>
                                    </div>
                                </a>
                            </div>
                            @php($showTime = explode("\n", $content->show_time))
                            @php($fares = explode("\n", $content->fares))
                            <div class="tp1">
                                <h5>{{$showTime[0]}}</h5>
                                <div class="tp2">
                                    <span class="fl">票价：{{min($fares)}}@if(count($fares) > 1)-{{max($fares)}}@endif元</span>
                                    <a href="{{$expandData->booking}}" class="fr">订票</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <script type="text/javascript">jQuery(".slideTxtBox").slide();</script>
        <!-- Tab切换 E -->
    </div>
    <!--右侧-->
    <div class="index-right fr">
        @include('home.default.public.right-jydt')
        @include('home.default.public.right-swhz')
    </div>
    <!--end-->
</div>
<!--end-->
<!--底部-->
@include('home.default.public.footer')
<!--end-->

</body>
</html>
