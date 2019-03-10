<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expand;
use App\Models\ExpandField;
use App\Models\Admin;
use App\Http\Requests\Admin\Expandfield\AddRequest;
use App\Http\Requests\Admin\Expandfield\EditRequest;
use Illuminate\Http\Request;

class ExpandfieldController extends Controller
{

    public function index($expandId)
    {
        $expandInfo = Expand::find($expandId);
        if (empty($expandInfo)) {
            return redirect('errors/404');
        }
        $datas = ExpandField::where('expand_id', $expandId)->orderBy('sequence')->get();
        $expandField = new ExpandField();
        $admin = new Admin();
        $expandIndexPower = $admin->checkPower('expand', 'index');
        $expandfieldAddPower = $admin->checkPower('expandfield', 'add');
        $expandfieldInfoPower = $admin->checkPower('expandfield', 'info');
        $expandfieldDeletePower = $admin->checkPower('expandfield', 'delete');
        return view('admin.expandfield.index', compact('datas', 'expandIndexPower', 'expandfieldAddPower', 'expandfieldInfoPower', 'expandfieldDeletePower', 'expandInfo', 'expandField'));
    }

    public function add(AddRequest $request, $expandId = null)
    {
        $expandField = new ExpandField();
        if ($request->isMethod('post')) {
            $res = $expandField->add($request->post());
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
        $typeProperty = $expandField->getTypeProperty();
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/expandfield/add';
        $action = 'add';
        return view('admin.expandfield.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'typeProperty', 'expandId'));
    }

    public function info($id)
    {
        $info = ExpandField::find($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $typeProperty = $info->getTypeProperty();
        $actionPower = (new Admin())->checkPower('expandfield', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/expandfield/edit';
        $action = 'edit';
        return view('admin.expandfield.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'info', 'typeProperty'));
    }

    public function edit(EditRequest $request)
    {
        $expandField = new ExpandField();
        $res = $expandField->edit($request->post('id'), [
            'name' => $request->post('name'),
            'default' => $request->post('default'),
            'sequence' => $request->post('sequence'),
            'tip' => $request->post('tip'),
            'config' => $request->post('config'),
            'is_must' => $request->post('is_must'),
            'is_unique' => $request->post('is_unique'),
            'is_index' => $request->post('is_index'),
            'regex' => $request->post('regex')
        ]);
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
        $res = (new ExpandField())->deleteById($id);
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
