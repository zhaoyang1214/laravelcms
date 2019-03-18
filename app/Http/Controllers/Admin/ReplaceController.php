<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Replace;
use App\Models\Admin;
use Illuminate\Http\Request;

class ReplaceController extends Controller
{

    public function index()
    {
        $datas = Replace::paginate(10);
        $admin = new Admin();
        $replaceAddPower = $admin->checkPower('replace', 'add');
        $replaceInfoPower = $admin->checkPower('replace', 'info');
        $replaceDeletePower = $admin->checkPower('replace', 'delete');
        return view('admin.replace.index', compact('datas', 'replaceAddPower', 'replaceInfoPower', 'replaceDeletePower'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $res = Replace::create($request->post());
            if ($res) {
                return response()->json([
                    'status' => 10000,
                    'message' => '添加成功'
                ]);
            }
            return response()->json([
                'status' => 10001,
                'message' => '添加失败'
            ]);
        }
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/replace/add';
        $action = 'add';
        return view('admin.replace.info', compact('actionPower', 'actionName', 'actionUrl', 'action'));
    }

    public function info($id)
    {
        $info = Replace::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $actionPower = (new Admin())->checkPower('replace', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/replace/edit';
        $action = 'edit';
        return view('admin.replace.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'info'));
    }

    public function edit(Request $request)
    {
        $replace = Replace::find($request->post('id', 0));
        if (! $replace) {
            return response()->json([
                'status' => 10002,
                'message' => '记录不存在'
            ]);
        }
        $res = $replace->fill($request->post())
            ->save();
        if ($res) {
            return response()->json([
                'status' => 10000,
                'message' => '修改成功'
            ]);
        }
        return response()->json([
            'status' => 10001,
            'message' => '修改失败'
        ]);
    }

    public function delete(Request $request)
    {
        $replace = Replace::find($request->post('id', 0));
        if (! $replace) {
            return response()->json([
                'status' => 10002,
                'message' => '记录不存在'
            ]);
        }
        $res = $replace->delete();
        if ($res) {
            return response()->json([
                'status' => 10000,
                'message' => '删除成功'
            ]);
        }
        return response()->json([
            'status' => 10001,
            'message' => '删除失败'
        ]);
    }
}
