<?php
namespace App\Models;

class Upload extends BaseModel
{

    protected $table = 'upload';

    public $timestamps = false;

    protected $fillable = [
        'file',
        'folder',
        'title',
        'ext',
        'size',
        'type',
        'time',
        'module'
    ];
}
