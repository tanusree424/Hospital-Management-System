<?php

namespace App\Mail;

use App\Models\Discharge;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientDischargedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $discharge;
    public $pdfPath;

    public function __construct($discharge, $pdfPath)
    {
        $this->discharge = $discharge;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Discharge Summary')
                    ->view('emails.patients.discharged')
                    ->attach($this->pdfPath, [
                        'as' => 'discharge_summary.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}

