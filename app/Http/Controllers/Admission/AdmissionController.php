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
// use App\Models\Admission;
// use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
class AdmissionController extends Controller
{


public function index()
{
    if (Gate::none(['admission_discharge_access'])) {
       abort(403);
    }
    $user = auth()->user();

    if ($user->hasRole('Patient')) {
        // Patient role: শুধু নিজের admission দেখাবে
        $admissions = Admission::with(['patient.user', 'discharge', 'ward', 'bed', 'payments'])
            ->where('patient_id', $user->patient->id)
            ->get();

        // এই Patient এর available admission patient list দরকার না, তাই empty রাখো বা null
        $availablePatients = collect();

    } else {
        // অন্য রোল: সব admission দেখাবে
        $admissions = Admission::with(['patient.user', 'discharge', 'ward', 'bed', 'payments'])->get();

        $admittedPatientIds = Admission::doesntHave('discharge')->pluck('patient_id');

        $availablePatients = Patient::whereNotIn('id', $admittedPatientIds)->with('user')->get();
    }

    $payment = Payment::all();
    $amount = 1500;
    $wards = Ward::all();
    $beds = Bed::where('status', 'available')->get();
    $patients = Patient::all();

    return view('pages.AdminPages.Admission&Discharge.index', compact(
        'admissions', 'availablePatients', 'beds', 'wards',
        'patients', 'payment', 'amount'
    ));
}




public function ajaxList(Request $request)
{
    if ($request->ajax()) {
        $data = Admission::with(['patient', 'ward', 'bed'])
            ->select('admissions.*');

        return DataTables::of($data)
            ->addIndexColumn()

            // Patient Name
            ->addColumn('patient_name', function ($row) {
                return $row->patient ? $row->patient->name : '-';
            })

            // Ward
            ->addColumn('ward', function ($row) {
                return $row->ward ? $row->ward->name : '-';
            })

            // Bed
            ->addColumn('bed', function ($row) {
                return $row->bed ? $row->bed->bed_number : '-';
            })

            // Date
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y') : '';
            })

            // Status
            ->addColumn('status', function ($row) {
                $badgeClass = match ($row->status) {
                    'Admitted' => 'bg-success',
                    'Discharged' => 'bg-secondary',
                    'Pending' => 'bg-warning',
                    default => 'bg-light'
                };
                return '<span class="badge ' . $badgeClass . '">' . $row->status . '</span>';
            })

            // Edit Button
            ->addColumn('edit', function ($row) {
                return '<button class="btn btn-sm btn-primary editAdmission" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </button>';
            })

            // Discharge Button
            ->addColumn('discharge', function ($row) {
                if ($row->status !== 'Discharged') {
                    return '<button class="btn btn-sm btn-danger dischargeAdmission" data-id="' . $row->id . '">
                                <i class="fa fa-sign-out-alt"></i>
                            </button>';
                }
                return '-';
            })

            // Payment Button
            ->addColumn('payment', function ($row) {
                return '<button class="btn btn-sm btn-warning paymentAdmission" data-id="' . $row->id . '">
                            <i class="fa fa-credit-card"></i>
                        </button>';
            })

            // Print Button
            ->addColumn('print', function ($row) {
                return '<a href="' . route('admissions.print', $row->id) . '" target="_blank" class="btn btn-sm btn-info">
                            <i class="fa fa-print"></i>
                        </a>';
            })

            ->rawColumns(['status', 'edit', 'discharge', 'payment', 'print'])
            ->make(true);
    }
}


public function store(Request $request)
{
    Log::info("Admission Store Called", $request->all());

    $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'admission_date' => 'required|date',
        'ward_id' => 'required|exists:wards,id',
        'bed_id' => 'required|exists:beds,id',
        'reason' => 'required|string',
    ]);
    Log::info("Validation Passed");

    try {
        // 1. Create admission
        $admission = Admission::create([
            'patient_id'     => $request->patient_id,
            'admission_date' => $request->admission_date,
            'ward_id'        => $request->ward_id,
            'bed_id'         => $request->bed_id,
            'reason'         => $request->reason,
        ]);
        Log::info("Admission Created", ['admission_id' => $admission->id]);

        $amount = $request->amount ?? 0;
        Log::info("Payment Amount", ['amount' => $amount]);

        // 2. Mark bed occupied
        Bed::where('id', $request->bed_id)->update(['status' => 'occupied']);
        Log::info("Bed marked as occupied", ['bed_id' => $request->bed_id]);

        // 3. WhatsApp notification
        try {
            $user = auth()->user();
            Log::info("Auth User", ['user_id' => $user->id, 'roles' => $user->getRoleNames()]);

            if ($user->hasRole('Patient') && $user->patient?->phone) {
                $phone = 'whatsapp:+91' . $user->patient->phone;
                $message = "✅ Your admission has been confirmed.\n💰 Amount: ₹{$amount}\n🔗 Please log in to complete the payment: https://yourportal.com/login";

                Log::info("Sending WhatsApp message", ['phone' => $phone, 'message' => $message]);

                $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
                $twilio->messages->create($phone, [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'body' => $message
                ]);

                Log::info("WhatsApp Message Sent Successfully", ['phone' => $phone]);
            } else {
                Log::warning("User has no phone or not a patient", ['user_id' => $user->id]);
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp Message Failed", ['error' => $e->getMessage()]);
        }

        // 4. Redirect to Razorpay
        Log::info("Redirecting to Payment", ['admission_id' => $admission->id]);

        return redirect()->route('payments.create', [
            'admission_id' => $admission->id,
            'admission'    => $admission
        ])->with([
            'success'      => 'Patient admitted successfully. Proceed to payment.',
            'amount'       => $amount,
            'admission_id' => $admission->id,
        ]);
    } catch (\Exception $e) {
        Log::error("Admission Store Failed", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()->with('error', 'Something went wrong. Please check logs.');
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
