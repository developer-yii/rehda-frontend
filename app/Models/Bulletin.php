<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $table = 'bulletin';
    protected $primaryKey = 'bu_id';
    public $timestamps = false;

    protected $guarded = [];
}
