<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $common['title'] }}</title>
    <meta name="keywords" content="{{ $common['keywords'] }}">
    <meta name="description" content="{{ $common['description'] }}">
</head>
<body>
<div class="form-group ">
    <label for="captcha" class="col-md-4 control-label">验证码</label>

    <div class="col-md-6">
        <input id="captcha" class="form-control" name="captcha" >

        <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='{{captcha_src()}}'+Math.random()" title="点击图片重新获取验证码">

    </div>
</div>
</body>
</html>