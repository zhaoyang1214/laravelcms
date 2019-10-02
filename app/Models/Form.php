<?php
namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * App\Models\FormController
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 表单名称
 * @property string $no 表单编号
 * @property string $table 表名
 * @property int $sequence 表单排序，升序
 * @property string $sort 内容排序
 * @property int $display 是否在前台显示此表单的分页列表内容，0：否，1：是
 * @property int $page 前台分页数
 * @property string $tpl 前台模板，为空使用默认模板
 * @property string $condition 前台分页条件
 * @property int $return_type 提交表单返回类型，0：JS消息框，1：json
 * @property string $return_msg 提交成功后返回的提示信息
 * @property string $return_url 提交成功后跳转的地址
 * @property int $is_captcha 是否使用图片验证码，0：否，1：是
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereIsCaptcha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereReturnMsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereReturnType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereReturnUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereTpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Form whereUpdateTime($value)
 */
class Form extends BaseModel
{

    protected $table = 'form';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'name',
        'no',
        'table',
        'sequence',
        'sort',
        'display',
        'page',
        'tpl',
        'condition',
        'return_type',
        'return_msg',
        'return_url',
        'is_captcha'
    ];

    public static function getAllowList(int $limit = null, int $offset = null)
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query();
        if (! ($adminGroupInfo['keep'] & 1)) {
            if (empty($adminGroupInfo['form_ids'])) {
                return [];
            }
            $query->whereIn('id', explode(',', $adminGroupInfo['form_ids']));
        }
        $query->orderBy('sequence');
        if (! is_null($limit)) {
            $query->limit($limit);
        }
        if (! is_null($offset)) {
            $query->offset($offset);
        }
        return $query->get()->toArray();
    }

    public static function getPaginator(int $perPage)
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query();
        if (! ($adminGroupInfo['keep'] & 1)) {
            if (empty($adminGroupInfo['form_ids'])) {
                return [];
            }
            $query->whereIn('id', explode(',', $adminGroupInfo['form_ids']));
        }
        return $query->orderBy('sequence')->paginate($perPage);
    }

    public function add(array $data)
    {
        $data['no'] = md5(md5($data['name'] . microtime(true)));
        if (! empty($data['sort'])) {
            $data['sort'] = preg_replace('/\s+/', ' ', str_replace('，', ',', strtolower($data['sort'])));
        }
        $table = $this->table . '_data_' . $data['table'];
        if (Schema::hasTable($table)) {
            return $this->appendMessage('该表已存在');
        }
        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
        });
        return self::create($data);
    }

    public function getOne(int $id)
    {
        $adminGroupInfo = session('adminGroupInfo');
        if (! ($adminGroupInfo['keep'] & 1) && ! in_array($id, $adminGroupInfo['form_id_arr'])) {
            return $this->appendMessage('该表单不存在');
        }
        return self::find($id);
    }

    public function deleteById(int $id)
    {
        $info = $this->getOne($id);
        if (! $info) {
            return $this->appendMessage('该表单不存在');
        }
        $data = $info->toArray();
        $table = $this->table . '_data_' . $data['table'];
        $res = $info->delete();
        Schema::drop($table);
        return $res;
    }
}
