<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $table = 'payment_type';
    protected $primaryKey = 'id';

    const DISPLAY_HIDE = 1;
    const DISPLAY_SHOW = 2;
}
