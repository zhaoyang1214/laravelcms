<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $common['title'] }}</title>
    <meta name="keywords" content="{{ $common['keywords'] }}">
    <meta name="description" content="{{ $common['description'] }}">
</head>
<body>
<pre>
{{var_dump($model->getModel('category')::where('id', 2)->first())}}
{{var_dump($model->table('category')::where('id', 4)->first())}}
{{var_dump($model->getModel('content')->first())}}
</pre>
index
</body>
</html>