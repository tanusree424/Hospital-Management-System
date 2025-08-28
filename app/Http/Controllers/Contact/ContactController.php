<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;
use App\Models\Contact; // only if saving to DB
use App\Http\Controllers\Controller;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
 public function index()
 {
    Gate::authorize('contact_access');
    $contacts = Contact::latest('id')->get();
    return view('pages.AdminPages.contact.index', compact('contacts'));
 }


   public function store(Request $request)
{// Block bots (honeypot)
    if ($request->filled('website')) {
        return back()->withErrors(['Spam detected.'])->withInput();
    }
    $data = $request->validate([
        'name'    => ['required','string','max:100'],
        'email'   => ['required','email','max:150'],
        'subject' => ['required','string','max:150'],
        'message' => ['required','string','max:2000'],
    ], [
        'name.required'    => 'Please enter your name.',
        'email.required'   => 'Please enter your email.',
        'email.email'      => 'Please enter a valid email address.',
        'subject.required' => 'Please enter a subject.',
        'message.required' => 'Please write your message.',
    ]);
    try {
        // (Optional) Save to DB
        Contact::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "subject"=>$request->subject,
            "message"=>$request->message
        ]);
        // Send email to site admin (change address)
        // In app/Http/Controllers/Contact/ContactController.php (around line 40)
        Mail::to('tanubasuchoudhury1997@gmail.com')->send(new ContactMessageMail($request->all()));
        return back()->with('success', 'Thanks! Your message has been sent.');
    } catch (Throwable $e) {
        \Log::info($e);
        report($e);
        return back()->withErrors(['Something went wrong while sending your message. Please try again.'])
            ->withInput();
    }}
}
