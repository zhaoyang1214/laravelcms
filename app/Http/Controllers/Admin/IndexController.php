<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use App\Models\Category;
use App\Models\Content;
use App\Models\Tags;
use App\Models\Upload;

class IndexController extends Controller
{

    public function index()
    {
        $authList = AdminAuth::getAllowListFormat(0, 2);
        $data = [
            'authList' => $authList,
            'adminInfo' => session('adminInfo')
        ];
        return view('admin.index.index', $data);
    }

    public function home()
    {
        $assign = [
            'adminInfo' => session('adminInfo'),
            'loginInfo' => session('loginInfo'),
            'categoryCount' => Category::count(),
            'contentCount' => Content::count(),
            'tagsCount' => Tags::count(),
            'uploadCount' => Upload::count()
        ];
        return view('admin.index.home', $assign);
    }

    public function cleanCache(Request $request)
    {
        $type = $request->post('type', 0);
        switch ($type) {
            case 0:
            case 1:
                Artisan::call('cache:clear');
                if ($type) {
                    break;
                }
            case 2:
                Artisan::call('config:clear');
                if ($type) {
                    break;
                }
            case 3:
                Artisan::call('route:clear');
                if ($type) {
                    break;
                }
            case 4:
                Artisan::call('view:clear');
                if ($type) {
                    break;
                }
            case 5:
                Artisan::call('clear-compiled');
        }
        return Response()->json([
            'status' => 10000,
            'message' => '清除缓存成功'
        ]);
    }
}
