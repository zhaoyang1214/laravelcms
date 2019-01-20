<?php
namespace App\Models;

class Category extends BaseModel
{

    protected $table = 'category';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'pid',
        'category_model_id',
        'sequence',
        'is_show',
        'type',
        'name',
        'urlname',
        'subname',
        'image',
        'category_tpl',
        'content_tpl',
        'page',
        'keywords',
        'description',
        'seo_content',
        'content_order',
        'expand_id'
    ];

    public static function getAllowList()
    {
        $adminGroupInfo = session('adminGroupInfo');
        $query = self::query();
        if (! ($adminGroupInfo['keep'] & 2)) {
            if (empty($adminGroupInfo['category_ids'])) {
                return [];
            }
            $query->whereIn('id', explode(',', $adminGroupInfo['category_ids']));
        }
        return $query->orderBy('sequence')
            ->get()
            ->toArray();
    }
}
