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
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentBookedMail;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\User;
use Razorpay\Api\Api;
use Yajra\DataTables\Facades\DataTables;


use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;
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
    $payments = Payment::get();
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
        $appointments = Appointment::with('payment')->latest('id')
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
        'doctor',
        'patients',
        'patient',
        'isDoctor',
        'isPatient',
        'payments'
    ));
}
// public function index(Request $request)
// {
//     $user = auth()->user();
//     $doctor = Doctor::where('user_id', $user->id)->first();
//     $patient = Patient::where('user_id', $user->id)->first();

//     $isDoctor = false;
//     $isPatient = false;

//     if ($patient) {
//         $isPatient = true;
//         $appointmentsQuery = Appointment::where('patient_id', $patient->id)
//             ->with(['patient.user', 'doctor.user', 'department', 'medical_record', 'payment'])
//             ->latest('id');
//     } elseif ($doctor) {
//         $isDoctor = true;
//         $appointmentsQuery = Appointment::where('doctor_id', $doctor->id)
//             ->with(['patient.user', 'doctor.user', 'department', 'medical_record', 'payment'])
//             ->latest('id');
//     } else {
//         $appointmentsQuery = Appointment::with(['patient.user', 'doctor.user', 'department', 'medical_record', 'payment'])
//             ->latest('id');
//     }

//     // ✅ If AJAX request → return JSON
//     if ($request->ajax()) {
//         return DataTables::of($appointmentsQuery)
//     ->addColumn('patient', fn($row) => $row->patient->user->name ?? '')
//     ->addColumn('department', fn($row) => $row->department->name ?? '')
//     ->addColumn('status', fn($row) => view('appointments.partials.status', compact('row'))->render())
//     ->addColumn('actions', fn($row) => view('appointments.partials.actions', compact('row'))->render())
//     ->addColumn('report', fn($row) => view('appointments.partials.report', compact('row'))->render())
//     ->addColumn('pay_now', fn($row) => view('appointments.partials.paynow', compact('row'))->render())
//     ->addColumn('download_receipt', fn($row) => view('appointments.partials.download', compact('row'))->render())
//     ->rawColumns(['status','actions','report','pay_now','download_receipt'])
//     ->make(true);
//     }

//     // ✅ For normal page load → get actual collection so Blade has $appointments
//     $appointments = $appointmentsQuery->get();

//     $departments = Department::all();
//     $doctors = Doctor::all();
//     $patients = Patient::all();
//     $payments = Payment::all();

//     return view('pages.AdminPages.Appoinments.index', compact(
//         'appointments',
//         'departments',
//         'doctors',
//         'patients',
//         'isDoctor',
//         'isPatient',
//         'payments'
//     ));
// }


public function getAppointments()
{
    $user = auth()->user();
    $userRole = $user->roles->pluck('name')->first();

    // Use Eloquent query builder with relations needed
    $query = Appointment::with(['patient.user', 'department', 'doctor.user' ])
        ->select('appointments.*');
    if ($userRole === "Patient") {
         $query = Appointment::with(['patient.user', 'department', 'doctor.user' ])->where('patient_id', $user->patient->id)
        ->select('appointments.*');
    }
    if ($userRole === "Doctor") {
         $query = Appointment::with(['patient.user', 'department', 'doctor.user' ])->where('doctor_id', $user->doctor->id)
        ->select('appointments.*');
    }

    return DataTables::eloquent($query)
        ->addIndexColumn() // Adds an auto index column (serial number)
        ->addColumn('patient', function($row) {
            return $row->patient && $row->patient->user
                ? $row->patient->user->name
                : 'Guest';
        })
        ->addColumn('department', function($row) {
            return $row->department ? $row->department->name : '';
        })
        ->addColumn('status', function($row) use ($userRole) {
            $status = $row->status ?? 'pending';

            // Build status button + dropdown html as in Blade
            $btnClass = match($status) {
                'approved' => 'btn-success',
                'completed' => 'btn-primary',
                'cancelled' => 'btn-danger',
                default => 'btn-secondary'
            };

            $html = '';

            if (in_array($status, ['completed', 'cancelled'])) {
                // Just button, disabled
                $html .= "<button class='btn $btnClass' disabled>" . ucfirst($status) . "</button>";

                if ($status === 'cancelled' && $row->cancelled_by) {
                    $html .= "<br><small class='text-muted'>(By " . ucfirst($row->cancelled_by) . ")</small>";
                }
            } else {
                // Button + dropdown for pending or approved
                $html .= "<div class='dropdown'>";
                $html .= "<button class='btn $btnClass dropdown-toggle' data-bs-toggle='dropdown'>"
                    . ucfirst($status) . "</button>";

                $html .= "<ul class='dropdown-menu'>";
                if ($userRole === 'Patient' && is_null($row->cancelled_by)) {
                    $html .= "<li><a class='dropdown-item status-option' href='#' data-id='{$row->id}' data-status='cancelled'>Cancel</a></li>";
                } elseif ($userRole !== 'Patient') {
                    if ($status !== 'approved') {
                        $html .= "<li><a class='dropdown-item status-option' href='#' data-id='{$row->id}' data-status='approved'>Approve</a></li>";
                    }
                    $html .= "<li><a class='dropdown-item status-option' href='#' data-id='{$row->id}' data-status='completed'>Completed</a></li>";

                    if (is_null($row->cancelled_by)) {
                        $html .= "<li><a class='dropdown-item status-option' href='#' data-id='{$row->id}' data-status='cancelled'>Cancel</a></li>";
                    }
                }
                $html .= "</ul>";
                $html .= "</div>";
            }
            return $html;
        })
        ->addColumn('actions', function($row) use ($userRole) {
            $buttons = '';

            // View button
            $buttons .= "<button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#viewModal{$row->id}'>
                <i title='View Appointment' class='bi bi-eye'></i></button> ";

            // Edit button - only if not completed/cancelled
            if (!in_array($row->status, ['completed', 'cancelled'])) {
                $buttons .= "<button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal{$row->id}'>
                    <i title='Edit Appointment' class='bi bi-pencil'></i></button> ";
            } else {
                $buttons .= "<button class='btn btn-warning btn-sm' disabled><i class='bi bi-pencil'></i></button> ";
            }

            // Delete form button - only if user is NOT patient and appointment not completed/cancelled
            if ($userRole !== 'Patient' && !in_array($row->status, ['completed', 'cancelled'])) {
                $buttons .= '<form action="'. route('appointment.destroy', $row->id) .'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button class="btn btn-danger btn-sm"><i title="Delete Appointment" class="bi bi-trash"></i></button>'
                    . '</form>';
            }

            return $buttons;
        })
        ->addColumn('report', function($row) {
            if ($row->status === 'cancelled') {
                return "<span class='badge bg-danger'>Cancelled by " . ucfirst($row->cancelled_by ?? 'Unknown') . "</span>";
            }
            if ($row->status === 'approved') {
                return "<span class='badge bg-warning'>Please complete the appointment</span>";
            }
            if ($row->status === 'pending') {
                return "<span class='badge bg-info text-danger'>Please approve the appointment</span>";
            }
            if ($row->medical_record) {
                return '<form action="'. route('medical_record.download') .'" method="POST" style="display:inline;">'
                    . csrf_field()
                    . '<input type="hidden" name="appointment_id" value="'. $row->id .'">'
                    . '<button type="submit" class="btn btn-sm btn-primary">Download</button>'
                    . '</form>';
            }
            return '<form action="'. route('medical_record.create', $row->id) .'" method="GET" style="display:inline;">'
                . '<button type="submit" class="btn btn-sm btn-success">Create Report</button>'
                . '</form>';
        })
        ->addColumn('pay_now', function($row) {
            // You need to pass payments collection or query to check payment status (adjust accordingly)
            $payment = $row->payment()->whereNotNull('transaction_id')->first();
            if ($payment) {
                return "<button class='btn btn-success' disabled><i class='bi bi-check-circle-fill' title='Already Paid'></i></button>";
            }
            elseif ($row->status === "cancelled")
                return "<div class='badge bg-danger'>Appointment Already Cancelled</div>";
            return '<form action="'. route('appointment.payment.process', $row->id) .'" method="POST">'
                . csrf_field()
                . '<input type="hidden" name="appointment_id" value="'. $row->id .'">'
                . '<input type="hidden" name="patient_id" value="'. ($row->patient?->id ?? '') .'">'
                . '<input type="hidden" name="payment_mode" value="online">'
                . '<button class="btn btn-outline-warning text-dark"><i title="Pay Now" class="bi bi-wallet2 me-1"></i></button>'
                . '</form>';
        })
        ->addColumn('download_receipt', function($row) {
            $payment = $row->payment()->whereNotNull('transaction_id')->first();
            if ($payment) {
                return '<a href="'. route('appointment.receipt.download', $row->id) .'" class="btn btn-sm btn-outline-success" title="Download Receipt">'
                    . '<i class="bi bi-receipt-cutoff me-1"></i> Receipt</a>';
            }
            elseif ($row->status === "cancelled")
                return "<div class='badge bg-danger'>Appointment Already Cancelled</div>";
            return '';
        })
        ->rawColumns(['status', 'actions', 'report', 'pay_now', 'download_receipt'])
        ->make(true);
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
    $validated = $request->validate([
        'department_id'     => 'required|exists:departments,id',
        'doctor_id'         => 'required|exists:doctors,id',
        'appointment_date'  => 'required|date',
        'appointment_time'  => 'required',
        'name'              => auth()->check() ? 'nullable' : 'required|string|max:255',
        'email'             => auth()->check() ? 'nullable|email' : 'required|email',
    ]);

    // Determine patient ID (null for guest users)
    $patientId = auth()->check() && auth()->user()->patient
        ? auth()->user()->patient->id
        : $request->patient_id;

    // Create appointment
    $appointment = Appointment::create([
        'doctor_id'        => $request->doctor_id,
        'patient_id'       => $patientId,
        'user_type'        => $patientId ? 'Patient' : 'Guest',
        'name'             => $patientId ? null : $request->name,
        'email'            => $patientId ? null : $request->email,
        'department_id'    => $request->department_id,
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $request->appointment_time,
        'status'           => 'pending',
        'appointment_number' => 'APT-' . strtoupper(uniqid()),
    ]);

    // Send confirmation email (to guest email or patient email)
    $recipientEmail = $appointment->email
    ?? optional($appointment->patient->user)->email
    ?? 'tanubasuchoudhury1997@gmail.com';

    if ($recipientEmail) {
        Mail::to($recipientEmail)->send(new AppointmentBookedMail($appointment, $appointment->appointment_number));
    }

    return redirect()->route('appointment.payment', $appointment->id)->with('success', 'Your appointment has been booked successfully!');
}
public function showPayment($id)
{
    $appointment = Appointment::with('doctor.user', 'department')->findOrFail($id);

    return view('pages.AdminPages.Appoinments.payment', compact('appointment'));
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
// public function processPayment(Request $request, $id)
// {
//     $appointment = Appointment::findOrFail($id);

//     // Check if payment already exists for this appointment
//     $existingPayment = Payment::where('appointment_id', $appointment->id)
//         ->where('payment_status', 'Paid')
//         ->first();

//     if ($existingPayment) {
//         return redirect()->back()->with('info', 'Payment already completed for this appointment.');
//     }

//     // Razorpay credentials
//     $api_key = config('services.razorpay.key');
//     $api_secret = config('services.razorpay.secret');
//     $api = new Api($api_key, $api_secret);

//     // Razorpay order data
//     $orderData = [
//         'receipt' => 'RCPT-' . $appointment->appointment_number,
//         'amount' => 150000, // ₹1500 in paise
//         'currency' => 'INR',
//         'payment_capture' => 1
//     ];

//     // Create Razorpay order
//     $razorpayOrder = $api->order->create($orderData);

//     // Store the Razorpay order in DB with pending status
//     Payment::create([
//         'appointment_id' => $appointment->id,
//         'patient_id' => $appointment->patient->id ?? auth()->user()->patient->id ?? null,
//         'amount' => 1500,
//         'payment_status' => 'Pending',
//         'payment_method' => 'Razorpay',
//         'paid_at'=>now(),
//         'transaction_id' => $razorpayOrder->id, // Razorpay order ID
//     ]);

//     // Return the payment gateway blade
//     return view('pages.AdminPages.Appoinments.payment-gateway', [
//         'order' => $razorpayOrder,
//         'appointment' => $appointment,
//         'api_key' => $api_key,
//     ]);
// }
public function processPayment(Request $request, $id)
{
    $appointment = Appointment::findOrFail($id);

    // ✅ Check if payment already exists and is Paid
    $existingPayment = Payment::where('appointment_id', $appointment->id)
        ->where('payment_status', 'Paid')
        ->first();

    if ($existingPayment) {
        return redirect()->back()->with('info', 'Payment already completed for this appointment.');
    }

    // ✅ If "After Admission" button clicked
    if ($request->payment_mode === 'after_admission') {
        // Check if a pending payment already exists
        $pendingPayment = Payment::where('appointment_id', $appointment->id)
            ->where('payment_status', 'Pending')
            ->first();

        if (!$pendingPayment) {
            Payment::create([
                'appointment_id' => $appointment->id,
                'patient_id'     => $appointment->patient->id ?? auth()->user()->patient->id ?? null,
                'amount'         => 1500, // Can be dynamic
                'payment_status' => 'Pending',
                'payment_method' => 'After Admission',
                'notes'          => 'Payment will be collected at the time of admission/appointment',
            ]);
        }

        // Update appointment status if needed
        $appointment->update(['payment_status' => 'Payment Pending']);

        return redirect()
            ->route('appointment.index', $appointment->id)
            ->with('success', 'Payment marked as pending for this appointment.');
    }

    // ✅ Otherwise, process Razorpay Online Payment
    $api_key = config('services.razorpay.key');
    $api_secret = config('services.razorpay.secret');
    $api = new Api($api_key, $api_secret);

    $orderData = [
        'receipt'         => 'RCPT-' . $appointment->appointment_number,
        'amount'          => 1500 * 100, // ₹1500 in paise
        'currency'        => 'INR',
        'payment_capture' => 1
    ];

    $razorpayOrder = $api->order->create($orderData);

    // Store the pending online payment
    Payment::create([
        'appointment_id' => $appointment->id,
        'patient_id'     => $appointment->patient->id ?? auth()->user()->patient->id ?? null,
        'amount'         => 1500,
        'payment_status' => 'Pending',
        'payment_method' => 'Razorpay',
        'transaction_id' => $razorpayOrder->id,
    ]);

    // Show payment gateway page
    return view('pages.AdminPages.Appoinments.payment-gateway', [
        'order'       => $razorpayOrder,
        'appointment' => $appointment,
        'api_key'     => $api_key,
    ]);
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
public function paymentSuccess(Request $request)
{
    $appointmentId = $request->appointment_id;
    $patientId = $request->patient_id;

    // Find payment by appointment_id
    $payment = Payment::where('appointment_id', $appointmentId)->first();

    $data = [
        'patient_id'        => $patientId,
        'amount'            => 1500, // Or $request->amount if you send it
        'payment_status'    => 'Paid',
        'payment_method'    => 'Online',
        'transaction_id'    => $request->razorpay_payment_id,
        'paid_at'           => now(),
        'notes'             => null, // Or set a value if needed
        'updated_at'        => now(),
    ];

    if ($payment) {
        // Update existing payment (keeping admission_id untouched)
        $payment->update($data);
    } else {
        // Create new payment
        $data['appointment_id'] = $appointmentId;
        Payment::create($data);
    }

    return redirect()
        ->route('appointment.index')
        ->with('success', 'Payment successful.');
}



public function downloadReceipt($id)
{
    $appointment = Appointment::with('patient.user', 'doctor.user', 'payment')->findOrFail($id);

    $payment = $appointment->payment;

    if (!$payment || !$payment->transaction_id) {
        return redirect()->back()->with('error', 'Payment not completed. Receipt cannot be downloaded.');
    }

    $pdf = Pdf::loadView('pages.AdminPages.Appoinments.receipt-pdf', compact('appointment', 'payment'));
    return $pdf->download('appointment_receipt.pdf');
}





// public function handlePaymentSuccess(Request $request)
// {
//     // Optional: verify signature here

//     Payment::create([
//         'patient_id' => $request->patient_id,
//         'admission_id' => null,
//         'appointment_id' => $request->appointment_id,
//         'amount' => $request->amount / 100,
//         'payment_status' => 'Paid',
//         'payment_method' => 'Razorpay',
//         'transaction_id' => $request->razorpay_payment_id,
//         'paid_at' => now(),
//     ]);

//     // $appointment = Appointment::find($request->appointment_id);
//     // $appointment->payment_status = 'Paid';
//     // $appointment->save();

//     return redirect()->route('appointment.index')->with('success', 'Payment successful.');
// }


public function show($id)
{
    $appointment = Appointment::findOrFail($id);
    return view('appointments.show', compact('appointment'));
}


}
