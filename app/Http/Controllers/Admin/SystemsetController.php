<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\SystemConfig;
use Illuminate\Support\Facades\Cache;

class SystemsetController extends Controller
{

    public function index()
    {
        $systemsetSavePower = (new Admin())->checkPower('systemset', 'save');
        return view('admin.systemset.index', compact('systemsetSavePower'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2'
        ]);
        $data = $request->post();
        $res = SystemConfig::updateOrCreate([
            'name' => $data['name']
        ], [
            'value' => $data['value']
        ]);
        if (! $res) {
            return response()->json([
                'status' => 10001,
                'message' => '保存失败'
            ]);
        }
        Cache::forget('systemConfig');
        return response()->json([
            'status' => 10000,
            'message' => '保存成功'
        ]);
    }
}
