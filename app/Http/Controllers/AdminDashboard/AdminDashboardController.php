<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Bed;
use App\Models\Ward;
use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Feedback;
class AdminDashboardController extends Controller
{
public function dashboard()
{
    $user = auth()->user();

    // Initialize counts
    $doctorsCount = Doctor::count();
    $bedsCount = Bed::count();
    $wardsCount = Ward::count();
    $departmentsCount = Department::count();
    $usersCount = User::count();
    $rolesCount = Role::count();
    $permissionsCount = Permission::count();
    $blogCount = Blog::count();
    $servicesCount = Service::count();
    $feedbackCount = Feedback::count();

    if ($user->hasRole('Patient')) {
        $appointmentsCount = Appointment::where('patient_id', $user->patient->id)->where('status' , '!=' , 'Completed')->count();
        $patientsCount = 1; // Only themselves

    } elseif ($user->hasRole('Doctor')) {
        $doctorId = $user->doctor->id;

        $appointmentsCount = Appointment::where('doctor_id', $doctorId)->where('status', '!=' ,'Completed')->count();

        $patientsCount = Patient::whereHas('appointment', function($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId)
                  ->where('status', '!=', 'Completed');
        })->count();

    } else {
        // Admin or other roles
        $appointmentsCount = Appointment::count();
        $patientsCount = Patient::count();
    }

    return view('pages.dashboard', compact(
        'doctorsCount',
        'patientsCount',
        'appointmentsCount',
        'bedsCount',
        'wardsCount',
        'departmentsCount',
        'usersCount',
        'rolesCount',
        'permissionsCount',
        'blogCount',
        'servicesCount',
        'feedbackCount'
    ));
}



}
