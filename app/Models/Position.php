<?php
namespace App\Models;

/**
 * App\Models\Position
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 名称
 * @property int $sequence 排序，升序
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Position whereSequence($value)
 */
class Position extends BaseModel
{

    protected $table = 'position';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'sequence'
    ];
}
