<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Admin;
use Illuminate\Http\Request;

class PositionController extends Controller
{

    public function index()
    {
        $datas = Position::paginate(10);
        $admin = new Admin();
        $positionAddPower = $admin->checkPower('position', 'add');
        $positionInfoPower = $admin->checkPower('position', 'info');
        $positionDeletePower = $admin->checkPower('position', 'delete');
        return view('admin.position.index', compact('datas', 'positionAddPower', 'positionInfoPower', 'positionDeletePower'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $res = Position::create($request->post());
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
        $actionUrl = '/admin/position/add';
        $action = 'add';
        return view('admin.position.info', compact('actionPower', 'actionName', 'actionUrl', 'action'));
    }

    public function info($id)
    {
        $info = Position::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $actionPower = (new Admin())->checkPower('position', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/position/edit';
        $action = 'edit';
        return view('admin.position.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'info'));
    }

    public function edit(Request $request)
    {
        $position = Position::find($request->post('id', 0));
        if (! $position) {
            return response()->json([
                'status' => 10002,
                'message' => '记录不存在'
            ]);
        }
        $res = $position->fill($request->post())
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
        $position = Position::find($request->post('id', 0));
        if (! $position) {
            return response()->json([
                'status' => 10002,
                'message' => '记录不存在'
            ]);
        }
        $res = $position->delete();
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
