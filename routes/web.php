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
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\Discharge\DischargeController;
use App\Http\Controllers\Feedback\FeedbackController;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Controllers\AdminDashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Services\ServiceController;
use App\Http\Controllers\Blog\BlogController;



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

// Route::get('/', function () {
//     return view('index');
// })->name('home');
Route::get('/', [DashboardController::class,'home'])->name('home');
Route::get('/admin/register', [AuthController::class,'register'] )->name('admin.register');
Route::post('/admin/register',[AuthController::class,'PostRegister'])->name('admin.registerpost');
Route::get('/admin/login', [AuthController::class,'login'])->name('admin.login');
Route::post('/admin/login',[AuthController::class,'loginPost'])->name('admin.loginpost');
Route::get('/admin/logout',[AuthController::class,'logout'])->name('admin.logout');
// Forgot password form
Route::get('admin/forgot-password', [App\Http\Controllers\ForgetPassword\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('admin/forgot-password', [App\Http\Controllers\ForgetPassword\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset password
Route::get('admin/reset-password/{token}', [App\Http\Controllers\ForgetPassword\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('admin/reset-password', [App\Http\Controllers\ForgetPassword\ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/blog/{slug}', [DashboardController::class,'findSingleBlog'])->name('blog.slug');
Route::post('/comment/{blogId}',[DashboardController::class, 'storeComment'])->name('comments.store');
Route::get('/find-doctor/search', [DashboardController::class, 'search'])
->name('find.doctor.search');
Route::get('/all/blogs', [DashboardController::class,'allBlogs'])->name('allBlogs');
Route::get('/search', [DashboardController::class ,'searchBlog'])->name('search.page');
Route::get('/about',[DashboardController::class,'about'])->name('about');
Route::get('/services',[DashboardController::class,'services'])->name('services');
Route::get('/appointment/book',[DashboardController::class,'appointment'])->name('appointment');
Route::get('/team', [DashboardController::class , 'team'])->name('team');
Route::get('/pricing',[DashboardController::class,'pricing'])->name('pricing');
Route::get('/testimonial',[DashboardController::class,'testimonial'])->name('testimonial');
Route::get('/get-doctors',[DashboardController::class,'getDoctorsByDepartment'])->name('doctors');
Route::post('/store/appointment/guest' , [DashboardController::class,'storeGuest'])->name('guest.store');
Route::get('/guest/payment', [Dashboardcontroller::class,'paymentPage'])->name('guest.payment');
Route::post('/payment/razorpay/success', [DashboardController::class, 'razorpaySuccess'])->name('payment.razorpay.success');
Route::get('/appointment/department/{id}/book', [DashboardController::class,'bookAppointmentByDepartment'])->name('appointment.dept.book');
//Route::get('/services', [DashboardController::class, 'index'])->name('services.index');
//Role Routes
Route::middleware('auth')->prefix('admin')->group(function () {

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
// Route::get('user/create', [UserController::class , 'create'])->name('user.create');
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
Route::get('get-doctors', [AppointmentController::class, 'getDoctorsByDepartment']);
Route::post('appointment/status-update', [AppointmentController::class, 'updateStatus'])->name('appointment.updateStatus');
Route::get('/appointment/{id}/payment', [AppointmentController::class, 'showPayment'])->name('appointment.payment');
Route::post('/appointment/{id}/payment', [AppointmentController::class, 'processPayment'])->name('appointment.payment.process');
//Route::get('/appointment/{id}/payment-gateway', [AppointmentController::class, 'paymentGatewayPage'])->name('appointment.payment.gateway');
Route::get('/appointment/{id}', [AppointmentController::class, 'show'])->name('appointment.show');
Route::post('/appointment/payment/process/{id}', [AppointmentController::class, 'processPayment'])->name('appointment.payment.process');
Route::post('/appointment/payment/success', [AppointmentController::class, 'paymentSuccess'])->name('appointment.payment.success');
Route::get('/appointment/{id}/receipt/download', [AppointmentController::class, 'downloadReceipt'])
    ->name('appointment.receipt.download');
Route::get('/appointments/data', [AppointmentController::class, 'getAppointments'])->name('appointments.data');


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
Route::put('admission/update/{id}','\App\Http\Controllers\Admission\AdmissionController@update')->name('admissions.update');

Route::get('/get-beds-by-ward', [AdmissionController::class, 'getBedsByWard'])->name('get.beds.by.ward');
Route::get('/admission/{id}/print-receipt', [AdmissionController::class, 'printReceipt'])->name('admission.receipt.print');
Route::get('/admission/{id}/receipt/download', [AdmissionController::class, 'downloadReceipt'])
    ->name('admission.receipt.download');


// ProfileSetting Routes

Route::get('/profile-setting', '\App\Http\Controllers\ProfileSetting\ProfileSettingController@index')->name('admin.profile_setting');
Route::put('/profile-update', '\App\Http\Controllers\ProfileSetting\ProfileSettingController@update')->name('admin.profile_update');
Route::put('/admin/change-password', [ProfileSettingController::class, 'changePassword'])->name('admin.change_password');

// Hospital Management Routes
Route::get('/hospital-management', [HospitalController::class, 'index'])->name('hospital.management');
Route::post('hospita-management/create/ward',[HospitalController::class,'wardstore'])->name('hospital.management.ward.store');
Route::put('hospital-management/update/ward',[HospitalController::class,'editWard'])->name('hospital.management.ward.update');
Route::delete('hospital-management/delete/{id}/ward',[HospitalController::class,'destroy'])->name('hospital.management.destroy');
// Bed Routes
Route::post('hospita-management/create/bed',[HospitalController::class ,'bedstore'])->name('hospital.management.bed.store');
Route::put('hospital-management/update/bed',[HospitalController::class,'bedupdate'])->name('hospital.management.bed.update');
Route::delete('hospital-management/delete/{id}/bed',[HospitalController::class,'beddestroy'])->name('hospital.management.bed.destroy');
Route::get('/get-beds-by-ward', [HospitalController::class, 'getBedsByWard'])->name('get.beds.by.ward');

// Medicien Routes
Route::post('hospital-management/create/medicine',[HospitalController::class,'medicinestore'])->name('hospital.management.medicine.store');
Route::put('hospital-management/upadte/medicine',[HospitalController::class,'medicineupdate'])->name('hospital.management.medicine.update');
Route::delete('hospital-management/delete/{id}/medicine',[HospitalController::class,'medicinedestroy'])->name('hospital.management.medicine.destroy');
Route::post('/discharges', [DischargeController::class, 'store'])->name('discharge.store');
Route::post('/feedback/submit', [FeedbackController::class, 'store'])->name('admin.feedback.submit');


//Payment Routes

Route::get('/payments','\App\Http\Controllers\Payments\PaymentController@index')->name('payments.index');
Route::get('/payments/{admission_id}/pay', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');
Route::post('/razorpay/success', [PaymentController::class, 'razorpaySuccess'])->name('razorpay.success');
Route::post('/razorpay/pay-later', [PaymentController::class, 'razorpayPayLater'])->name('razorpay.payLater');
Route::get('/razorpay/payment-info/{payment_id}', [PaymentController::class, 'paymentInfo']);
Route::post('/admission/{id}/payment', [AdmissionController::class, 'processAdmissionPayment'])->name('admission.payment.process');
Route::post('/admission/payment/store', [AdmissionController::class, 'storeAdmissionPayment'])->name('admission.payment.store');

Route::post('/admission/payment/update/{id}', [AdmissionController::class, 'admissionPaymentUpdate'])
    ->name('admission.payment.update');

  Route::get('dashboard',[AdminDashboardController::class,'dashboard'])->name('admin.dashboard');

//  Feedback Routes

Route::get('/feedbacks' , [FeedbackController::class,'index'])->name('admin.feedbacks.index');
Route::delete('/feedback/{id}' ,[FeedbackController::class, 'removeFeedback'])->name('admin.feedback.delete');

//Services Routes
Route::get('/services', [ServiceController::class,'index'])->name('admin.services.index');
Route::post('/services',[ServiceController::class,'store'])->name('admin.services.store');
Route::put('/services/{id}' , [ServiceController::class , 'update'])->name('admin.services.update');
Route::delete('/services/{id}' , [ServiceController::class , 'destroy'])->name('admin.services.destroy');

// Blogs Routes

Route::get('blogs', [BlogController::class ,'index'] )
->name('admin.blogs.index');
Route::post('blogs' , [BlogController::class ,'store'])->name('admin.blogs.store');
Route::put('blogs/{id}', [BlogController::class,'update'])->name('admin.blogs.update');
Route::delete('blogs/{id}', [BlogController::class,'destroy'])->name('admin.blogs.delete');
});

