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
                <li>
                    <a href="#">郑佩佩主演赖声川话剧话剧郑佩佩主演赖声川话剧话剧</a>
                    <h5>2016-07-18</h5>
                </li>
                <li>
                    <a href="#">郑佩佩主演赖声川话剧话剧郑佩佩主演赖声川话剧话剧</a>
                    <h5>2016-07-18</h5>
                </li>
                <li>
                    <a href="#">郑佩佩主演赖声川话剧话剧郑佩佩主演赖声川话剧话剧</a>
                    <h5>2016-07-18</h5>
                </li>
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
                    <li><a href="#">热门演出</a></li>
                    <li><a href="#">节目预告</a></li>
                    <li><a href="#">节目单</a></li>
                </ul>
            </div>
            <div class="bd">
                <ul class="tp0 overflow">
                    <li>
                        <div class="tp">
                            <img src="/home/default/img/pic5.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp">
                            <img src="/home/default/img/pic6.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    <li class="last">
                        <div class="tp">
                            <img src="/home/default/img/pic6.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp">
                            <img src="/home/default/img/pic6.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp">
                            <img src="/home/default/img/pic6.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="tp0 overflow">
                    <li>
                        <div class="tp">
                            <img src="/home/default/img/pic5.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp">
                            <img src="/home/default/img/pic6.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    <li class="last">
                        <div class="tp">
                            <img src="/home/default/img/pic6.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>

                </ul>
                <ul class="tp0 overflow">
                    <li>
                        <div class="tp">
                            <img src="/home/default/img/pic5.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp">
                            <img src="/home/default/img/pic6.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>
                    <li class="last">
                        <div class="tp">
                            <img src="/home/default/img/pic6.jpg" />
                            <div class="txt">
                                <h3>荒诞喜剧《劫出人生》</h3>
                            </div>
                        </div>
                        <div class="tp1">
                            <h5>8月15</h5>
                            <div class="tp2">
                                <span class="fl">票价：60-400元</span>
                                <a href="#" class="fr">订票</a>
                            </div>
                        </div>
                    </li>

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
