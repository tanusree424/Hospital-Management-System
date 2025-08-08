<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\doctor;
use App\Models\patient;
use App\Models\Medical_records;
class appointment extends Model
{
    use HasFactory;
    protected $table="appointments";
    protected $fillable = ["doctor_id","patient_id","department_id","appointment_date","appointment_time","status"];

    public function department()
    {

        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(patient::class);
    }
    // In App\Models\Appointment.php
public function medical_record()
{
    return $this->hasOne(Medical_records::class, 'appointment_id');
}
public function payment()
{
    return $this->hasOne(Payment::class);
}

}
