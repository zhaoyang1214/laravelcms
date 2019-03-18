<?php
namespace App\Models;

class Replace extends BaseModel
{

    protected $table = 'replace';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'key',
        'content',
        'num',
        'status'
    ];
}
