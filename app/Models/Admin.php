<?php
namespace App\Models;

class Admin extends BaseModel
{

    protected $table = 'admin';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'username',
        'password',
        'nicename',
        'regtime',
        'admin_group_id'
    ];

    /**
     * 登录校验
     *
     * @param string $username
     *            用户名
     * @param string $password
     *            密码
     * @return bool
     */
    public function checkLogin(string $username, string $password)
    {
        $info = self::where('username', $username)->first();
        if (empty($info) || $info['password'] != md5(md5($password) . env('DB_PASSWORD_SALT'))) {
            return $this->appendMessage('用户名或密码错误');
        }
        if (! $info->status) {
            return $this->appendMessage('账户已被禁用');
        }
        return true;
    }

    /**
     * 检测是否已登陆
     *
     * @return bool
     */
    public static function checkIsLogged()
    {
        $adminInfo = session('adminInfo');
        return is_null($adminInfo) ? false : true;
    }

    /**
     * 校验权限
     *
     * @param string $controllerName            
     * @param string $actionName            
     * @return bool
     */
    public static function checkPower(string $controllerName, string $actionName)
    {
        if (! self::checkIsLogged()) {
            return false;
        }
        if (in_array($controllerName . '-' . $actionName, AdminAuth::LOGGED_DEFAULT_ALLOW)) {
            return true;
        }
        $adminGroupInfo = session('adminGroupInfo');
        if ($adminGroupInfo['keep'] & 4) {
            return true;
        }
        $adminAuthInfo = AdminAuth::getInfoByConAct($controllerName, $actionName);
        if (! is_null($adminAuthInfo) && in_array($adminAuthInfo->id, $adminGroupInfo['admin_auth_id_arr'])) {
            return true;
        }
    }
}
