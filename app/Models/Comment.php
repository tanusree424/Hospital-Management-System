<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";

    protected $fillable = ['blog_id', 'user_id', 'content'];

    public function blog()
{
    return $this->belongsTo(Blog::class);
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

