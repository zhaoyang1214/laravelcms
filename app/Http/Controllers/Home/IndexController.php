<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController;
use App\Models\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends HomeController
{
    public function index(Request $request)
    {
        $url = $request->getUri();
        $systemConfig =config('system');
        $viewCacheKey = 'view:' . $url;
        if ($systemConfig['view_cache']) {
            $html = Cache::get($viewCacheKey);
            if (!is_null($html)) {
                return $html;
            }
        }
        $view = "home.{$systemConfig['theme']}.{$systemConfig['index_tpl']}";
        $common = $this->media();
        $model = new BaseModel();
        $html = view($view, compact('common', 'model'))->render();
        if ($systemConfig['view_cache']) {
            Cache::set($viewCacheKey, $html, intval($systemConfig['html_index_cache_time']) / 60);
        }
        return $html;
    }
}
