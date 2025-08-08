<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use App\Models\Admission;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::get();

        return view('pages.AdminPages.Payment.index',compact('payments'));
    }

public function create($admission_id)
{
    $admission = Admission::with('patient')->findOrFail($admission_id);
    $amount = $admission->amount ?? 1000;

    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

    $order = $api->order->create([
        'receipt'         => Str::random(10),
        'amount'          => $amount * 100, // amount in paise
        'currency'        => 'INR',
    ]);

    return view('pages.AdminPages.Payment.rozerpay', [
        'order_id' => $order['id'],
        'amount'   => $amount,
        'admission_id' => $admission_id,
        'admission'=>$admission,
        'razorpay_key' => config('services.razorpay.key'),
    ]);
}
public function razorpaySuccess(Request $request)
{
    $admission = Admission::findOrFail($request->admission_id);

    $patientId = null;

    if (auth()->check() && auth()->user()->patient) {
        $patientId = auth()->user()->patient->id;
    } elseif ($request->has('patient_id')) {
        $patientId = $request->patient_id;
    }

    if (!$patientId) {
        return redirect()->back()->with('error', 'Patient information is missing.');
    }

    Payment::create([
        'admission_id'   => $request->admission_id,
        'patient_id'     => $patientId,
        'amount'         => $admission->amount,
        'payment_status' => 'Paid',
        'payment_method' => $request->razorpay_method, // e.g., "upi", "card", etc.
        'transaction_id' => $request->razorpay_payment_id,
        'paid_at'        => now(),
    ]);

    return redirect()->route('admission.index')->with('success', 'Payment successful.');
}



public function razorpayPayLater(Request $request)
{
    $payment = Payment::create([
        'admission_id'   => $request->admission_id,
        'patient_id'     => auth()->check() && auth()->user()->patient ? auth()->user()->patient->id : $request->patient_id,
        'amount'         => Admission::findOrFail($request->admission_id)->amount,
        'payment_status' => 'Pending',
        'payment_method' => 'Pay Later',
        'transaction_id' => 'RPYTXN_' . strtoupper(Str::random(10)),
    ]);

    return redirect()->route('admission.index')->with('success', 'Payment marked as Pay Later.');
}
public function paymentInfo($payment_id)
{
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    try {
        $payment = $api->payment->fetch($payment_id);

        return response()->json([
            'method' => $payment->method
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Payment not found'], 404);
    }
}






}
