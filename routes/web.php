<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// CUSTOM ROUTES - PATIENT MODEL ----------------------------------------------------------------------------------
Route::post('/patients/search','App\Http\Controllers\PatientController@searchPatients')->name('searchPatients');
Route::get('/patients/{id}/admit', 'App\Http\Controllers\PatientController@admitPatientPage')->name('admit');
Route::get('/patients/{id}/discharge', 'App\Http\Controllers\PatientController@dischargePatientPage')->name('discharge');

Route::post('/patients/admit-patient', 'App\Http\Controllers\PatientController@admitPatient')->name('admitPatient');
Route::put('/patients/{id}/discharge-patient', 'App\Http\Controllers\PatientController@dischargePatient')->name('dischargePatient');

Route::get('/patients/{id}/soft-delete', 'App\Http\Controllers\PatientController@softDelete')->name('patientSoftDelete');
Route::get('/patients/{id}/restore', 'App\Http\Controllers\PatientController@restore')->name('patientRestore');
Route::get('/patients/recycle-bin', 'App\Http\Controllers\PatientController@recycleBinList')->name('recycleBinList');
Route::delete('/patients/{id}/hard-delete', 'App\Http\Controllers\PatientController@hardDelete')->name('patientHardDelete');
// ----------------------------------------------------------------------------------------------------------------


// CUSTOM ROUTE - ADMISSION MODEL ---------------------------------------------------------------------------------
Route::get('/admission/{id}/admit', 'App\Http\Controllers\AdmissionController@admitPatientPage')->name('admitPage');
Route::get('/admission/{id}/discharge', 'App\Http\Controllers\AdmissionController@dischargePatientPage')->name('dischargePage');

Route::post('/admission/admit-patient', 'App\Http\Controllers\AdmissionController@admitPatient')->name('admittingPatient');
Route::put('/admission/{id}/discharge-patient', 'App\Http\Controllers\AdmissionController@dischargePatient')->name('dischargingPatient');
// ----------------------------------------------------------------------------------------------------------------

//RESOURCE ROUTES -------------------------------------------------------------------------------------------------
Route::resource('/patients', 'App\Http\Controllers\PatientController');
Route::resource('/admissions', 'App\Http\Controllers\AdmissionController');
Route::resource('/wards', 'App\Http\Controllers\WardController');
// ----------------------------------------------------------------------------------------------------------------

