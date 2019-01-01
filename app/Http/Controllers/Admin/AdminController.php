<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin;
use App\Models\AdminGroup;
use App\Models\AdminLog;

class AdminController extends Controller
{

    /**
     * 登陆
     *
     * @param Request $request            
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
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

    /**
     * 退出
     *
     * @param Request $request            
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function loginOut(Request $request)
    {
        $request->session()->flush();
        return redirect('admin/admin/login');
    }
}
