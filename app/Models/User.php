<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    public function getImageUrl()
    {
        if($this->profile_image){
            if(Storage::disk('local')->exists("public/user_image/" . $this->profile_image)) {
                return asset('storage/user_image')."/".$this->profile_image;
            }
        }
        return asset('backend/assets/img/avatars/avatar.png');

    }

    public static $permissionRoutes = [
        'user-view' => 'user.index',
        'roles-view' => 'roles.index',
        'room-view' => 'rooms.index',
        'category-view' => 'category.index',
        'templates-view' => 'templates.index',
        'items-view' => 'items.index',
        'spa-package-view' => 'spa_package.index',
        'therapist-view' => 'therapist.index',
        'cartype-view' => 'cartype.index',
        'setting-view' => 'setting.index',
        'calendar-view' => 'calendar.index',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function therapist()
    {
        return $this->hasOne(Therapist::class, 'user_id');
    }

    public function branchName()
    {
        return $this->hasOne(Branch::class,'bid','branchid');
    }
}
