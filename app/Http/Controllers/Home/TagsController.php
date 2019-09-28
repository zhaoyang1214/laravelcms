<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController;
use App\Models\BaseModel;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TagsController extends HomeController
{

    /**
     * 功能：tags首页
     * 修改日期：2019/9/22
     *
     * @param Request $request
     * @throws \Psr\SimpleCache\InvalidArgumentException|\Throwable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|mixed|string
     */
    public function index(Request $request)
    {
        $url = $request->getUri();
        $systemConfig = config('system');
        $viewCacheKey = 'view:' . $url;
        if ($systemConfig['view_cache']) {
            $html = Cache::get($viewCacheKey);
            if (!is_null($html)) {
                return $html;
            }
        }
        $tplTagsIndexPage = intval($systemConfig['tpl_tags_index_page']);
        $listRows = $tplTagsIndexPage < 1 ? 10 : $tplTagsIndexPage;
        $tags = new Tags();
        $list = $tags->cachePaginate($tags::orderByDesc('click'), $listRows);
        $nav = [
            [
                'name' => 'TAG',
                'url' => '/tags/index'
            ]
        ];
        $common = $this->media('TAGS 列表');
        $model = new BaseModel();
        $renderView = empty($systemConfig['tags_index_tpl']) ? 'tags.index' : $systemConfig['tags_index_tpl'];
        $html = View("home.{$systemConfig['theme']}.{$renderView}", compact('nav', 'common', 'model', 'list'))
            ->render();
        if ($systemConfig['view_cache']) {
            Cache::set($viewCacheKey, $html, intval($systemConfig['html_other_cache_time']) / 60);
        }
        return $html;
    }

    /**
     * 功能：
     * 修改日期：2019/9/28
     *
     * @param string $tag
     * @param Request $request
     * @throws \Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException|\Throwable
     * @return mixed
     */
    public function info(string $tag, Request $request)
    {
        Tags::where('name', $tag)->increment('click', 1);
        $url = $request->getUri();
        $systemConfig = config('system');
        $viewCacheKey = 'view:' . $url;
        if ($systemConfig['view_cache']) {
            $html = Cache::get($viewCacheKey);
            if (!is_null($html)) {
                return $html;
            }
        }
        $tplTagsPage = intval($systemConfig['tpl_tags_page']);
        $listRows = $tplTagsPage < 1 ? 10 : $tplTagsPage;
        $list = (new Tags())->getListByTagName($tag, $listRows);
        $nav = [
            [
                'name' => 'TAG',
                'url' => '/tags/index'
            ],
            [
                'name' => $tag,
                'url' => '/tag/' . $tag
            ]
        ];
        $common = $this->media($tag . ' - TAGS', $tag);
        $model = new BaseModel();
        $renderView = empty($systemConfig['tags_info_tpl']) ? 'tags.info' : $systemConfig['tags_info_tpl'];
        $html = View("home.{$systemConfig['theme']}.{$renderView}", compact('nav', 'common', 'model', 'list'))
            ->render();
        if ($systemConfig['view_cache']) {
            Cache::set($viewCacheKey, $html, intval($systemConfig['html_other_cache_time']) / 60);
        }
        return $html;
    }
}
