<?php
namespace App\Models;

class AdminAuth extends BaseModel
{

    protected $table = 'admin_auth';

    // 登录后默认的权限
    const LOGGED_DEFAULT_ALLOW = [
        'Index-index',
        'Index-home'
    ];

    /**
     * 根据控制器名和动作名获取权限信息
     *
     * @param string $controllerName            
     * @param string $actionName            
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public static function getInfoByConAct(string $controllerName, string $actionName)
    {
        return self::getInfo([
            'controller' => $controllerName,
            'action' => $actionName,
            'status' => 1
        ]);
    }
}
