<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'requestable_type',
        'requestable_id',
        'user_id',
        'manager_id',
        'status',
        'comment',
        'actioned_at'
    ];

    const STATUS_SUBMITTED = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;

    protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID when creating a new request
        static::creating(function ($model) {
            $model->request_uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the parent requestable model (device or application).
     */
    public function requestable()
    {
        return $this->morphTo();
    }

    /**
     * User who made the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Manager who processed the request.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
