<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $common['title'] }}</title>
    <meta name="keywords" content="{{ $common['keywords'] }}">
    <meta name="description" content="{{ $common['description'] }}">
    <link rel="stylesheet" href="{{ asset('lib/layui/css/layui.css') }}">
</head>
<body>
<div class="form-group ">
    <form class="layui-form" method="post" action="/form/add">
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">年龄</label>
            <div class="layui-input-inline">
                <input type="text" name="age" value="" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label for="admin_group_id" class="layui-form-label">验证码</label>
            <div class="layui-input-inline">
                <input type="text" name="captcha" value="" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='{{captcha_src()}}'+Math.random()" title="点击图片重新获取验证码">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            @csrf
            <input type="hidden" name="no" value="ce155b0a53a8830f28c5c3d9066061b9" />
            <button class="layui-btn" lay-filter="submit" lay-submit="">提交</button>
        </div>
    </form>
</div>
</body>
</html>