<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'members';
    protected $primaryKey = 'mid';
    public $timestamps = ["m_created_at","m_deleted_at"];

    const CREATED_AT = 'm_created_at';
    const DELETED_AT = 'm_deleted_at';
    const UPDATED_AT = NULL;

    // Add the mass assignable attributes
    protected $fillable = [
        'm_type',
        'm_branch',
        'm_no_p1',
        'm_no_p2',
        'm_no_p3',
        'm_no_p4',
        'm_no_p5',
        'm_approval_at',
        'm_created_at',
    ];

    // Relationship with MemberType
    public function memberType()
    {
        return $this->belongsTo(MemberType::class, 'm_type', 'mt_id');
    }

    // Relationship with MemberComp
    public function memberComps()
    {
        return $this->hasMany(MemberComp::class, 'd_mid', 'mid');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'm_branch', 'bid');
    }

    // Define the relationship to the MemberUserProfile model
    public function userProfiles()
    {
        return $this->hasMany(MemberUserProfile::class, 'up_mid', 'mid');
        // 'up_mid' is the foreign key in the 'member_userprofiles' table
        // 'mid' is the primary key in the 'members' table
    }
}
