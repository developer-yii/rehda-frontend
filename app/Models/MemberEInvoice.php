<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberEInvoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_einvoices';
    protected $primaryKey = 'mei_id';

    public $timestamps = ["mei_created","mei_deleted"];

    const CREATED_AT = 'mei_created';
    const DELETED_AT = 'mei_deleted';
    const UPDATED_AT = NULL;

    // to handle legacy path and new path
    public function getEinvoicePathAttribute()
    {
        if (str_starts_with($this->mei_einvoice_path, '../')) {
            return str_replace('../', '', $this->mei_einvoice_path);
        }
        return $this->mei_einvoice_path;
    }

    protected $fillable = [
        'mei_mid',
        'mei_einvoice_path',
        'mei_yr',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'mei_mid', 'mid');
    }

    public function memberComp()
    {
        return $this->belongsTo(MemberComp::class, 'mei_mid', 'did');
    }
}
