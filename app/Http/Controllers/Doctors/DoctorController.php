<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with('user','department')->get();
         $departments = Department::all();
        return view('pages.AdminPages.Doctors.index', compact('doctors','departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

     return view('pages.AdminPages.Doctors.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{

    $validator = Validator::make($request->all(), [
        "name" => "required|string|max:50|min:3",
        "email" => "required|email|unique:users,email",
        "password" => "required|confirmed|min:6",
        "phone" => "required|digits:10",
        "qualifications" => "required|string",
        "department" => "required|exists:departments,id",
        "profile_picture" => "nullable|image|mimes:jpg,jpeg,png|max:2048"
    ]);

    if ($validator->fails()) {
        return redirect()->route('doctors.index')->withErrors($validator)->withInput();
    }

    // ✅ Create user
    $user = User::create([
        "name" => $request->name,
        "email" => $request->email,
        "password" => Hash::make($request->password),
    ]);

    // ✅ Assign role
    $user->assignRole('doctor');

    // ✅ Handle file upload
    $imagePath = null;
    if ($request->hasFile('profile_picture')) {
        $imagePath = $request->file('profile_picture')->store('doctor_profiles', 'public');
    }

    // ✅ Create doctor record
   $doctor= Doctor::create([
        "user_id" => $user->id,
        "qualifications" => $request->qualifications,
        "phone" => $request->phone,
        "department_id" => $request->department,
        "profile_picture" => $imagePath,
    ]);

   return redirect()
    ->route('doctors.index')
    ->with('success', "Doctor {$doctor->user->name} Profile Created Successfully");

}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = Doctor::find($id);
        $departments = Department::all();
        return view('pages.AdminPages.Doctors.edit', compact('doctor', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor) {
        $request->validate([
            'qualifications' => 'required',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $doctor->update([
            'qualifications' => $request->qualifications,
            'department_id' => $request->department,
            'phone' => $request->phone,
        ]);

        $doctor->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);

        if ($doctor) {
            $doctor->delete();
            return redirect()->route('doctors.index')->with('success','Doctor Deleted Successfully');
        }
        return redirect()->route('doctors.index')->with('error','Doctor not Deleted Successfully');
    }
}
