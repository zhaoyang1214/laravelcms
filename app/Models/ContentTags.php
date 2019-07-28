<?php
namespace App\Models;

/**
 * App\Models\ContentTags
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentTags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentTags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentTags query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $content_id content表id
 * @property int $tags_id tags表id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentTags whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentTags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ContentTags whereTagsId($value)
 */
class ContentTags extends BaseModel
{

    protected $table = 'content_tags';

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'tags_id'
    ];

    public function addByArr($tagsArr, $contentId)
    {
        $tagsArr = array_map(function ($v) use ($contentId) {
            return [
                'content_id' => $contentId,
                'tags_id' => $v
            ];
        }, $tagsArr);
        return self::insert($tagsArr);
    }
}
