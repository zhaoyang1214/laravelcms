<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fragment;
use App\Models\Admin;
use Illuminate\Http\Request;

class FragmentController extends Controller
{

    public function index()
    {
        $datas = Fragment::paginate(10);
        $admin = new Admin();
        $fragmentAddPower = $admin->checkPower('fragment', 'add');
        $fragmentInfoPower = $admin->checkPower('fragment', 'info');
        $fragmentDeletePower = $admin->checkPower('fragment', 'delete');
        return view('admin.fragment.index', compact('datas', 'fragmentAddPower', 'fragmentInfoPower', 'fragmentDeletePower'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $fragment = new Fragment();
            $res = $fragment->add($request->post());
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
        $actionUrl = '/admin/fragment/add';
        $action = 'add';
        return view('admin.fragment.info', compact('actionPower', 'actionName', 'actionUrl', 'action'));
    }

    public function info($id)
    {
        $info = Fragment::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $actionPower = (new Admin())->checkPower('fragment', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/fragment/edit';
        $action = 'edit';
        return view('admin.fragment.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'info'));
    }

    public function edit(Request $request)
    {
        $res = (new Fragment())->edit($request->post());
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
        $fragment = Fragment::find($request->post('id', 0));
        if (! $fragment) {
            return response()->json([
                'status' => 10002,
                'message' => '记录不存在'
            ]);
        }
        $res = $fragment->delete();
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
