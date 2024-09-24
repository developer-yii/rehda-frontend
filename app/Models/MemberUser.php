<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_users';
    protected $primaryKey = 'ml_id';

    const CREATED_AT = 'ml_created_at';
    const UPDATED_AT = 'ml_mod_at';
    const DELETED_AT = 'ml_deleted_at';

    protected $fillable = [
        'ml_uid',
        'ml_username',
        'ml_emailadd',
        'ml_pwd',
        'ml_salt',
        'ml_priv',
        'ml_status',
        'ml_temppwd'
    ];

    public function memberUserProfile()
    {
        return $this->belongsTo(MemberUserProfile::class, 'ml_uid', 'up_id');
    }
}
