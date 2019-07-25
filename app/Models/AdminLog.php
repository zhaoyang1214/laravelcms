<?php
namespace App\Models;

/**
 * App\Models\AdminLog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $admin_id 表admin id
 * @property string $logintime 登录时间
 * @property string $ip
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereLogintime($value)
 */
class AdminLog extends BaseModel
{

    protected $table = 'admin_log';

    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'logintime',
        'ip'
    ];

    public static function getPaginator(int $perPage)
    {
        $adminInfo = session('adminInfo');
        return self::query()->select('logintime', 'ip')
            ->where('admin_id', $adminInfo['id'])
            ->orderByDesc('id')
            ->paginate($perPage);
    }
}
