<?php
namespace App\Models;

class AdminGroup extends BaseModel
{

    protected $table = 'admin_group';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'pid',
        'name',
        'admin_auth_ids',
        'category_ids',
        'form_ids',
        'grade',
        'keep',
        'admin_id'
    ];

    public static function getPaginator(int $perPage)
    {
        $adminGroupInfo = session('adminGroupInfo');
        // $query = self::query();
        // $query->where('grade', '>=', $adminGroupInfo['grade']);
        // return $query->paginate($perPage);
        return self::where('grade', '>=', $adminGroupInfo['grade'])->paginate($perPage);
    }

    public static function getLowerList()
    {
        $adminGroupInfo = session('adminGroupInfo');
        return self::where('grade', '>', $adminGroupInfo['grade'])->get();
    }

    public function getOne(int $id)
    {
        $info = self::find($id);
        $adminGroupInfo = session('adminGroupInfo');
        if (! $info || $info->grade <= $adminGroupInfo['grade']) {
            return $this->appendMessage('管理组不存在');
        }
        return $info;
    }
}
