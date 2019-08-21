<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\CategoryJump;
use App\Models\CategoryPage;
use App\Models\Content;
use App\Models\Replace;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryController extends HomeController
{

    public function index(Request $request, $urlname)
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
        $category = Category::getInfoCache('urlname', $urlname);
        if (empty($category)) {
            return view('errors.404');
        }
        if ($category->category_model_id == 3) {
            $categoryJump = CategoryJump::getInfoCache('category_id', $category->id);
            if (empty($categoryJump) || empty($categoryJump->url)) {
                return view('errors.404');
            }
            return redirect($categoryJump->url);
        }
        if ($category->category_model_id == 2) {
            $categoryPage = CategoryPage::getInfoCache('category_id', $category->id);
            if (empty($categoryPage)) {
                return view('errors.404');
            }
            $contentArr = explode('[page]', htmlspecialchars_decode($categoryPage->content));
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($contentArr);
            $perPage = 1;
            $contents = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $replace = new Replace();
            foreach ($contents as &$content) {
                $content = $replace->replaceContent($content);
            }
            $paginator= new LengthAwarePaginator($contents, count($collection), $perPage, $currentPage);
            $paginator->setPath($url);
            $content = $contents[0];
            $nav = $category->getParents($category->id);
            $parentCategory = Category::getInfoCache($category->pid);
            $common = $this->media($category->name, $category->keywords, $category->description);
            $topCategory = $category->getTopCategory($category->id);
            $renderView = empty($category->category_tpl) ? 'category.page' : $category->category_tpl;
            $model = new BaseModel();
            $html = View("home.{$systemConfig['theme']}.{$renderView}", compact(
                'nav',
                'common',
                'model',
                'category',
                'content',
                'paginator',
                'parentCategory',
                'topCategory'
            ))->render();
        } elseif ($category->category_model_id == 1) {
            if ($category->type == 1) {
                $categorySons = $category->getSons($category->id);
                $categoryIds = array_column($categorySons, 'id');
                $categoryIds[] = $category->id;
            } else {
                $categoryIds = [$category->id];
            }
            $listRows = intval($category->page);
            $listRows = $listRows > 0 ? $listRows : 10;
            $content = new Content();
            $list = $content->getContentList($categoryIds, $listRows, $category->expand_id, $category->content_order);
            echo "<pre>";
            var_dump($list);
            exit;
            $html = '';
        } else {
            return view('errors.404');
        }
        if ($systemConfig['view_cache']) {
            Cache::set($viewCacheKey, $html, intval($systemConfig['html_index_cache_time']) / 60);
        }
        return $html;
    }
}
