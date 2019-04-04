<?php
namespace App\Models;

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
