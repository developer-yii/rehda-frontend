<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paymentdev extends Model
{
    use HasFactory;
    protected $table = 'payments_dev';
    protected $primaryKey = 'pid';
    protected $guarded = [];
    public $timestamps = false;
}