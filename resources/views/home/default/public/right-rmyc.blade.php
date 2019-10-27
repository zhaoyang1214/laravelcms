<div class="tab mt25">
    <div class="tab1" style="background:url(/home/default/img/pic.jpg) top center no-repeat; height:110px;">
        <h3>热门演出</h3>
        <p>THEATRE NEWS</p>
    </div>
    <div class="tab02">
        <div class="tab2-top1">
            @foreach($model->getModel('content')->getListByPositions(1, 3, [12, 13], true) as $content)
            <dl @if ($loop->last) last @endif>
                <dt><a href="{{$content['url']}}"><img src="{{$content['image']}}" /></a></dt>
                @php($expandData = $model->getModel('expandData')->setTableName('program')->getInfoCache('content_id', $content['id']))
                @php($showTime = explode("\n", $expandData->show_time))
                @php($fares = explode("\n", $expandData->fares))
                <dd>
                    <h3 class="text_overflow1">{{$content['title']}}</h3>
                    <p>{{$showTime[0]}}</p>
                    <h4>票价：{{min($fares)}}@if(count($fares) > 1)-{{max($fares)}}@endif元</h4>
                    <a href="{{$expandData->booking}}">订票</a>
                </dd>
            </dl>
            @endforeach
        </div>
    </div>
</div>