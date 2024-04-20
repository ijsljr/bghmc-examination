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
Route::get('/patients/{id}/admit-patient', 'App\Http\Controllers\PatientController@admitPatient')->name('admitPatient');
Route::get('/patients/{id}/discharge-patient', 'App\Http\Controllers\PatientController@dischargePatient')->name('dischargePatient');
Route::get('/patients/{id}/soft-delete', 'App\Http\Controllers\PatientController@softDelete')->name('patientSoftDelete');
Route::get('/patients/{id}/restore', 'App\Http\Controllers\PatientController@restore')->name('patientRestore');
Route::get('/patients/recycle-bin', 'App\Http\Controllers\PatientController@recycleBinList')->name('recycleBinList');
Route::delete('/patients/{id}/hard-delete', 'App\Http\Controllers\PatientController@hardDelete')->name('patientHardDelete');
// ----------------------------------------------------------------------------------------------------------------

//RESOURCE ROUTES -------------------------------------------------------------------------------------------------
Route::resource('/patients', 'App\Http\Controllers\PatientController');
Route::resource('/admissions', 'App\Http\Controllers\AdmissionController');
Route::resource('/wards', 'App\Http\Controllers\WardController');
// ----------------------------------------------------------------------------------------------------------------

