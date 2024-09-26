<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MemberUser extends Authenticatable
{
    use HasFactory, SoftDeletes, CanResetPassword, Notifiable;

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

    public function getAuthIdentifierName()
    {
        return 'ml_emailadd'; // Use 'emailadd' instead of 'email'
    }

    public function getEmailForPasswordReset()
    {
        return $this->emailadd; // Return the 'emailadd' field for password resets
    }

    public function getImageUrl()
    {
        if($this->profile_image){
            if(Storage::disk('local')->exists("public/user_image/" . $this->profile_image)) {
                return asset('storage/user_image')."/".$this->profile_image;
            }
        }
        return asset('backend/assets/img/avatars/avatar.png');

    }
}
