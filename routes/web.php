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

//RESOURCE ROUTES -------------------------------------------------------------------------------------------------
Route::resource('/patients', 'App\Http\Controllers\PatientController');
Route::resource('/admissions', 'App\Http\Controllers\AdmissionController');
Route::resource('/wards', 'App\Http\Controllers\WardController');
// ----------------------------------------------------------------------------------------------------------------

// CUSTOM ROUTES - PATIENT MODEL ----------------------------------------------------------------------------------
Route::get('/patients/{id}/delete', 'App\Http\Controllers\PatientController@softDelete')->name('patientSoftDelete');
// ----------------------------------------------------------------------------------------------------------------
