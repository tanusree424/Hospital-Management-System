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
    $user = auth()->user();

    // Base validation for all users
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];

    // Role-specific validation
    if ($user->hasRole('Doctor')) {
        $rules['qualifications'] = 'nullable|string|max:255';
        $rules['department_id'] = 'nullable|exists:departments,id';
    }

    if ($user->hasRole('Patient')) {
        $rules['dob'] = 'nullable|date';
        $rules['gender'] = 'nullable|in:male,female,other';
        $rules['profile_image'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        $rules['address'] = 'nullable|string|max:255';
    }

    $request->validate($rules);

    // Update basic user info
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // Upload files only if provided (avoids tmp paths in DB)
    $profileImagePath = null;
    if ($request->hasFile('profile_image')) {
        $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
    }
    $patientImagePath = null;
    if ($request->hasFile('profile_image')) {
        $patientImagePath = $request->file('profile_image')->store('patient_image', 'public');
    }
    if ($user->hasRole('Admin')) {
        $user->admin()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                // Keep old image if no new one uploaded
                'profile_picture' => $profileImagePath ?? $user->admin?->profile_picture,
            ]
        );}
    elseif ($user->hasRole('Doctor')) {
        $user->doctor()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'profile_picture' => $profileImagePath ?? $user->doctor?->profile_picture,
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
                'patient_image' => $patientImagePath ?? $user->patient?->patient_image,
            ]
        );}
    if ($request->ajax()) {
        return response()->json(['success' => 'Profile updated successfully.']);
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
