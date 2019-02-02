<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Admin;
use App\Http\Requests\Admin\Formfield\AddRequest;

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
        $admin = new Admin();
        $formIndexPower = $admin->checkPower('form', 'index');
        $formfieldAddPower = $admin->checkPower('formfield', 'add');
        $formfieldInfoPower = $admin->checkPower('formfield', 'info');
        $formfieldDeletePower = $admin->checkPower('formfield', 'delete');
        return view('admin.formfield.index', compact('datas', 'formIndexPower', 'formfieldAddPower', 'formfieldInfoPower', 'formfieldDeletePower', 'formId'));
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
}
