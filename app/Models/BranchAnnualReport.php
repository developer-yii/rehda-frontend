<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchAnnualReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branch_annual_reports';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $guarded = [];

    public function branchName()
    {
        return $this->hasOne(Branch::class,'bid','branchid');
    }
}
