<?php

namespace App\Http\Controllers\Discharge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bed;
use App\Models\Admission;
use App\Models\Patient;
use App\Models\Discharge;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PatientDischargedMail;
use Illuminate\Support\Facades\Log;


class DischargeController extends Controller
{
public function store(Request $request)
{
    Log::info('Discharge store method called.');
    Log::info('Incoming request data:', $request->all());

    $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'admission_id' => 'required|exists:admissions,id',
        'bed_id' => 'required|exists:beds,id',
        'discharge_date' => 'required|date',
        'discharge_reason' => 'nullable|string',
    ]);

    Log::info('Validation passed.');

    $discharge = Discharge::create([
        'patient_id' => $request->patient_id,
        'admission_id' => $request->admission_id,
        'discharge_date' => $request->discharge_date,
        'discharge_summary' => $request->discharge_reason,
    ]);
    Log::info('Discharge created:', $discharge->toArray());

    $bed = Bed::find($request->bed_id);
    if ($bed) {
        $bed->update(['status' => 'available']);
        Log::info("Bed #{$bed->id} marked as available.");
    }

    $admission = Admission::find($request->admission_id);
    if ($admission) {
        $admission->update(['discharge' => 1]);
        Log::info("Admission #{$admission->id} marked as discharged.");
    }

    $patient = Patient::with('user')->findOrFail($request->patient_id);
    Log::info('Patient info loaded:', $patient->toArray());

    $pdf = Pdf::loadView('pdf.discharge_summary', [
        'discharge' => $discharge,
        'patient' => $patient,
    ]);

    $pdfPath = storage_path('app/public/discharge_summary.pdf');
    $pdf->save($pdfPath);
    Log::info("PDF generated and saved at: $pdfPath");

    // Send email
    Mail::to('tanubasuchoudhury1997@gmail.com')->send(
        new PatientDischargedMail($discharge, $pdfPath)
    );
    Log::info("Email sent with discharge summary.");

    File::delete($pdfPath);
    Log::info("Temporary PDF file deleted.");

    return redirect()->back()->with([
    'discharge_success' => 'Patient discharged successfully and email sent with summary.',
    'patient_id' => $admission->patient->id,  // অথবা $admission->patient_id
]);

}


}
