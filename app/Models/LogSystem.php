<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSystem extends Model
{
    use HasFactory;

    protected $table = 'log_system';

    // const CREATED_AT = 'datetime';
    // const UPDATED_AT = null;
    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'activity',
        'record',
        'page',
        'datetime'
    ];
}
