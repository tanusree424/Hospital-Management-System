<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register()
    {
        return view('pages.auth.Register');
    }


public function PostRegister(Request $request)
{
    $validate = Validator::make($request->all(), [
        "name" => "required|string|max:50|min:3",
        "email" => "required|string|email|max:50|unique:users,email",
        "password" => "required|string|min:6|max:50"
    ]);

    if ($validate->fails()) {
        return redirect()->route('admin.register')
                         ->withErrors($validate)
                         ->withInput(); // form input retain
    }

    // ✅ User Create
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // ✅ ডিফল্ট রোল Patient অ্যাসাইন করা
    $user->assignRole('patient'); // Spatie Permission method
    $patient = Patient::create([
        'user_id'=> $user->id,
        'DOB'=>$request->dob,
        'pincode'=>$request->pincode,
        'city'=>$request->city,
        'state'=>$request->state,
        'post_office'=>$request->post_office,
        'country'=>$request->country,
        'gender'=>$request->gender,
        'phone'=>$request->phone,
        'patient_image'=> $request->patient_image,
        'address'=>$request->address,


    ]);

    // ✅ Optional: Auto login after register
    // Auth::login($user);

    return redirect()->route('admin.login')->with('success', 'Registration successful!');
}


    public function login()
    {
        return view('pages.auth.Login');
    }
    public function loginPost(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            "email"=>"required|email|string|max:50|min:3",
            "password"=>"required"
        ]);
        $credentials = $request->only(['email','password']);
        if (Auth::attempt($credentials)) {
             $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
      return redirect()->back()->withErrors(['email'=>'Invalid Credentials'])->withInput();
    }

   public function logout()
{
    if (Auth::check()) {
        Auth::logout(); // Logs the user out
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }

    return redirect()->route('admin.login')->with('error', 'No active session found.');
}
}
