<?php
namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * App\Models\Expand
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $table 模型表名称
 * @property string $name 模型名称
 * @property int $sequence 扩展模型排序，升序
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expand whereUpdateTime($value)
 */
class Expand extends BaseModel
{

    protected $table = 'expand';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'name',
        'table',
        'sequence'
    ];

    public function add(array $data)
    {
        $table = $this->table . '_data_' . $data['table'];
        if (Schema::hasTable($table)) {
            return $this->appendMessage('该模型已存在');
        }
        Schema::create($table, function (Blueprint $table) {
            $table->increments('id');
        });
        return self::create($data);
    }

    public function deleteById(int $id)
    {
        $info = self::find($id);
        if (! $info) {
            return $this->appendMessage('该模型不存在');
        }
        $categoryCount = Category::where('expand_id', $id)->count();
        if ($categoryCount > 0) {
            return $this->appendMessage('该模型已被栏目使用，不允许删除');
        }
        $data = $info->toArray();
        $table = $this->table . '_data_' . $data['table'];
        $res = $info->delete();
        Schema::drop($table);
        return $res;
    }
}
