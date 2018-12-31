<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminAuth;

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
        echo 'home';
        exit();
    }
}
