<?php
namespace App\Models;

/**
 * App\Models\SystemConfig
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 配置名称
 * @property string $value 配置值
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereUpdateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SystemConfig whereValue($value)
 */
class SystemConfig extends BaseModel
{

    protected $table = 'system_config';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'name',
        'value'
    ];
}
