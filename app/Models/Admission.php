<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Discharge;

class Admission extends Model
{
    use HasFactory;
    protected $table = "admissions";
    protected $fillable = ["patient_id",'admission_date','ward','bed','reason','discharge'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function discharge()
    {
        return $this->hasOne(Discharge::class);
    }

}
