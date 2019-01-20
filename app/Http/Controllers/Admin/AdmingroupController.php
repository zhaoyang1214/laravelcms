<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminGroup;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\AdminAuth;
use App\Models\Category;
use App\Models\Form;
use App\Http\Requests\Admin\Admingroup\AddRequest;
use App\Http\Requests\Admin\Admingroup\EditRequest;

class AdmingroupController extends Controller
{

    public function index()
    {
        $data = AdminGroup::getPaginator(10);
        $admin = new Admin();
        $admingroupAddPower = $admin->checkPower('admingroup', 'add');
        $admingroupInfoPower = $admin->checkPower('admingroup', 'info');
        $admingroupDeletePower = $admin->checkPower('admingroup', 'delete');
        $adminGroupInfo = session('adminGroupInfo');
        return view('admin.admingroup.index', compact('data', 'admingroupAddPower', 'admingroupInfoPower', 'admingroupDeletePower', 'adminGroupInfo'));
    }

    public function add(AddRequest $request)
    {
        $adminGroupInfo = session('adminGroupInfo');
        if ($request->isMethod('post')) {
            $adminInfo = session('adminInfo');
            $data = $request->post();
            $data['pid'] = $adminGroupInfo['id'];
            $data['admin_id'] = $adminInfo['id'];
            $res = AdminGroup::create($data);
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
        $adminAuthList = (new AdminAuth())->getAllowList();
        $cateGoryList = (new Category())->getAllowList();
        $formList = (new Form())->getAllowList();
        array_walk($adminAuthList, function (&$v) {
            $v['icon'] = '';
        });
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/admingroup/add';
        $action = 'add';
        $adminAuthTree = json_encode($adminAuthList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $cateGoryTree = json_encode($cateGoryList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $formTree = json_encode($formList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return view('admin.admingroup.info', compact('adminGroupInfo', 'adminAuthTree', 'cateGoryTree', 'formTree', 'actionPower', 'actionName', 'actionUrl', 'action'));
    }

    public function info($id)
    {
        $adminGroup = new AdminGroup();
        $info = $adminGroup->getOne($id);
        if (! $info) {
            return response()->json([
                'status' => 10001,
                'message' => $adminGroup->getMessages()[0]['message']
            ]);
        }
        $allowAdminAuthIdArr = empty($info->admin_auth_ids) ? [] : explode(',', $info->admin_auth_ids);
        $allowCateGoryIdArr = empty($info->category_ids) ? [] : explode(',', $info->category_ids);
        $allowFormIdArr = empty($info->form_ids) ? [] : explode(',', $info->form_ids);
        $adminGroupInfo = session('adminGroupInfo');
        $adminAuthList = (new AdminAuth())->getAllowList();
        foreach ($adminAuthList as &$adminAuth) {
            $adminAuth['icon'] = '';
            if (in_array($adminAuth['id'], $allowAdminAuthIdArr)) {
                $adminAuth['checked'] = true;
            }
        }
        $cateGoryList = (new Category())->getAllowList();
        foreach ($cateGoryList as &$cateGory) {
            if (in_array($cateGory['id'], $allowCateGoryIdArr)) {
                $cateGory['checked'] = true;
            }
        }
        $formList = (new Form())->getAllowList();
        foreach ($formList as &$form) {
            if (in_array($form['id'], $allowFormIdArr)) {
                $form['checked'] = true;
            }
        }
        $actionPower = (new Admin())->checkPower('admingroup', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/admingroup/edit';
        $action = 'edit';
        $adminAuthTree = json_encode($adminAuthList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $cateGoryTree = json_encode($cateGoryList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $formTree = json_encode($formList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return view('admin.admingroup.info', compact('adminGroupInfo', 'adminAuthTree', 'cateGoryTree', 'formTree', 'actionPower', 'actionName', 'actionUrl', 'action', 'info'));
    }

    public function edit(EditRequest $request)
    {
        $id = $request->post('id');
        $data = [
            'name' => $request->post('name'),
            'admin_auth_ids' => $request->post('admin_auth_ids'),
            'category_ids' => $request->post('category_ids'),
            'form_ids' => $request->post('form_ids'),
            'grade' => $request->post('grade'),
            'keep' => $request->post('keep')
        ];
        $adminGroup = AdminGroup::find($id);
        $res = $adminGroup->fill($data)->save();
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
        $adminGroup = new AdminGroup();
        $info = $adminGroup->getOne($request->post('id', 0));
        if (! $info) {
            return response()->json([
                'status' => 10001,
                'message' => $adminGroup->getMessages()[0]['message']
            ]);
        }
        $res = $info->delete();
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
