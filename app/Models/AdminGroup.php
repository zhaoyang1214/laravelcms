<?php
namespace App\Models;

/**
 * App\Models\AdminGroup
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $pid 上级 id
 * @property string $name 角色名称
 * @property string $admin_auth_ids 操作权限ids,1,2,5
 * @property string $category_ids 栏目权限
 * @property string $form_ids 表单权限
 * @property int $grade 等级，数字越小等级越高
 * @property int $keep 是否校验权限（允许组合），0：全部校验，1：不校验表单权限，2：不校验栏目权限，4：不校验功能权限，7：全部不校验
 * @property int $admin_id admin表 id，创建者id
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereAdminAuthIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereCategoryIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereFormIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereKeep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminGroup whereUpdateTime($value)
 */
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
