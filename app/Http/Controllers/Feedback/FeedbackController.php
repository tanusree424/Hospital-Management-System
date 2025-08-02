<?php

namespace App\Http\Controllers\Feedback;
use App\Services\WhatsAppService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Twilio\Rest\Client;

class FeedbackController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'message' => 'nullable|string|max:1000',
    ]);

    Feedback::create([
        'rating' => $request->rating,
        'message' => $request->message,
        'patient_id' => auth()->id() ?  auth()->id() : null, // if needed
    ]);
$whatsappMessage = "🙏 Thank you for your valuable feedback!\n⭐ Rating: {$request->rating}\n💬 Message: {$request->message}\nWe appreciate your time. - Medinova Hospital";

// Get the patient's WhatsApp number only if the user is a patient
$whatsapp = auth()->user()->hasRole('Patient')
    ? 'whatsapp:+91' . auth()->user()->patient->phone
    : 'whatsapp:+919332819707';

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
    // Optional: silently fail without breaking the main feedback submission flow
}
    return response()->json(['success' => true]);
}


}
