<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;

class IndexController extends Controller
{

    public function index()
    {
        return view('admin.index.index');
    }

    public function home()
    {
        echo 'home';
        exit();
    }

    public function test()
    {
        echo 'test';
        exit();
    }

    public function test1()
    {
        echo 'test1';
        exit();
    }

    public function test2()
    {
        echo 'test2';
        exit();
    }
}
