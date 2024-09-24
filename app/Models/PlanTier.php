<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanTier extends Model
{
    use HasFactory;

    protected $table = 'plan_tier';
    protected $primaryKey = 'pt_id';
}
