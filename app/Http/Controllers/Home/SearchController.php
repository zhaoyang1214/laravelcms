<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends HomeController
{

    /**
     * 功能：搜索
     * 修改日期：2019/9/22
     *
     * @param Request $request
     * @throws \Psr\SimpleCache\InvalidArgumentException|\Throwable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|mixed|string
     */
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
        $keyword = $request->get('keyword', '');
        $keywords = preg_replace('/\s+/', ' ', $keyword);
        $categoryId = intval($request->get('category_id', 0));
        $category = new Category();
        $categoryGroup = $category->getGroup($categoryId);
        $categoryIds = array_column($categoryGroup, 'id');
        $type = intval($request->get('type', 0));
        $tplSeachPage = intval($systemConfig['tpl_seach_page']);
        $listRows = $tplSeachPage < 1 ? 10 : $tplSeachPage;
        $content = new Content();
        $list = $content->getListBySearch($keywords, $type, $categoryIds, $listRows);
        $nav = [
            [
                'name' => '搜索',
                'url' => 'search/index',
            ],
            [
                'name' => $keyword,
                'url' => $url,
            ],
        ];
        $common = $this->media($keyword . ' - 搜索', $keyword);
        $model = new BaseModel();
        $renderView = empty($systemConfig['search_tpl']) ? 'search.index' : $systemConfig['search_tpl'];
        $html = View("home.{$systemConfig['theme']}.{$renderView}", compact('nav', 'common', 'model', 'list'))
            ->render();
        if ($systemConfig['view_cache']) {
            Cache::set($viewCacheKey, $html, intval($systemConfig['html_search_cache_time']) / 60);
        }
        return $html;
    }
}
