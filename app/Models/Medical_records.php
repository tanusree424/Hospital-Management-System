<?php
// app/Models/Medical_records.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medical_records extends Model
{
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'diagnosis',
        'prescription',
        'test_file',
        'file_type',
    ];
    protected $table = "medical_records";
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
