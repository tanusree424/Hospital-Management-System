<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\appointment;
use App\Models\feedback;

class patient extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "patients";
    protected $fillable = ['user_id','DOB','gender','phone','patient_image','address','pincode','state','country','post_office','city'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointment()
    {
        return $this->HasMany(appointment::class);
    }
    public function feedback()
    {
        return $this->HasMany(feedback::class);
    }

}
