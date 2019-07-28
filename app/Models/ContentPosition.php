<?php
namespace App\Models;

/**
 * App\Models\ContentPosition
 *
 * @property int $id
 * @property int $content_id content表id
 * @property int $position_id position表id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentPosition whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentPosition wherePositionId($value)
 * @mixin \Eloquent
 */
class ContentPosition extends BaseModel
{

    protected $table = 'content_position';

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'position_id'
    ];

    public function addByArr($positionArr, $contentId)
    {
        $positionArr = array_map(function ($v) use ($contentId) {
            return [
                'content_id' => $contentId,
                'position_id' => $v
            ];
        }, $positionArr);
        return self::insert($positionArr);
    }
}
