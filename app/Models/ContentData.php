<?php
namespace App\Models;

/**
 * App\Models\ContentData
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentData query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $content_id content表id
 * @property string $content
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentData whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentData whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentData whereId($value)
 */
class ContentData extends BaseModel
{

    protected $table = 'content_data';

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'content'
    ];
}
