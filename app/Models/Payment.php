<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use App\Models\Admission;
class Payment extends Model
{
    use HasFactory;

    protected $table = "payments";

    protected $fillable = [
        'patient_id',
        'admission_id',
        'appointment_id',
        'amount',
        'payment_status',
        'payment_method',
        'transaction_id',
        'paid_at',
        'notes',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

      public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }
}
