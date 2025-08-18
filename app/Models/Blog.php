<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Admin;
use App\Models\Comment;

class Blog extends Model
{
    use HasFactory;
    protected $table = "blogs";

   // protected $fillable = ["title",''];
   public $guarded =[];


   public function doctor()
   {
    return $this->belongsTo(Doctor::class , 'author_id');
   }
   public function author()
{
    return $this->belongsTo(User::class, 'author_id'); // 'author' column holds the user_id
}


   public function admin()
   {
    return $this->belongsTo(Admin::class, 'author_id');
   }
   public function comments()
{
    return $this->hasMany(Comment::class);
}
}


