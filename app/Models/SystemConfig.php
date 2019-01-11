<?php
namespace App\Models;

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
