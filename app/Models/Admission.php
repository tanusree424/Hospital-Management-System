<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Discharge;
use App\Models\Ward;
use App\Models\Bdes;
use App\Models\Payment;
use App\Models\User;
use App\Models\Doctor;
class Admission extends Model
{
    use HasFactory;
    protected $table = "admissions";
    protected $fillable = ["patient_id",'admission_date','ward_id','bed_id','reason','discharge'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class,'ward_id');
    }
    public function Bed()
    {
        return $this->belongsTo(Bed::class,'bed_id');
    }
    public function discharge()
    {
        return $this->hasOne(Discharge::class);
    }
   public function payments()
{
    return $this->hasMany(\App\Models\Payment::class);
}
public function doctor()
{
    return $this->belongsTo(Doctor::class);
}


}
