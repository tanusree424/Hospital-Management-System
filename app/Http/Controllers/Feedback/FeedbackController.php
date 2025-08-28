<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks =  Feedback::with('patient.user')->latest('id')->get();
        //dd($feedbacks);
        // return response()->json([
        //     'feedbacks'=>$feedbacks
        // ]);
        return view('pages.AdminPages.Feedback.index', compact('feedbacks'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:1000',
           'patientId' => 'nullable|integer|exists:patients,id',
        ]);
$patientId = auth()->user()->hasRole('Patient')
    ? auth()->user()->patient->id
    : $request->patientId;
       Feedback::create([
    'rating' => $request->rating,
    'message' => $request->message,
    'patient_id' =>  $patientId,
]);
\Log::info($request->all());
        $whatsappMessage = "🙏 Thank you for your valuable feedback!\n⭐ Rating: {$request->rating}\n💬 Message: {$request->message}\nWe appreciate your time. - Medinova Hospital";

        // Get patient's WhatsApp number by patientId
        $patientPhone = \App\Models\Patient::find($request->patientId)->phone ?? null;

        $whatsapp = $patientPhone ? 'whatsapp:+91' . $patientPhone : null;

        try {
            if ($whatsapp) {
                $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

                $twilio->messages->create(
                    $whatsapp,
                    [
                        'from' => env('TWILIO_WHATSAPP_FROM'),
                        'body' => $whatsappMessage
                    ]
                );
            }
        } catch (\Exception $e) {
            \Log::error("WhatsApp Send Failed: " . $e->getMessage());
            // Optional: continue without breaking main flow
        }

        return response()->json(['success' => true]);
    }


    public function removeFeedback($id)
    {
        $feedback  = Feedback::findOrFail($id);
        if (!$feedback) {
            return redirect()->back()->with('error', 'No Feedback Found');
        }
        $feedback->delete();
        return redirect()->route('admin.feedbacks.index')->with('success', "Feedback {$feedback->message} Deleted  Successfully");
    }
}
