<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController;
use App\Models\BaseModel;
use App\Models\Category;
use App\Models\CategoryJump;
use App\Models\CategoryPage;
use App\Models\Replace;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

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
            $renderView = empty($category->category_tpl) ? 'categorypage/index' : $category->category_tpl;
            $model = new BaseModel();
            $html = View($renderView, compact(
                'nav',
                'common',
                'model',
                'category',
                'content',
                'paginator',
                'parentCategory',
                'topCategory'
            ))->render();
        } elseif ($category->category_model_id == 3) {
            $html = '';
        } else {
            return view('errors.404');
        }
        if ($systemConfig['view_cache']) {
            Cache::set($this->viewCacheKey, $html, intval($systemConfig['html_index_cache_time']) / 60);
        }
        return $html;
    }
}
