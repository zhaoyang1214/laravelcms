@include('home.default.public.header')
<script type="text/javascript">
    $(function(){
        $(".but").click(function(){
            var bg="#faqbg"+$(this).attr('va');
            var div="#faqdiv"+$(this).attr('va');
            $(bg).css({display:"block",height:$(document).height()});
            var yscroll =document.documentElement.scrollTop;
            $(div).css("top","200px");
            $(div).css("display","block");
            document.documentElement.scrollTop=0;
        });
        $(".close").click(function(){
            var bg="#faqbg"+$(this).attr('va');
            var div="#faqdiv"+$(this).attr('va');
            $(bg).css("display","none");
            $(div).css("display","none");
        });
    })
</script>
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
            <div class="about2">
                <ul>
                    @foreach($list as $content)
                    <li><a class="but"><img width="310px" height="232px" src="{{$content['image']}}" /></a></li>
                    @endforeach
                </ul>
            </div>
            <!--分页-->
            {{ $list->links('home.default.public.page') }}
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
<div class="clear"></div>
@include('home.default.public.footer')
<!--end-->
</body>
</html>
