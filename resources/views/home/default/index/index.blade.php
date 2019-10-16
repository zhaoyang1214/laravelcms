<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="home/{{config('system.theme')}}/css/style.css">
    <script type="text/javascript" src="home/{{config('system.theme')}}/js/jquery1.42.min.js"></script>
    <script type="text/javascript" src="home/{{config('system.theme')}}/js/jquery.SuperSlide.2.1.1.js"></script>
    <title>{{ $common['title'] }}</title>
    <meta name="keywords" content="{{ $common['keywords'] }}">
    <meta name="description" content="{{ $common['description'] }}">
</head>

<body>
<!--顶部-->
@include('home.' . config('system.theme') . '.public.header')
<!--end-->

<!--banner-->
<div class="wbox index0">
    <!--图片-->
    <div id="iFocus" class="fl">
        <ul>
            @foreach($model->getModel('FormData')->getAllByTableName('index_banner') as $data)
            <li><a href="{{$data->url}}" target="_blank"><img src="{{$data->pic}}" /></a></li>
            @endforeach
        </ul>
        <div class="btnBg"></div>
        <div class="btn">
            @foreach($model->getModel('FormData')->getAllByTableName('index_banner') as $data)
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
                <dt><img src="home/default/img/pic4.jpg" /></dt>
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
                            <img src="home/default/img/pic5.jpg" />
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
                            <img src="home/default/img/pic6.jpg" />
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
                            <img src="home/default/img/pic6.jpg" />
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
                            <img src="home/default/img/pic6.jpg" />
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
                            <img src="home/default/img/pic6.jpg" />
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
                            <img src="home/default/img/pic5.jpg" />
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
                            <img src="home/default/img/pic6.jpg" />
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
                            <img src="home/default/img/pic6.jpg" />
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
                            <img src="home/default/img/pic5.jpg" />
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
                            <img src="home/default/img/pic6.jpg" />
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
                            <img src="home/default/img/pic6.jpg" />
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
        <div class="tab">
            <div class="tab1" style="background:url(img/pic.jpg) top center no-repeat; height:110px;">
                <h3>剧院动态</h3>
                <p>THEATRE NEWS</p>
            </div>
            <div class="tab2">
                <div class="tab2-top">
                    <dl>
                        <a href="#">
                            <dt><img src="home/default/img/pic8.jpg" /></dt>
                            <dd>
                                <h3>郑佩佩主演赖声川话剧 故事脑洞大开到外星球</h3>
                                <h5>2016-07-18</h5>
                            </dd>
                        </a>
                    </dl>
                    <p> 郑佩佩曾经是武侠片中的“侠女”，近50岁时在《唐伯虎点秋香》中饰演“华夫人”，成为80后心目中的喜剧演员...</p>
                </div>
                <div class="tab2-top">
                    <dl>
                        <a href="#">
                            <dt><img src="home/default/img/pic8.jpg" /></dt>
                            <dd>
                                <h3>郑佩佩主演赖声川话剧 故事脑洞大开到外星球</h3>
                                <h5>2016-07-18</h5>
                            </dd>
                        </a>
                    </dl>
                </div>
                <div class="tab2-top last">
                    <dl>
                        <a href="#">
                            <dt><img src="home/default/img/pic8.jpg" /></dt>
                            <dd>
                                <h3>郑佩佩主演赖声川话</h3>
                                <h5>2016-07-18</h5>
                            </dd>
                        </a>
                    </dl>
                </div>
            </div>
        </div>
        <div class="tab mt10">
            <div class="tab1" style="background:url(img/pic3.jpg) top center no-repeat; height:110px;">
                <h3>商务合作</h3>
                <p>cooperation</p>
            </div>
            <div class="tab3">
                <dl>
                    <dt>合肥场地租赁</dt>
                    <dd>
                        <p>负责人：望京</p>
                        <p>联系电话：15215569996</p>
                    </dd>
                </dl>
                <dl>
                    <dt>合肥场地租赁</dt>
                    <dd>
                        <p>负责人：望京</p>
                        <p>联系电话：15215569996</p>
                    </dd>
                </dl>
                <dl>
                    <dt>合肥场地租赁</dt>
                    <dd>
                        <p>负责人：望京</p>
                        <p>联系电话：15215569996</p>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <!--end-->
</div>
<!--end-->
<!--底部-->
<div class="footer mt60">
    <div class="wbox overflow">
        <div class="footer-left fl">
            <div class="footer1">
                <a href="#">剧院概况</a> <a href="#"> 配套设施</a> <a href="#"> 媒体报道</a> <a href="#"> 网上购票 </a> <a href="#">演出信息</a> <a href="#">商务合作 </a> <a href="#">招聘信息</a>
            </div>
            <p>电话：0551-5656-2121        传真：021-5656-2323        邮箱：696969@qq.com</p>
            <p>© 2016 万盛江淮大剧院版权所有      技术支持：海拔网络</p>
        </div>
        <div class="footer-right fr">
            <img src="home/default/img/logo.png" width="322" height="45" />
        </div>
    </div>
</div>
<!--end-->

</body>
</html>
