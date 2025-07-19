<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;


class doctor extends Model
{
    use HasFactory;
    protected $table ="doctors";
    protected $fillable = [
    'user_id', 'qualifications', 'phone', 'department_id', 'profile_picture'
];


    public function user()
    {
       return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
