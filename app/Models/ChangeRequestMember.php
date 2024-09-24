<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequestMember extends Model
{
    use HasFactory;

    protected $table = 'requestchg_member';
    protected $primaryKey = 'rc_id';

    public $timestamps = ["rc_created_at","rc_mod_at"];

    const CREATED_AT = 'rc_created_at';
    const UPDATED_AT = 'rc_mod_at';
    const DELETED_AT = NULL;

    const STATUS_NEW = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_REJECTED = 3;

    public function memberUserProfile()
    {
        return $this->belongsTo(MemberUserProfile::class, 'rc_uid', 'up_id');
    }
}
