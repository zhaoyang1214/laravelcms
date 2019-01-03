<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemsetController extends Controller
{

    public function index()
    {
        return view('admin.systemset.index');
    }

    public function save(Request $request)
    {
        $data = $request->post();
    }
}
