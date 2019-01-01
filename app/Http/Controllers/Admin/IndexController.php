<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{

    public function index()
    {
        $authList = AdminAuth::getAllowList(0, 2);
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
            'loginInfo' => session('loginInfo')
        ];
        return view('admin.index.home', $assign);
    }

    public function cleanCache(Request $request)
    {
        $type = $request->post('type', 0);
        switch ($type) {
            case 1:
                break;
            default:
                Cache::flush();
        }
        return Response()->json([
            'status' => 10000,
            'message' => '清除缓存成功'
        ]);
    }
}
