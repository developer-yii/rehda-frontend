<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';
    protected $primaryKey = 'pid';
    protected $guarded = [];
    public $timestamps = false;
}