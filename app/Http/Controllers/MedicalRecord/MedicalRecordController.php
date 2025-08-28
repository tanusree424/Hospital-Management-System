<?php

namespace App\Http\Controllers\MedicalRecord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\appointment;
use App\Models\Medical_records;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PDF;
use App\Mail\TestFileUploadedMail;
use Illuminate\Support\Facades\Mail;
class MedicalRecordController extends Controller
{
    public function create($appointment_id)
    {
        $appointment = appointment::findOrFail($appointment_id);
        return view('pages.AdminPages.Doctors.Records.create',compact('appointment'));
    }
    public function store(Request $request)
{
    $request->validate([
        "diagnosis" => "required|string",
        "prescription" => "nullable|string",
        "test_file" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:2048",
        "appointment_id" => "required|exists:appointments,id",
    ]);
   // dd($request->all());
    $filePath = null;
    $fileType = null;

    if ($request->hasFile('test_file')) {
        $fileReq = $request->file('test_file');
        $filePath = $fileReq->store('medical_record', 'public');
        $fileType = $fileReq->getClientOriginalExtension();
    }

    // Fetch appointment
    $appointment = Appointment::findOrFail($request->appointment_id);

    // Determine doctor_id
    $doctorId = (auth()->user()->hasRole('Doctor')) ? auth()->id() : $appointment->doctor_id;

    Medical_records::create([
        "appointment_id" => $appointment->id,
        "patient_id" => $appointment->patient_id,
        "doctor_id" => $doctorId,
        "diagnosis" => $request->diagnosis,
        "prescription" => $request->prescription,
        "test_file" => $filePath,
        "file_type" => $fileType,
    ]);

    return redirect()->back()->with('success', 'Medical record saved successfully.');
}

public function downloadReport(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id',
    ]);

    $record = Medical_records::where('appointment_id', $request->appointment_id)->first();

    if (!$record) {
        return redirect()->back()->with('error', 'Medical record not found.');
    }

    $data = [
        'record' => $record,
        'appointment' => $record->appointment,
        'patient' => $record->appointment->patient->user ?? "GUEST",
        'doctor' => $record->appointment->doctor->user,
    ];

    $pdf = PDF::loadView('pages.AdminPages.Doctors.Records.pdf', $data);

    $filename = 'Report_' . $request->appointment_id . '.pdf';
    return $pdf->download($filename);
}

public function uploadTestFile(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id',
        'test_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $appointment = Appointment::findOrFail($request->appointment_id);

    // Ensure medical record exists
    $medicalRecord = $appointment->medical_record;
    if (!$medicalRecord) {
        return redirect()->back()->with('error', 'Medical record not found for this appointment.');
    }

    // Store the uploaded file
    $file = $request->file('test_file');
    $filePath = $file->store('medical_record', 'public');
    $fileType = $file->getClientOriginalExtension();

    // Update medical record
    $medicalRecord->update([
        'test_file' => $filePath,
        'file_type' => $fileType,
    ]);

    // ✅ Send notification email to patient
    // $patientEmail = $appointment->patient->user->email;
    $patientEmail = "tbasuchoudhury@gmail.com";
    if ($patientEmail) {
        Mail::to($patientEmail)->send(new TestFileUploadedMail($appointment));
    }

    return redirect()->route('appointment.index')->with('success', 'Test file uploaded and email sent.');
}

}
