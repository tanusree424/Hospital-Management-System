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
use App\Models\Patient;
use Illuminate\Support\Str;
use App\Models\feedback;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Comment;



class DashboardController extends Controller
{
public function home()
{
    // All departments
    $departments = Department::all();

    // Doctors with linked user
    $doctors = Doctor::with('user')->get();

    // Services
    $services = Service::all();

    // Blogs with author info + comments count
    $blogs = Blog::with(['doctor.user', 'admin.user'])
                 ->withCount('comments')   // each blog will have comments_count
                 ->latest('id')
                 ->get();

    // All patients
    $patients = Patient::with('user', 'feedback')->get();

    // Only patients who have feedback
    $feedbackPatients = Patient::with('user', 'feedback')
                               ->has('feedback')
                               ->get();

    // Pass data to view
    // return response()->json([
    //     "blogs"=>$blogs

    // ]);
    return view('index', compact(
        'departments',
        'doctors',
        'services',
        'blogs',
        'patients',
        'feedbackPatients'
    ));
}


public function search(Request $request)
{
    // Start with the Eloquent query builder (NOT a collection)
    $query = Doctor::with(['user', 'department']);

    // Filter by department
    if ($request->filled('department_id') && $request->department_id !== 'all') {
        $query->where('department_id', $request->department_id);
    }

    // Keyword: search doctor name (users.name) OR qualifications
    if ($request->filled('keyword')) {
        $keyword = trim($request->keyword);

        $query->where(function ($q) use ($keyword) {
            $q->whereHas('user', function ($uq) use ($keyword) {
                $uq->where('name', 'like', "%{$keyword}%");
            })->orWhere('qualifications', 'like', "%{$keyword}%");
        });
    }

    // Finally execute the query
    $doctors = $query->latest()->get();

    return view('pages.find-doctor-department', compact('doctors'));
}


public function bookAppointmentByDepartment($id)
{
    $department = Department::find($id);
    return view('pages.bookAppointmentForDepartemnt', compact('department'));
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
    public function team()
    {
        $doctors =  Doctor::with('user')->get();
        return view('pages.team', compact('doctors'));
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
        $departments = Department::all();
        return view('pages.pricing', compact('departments'));
    }
    public function testimonial()
    {
        $patients = Patient::with('user', 'feedback')->get();
    $feedbackPatients = Patient::with('user', 'feedback')->has('feedback')->get();
        return view('pages.patients' ,compact('patients', 'feedbackPatients'));
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
public function patients()
{
 $patients  = Patients::all();
 return view();
}

public function findSingleBlog($slug)
{
    $blogs = Blog::with('comments.user') // eager load comments + user
                ->where('slug', $slug)
                ->first();

    if (!$blogs) {
        return redirect()->back()->with('error', 'Blog not found.');
    }

    $blogs->increment('views');
    // return response()->json([
    //     "blogs"=>$blogs
    // ]);
    $comments = Comment::where('blog_id', $blogs->id)->get();
    // return response()->json([
    //     "comments"=>$comments
    // ]);

    return view('pages.SingleBlog', compact('blogs','comments'));
}
public function storeComment(Request $request, $blogId)
{
    $request->validate([
        'content' => 'required|string|max:500',
        'guest_name' => 'nullable|string|max:100',
        'guest_email' => 'nullable|email|max:150'
    ]);

    $blog = Blog::findOrFail($blogId);


    $comment = new Comment();
    $comment->blog_id = $blog->id;
    $comment->content = $request->content;

    if (auth()->check()) {
        // logged in user
        $comment->user_id = auth()->id();
    } else {
        // guest user
        $comment->name = $request->guest_name ?? 'Anonymous';
        $comment->email = $request->guest_email;
    }

    $comment->save();
    // $blog->update([
    //     'comments'=>$comment->id
    // ]);
    return redirect()
        ->route('blog.slug', $blog->slug)
        ->with('success', 'Your comment has been added!');
}

public function allBlogs()
{
     $blogs = Blog::with(['doctor.user', 'admin.user'])
                 ->withCount('comments')   // each blog will have comments_count
                 ->latest('id')
                 ->get();
                 return view('pages.blogs', compact('blogs'));
}

public function searchBlog()
{
    return view('pages.search');
}

}
