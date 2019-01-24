<?php
namespace App\Models;

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
