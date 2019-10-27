<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/home/default/css/style.css">
    <script type="text/javascript" src="/home/default/js/jquery1.42.min.js"></script>
    <script type="text/javascript" src="/home/default/js/jquery.js" ></script>
    <script type="text/javascript" src="/home/default/js/jquery.easing.js" ></script>

    <script type="text/javascript" src="/home/default/js/jquery.SuperSlide.2.1.1.js"></script>
    <style>
        .hasMoreTab{ width:650px; overflow:hidden}
        .hasMoreTab .hd{ line-height:50px; height:50px;border-bottom:1px solid #dedede;font-size:14px;font-weight:bold}
        .hasMoreTab .hd ul{ z-index:5; position:absolute; height:50px;  overflow:hidden; zoom:1; }
        .hasMoreTab .hd li{ float:left;  padding:0 20px;cursor:pointer; background:url(/home/default/img/x2.png) right center no-repeat}
        .hasMoreTab .hd li.on{ font-weight:bold; height:48px; line-height:48px;color:#ce000c;border-bottom:2px solid #ce000c}
        .hasMoreTab .bd{padding:10px; clear:both; position:relative;  }


        .kv_pic{width:5000px;height:380px;overflow:hidden;position:absolute;}
        .kv_pic>li{width:1000px;height:380px;float:left;}
        .kv_pic img{width:100%;}
        .kv_word{width:340px;height:192px;background-color:#313131;position:absolute;top:280px;left:0;overflow:hidden;}
        .kv_word .tit1{font-size:18px;color:#fff;margin-left:18px;margin-top:14px;}
        .kv_word .tit2{font-size:18px;color:#f5df00;margin-left:18px;}
        .kv_word li p{font-size:12px;color:#868686;width:252px;margin-left:18px;line-height:1.6;margin-top:10px;}
        .kv_word ul{width:1700px;height:192px;position:absolute;}
        .kv_word ul li{width:340px;height:192px;float:left;}
        .kv .control{width:54px;height:26px;position:absolute;left:313px;top:354px;}
        .kv .control div{width:26px;height:26px;background-color:#f5df00;margin-right:1px;float:left;cursor:pointer;}
    </style>
    <title>{{ $common['title'] }}</title>
    <meta name="keywords" content="{{ $common['keywords'] }}">
    <meta name="description" content="{{ $common['description'] }}">
</head>

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

            <!--选项卡-->
            <div class="hasMoreTab">
                <div class="hd">
                    <ul>
                        @foreach($list as $content)
                        <li><a >{{$content['title']}}</a></li>
                        @endforeach
                    </ul>

                </div>
                <div class="bd">
                    <div class="conWrap">
                        @foreach($list as $content)
                        <div class="con">
                            <div class="tp3" style="width:644px; height:400px;">
                                <div class="main">
                                    <div class="kv">
                                        <ul class="kv_pic kv_pic{{$loop->index}}">
                                        @php($expandData = $model->getModel('expandData')->setTableName('cooperation')->getInfoCache('content_id', $content['id']))
                                        @php($rollingPicture = json_decode($expandData->rolling_picture, true))
                                        @foreach($rollingPicture as $v)
                                            <li><img src="{{$v['url']}}" alt="" /></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @php ($contentData = $model->getModel('contentData')::getInfoCache('content_id', $content['id']))
                            <div class="tp4">
                                {!!htmlspecialchars_decode($contentData->content)!!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(".hasMoreTab").slide({ mainCell:".conWrap", targetCell:".more a", effect:"fold"});
            </script>
            <!--end-->
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
<script type="text/javascript">
    $(function(){
        function nextKv(num, index, kv_num){
            $(".control").attr("style","pointer-events:none");
            kv_num++;
            kv_num = kv_num % num;
            $(".kv_pic"+index).animate({ left:-1000*kv_num},{ easing: 'easeInOutQuad', duration: 500, complete: function(){
                    $(".control").attr("style","pointer-events:auto");
                }});
        }
        $('.kv_pic').each(function (index) {
            let num = $(this).find('li').length;
            let kv_num = 0;
            // 自动轮播
            setInterval(function () {
                nextKv(num, index, kv_num++);
            },3500);
        });

    });
</script>
</html>
