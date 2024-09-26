<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annualreport extends Model
{
    use HasFactory;

    protected $table = 'annual_report';
    protected $primaryKey = 'ar_id';
    public $timestamps = false;

    protected $guarded = [];
}
