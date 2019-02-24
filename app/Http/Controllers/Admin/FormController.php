<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Admin;
use App\Http\Requests\Admin\Form\AddRequest;
use App\Http\Requests\Admin\Form\EditRequest;
use Illuminate\Http\Request;

class FormController extends Controller
{

    public function index()
    {
        $datas = Form::getPaginator(10);
        $admin = new Admin();
        $formAddPower = $admin->checkPower('form', 'add');
        $formInfoPower = $admin->checkPower('form', 'info');
        $formDeletePower = $admin->checkPower('form', 'delete');
        $formfieldIndexPower = $admin->checkPower('formfield', 'index');
        $formdataIndexPower = $admin->checkPower('formdata', 'index');
        return view('admin.form.index', compact('datas', 'formAddPower', 'formInfoPower', 'formDeletePower', 'formfieldIndexPower', 'formdataIndexPower'));
    }

    public function add(AddRequest $request)
    {
        if ($request->isMethod('post')) {
            $form = new Form();
            $res = $form->add($request->post());
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
        $actionUrl = '/admin/form/add';
        $action = 'add';
        return view('admin.form.info', compact('actionPower', 'actionName', 'actionUrl', 'action'));
    }

    public function info($id)
    {
        $info = (new Form())->getOne($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $actionPower = (new Admin())->checkPower('form', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/form/edit';
        $action = 'edit';
        return view('admin.form.info', compact('actionPower', 'actionName', 'actionUrl', 'action', 'info'));
    }

    public function edit(EditRequest $request)
    {
        $form = Form::find($request->post('id'));
        $data = $request->post();
        if (! empty($data['sort'])) {
            $data['sort'] = preg_replace('/\s+/', ' ', str_replace('，', ',', strtolower($data['sort'])));
        }
        $res = $form->fill($data)->save();
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
        $res = (new Form())->deleteById($id);
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
