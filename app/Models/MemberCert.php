<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberCert extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_certs';
    protected $primaryKey = 'mc_id';

    public $timestamps = ["mc_created","mc_deleted"];

    const CREATED_AT = 'mc_created';
    const DELETED_AT = 'mc_deleted';
    const UPDATED_AT = NULL;

    // to handle legacy path and new path
    public function getCertificatePathAttribute()
    {
        if (str_starts_with($this->mc_cert_path, '../')) {
            return str_replace('../', '', $this->mc_cert_path);
        }
        return $this->mc_cert_path;
    }
}
