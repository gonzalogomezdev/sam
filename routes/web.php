<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EmailConfirmationController;

use App\Http\Controllers\MedicalConsultationRecordController;
use App\Http\Controllers\MedicalHistoryController;

use App\Http\Controllers\PasswordResetController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\LogoutController;

use App\Http\Controllers\PatientController;

use App\Http\Controllers\AppointmentController;

use App\Http\Controllers\MessageController;

use App\Http\Controllers\TimetableController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SocialWorkController;

Route::get('/', function () {
    return view('pages.home.index');
})->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/emailVerification/{token}', [EmailConfirmationController::class, 'verifyEmail'])->name('confirmar.email');
Route::post('/recover-password', [PasswordResetController::class, 'sendPasswordResetLink'])->name('sendPasswordResetLink');

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/welcome', [DashboardController::class, 'showWelcome'])->name('welcome');
// Route::view('/welcome', 'dashboards.welcome.welcome')->name('welcome');

Route::get('/requests', [PatientController::class, 'showRequests'])->name('patientRequests');
Route::get('/patients', [PatientController::class, 'showPatients'])->name('patients');
Route::post('/accept-patient', [PatientController::class, 'approveUserRequest'])->name('approve-userPatient');
Route::delete('/reject-patient/{id}', [PatientController::class, 'rejectUserRequest'])->name('reject-userPatient');
Route::post('/patient/deactivate', [PatientController::class, 'deactivatePatient'])->name('patient.deactivate');
Route::post('/patient/activate', [PatientController::class, 'activatePatient'])->name('patient.activate');

Route::get('/calendar', [AppointmentController::class, 'showCalendar'])->name('showCalendar');
Route::post('/dateTimetables', [AppointmentController::class, 'getTimetables'])->name('getTimetables');
Route::post('/save', [AppointmentController::class, 'saveAppointment'])->name('guardarTurnos');
Route::post('/cancel', [AppointmentController::class, 'cancelAppointment'])->name('cancelarTurnos');
Route::post('/block', [AppointmentController::class, 'blockAppointment'])->name('bloquearDia');
Route::post('/unblock', [AppointmentController::class, 'unblockAppointment'])->name('desbloquearDia');
Route::post('/blockTime', [AppointmentController::class, 'blockTime'])->name('bloquearxhora');

Route::get('/messages', [MessageController::class, 'showMessages'])->name('showMessages');
Route::get('/chat', [MessageController::class, 'getConversation'])->name('getConversation');
Route::post('/save-message', [MessageController::class, 'sendMessage'])->name('sendMessage');
Route::post('/broadcast', [MessageController::class, 'broadcast']);

Route::post('/update-interval', [TimetableController::class, 'store'])->name('store');

Route::get('/profile', [UserController::class, 'showUserProfile'])->name('myProfile');
Route::get('/obtener-localidades/{idProvincia}', [LocationController::class, 'obtenerLocalidades']);
Route::put('/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
Route::put('/update-password', [UserController::class, 'updatePassword'])->name('updatePassword');

//Route::resource('/registromedico', MedicalConsultationRecordController::class);
Route::get('/medicalRecord', [MedicalConsultationRecordController::class, 'index'])->name('medicalRecord');
Route::post('/Record', [MedicalConsultationRecordController::class, 'store'])->name('record');
Route::post('/newPatient', [PatientController::class, 'newPatient'])->name('newPatient');

Route::get('/medicalHistory', [MedicalHistoryController::class, 'index'])->name('medicalHistory');
Route::get('/historial/{idPaciente}', [MedicalHistoryController::class, 'verHistorial'])->name('historial');
Route::post('/actualizar-estado-historial', [MedicalHistoryController::class, 'actualizarEstado'])->name('actualizar-estado-historial');
Route::get('/medicalhistory-pdf/{id}', [MedicalHistoryController::class, 'pdf'])->name('medicalhistory-pdf');
//Route::resource('/medicalHistory', MedicalHistoryController::class)->name('medicalHistory');

Route::get('/appointments', [AppointmentController::class, 'appointments'])->name('appointments');

// Ruta para actualizar la obra social de un paciente
Route::post('/patient/update-social-work', [PatientController::class, 'updateSocialWork'])->name('patient.updateSocialWork');

Route::get('/social', [SocialWorkController::class, 'socialWorks'])->name('social');
Route::post('/social', [SocialWorkController::class, 'addSocialWork'])->name('social.add');
Route::put('/social/{id}', [SocialWorkController::class, 'updateSocialWork'])->name('social.update');
Route::delete('/social/{id}', [SocialWorkController::class, 'deleteSocialWork'])->name('social.delete');


Route::get('/getPatientDetails/{id}', [MedicalConsultationRecordController::class, 'getPatientDetails'])->name('getPatientDetails');