<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Departments\DepartmentController;
use App\Http\Controllers\Doctors\DoctorController;
use App\Http\Controllers\Patients\PatientController;
use App\Http\Controllers\Appointments\AppointmentController;
use App\Http\Controllers\MedicalRecord\MedicalRecordController;
use App\Http\Controllers\MedicalReport\MedicalReportController;
use App\Http\Controllers\Admission\AdmissionController;
use App\Http\Controllers\ProfileSetting\ProfileSettingController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/admin/register', [AuthController::class,'register'] )->name('admin.register');
Route::post('/admin/register',[AuthController::class,'PostRegister'])->name('admin.registerpost');
Route::get('/admin/login', [AuthController::class,'login'])->name('admin.login');
Route::post('/admin/login',[AuthController::class,'loginPost'])->name('admin.loginpost');
Route::get('/admin/logout',[AuthController::class,'logout'])->name('admin.logout');


//Role Routes
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('admin.dashboard');
   Route::get('roles',[RoleController::class,'index'])->name('role.index');
Route::get('roles/create',[RoleController::class,'create'])->name('role.create');
Route::post('roles',[RoleController::class,'store'])->name('role.store');
Route::get('role/{id}',[RoleController::class ,'edit'])->name('role.edit');
Route::put('role/{id}',[RoleController::class,'update'])->name('role.update');
Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

//Permssions Routes

Route::get('permissions', [PermissionController::class,'index'])->name('permission.index');
Route::get('permission/create',[PermissionController::class,'create'])->name('permission.create');
Route::post('permission',[PermissionController::class,'store'])->name('permission.store');
Route::get('permission/{id}', [PermissionController::class,'edit'])->name('permission.edit');
Route::put('permission/{id}', [PermissionController::class,'update'])->name('permission.update');
Route::delete('permission/{id}',[PermissionController::class,'destroy'])->name('permission.delete');

// Users Routes
Route::get('users', [UserController::class,'index'])->name('user.index');
Route::get('user/create', [UserController::class , 'create'])->name('user.create');
Route::post('users',[UserController::class ,'store'])->name('user.store');
Route::get('user/{id}', [UserController::class , 'edit'])->name('user.edit');
Route::put('user/{id}', [UserController::class,'update'])->name('user.update');
Route::delete('user/{id}',[UserController::class,'destroy'])->name('user.delete');

// Departments Routes
Route::get('departments', [DepartmentController::class,'index'])->name('departments.index');
Route::get('departments/create',[DepartmentController::class,'create'])->name('departments.create');
Route::post('departments',[DepartmentController::class,'store'])->name('departments.store');
Route::get('department/{id}',[DepartmentController::class,'edit'])->name('departments.edit');
Route::put('department/{id}', [DepartmentController::class,'update'])->name('departments.update');
Route::delete('department/{id}',[DepartmentController::class,'destroy'])->name('departments.delete');

// Doctors Route

Route::resource('doctors', DoctorController::class);

// Patients Routes

Route::resource('patients', PatientController::class);

// Appointments

Route::resource('appointment', AppointmentController::class);
Route::get('get-doctors/{id}', [AppointmentController::class, 'getDoctors'])->name('get.doctors');
Route::post('appointment/status-update', [AppointmentController::class, 'updateStatus'])->name('appointment.updateStatus');

// Medical Record

Route::get('medical-records/create/{appointment_id}', [MedicalRecordController::class,'create'])->name('medical_record.create');
Route::post('medical-records',[MedicalRecordController::class,'store'])->name('medical_record.store');
Route::post('medical-record/download', [MedicalRecordController::class, 'downloadReport'])->name('medical_record.download');
Route::post('medial-record/upload',[MedicalRecordController::class,'uploadTestFile'])->name('medical_record.upload');

// Medical Report
Route::get('medical-report',[MedicalReportController::class,'index'])->name('medical_report.index');

// Admission Routes

Route::get('admission','\App\Http\Controllers\Admission\AdmissionController@index')->name('admission.index');
Route::post('admission/create','\App\Http\Controllers\Admission\AdmissionController@store')->name('admissions.store');
Route::post('admission/update/{id}','\App\Http\Controllers\Admission\AdmissionController@update')->name('admissions.update');


// ProfileSetting Routes

Route::get('/profile-setting', '\App\Http\Controllers\ProfileSetting\ProfileSettingController@index')->name('admin.profile_setting');
Route::put('/profile-update', '\App\Http\Controllers\ProfileSetting\ProfileSettingController@update')->name('admin.profile_update');
Route::put('/admin/change-password', [ProfileSettingController::class, 'changePassword'])->name('admin.change_password');

});

