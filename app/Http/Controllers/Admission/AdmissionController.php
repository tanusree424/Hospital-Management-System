<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discharge;
use App\Models\Admission;
use App\Models\patient;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::with('patient.user','discharge')->paginate(5);
        $patients = patient::all();

        return view('pages.AdminPages.Admission&Discharge.index',compact('admissions','patients'));
    }
    public function store(Request $request)
{
    $request->validate([
        'patient_id'      => 'required|exists:patients,id',
        'ward'            => 'required|string|max:100',
        'bed'             => 'required|string|max:50',
        'admission_date'  => 'required|date',
    ]);

    try {
        \App\Models\Admission::create([
            'patient_id'     => $request->patient_id,
            'ward'           => $request->ward,
            'bed'            => $request->bed,
            'admission_date' => $request->admission_date,
            'reason'         => $request->reason,
            'discharge'      => false,
        ]);

        return redirect()->route('admissions.index')->with('success', 'Patient admitted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to admit patient. ' . $e->getMessage());
    }
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
        'ward' => 'required|string|max:255',
        'bed' => 'required|string|max:255',
        'admission_date' => 'required|date',
        'reason' => 'required|string',
    ]);

    // Update the admission record
    $admission->update($validatedData);

    return redirect()->route('admissions.index')->with('success', 'Admission updated successfully.');
}

}
