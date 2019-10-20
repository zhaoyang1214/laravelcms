<div class="footer mt60">
    <div class="wbox overflow">
        <div class="footer-left fl">
            <div class="footer1">
                @foreach($model->getModel('category')->getGroup(0, 1) as $category)
                <a href="{{$category['url']}}">{{$category['name']}}</a>
                @endforeach
            </div>
            <p>电话：{{ config('system.telephone') }}        传真：{{ config('system.fax') }}        邮箱：{{ config('system.masteremail') }}</p>
            <p>{{ config('system.copyright') }}      技术支持：{{ config('system.linkman') }}</p>
        </div>
        <div class="footer-right fr">
            <img src="/home/default/img/logo.png" width="322" height="45" />
        </div>
    </div>
</div>