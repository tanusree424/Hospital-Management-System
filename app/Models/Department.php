<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\doctor;

class Department extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "departments";
    protected $fillable = ["name","description"];

    public function doctors()
    {
      return  $this->hasMany(doctor::class);
    }
}
