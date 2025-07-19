<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admission;

class Discharge extends Model
{
    use HasFactory;
    protected $table = "discharges";
    protected $fillable = ["admission_id","discharge_date","discharge_summary"];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
