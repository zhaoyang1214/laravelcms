<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expand;
use App\Models\Admin;
use App\Http\Requests\Admin\Expand\AddRequest;
use App\Http\Requests\Admin\Expand\EditRequest;
use Illuminate\Http\Request;

class ExpandController extends Controller
{

    public function index()
    {
        $datas = Expand::orderBy('sequence')->paginate(10);
        $admin = new Admin();
        $expandAddPower = $admin->checkPower('expand', 'add');
        $expandInfoPower = $admin->checkPower('expand', 'info');
        $expandDeletePower = $admin->checkPower('expand', 'delete');
        $expandfieldIndexPower = $admin->checkPower('expandfield', 'index');
        return view('admin.expand.index', compact('datas', 'expandAddPower', 'expandInfoPower', 'expandDeletePower', 'expandfieldIndexPower'));
    }

    public function add(AddRequest $request)
    {
        if ($request->isMethod('post')) {
            $expand = new Expand();
            $res = $expand->add($request->post());
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
        $actionUrl = '/admin/expand/add';
        $action = 'add';
        return view('admin.expand.info', compact('actionPower', 'actionName', 'actionUrl', 'action'));
    }

    public function info($id)
    {
        $info = Expand::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $actionPower = (new Admin())->checkPower('expand', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/expand/edit';
        $action = 'edit';
        return view('admin.expand.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'info'));
    }

    public function edit(EditRequest $request)
    {
        $form = Expand::find($request->post('id'));
        $res = $form->fill($request->post())
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
        $id = $request->post('id', 0);
        $res = (new Expand())->deleteById($id);
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
