<div class="about1">
    <div class="about-top">
        <h3>{{$parentCategory['name']}}</h3>
        <h2>{{$parentCategory['subname']}}</h2>
    </div>
    <div class="about-top1">
        <ul>
            @foreach($model->getModel('category')->getSons($parentCategory['id'], 1) as $value)
                <li><a href="{{$value['url']}}" @if($category->id == $value['id'])class="on"@endif>{{$value['name']}}</a></li>
            @endforeach
        </ul>
    </div>
</div>