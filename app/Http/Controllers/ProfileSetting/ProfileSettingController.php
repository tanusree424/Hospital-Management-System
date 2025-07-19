<?php

namespace App\Http\Controllers\ProfileSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
class ProfileSettingController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $role = $user->roles->pluck('name')->first();
    $extra = null;
    $departments = null;
    if ($role === 'Admin') {
        $extra = $user->admin;
    } elseif ($role === 'Doctor') {
        $departments = Department::all();
        $extra = $user->doctor;
    } elseif ($role === 'Patient') {
        $extra = $user->patient;
    }

    return view('pages.AdminPages.ProfileSetting.ProfileSettingPage', compact('extra', 'departments'));


}

public function update(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
        'phone' => 'nullable',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        // For Patient
        'dob' => 'nullable|date',
        'gender' => 'nullable|in:male,female,other',
        'patient_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'address' => 'nullable|string|max:255',
    ]);

    $user = auth()->user();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    // Handle file uploads
    $profileImagePath = null;
    if ($request->hasFile('profile_image')) {
        $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
    }

    $patientImagePath = null;
    if ($request->hasFile('patient_image')) {
        $patientImagePath = $request->file('patient_image')->store('patient_images', 'public');
    }

    // Role-based updates
    if ($user->hasRole('Admin')) {
        $user->admin()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'profile_picture' => $profileImagePath ?? $user->admin->profile_picture ?? null,
            ]
        );
    } elseif ($user->hasRole('Doctor')) {
        $user->doctor()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'profile_picture' => $profileImagePath ?? $user->doctor->profile_picture ?? null,
                'qualifications' => $request->qualifications,
                'department_id' => $request->department_id,
            ]
        );
    }
    elseif ($user->hasRole('Patient')) {
            $user->patient()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $request->phone,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'patient_image' => $patientImagePath ?? $user->patient->patient_image ?? null,
                ]
            );
        }

        return back()->with('success', 'Profile updated successfully.');
    }



public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed|min:6',
    ]);

    if (!Hash::check($request->current_password, auth()->user()->password)) {
        return back()->with('error', 'Current password is incorrect.');
    }

    auth()->user()->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('success', 'Password changed successfully.');
}

}
