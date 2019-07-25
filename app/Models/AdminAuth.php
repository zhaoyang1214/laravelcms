<?php
namespace App\Models;

/**
 * App\Models\AdminAuth
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 权限名称
 * @property int $pid 父id
 * @property string $controller 控制器
 * @property string $action 操作方法
 * @property int $sequence 排序，越小越排在前面
 * @property string $note 备注
 * @property string $icon 图标
 * @property int $status 状态：0：隐藏，1：显示
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth whereController($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminAuth whereStatus($value)
 */
class AdminAuth extends BaseModel
{

    protected $table = 'admin_auth';

    // 登录后默认的权限
    const LOGGED_DEFAULT_ALLOW = [
        'Index-index',
        'Index-home',
        'Admin-loginOut',
        'Index-cleanCache',
        'Content-getKeywords'
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

    public static function getAllowList()
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query();
        if (! ($adminGroupInfo['keep'] & 4)) {
            if (empty($adminGroupInfo['admin_auth_ids'])) {
                return [];
            }
            $query->whereIn('id', explode(',', $adminGroupInfo['admin_auth_ids']));
        }
        return $query->where('status', 1)
            ->orderBy('sequence')
            ->get()
            ->toArray();
    }

    public static function getAllowListFormat(int $pid = 0, int $depth = null)
    {
        $list = self::getAllowList();
        return self::format($list, $pid, $depth);
    }

    protected static function format(array $list, int $pid = 0, int $depth = null)
    {
        if (! is_null($depth) && $depth == 0) {
            return [];
        }
        $authList = [];
        foreach ($list as $v) {
            if ($v['pid'] == $pid) {
                $v['childs'] = self::format($list, $v['id'], is_null($depth) ? null : $depth - 1);
                $authList[] = $v;
            }
        }
        return $authList;
    }
}
