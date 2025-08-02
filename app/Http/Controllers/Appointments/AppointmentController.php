<?php

namespace App\Http\Controllers\Appointments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\doctor;
use App\Models\patient;
use App\Models\appointment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Medical_records;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $user = auth()->user();

    $doctor = Doctor::where('user_id', $user->id)->first();
    $patient = Patient::where('user_id', $user->id)->first();

    $isDoctor = false;
    $isPatient = false;

    if ($patient) {
        $isPatient = true;
        $appointments = Appointment::where('patient_id', $patient->id)
            ->latest('id')
            ->with('patient.user', 'doctor.user', 'department', 'medical_record')
            ->get();
    } elseif ($doctor) {
        $isDoctor = true;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->latest('id')
            ->with('patient.user', 'doctor.user', 'department', 'medical_record')
            ->get();
    } else {
        // For Admin or other roles
        $appointments = Appointment::latest('id')
            ->with('patient.user', 'doctor.user', 'department', 'medical_record')
            ->get();
    }

    $departments = Department::all();
    $doctors = Doctor::all();
    $patients = Patient::all();

    return view('pages.AdminPages.Appoinments.index', compact(
        'appointments',
        'departments',
        'doctors',
        'patients',
        'isDoctor',
        'isPatient'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $departments = Department::all();
    $patients = Patient::with('user')->get();

    $user = auth()->user();
    $isDoctor = $user->hasRole('Doctor');
    $isPatient = $user->hasRole('patient');

    $doctor = null;
    $patient = null;
    if ($isDoctor) {
        $doctor = \App\Models\Doctor::where('user_id', $user->id)->first();
        // Now you can access $doctor->department->id
        // Example:
        // dd($doctor->department->id);
    }
    if ($isPatient) {
        $patient = \App\Models\patient::where('user_id', $user->id)->first();

    }

    return view('pages.AdminPages.Appoinments.create', compact('departments', 'patients', 'isDoctor', 'doctor', 'isPatient','patient'));
}


//  public function getDoctors($id)
// {
//     $doctors = Doctor::with('user:id,name')->where('department_id', $id)->get(['id', 'user_id']);
//     return response()->json($doctors);
// }
// DoctorController.php
public function getDoctorsByDepartment(Request $request)
{
    $department_id = $request->department_id;
    $doctors = Doctor::where('department_id', $department_id)
        ->with('user') // so you get access to $doctor->user->name
        ->get();

    return response()->json($doctors);
}



    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $validate = Validator::make($request->all(), [
        "department_id" => "required",
        "doctor_id" => "required",
        "patient_id" => "required",
        "appointment_date" => "required|date",
        "appointment_time" => "required|string|max:50"
    ]);

    if ($validate->fails()) {
        return redirect()->route('appointment.create')->withErrors($validate)->withInput();
    }

    $appointments = DB::insert(
        'insert into appointments (doctor_id, patient_id, department_id, appointment_date, appointment_time) values (?, ?, ?, ?, ?)',
        [
            $request->doctor_id,
            $request->patient_id,
            $request->department_id,
            $request->appointment_date,
            $request->appointment_time
        ]
    );

    if ($appointments) {
        return redirect()->route('appointment.index')->with('success', 'Appointment created successfully');
    }
    return redirect()->route('appointment.create')->with('error', 'Failed to create appointment');
}


    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */


public function update(Request $request, $id)
{
    $appointment = Appointment::findOrFail($id);

    // Validation
    $request->validate([
        'department_id' => 'required|exists:departments,id',
        'doctor_id' => 'required|exists:doctors,id',
        'patient_id' => 'required|exists:patients,id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
    ]);

    // Update appointment fields
    $appointment->department_id = $request->department_id;
    $appointment->doctor_id = $request->doctor_id;
    $appointment->patient_id = $request->patient_id;
    $appointment->appointment_date = $request->appointment_date;
    $appointment->appointment_time = $request->appointment_time;

    // If the logged-in user is a Patient, reset status to 'pending'
    if (Auth::user()->hasRole('Patient')) {
        $appointment->status = 'pending';
    }

    $appointment->save();

    return redirect()->back()->with('success', 'Appointment updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return redirect()->route('appointment.index')->with('error','Appointment Not Found');
        }
        $appointment->delete();
        return redirect()->route('appointment.index')->with('success','Appointment Deleted Successfully');
    }
    public function updateStatus(Request $request)
{
    $appointment = Appointment::findOrFail($request->id);

    $appointment->status = $request->status;

    if ($request->status === 'cancelled') {
        // Detect the role of the user cancelling
        $userRole = Auth::user()->roles->pluck('name')->first();
        $appointment->cancelled_by = $userRole;
    }

    $appointment->save();

    return response()->json(['success' => true, 'status' => $appointment->status]);
}


}
