<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentPermissionMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'content_mperm';
    protected $primaryKey = 'cm_id';

    const CREATED_AT = 'cm_created_at';
    const UPDATED_AT = 'cm_updated_at';
    const DELETED_AT = 'cm_deleted_at';

    protected $guarded = [];

    public function memberTypeName()
    {
        return $this->hasOne(MemberType::class,'mt_id','cm_membertype');
    }
}
