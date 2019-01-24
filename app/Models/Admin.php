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
        'nickname',
        'regtime',
        'status',
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

    public static function getPaginator(int $perPage)
    {
        $adminGroupInfo = session('adminGroupInfo');
        return self::query()->select('admin.id', 'admin.username', 'admin.nickname', 'admin.regtime', 'admin.status', 'admin_group.name as admin_group_name', 'admin_group.grade')
            ->leftJoin('admin_group', 'admin.admin_group_id', '=', 'admin_group.id')
            ->where('grade', '>=', $adminGroupInfo['grade'])
            ->paginate($perPage);
    }

    public function getOne(int $id)
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query()->select('admin.*')
            ->leftJoin('admin_group', 'admin.admin_group_id', '=', 'admin_group.id')
            ->where('admin.id', $id)
            ->where('grade', '>', $adminGroupInfo['grade']);
        return $query->first();
    }

    public function getOneOrSelf(int $id)
    {
        $adminGroupInfo = session('adminGroupInfo');
        $adminInfo = session('adminInfo');
        $query = self::query()->select('admin.*')
            ->leftJoin('admin_group', 'admin.admin_group_id', '=', 'admin_group.id')
            ->where('admin.id', $id);
        $query->where(function ($query) use ($adminGroupInfo, $adminInfo) {
            $query->where('grade', '>', $adminGroupInfo['grade'])
                ->orWhere('admin.id', $adminInfo['id']);
        });
        return $query->first();
    }
}
