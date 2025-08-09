<?php

namespace App\Http\Controllers\Dashboard;

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
class DashboardController extends Controller
{




public function dashboard()
{
    $doctorsCount = Doctor::count();
    $patientsCount = Patient::count();
    $appointmentsCount = Appointment::count();
    $bedsCount = Bed::count();
    $wardsCount = Ward::count();
    $departmentsCount = Department::count();
    $usersCount = User::count();
    $rolesCount = Role::count();
    $permissionsCount = Permission::count();

    return view('pages.dashboard', compact(
        'doctorsCount',
        'patientsCount',
        'appointmentsCount',
        'bedsCount',
        'wardsCount',
        'departmentsCount',
        'usersCount',
        'rolesCount',
        'permissionsCount'
    ));
}


}
