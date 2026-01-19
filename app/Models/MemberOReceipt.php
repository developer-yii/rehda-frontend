<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberOReceipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_oreceipts';
    protected $primaryKey = 'mor_id';

    public $timestamps = ["mor_created","mor_deleted"];

    const CREATED_AT = 'mor_created';
    const DELETED_AT = 'mor_deleted';
    const UPDATED_AT = NULL;

    // to handle legacy path and new path
    public function getOreceiptPathAttribute()
    {
        if (str_starts_with($this->mor_oreceipt_path, '../')) {
            return str_replace('../', '', $this->mor_oreceipt_path);
        }
        return $this->mor_oreceipt_path;
    }

    protected $fillable = [
        'mor_mid',
        'mor_oreceipt_path',
        'mor_yr',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'mor_mid', 'mid');
    }

    public function memberComp()
    {
        return $this->belongsTo(MemberComp::class, 'mor_mid', 'did');
    }
}
