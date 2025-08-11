<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use Carbon\Carbon;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Support\Str;


class DashboardController extends Controller
{
    public function home()
    {
         $departments = Department::all();

        return view('index', compact('departments'));
    }

    public function about()
    {
        return view('pages.about');
    }
    public function services()
    {
        return view('pages.services');
    }
    public function appointment()
    {
        $departments = Department::all();
        return view('pages.appointment', compact('departments'));
    }
public function storeGuest(Request $request)
{
    $validated = $request->validate([
        'department_id'     => 'required|exists:departments,id',
        'doctor_id'         => 'required|exists:doctors,id',
        'name'              => 'required|string|max:255',
        'email'             => 'required|email:rfc,dns',
        'appointment_date'  => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|date_format:g:i A',
    ]);

    // Log the request data
      $appointmentNumber = 'APT-' . strtoupper(Str::random(6));
    Log::info('Guest Appointment Request', $request->all());

    Appointment::create([
        'department_id'     => $validated['department_id'],
        'doctor_id'         => $validated['doctor_id'],
        'name'              => $validated['name'],
        'email'             => $validated['email'],
        'appointment_date'  => Carbon::createFromFormat('m/d/Y', $validated['appointment_date'])->format('Y-m-d'),
        'appointment_time'  => Carbon::createFromFormat('g:i A', $validated['appointment_time'])->format('H:i'),
        'status'            => 'pending',
        'user_type'         => 'Guest',
        'appointment_number' =>$appointmentNumber
    ]);

    return redirect()->route('guest.payment')->with('success', 'Your appointment has been booked! We will contact you soon.');
}
public function getDoctorsByDepartment(Request $request)
{
    $department_id = $request->department_id;
    $doctors = Doctor::where('department_id', $department_id)
        ->with('user') // so you get access to $doctor->user->name
        ->get();

    return response()->json($doctors);
    }

    public function pricing()
    {
        return view('pages.pricing');
    }
    public function testimonial()
    {
        return view('pages.patients');
    }
    public function paymentPage()
    {
         $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    // Create Razorpay order
    $order = $api->order->create([
        'receipt'         => 'rcptid_' . time(),
        'amount'          => 1500 * 100, // in paise
        'currency'        => 'INR',
        'payment_capture' => 1
    ]);

    return view('pages.PaymentPage', [
        'key'     => env('RAZORPAY_KEY'),
        'amount'  => 1500,
        'orderId' => $order['id']
    ]);
      //  return view('pages.PaymentPage');
    }

  public function razorpaySuccess(Request $request)
{
    Log::info('--- Razorpay Success Callback Triggered ---', [
        'incoming_data' => $request->all()
    ]);

    try {
        $payment = Payment::create([
            'patient_id'     => null,
            'appointment_id' => $request->appointment_id ?? null,
            'amount'         => 1500.00,
            'payment_status' => 'Paid',
            'payment_method' => 'Online',
            'transaction_id' => $request->razorpay_payment_id,
            'paid_at'        => now(),
        ]);

        Log::info('Payment record created', [
            'payment' => $payment->toArray()
        ]);

        return redirect()->route('home')->with('success', 'Payment successful!');

    } catch (\Throwable $e) {
        Log::error('Error in razorpaySuccess', [
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString()
        ]);

        return redirect()->route('home')->with('error', 'Payment could not be processed.');
    }
}
}
