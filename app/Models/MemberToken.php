<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberToken extends Model
{
    use HasFactory;

    protected $table = 'member_tokens';
    protected $primaryKey = 'mt_id';
    protected $guarded = [];
    public $timestamps = false;
}