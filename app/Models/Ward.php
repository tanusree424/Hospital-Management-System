<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $table = "wards";
    protected $fillable = ["name","capacity","description"];

public function beds() {
    return $this->hasMany(Bed::class);
}

}
