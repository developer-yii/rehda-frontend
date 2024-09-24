<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circular extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'circular';
    protected $primaryKey = 'ar_id';

    const CREATED_AT = 'ar_created_at';
    const UPDATED_AT = 'ar_updated_at';
    const DELETED_AT = 'ar_deleted_at';

    protected $guarded = [];

    public function branchName()
    {
        return $this->hasOne(Branch::class,'bid','ar_branchid');
    }

}
