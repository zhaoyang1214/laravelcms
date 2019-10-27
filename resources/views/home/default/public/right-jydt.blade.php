<div class="tab @isset($class){{$class}}@endisset">
    <div class="tab1" style="background:url(/home/default/img/pic.jpg) top center no-repeat; height:110px;">
        <h3>剧院动态</h3>
        <p>THEATRE NEWS</p>
    </div>
    <div class="tab2">
        @foreach($model->getModel('content')->getListByCategoryId([10, 11], 3, 1) as $v)
        <div class="tab2-top @if ($loop->last) last @endif">
            <dl>
                <a href="{{$v->url}}">
                    <dt><img width="60px" height="60px" src="{{$v->image}}" /></dt>
                    <dd>
                        <h3 class="text_overflow2">{{$v->title}}</h3>
                        <h5>{{date('Y-m-d', strtotime($v->update_time))}}</h5>
                    </dd>
                </a>
            </dl>
            @if ($loop->first)
            <p class="text_overflow3"> {{$v->description}}</p>
            @endif
        </div>
        @endforeach
    </div>
</div>