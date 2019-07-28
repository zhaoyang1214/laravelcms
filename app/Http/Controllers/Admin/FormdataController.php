<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormData;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\FormField;

class FormdataController extends Controller
{

    public function index($formId)
    {
        $form = new Form();
        $formInfo = $form->getOne($formId);
        if (empty($formInfo)) {
            return redirect('errors/404');
        }
        $formData = new FormData($formInfo->table);
        if (! empty($formInfo->sort)) {
            $sortArr = explode(',', $formInfo->sort);
            foreach ($sortArr as $sort) {
                $sort = explode(' ', $sort);
                if (isset($sort[1]) && $sort[1] == 'desc') {
                    $formData->orderByDesc($sort[0]);
                } else {
                    $formData->orderBy($sort[0]);
                }
            }
        }
        $data = $formData->paginate(10);
        $formFieldList = FormField::where('form_id', $formInfo->id)->where('admin_display', 1)->get();
        $admin = new Admin();
        $formIndexPower = $admin->checkPower('form', 'index');
        $formdataAddPower = $admin->checkPower('formdata', 'add');
        $formdataInfoPower = $admin->checkPower('formdata', 'info');
        $formdataDeletePower = $admin->checkPower('formdata', 'delete');
        return view('admin.formdata.index', compact('data', 'formIndexPower', 'formdataAddPower', 'formdataInfoPower', 'formdataDeletePower', 'formInfo', 'formFieldList'));
    }

    public function add(Request $request, $formId = null)
    {
        $formId = $formId ?? $request->post('form_id', 0);
        $formInfo = (new Form())->getOne($formId);
        if ($request->isMethod('post')) {
            if (! $formInfo) {
                return response()->json([
                    'status' => 10002,
                    'message' => '表单不存在'
                ]);
            }
            $formData = new FormData($formInfo->table);
            $res = $formData->add($request->post(), $formId);
            if ($res) {
                return response()->json([
                    'status' => 10000,
                    'message' => '添加成功'
                ]);
            }
            return response()->json([
                'status' => 10001,
                'message' => $formData->getMessages()[0]['message'] ?? '添加失败'
            ]);
        }
        if (! $formInfo) {
            return redirect('error/404');
        }
        $formFieldList = FormField::where('form_id', $formInfo->id)->orderBy('sequence')->get();
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/formdata/add';
        $action = 'add';
        return view('admin.formdata.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'formId', 'formFieldList'));
    }

    public function info($formId, $id)
    {
        $formInfo = (new Form())->getOne($formId);
        if (! $formInfo) {
            return redirect('errors/404');
        }
        $formData = (new FormData($formInfo->table))->find($id);
        if (! $formData) {
            return redirect('errors/404');
        }
        $formFieldList = FormField::where('form_id', $formInfo->id)->orderBy('sequence')->get();
        $actionPower = (new Admin())->checkPower('formdata', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/formdata/edit';
        $action = 'edit';
        return view('admin.formdata.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'formId', 'formFieldList', 'formData'));
    }

    public function edit(Request $request)
    {
        $formId = $request->post('form_id', 0);
        $formInfo = (new Form())->getOne($formId);
        if (! $formInfo) {
            return response()->json([
                'status' => 10002,
                'message' => '表单不存在'
            ]);
        }
        $formData = new FormData($formInfo->table);
        $res = $formData->edit($request->post());
        if ($res) {
            return response()->json([
                'status' => 10000,
                'message' => '修改成功'
            ]);
        }
        return response()->json([
            'status' => 10001,
            'message' => $formData->getMessages()[0]['message'] ?? '修改失败'
        ]);
    }

    public function delete(Request $request)
    {
        $formId = $request->post('form_id', 0);
        $formInfo = (new Form())->getOne($formId);
        if (! $formInfo) {
            return response()->json([
                'status' => 10002,
                'message' => '表单不存在'
            ]);
        }
        $id = $request->post('id', 0);
        $formData = (new FormData($formInfo->table))->find($id);
        if (! $formData) {
            return redirect('errors/404');
        }
        $res = $formData->delete();
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
