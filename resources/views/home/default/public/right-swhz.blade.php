<div class="tab mt10">
    <div class="tab1" style="background:url(/home/default/img/pic3.jpg) top center no-repeat; height:110px;">
        <h3>商务合作</h3>
        <p>cooperation</p>
    </div>
    <div class="tab3">
        @foreach($model->getModel('content')->getListByCategoryId(17, 3, 4) as $v)
        <dl>
            <dt>{{$v['site_name']}}</dt>
            <dd>
                <p>负责人：{{$v['leader']}}</p>
                <p>联系电话：{{$v['tel']}}</p>
            </dd>
        </dl>
        @endforeach
    </div>
</div>