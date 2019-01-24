<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;

class AdminlogController extends Controller
{

    public function index()
    {
        $data = AdminLog::getPaginator(10);
        return view('admin.adminlog.index', compact('data'));
    }
}
