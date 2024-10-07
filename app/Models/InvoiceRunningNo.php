<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceRunningNo extends Model
{
    use HasFactory;
    protected $table = 'inv_runningno';
    protected $primaryKey = 'irn_id';
    protected $guarded = [];
    public $timestamps = false;
}