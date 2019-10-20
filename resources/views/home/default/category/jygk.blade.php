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
                        @foreach($list as $content)
                        <li><a href="#">{{$content['title']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="bd">
                    @foreach($list as $content)
                        @php ($contentData = $model->getModel('contentData')::getInfoCache('content_id', $content['id']))
                        <ul class="overflow">
                            <li class="mt10">
                                <div class="tp3">
                                    <img src="{{$content['image']}}"  width="644"/>
                                </div>
                                <div class="tp4">
                                    {!!htmlspecialchars_decode($contentData->content)!!}
                                </div>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
            <script type="text/javascript">$(".slideTxtBox").slide({autoPlay:true,pnLoop:true});</script>
            <!-- Tab切换 E -->
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
