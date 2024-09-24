<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'brand', 'model', 'device_id', 'password', 'status', 'creator_id', 'updater_id', 'uuid'
    ];

    // Automatically generate UUID when creating a new Device
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    // Define a one-to-many relationship with DeviceUser
    public function users()
    {
        return $this->hasMany(DeviceUser::class);
    }

    /**
     * Get all requests for the device.
     */
    public function requests()
    {
        return $this->morphMany(AccessRequest::class, 'requestable');
    }
}
