<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $patients = Patient::with(['user','appointment.doctor.user'])->paginate(5);


        return view('pages.AdminPages.Patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.AdminPages.Patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            "name"=>"required",
            "email"=>"required|email|unique:users,email",
            "password"=>"required|string|min:5|confirmed",
            "dob"=>"required|Date",
            "gender"=>"required|in:male,female,other",
            "phone"=>"required|digits:10",
            "patient_image"=>"nullable|image|mimes:png,jpg,jpeg",
            "address"=>"required|string|max:255"
        ]);
        if ($validate->fails()) {
            return redirect()->route('patients.create')->withErrors($validate)->withInput();
        }
        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=> Hash::make($request->password)
        ]);
        $user->assignRole('patient');
        $imageSave = null;
        if ($request->hasFile('patient_image')) {
           $image =  $request->file('patient_image');
           $imageName = time() .'-'. $image->getClientOriginalExtension();
           $imageSave = $image->storeAs('patientimage',$imageName ,'public' );
        }
        $patient = Patient::create([
            "user_id"=>$user->id,
            "DOB"=>$request->dob,
            "gender"=>$request->gender,
            "phone"=>$request->phone,
            "patient_image"=>$imageSave,
            "address"=>$request->address
        ]);
        if ($patient) {
            return redirect()->route('patients.index')->with('success','patient Created Successfully');
        }
         return redirect()->route('patients.index')->with('error','patient not Created Successfully');
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
        $patient = Patient::find($id);
        return view('pages.AdminPages.Patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Patient $patient)
    {

         $validate = Validator::make($request->all(),[
            "name"=>"nullable",
            "email"=>"nullable|email|unique:users,email,$patient",

            "dob"=>"nullable|Date",
            "gender"=>"nullable|in:male,female,other",
            "phone"=>"nullbale|digits:10",
            "patient_image"=>"nullable|image|mimes:png,jpg,jpeg",
            "address"=>"required|string|max:255"
        ]);
        $imagePath = null;
        if ($request->hasFile('patient_image')) {
            $image = $request->file('patient_image');
            $imageName = time().'-'. $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('patient_image',$imageName,'public');
        }

        $patient->update([
            "DOB"=>$request->dob,
            "gender"=>$request->gender,
            "phone"=>$patient->phone,
            "patient_image"=>$imagePath

        ]);
        $patient->user->update([
            "name"=>$request->name,
            "email"=>$request->email
        ]);
        return redirect()->route('patients.index')->with('success','patient Data Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    $patient = Patient::findOrFail($id); // ⛑ ensures 404 if not found

    // Also delete associated user if needed
    if ($patient->user) {
        $patient->user->delete(); // This will also delete patient if `onDelete('cascade')` is set
    } else {
        $patient->delete(); // fallback in case no user found
    }

    return redirect()->route('patients.index')->with('success', 'Patient Data Deleted Successfully');
}

}
