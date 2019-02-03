<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Admin;
use App\Http\Requests\Admin\Formfield\AddRequest;
use App\Http\Requests\Admin\Formfield\EditRequest;
use Illuminate\Http\Request;

class FormfieldController extends Controller
{

    public function index($formId)
    {
        $form = new Form();
        $formInfo = $form->getOne($formId);
        if (empty($formInfo)) {
            return redirect('errors/404');
        }
        $datas = FormField::where('form_id', $formId)->orderBy('sequence')->get();
        $formField = new FormField();
        $admin = new Admin();
        $formIndexPower = $admin->checkPower('form', 'index');
        $formfieldAddPower = $admin->checkPower('formfield', 'add');
        $formfieldInfoPower = $admin->checkPower('formfield', 'info');
        $formfieldDeletePower = $admin->checkPower('formfield', 'delete');
        return view('admin.formfield.index', compact('datas', 'formIndexPower', 'formfieldAddPower', 'formfieldInfoPower', 'formfieldDeletePower', 'formInfo', 'formField'));
    }

    public function add(AddRequest $request, $formId = null)
    {
        $formField = new FormField();
        if ($request->isMethod('post')) {
            $res = $formField->add($request->post());
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
        $typeProperty = $formField->getTypeProperty();
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/formfield/add';
        $action = 'add';
        return view('admin.formfield.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'typeProperty', 'formId'));
    }

    public function info($id)
    {
        $formField = new FormField();
        $info = $formField->getOne($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $typeProperty = $formField->getTypeProperty();
        $actionPower = (new Admin())->checkPower('formfield', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/formfield/edit';
        $action = 'edit';
        return view('admin.formfield.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'info', 'typeProperty'));
    }

    public function edit(EditRequest $request)
    {
        $formField = new FormField();
        $res = $formField->edit($request->post('id'), [
            'name' => $request->post('name'),
            'default' => $request->post('default'),
            'sequence' => $request->post('sequence'),
            'tip' => $request->post('tip'),
            'config' => $request->post('config'),
            'is_must' => $request->post('is_must'),
            'is_unique' => $request->post('is_unique'),
            'is_index' => $request->post('is_index'),
            'regex' => $request->post('regex'),
            'admin_display' => $request->post('admin_display'),
            'admin_display_len' => $request->post('admin_display_len')
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
        $res = (new FormField())->deleteById($id);
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
