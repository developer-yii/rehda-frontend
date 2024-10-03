<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paper extends Model
{
    use HasFactory;
    protected $table = 'papers';
    protected $primaryKey = 'ar_id';
    protected $guarded = [];
}