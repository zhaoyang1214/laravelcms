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
            @foreach($list as $content)
            <div class="zhao">
                <div class="join">
                    <dl>
                        <dt></dt>
                        <dd>
                            <h3>{{$content['title']}}</h3>
                            <p>{{$content['subtitle']}}</p>
                            <span>发布时间：{{date('Y-m-d', strtotime($content['input_time']))}}</span>
                        </dd>
                    </dl>
                </div>
                @php($expandData = $model->getModel('expandData')->setTableName('join_us')->getInfoCache('content_id', $content['id']))
                <div class="join1 ac mt25">
                    <span class="em1">{{$expandData->salary}}</span> / <span>{{$expandData->address}}</span> / <span>经验：{{$expandData->experience}}</span> / <span> {{$expandData->profession}}</span> / <span>{{$expandData->position_type}}</span>
                </div>
                @php ($contentData = $model->getModel('contentData')::getInfoCache('content_id', $content['id']))
                <div class="join2">
                    {!!htmlspecialchars_decode($contentData->content)!!}
                </div>
            </div>
            @endforeach
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
