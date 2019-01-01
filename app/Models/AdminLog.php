<?php
namespace App\Models;

class AdminLog extends BaseModel
{

    protected $table = 'admin_log';

    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'logintime',
        'ip'
    ];
}
