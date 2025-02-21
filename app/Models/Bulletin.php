<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bulletin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bulletin';
    protected $primaryKey = 'bu_id';
    public $timestamps = false;

    const CREATED_AT = 'bu_created_at';
    const UPDATED_AT = 'bu_updated_at';
    const DELETED_AT = 'bu_deleted_at';

    protected $guarded = [];
}
