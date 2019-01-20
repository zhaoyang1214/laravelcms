<?php
namespace App\Models;

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
        'where',
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
}
