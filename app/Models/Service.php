<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = "services";

    // Add all fillable columns including price and status
    protected $fillable = [
        "title",
        "icon",
        "description",
        "link",
        "price",
        "status"
    ];
}
