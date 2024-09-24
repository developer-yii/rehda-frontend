<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentPermissionBranch extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'content_perm';
    protected $primaryKey = 'cp_id';

    const CREATED_AT = 'cp_created_at';
    const UPDATED_AT = 'cp_updated_at';
    const DELETED_AT = 'cp_deleted_at';

    protected $guarded = [];

    public function BranchName()
    {
        return $this->hasOne(Branch::class,'bid','cp_branch');
    }
}
