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
        'patients',
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
    $userRole = auth()->user()->role->name; // ✅ define it here

    $appointments = Appointment::with('doctor', 'patient')->get();

    return datatables()->of($appointments)
        ->addColumn('patient', fn($row) => $row->patient->user->name ?? '')
        ->addColumn('department', fn($row) => $row->department->name ?? '')
        ->addColumn('status', function($row) use ($userRole) {
            $html = "<select class='form-select form-select-sm status-dropdown' data-id='{$row->id}'>";

            if ($userRole === 'Patient' && is_null($row->cancelled_by)) {
                $html .= "<option value='cancelled' " . ($row->status === 'cancelled' ? 'selected' : '') . ">Cancel</option>";
            }
            elseif ($userRole !== 'Patient') {
                if ($row->status !== 'approved') {
                    $html .= "<option value='approved' " . ($row->status === 'approved' ? 'selected' : '') . ">Approve</option>";
                }
                $html .= "<option value='completed' " . ($row->status === 'completed' ? 'selected' : '') . ">Completed</option>";
                if (is_null($row->cancelled_by)) {
                    $html .= "<option value='cancelled' " . ($row->status === 'cancelled' ? 'selected' : '') . ">Cancel</option>";
                }
            }

            $html .= "</select>";
            return $html;
        })
        ->addColumn('actions', fn($row) => '<button class="btn btn-primary btn-sm">View</button>')
        ->addColumn('report', fn($row) => '<a href="#" class="btn btn-info btn-sm">Report</a>')
        ->addColumn('pay_now', fn($row) => '<a href="#" class="btn btn-success btn-sm">Pay</a>')
        ->addColumn('download_receipt', fn($row) => '<a href="#" class="btn btn-warning btn-sm">Download</a>')
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
    $validate = Validator::make($request->all(), [
        "department_id" => "required",
        "doctor_id" => "nullable",
        "patient_id" => "required",
        "appointment_date" => "required|date",
        "appointment_time" => "required|string|max:50"
    ]);

    if ($validate->fails()) {
        return redirect()->route('appointment.create')
                         ->withErrors($validate)
                         ->withInput();
    }

    $appointmentNumber = 'APT-' . strtoupper(Str::random(6));
    $patient_id  = $request->patient_id;
    $appointmentId = DB::table('appointments')->insertGetId([
       'doctor_id' => !empty($request->doctor_id) ? $request->doctor_id : 1,
        'patient_id' => $request->patient_id,
        'department_id' => $request->department_id,
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $request->appointment_time,
        'appointment_number' => $appointmentNumber,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $appointment = Appointment::with(['patient.user', 'doctor.user', 'department'])->find($appointmentId);

    if ($appointment) {
        // 📧 Email fallback logic
        $fallbackEmail = "tbasuchoudhury@gmail.com";
        $emailToSend = optional($appointment->patient->user)->email ?? $fallbackEmail;

        try {
            Mail::to($emailToSend)->send(new AppointmentBookedMail($appointment, $appointmentNumber));
        } catch (\Exception $e) {
            \Log::error("Email sending failed: " . $e->getMessage());
        }

        // 📲 WhatsApp via Twilio
        try {
            $whatsappMessage = "🙏 Thank you for Booking Appointment!\nAppointment No: $appointmentNumber\nhas been booked.\n\nTeam - Medinova Hospital";

            $whatsappNumber = optional($appointment->patient)->phone ?? '9332819707';
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $twilio->messages->create(
                "whatsapp:+91{$whatsappNumber}",
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'body' => $whatsappMessage
                ]
            );
        } catch (\Exception $e) {
            \Log::error("WhatsApp send failed: " . $e->getMessage());
        }

        // 🔁 Redirect to Razorpay Payment Page
        return redirect()->route('appointment.payment', ['id' => $appointment->id  ,'patient_id' => $patient_id  ]);
    }

    return redirect()->route('appointment.create')->with('error', 'Failed to create appointment');
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
