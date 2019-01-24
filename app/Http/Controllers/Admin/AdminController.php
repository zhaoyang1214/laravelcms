<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin;
use App\Models\AdminGroup;
use App\Models\AdminLog;
use App\Http\Requests\Admin\Admin\AddRequest;
use App\Http\Requests\Admin\Admin\EditRequest;
use App\Http\Requests\Admin\Admin\EditInfoRequest;

class AdminController extends Controller
{

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->post();
            $validator = \Validator::make($data, [
                'username' => 'bail|required|alpha_dash|between:4,20',
                'password' => 'required|between:6,20'
            ]);
            if ($validator->fails()) {
                $message = $validator->errors()->first();
                return response()->json([
                    'status' => - 10000,
                    'message' => $message
                ]);
            }
            $key = 'admin_login_times_' . $request->ip() . '_' . $data['username'] . '_' . date('Ymd');
            if (Cache::has($key)) {
                $errorTimes = Cache::get($key, 0);
            } else {
                Cache::set($key, 0, 86400);
                $errorTimes = 0;
            }
            
            $maxTimes = 10;
            if ($errorTimes > $maxTimes) {
                return response()->json([
                    'status' => - 10000,
                    'message' => '您的账号本日已禁止在该ip地址下登陆'
                ]);
            }
            $admin = new Admin();
            $checkRes = $admin->checkLogin($data['username'], $data['password']);
            if ($checkRes === false) {
                $errorTimes = Cache::increment($key);
                $errorMessage = $admin->getMessages()[0]['message'];
                if ($errorTimes >= 5) {
                    $errorMessage .= "<br>您已输错 {$errorTimes} 次，超过 {$maxTimes} 次后此ip今日将禁止登陆本账号";
                }
                return response()->json([
                    'status' => - 10000,
                    'message' => $errorMessage
                ]);
            }
            $adminInfo = Admin::where('username', $data['username'])->first();
            $adminGroupInfo = AdminGroup::find($adminInfo['admin_group_id']);
            $adminGroupInfo['admin_auth_id_arr'] = empty($adminGroupInfo['admin_auth_ids']) ? [] : explode(',', $adminGroupInfo['admin_auth_ids']);
            $adminGroupInfo['category_id_arr'] = empty($adminGroupInfo['category_ids']) ? [] : explode(',', $adminGroupInfo['category_ids']);
            $adminGroupInfo['form_id_arr'] = empty($adminGroupInfo['form_ids']) ? [] : explode(',', $adminGroupInfo['form_ids']);
            session([
                'adminInfo' => $adminInfo,
                'adminGroupInfo' => $adminGroupInfo,
                'loginInfo' => [
                    'loginTime' => date('Y-m-d H:i:s'),
                    'loginIp' => $request->getClientIp()
                ]
            ]);
            AdminLog::create([
                'admin_id' => $adminInfo['id'],
                'logintime' => date('Y-m-d H:i:s'),
                'ip' => $request->getClientIp()
            ]);
            return response()->json([
                'status' => 10000,
                'message' => '登录成功'
            ]);
        }
        return view('admin.admin.login');
    }

    public function loginOut(Request $request)
    {
        $request->session()->flush();
        return redirect('admin/admin/login');
    }

    public function index()
    {
        $data = Admin::getPaginator(10);
        $admin = new Admin();
        $adminAddPower = $admin->checkPower('admin', 'add');
        $adminInfoPower = $admin->checkPower('admin', 'info');
        $adminDeletePower = $admin->checkPower('admin', 'delete');
        $adminEditInfoPower = $admin->checkPower('admin', 'editInfo');
        $adminGroupInfo = session('adminGroupInfo');
        $adminInfo = session('adminInfo');
        return view('admin.admin.index', compact('data', 'adminAddPower', 'adminInfoPower', 'adminDeletePower', 'adminEditInfoPower', 'adminGroupInfo', 'adminInfo'));
    }

    public function add(AddRequest $request)
    {
        if ($request->isMethod('post')) {
            $data = [
                'username' => $request->post('username'),
                'password' => md5(md5($request->post('password')) . env('DB_PASSWORD_SALT')),
                'nickname' => $request->post('nickname'),
                'regtime' => date('Y-m-d H:i:s'),
                'status' => $request->post('status'),
                'admin_group_id' => $request->post('admin_group_id')
            ];
            $res = Admin::create($data);
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
        $adminGroupList = AdminGroup::getLowerList();
        $actionPower = true;
        $actionName = '添加';
        $actionUrl = '/admin/admin/add';
        $action = 'add';
        return view('admin.admin.info', compact('adminGroupList', 'actionPower', 'actionName', 'actionUrl', 'action'));
    }

    public function info($id)
    {
        $admin = new Admin();
        $info = $admin->getOne($id);
        if (! $info) {
            return redirect('errors/404');
        }
        $adminGroupList = AdminGroup::getLowerList();
        $actionPower = $admin->checkPower('admin', 'edit');
        $actionName = '修改';
        $actionUrl = '/admin/admin/edit';
        $action = 'edit';
        return view('admin.admin.info', compact('adminGroupList', 'actionPower', 'actionName', 'actionUrl', 'action', 'info'));
    }

    public function edit(EditRequest $request)
    {
        $id = $request->post('id');
        $data = [
            'username' => $request->post('username'),
            'nickname' => $request->post('nickname'),
            'status' => $request->post('status'),
            'admin_group_id' => $request->post('admin_group_id')
        ];
        if (! empty($request->post('password'))) {
            $data['password'] = md5(md5($request->post('password')) . env('DB_PASSWORD_SALT'));
        }
        $admin = Admin::find($id);
        $res = $admin->fill($data)->save();
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
        $admin = new Admin();
        $info = $admin->getOne($request->post('id', 0));
        if (! $info) {
            return response()->json([
                'status' => 10001,
                'message' => '该管理员不存在'
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

    public function editInfo(EditInfoRequest $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $id = $request->post('id');
            $data = [
                'nickname' => $request->post('nickname')
            ];
            if (! empty($request->post('password'))) {
                $data['password'] = md5(md5($request->post('password')) . env('DB_PASSWORD_SALT'));
            }
            $admin = Admin::find($id);
            $res = $admin->fill($data)->save();
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
        $admin = new Admin();
        $info = $admin->getOneOrSelf($id);
        if (! $info) {
            return redirect('errors/404');
        }
        return view('admin.admin.editInfo', compact('info'));
    }
}
