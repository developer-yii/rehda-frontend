<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberUserProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_userprofiles';
    protected $primaryKey = 'up_id';
    const CREATED_AT = 'up_created_at';
    const UPDATED_AT = 'up_mod_at';
    const DELETED_AT = 'up_deleted_at';

    public function memberComp()
    {
        return $this->belongsTo(MemberComp::class, 'up_mid', 'did');
    }

    // You can also define the relationship with MemberUser
    public function memberUser()
    {
        return $this->hasOne(MemberUser::class, 'ml_uid', 'up_id');
    }

    public function memberUserNew()
    {
        return $this->belongsTo(MemberUser::class, 'up_id', 'ml_uid');
    }

    protected $guarded = [];
}
