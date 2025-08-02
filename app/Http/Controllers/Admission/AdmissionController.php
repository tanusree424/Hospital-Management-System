<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discharge;
use App\Models\Admission;
use App\Models\patient;
use App\Models\Ward;
use App\Models\Bed;

class AdmissionController extends Controller
{
    public function index()
{
    // Get all current admissions with relationships
    $admissions = Admission::with(['patient.user', 'discharge', 'ward', 'bed'])->get();

    // Get IDs of currently admitted patients (no discharge record)
    $admittedPatientIds = Admission::doesntHave('discharge')->pluck('patient_id');

    // Get available patients (not currently admitted)
    $availablePatients = Patient::whereNotIn('id', $admittedPatientIds)->with('user')->get();

    // Get wards and beds
    $wards = Ward::all();
      $beds = Bed::where('status', 'available')->get();
    $patients = Patient::all();

    return view('pages.AdminPages.Admission&Discharge.index', compact(
        'admissions', 'availablePatients', 'beds', 'wards' ,
        'patients'
    ));
}

public function store(Request $request)
{
    $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'admission_date' => 'required|date',
        'ward_id' => 'required|exists:wards,id',
        'bed_id' => 'required|exists:beds,id',
        'reason' => 'required|string',
    ]);

    // Create admission
    Admission::create([
        'patient_id' => $request->patient_id,
        'admission_date' => $request->admission_date,
        'ward_id' => $request->ward_id,
        'bed_id' => $request->bed_id,
        'reason' => $request->reason,
    ]);

    // Mark selected bed as occupied
    Bed::where('id', $request->bed_id)->update(['status' => 'occupied']);

    return back()->with('success', 'Patient admitted and bed marked as occupied.');
}

   public function update($id, Request $request)
{
    $admission = Admission::find($id);

    if (!$admission) {
        return redirect()->route('admissions.index')->with('error', 'Admission record not found.');
    }

    // Validate the form data
    $validatedData = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'ward_id' => 'required|exists:wards,id',
        'bed_id' => 'required|exists:beds,id',
        'admission_date' => 'required|date',
        'reason' => 'required|string',
    ]);


    // Update the admission record
    $admission->update($validatedData);

    return redirect()->route('admission.index')->with('success', 'Admission updated successfully.');
}
public function getBedsByWard(Request $request)
{
    $wardId = $request->ward_id;

    $beds = Bed::where('ward_id', $wardId)
                ->where('status', 'available') // Assuming you have a 'status' column
                ->get(['id', 'bed_number']);

    return response()->json($beds);
}

}
