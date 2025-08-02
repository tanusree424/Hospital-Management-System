<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class feedback extends Model
{
    protected $table = "feedback";
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'rating',
        'message',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
