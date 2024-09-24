<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'oid';

    const CREATED_AT = 'order_created_at';
    const UPDATED_AT = 'order_updated_at';
    const DELETED_AT = 'order_deleted_at';

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status');
    }

    // Define the relationship to MemberComp
    public function memberComp()
    {
        return $this->belongsTo(MemberComp::class, 'order_mid', 'did');
    }
}
