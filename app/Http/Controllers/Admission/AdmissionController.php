<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Discharge;
use App\Models\Admission;
use App\Models\Patient;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
// use \Razorpay\Api\Api; // ✅ Fully qualified Razorpay class
use Illuminate\Support\Facades\Str;
use Barryvdh\DomPDF\Facade\Pdf;
class AdmissionController extends Controller
{
    public function index()
{
    // Get all current admissions with relationships
    $admissions = Admission::with(['patient.user', 'discharge', 'ward', 'bed','payments'])->get();
    $payment =  Payment::all();
//    dd($payment);

    // Get IDs of currently admitted patients (no discharge record)
    $admittedPatientIds = Admission::doesntHave('discharge')->pluck('patient_id');

    // Get available patients (not currently admitted)
    $availablePatients = Patient::whereNotIn('id', $admittedPatientIds)->with('user')->get();
    $amount = 1500;

    // Get wards and beds
    $wards = Ward::all();
      $beds = Bed::where('status', 'available')->get();
    $patients = Patient::all();

    return view('pages.AdminPages.Admission&Discharge.index', compact(
        'admissions', 'availablePatients', 'beds', 'wards' ,
        'patients',
        'payment',
        'amount'
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

    // 1. Create admission
    $admission = Admission::create([
        'patient_id'     => $request->patient_id,
        'admission_date' => $request->admission_date,
        'ward_id'        => $request->ward_id,
        'bed_id'         => $request->bed_id,
        'reason'         => $request->reason,
    ]);
    $amount =  $request->amount;
    // 2. Mark selected bed as occupied
    Bed::where('id', $request->bed_id)->update(['status' => 'occupied']);

    // 3. Create initial payment record
//    $amount = 5000;

//     $payment = Payment::create([
//         'patient_id'     => $admission->patient_id,
//         'admission_id'   => $admission->id,
//         'amount'         => $amount,
//         'payment_status' => 'Pending',        // Razorpay payment is not yet complete
//         'payment_method' => 'Pay Later',         // Temporary placeholder, actual method (upi, card...) will be updated after Razorpay success
//         'transaction_id' => null,
//         'paid_at'        => null,
//         'notes'          => 'Auto-generated on admission',
//     ]);

    // 4. Send WhatsApp Message to Patient
    try {
        $user = auth()->user();

        if ($user->hasRole('Patient') && $user->patient?->phone) {
            $phone = 'whatsapp:+91' . $user->patient->phone;
            $message = "✅ Your admission has been confirmed.\n💰 Amount: ₹{$amount}\n🔗 Please log in to complete the payment: https://yourportal.com/login";

            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create($phone, [
                'from' => env('TWILIO_WHATSAPP_FROM'),
                'body' => $message
            ]);
        }

    } catch (\Exception $e) {
        \Log::error("WhatsApp Message Failed: " . $e->getMessage());
    }

    // 5. Redirect to Razorpay Payment Page
    return redirect()->route('payments.create', ['admission_id' => $admission->id , 'admission'=>$admission])->with([
        'success' => 'Patient admitted successfully. Proceed to payment.',
        'amount' => $amount,
        'admission_id' => $admission->id,
    ]);
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


public function processAdmissionPayment(Request $request, $admissionId)
{
    $admission = Admission::findOrFail($admissionId);

    if ($request->payment_mode === 'after_admission') {
        // Insert payment record as unpaid
        Payment::create([
            'patient_id'      => $admission->patient_id,
            'admission_id'    => $admission->id,
            'amount'          => $request->amount,
            'payment_status'  => 'Pending',
            'payment_method'  => 'Pay at Admission',
            'appointment_id'  => null,

        ]);

        return redirect()->route('admission.index')->with('success', 'Payment will be collected later.');
    }

    // Online Payment via Razorpay
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    $order = $api->order->create([
        'receipt'         => 'ADM_' . $admission->id,
        'amount'          => $request->amount * 100, // in paise
        'currency'        => 'INR',
        'payment_capture' => 1
    ]);

    return view('pages.AdminPages.Payment.rozerpayPayment', [
        'order' => $order,
        'admission' => $admission,
        'api_key' => env('RAZORPAY_KEY'),
       // 'patient_id'=> $admission->patient->id
    ]);
}
public function storeAdmissionPayment(Request $request)
{
    // Log for debugging
    \Log::info('Admission Payment Request:', $request->all());

    $payment = Payment::create([
        'admission_id'   => $request->admission_id,
        'patient_id'     => optional(auth()->user()->patient)->id ?? $request->patient_id,
        'amount'         => $request->amount,
        'payment_status' => 'Paid',
        'payment_method' => 'Razorpay',
        'transaction_id' => $request->razorpay_payment_id,
        'paid_at'        => now(),
    ]);

    return redirect()->route('admission.index')->with('success', 'Payment successful!');
}

public function admissionPaymentUpdate($id, Request $request)
{
    try {
        $payment = Payment::where('admission_id', $id)->first();

        if (!$payment) {
            \Log::error('Payment update failed: Payment not found', ['admission_id' => $id]);
            return redirect()->back()->with('error', 'Payment update failed. Record not found.');
        }

        $payment->transaction_id = $request->razorpay_payment_id;
        $payment->payment_status = 'Paid';
        $payment->paid_at = now();
        $payment->save();

        return redirect()->route('admission.index')->with('success', 'Payment updated successfully.');
    } catch (\Exception $e) {
        \Log::error('Payment update failed', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Something went wrong while updating payment.');
    }
}
public function printReceipt($id)
{
    $admission = Admission::with('patient.user', 'doctor.user', 'payments')->findOrFail($id);

    $payment = $admission->payments->first(); // use first payment

    if (!$payment || !$payment->transaction_id) {
        return redirect()->back()->with('error', 'Payment not completed. Receipt cannot be printed.');
    }
  //  dd($admission);

    return view('pages.AdminPages.Admission&Discharge.receipt', compact('admission', 'payment'));
}

public function downloadReceipt($id)
{
    $admission = Admission::with('patient.user', 'doctor.user', 'payments')->findOrFail($id);
    $payment = $admission->payments->first();

    if (!$payment || !$payment->transaction_id) {
        return redirect()->back()->with('error', 'Payment not completed. Receipt cannot be downloaded.');
    }

    $pdf = Pdf::loadView('pages.AdminPages.Admission&Discharge.receipt-pdf', compact('admission', 'payment'));
    return $pdf->download('payment_receipt.pdf');
}




}
