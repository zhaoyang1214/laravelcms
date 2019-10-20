<?php

/**
 * Copyright (c) 2019,1134856531@qq.com
 * 摘    要：
 * 作    者：赵阳
 * 修改日期：2019/9/8
 */


namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\Content;
use App\Models\ContentData;
use App\Models\Expand;
use App\Models\ExpandData;
use App\Models\ExpandField;
use App\Models\Replace;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ContentController extends HomeController
{

    /**
     * 功能：内容
     * 修改日期：2019/9/8
     *
     * @param Request $request
     * @param $urltitle
     * @throws \Psr\SimpleCache\InvalidArgumentException|\Throwable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(Request $request, $urltitle)
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
        $content = Content::getInfoCache('urltitle', $urltitle);
        if (empty($content)) {
            return view('errors.404');
        }
        Content::where('id', $content->id)->increment('views', 1);
        if (!empty($content->jump_url)) {
            return redirect($content->jump_url);
        }
        $category = Category::getInfoCache($content->category_id);
        if ($category->expand_id) {
            $expand = Expand::getInfoCache($category->expand_id);
            $expandData = (new ExpandData($expand->table))::getInfoCache('content_id', $content->id);
            $expandField = new ExpandField();
            $expandFieldList = $expandField::getListCache('expand_id', $category->expand_id);
        }
        $contentData = ContentData::getInfoCache('content_id', $content->id);
        $contentArr = explode('[page]', htmlspecialchars_decode($contentData->content));
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($contentArr);
        $perPage = 1;
        $contents = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $contentStr = $contents[$currentPage-1];
        if (!empty($contentStr)) {
            $replace = new Replace();
            $contentStr = $replace->replaceContent($contentStr);
            if ($content->taglink) {
                $contentStr = (new Tags())->tagLink($contentStr, $content->id);
            }
        }
        $content->content = $contentStr;
        $paginator= new LengthAwarePaginator($contents, count($collection), $perPage, $currentPage);
        $paginator->setPath(preg_replace('/\??&?page=\d*&?/', '', $url));
        $prevContent = $content->getPrevContent($content, $category);
        $nextContent = $content->getNextContent($content, $category);
        $nav = $category->getParents($category->id);
        $parentCategory = $category->getParent($category->id);
        $common = $this->media($content->title . '-' . $category->name, $content->keywords, $content->description);
        $topCategory = $category->getTopCategory($category->id);
        $renderView = empty($category->content_tpl) ? 'content.index' : $category->content_tpl;
        $model = new BaseModel();
        $html = View("home.{$systemConfig['theme']}.{$renderView}", compact(
            'nav',
            'common',
            'model',
            'category',
            'content',
            'paginator',
            'parentCategory',
            'topCategory',
            'prevContent',
            'nextContent',
            'expandField',
            'expandFieldList',
            'expandData'
        ))->render();
        if ($systemConfig['view_cache']) {
            Cache::set($viewCacheKey, $html, intval($systemConfig['html_other_cache_time']) / 60);
        }
        return $html;
    }
}
