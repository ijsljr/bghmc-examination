<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Ward;
use App\Models\Admission;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $patients = DB::table('patients')->select('first_name', 'middle_name', 'last_name', 'suffix_name', 'address', 'birthdate', 'status')->where('status', 'admitted')->orderBy('last_name', 'desc')->paginate(10);

        $patients_admissions = DB::table('patients')
        ->join('admissions', 'patients.id', '=', 'admissions.patient_id')
        ->select('patients.id','patients.last_name as lname', 'patients.first_name as fname', 'patients.middle_name as mname', 'patients.suffix_name as sname', 'admissions.admission_date_time as admission', 'admissions.discharge_date_time as discharge', 'admissions.status as status')
        ->where('patients.status', 'Admitted')
        ->paginate(10);

        return view('pages.patient.index', ['patients_admissions' => $patients_admissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $wards = DB::table('wards')->orderBy('ward_name', 'asc')->paginate(10);

        return view('pages.patient.create', ['wards' => $wards]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePatientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


            
        //TEST IF THE CHECKBOX FOR checkbox_admit IS CHECKED (YES = CREATE NEW ADMISSION, NO = NO ADDED ACTION)
        $value = request('checkbox_admit');

        if ($value == '1'){

            //CREATE A NEW PATIENT
            $patient_details = new Patient();
            $patient_details->first_name = request('first_name');
            $patient_details->middle_name = request('middle_name');
            $patient_details->last_name = request('last_name');
            $patient_details->suffix_name = request('suffix_name');
            $patient_details->address = request('address');
            $patient_details->birthdate = request('birthdate');
            $patient_details->status = 'Admitted';
            // $patient_details->status = "admitted";
            // $patient_details->author = Auth::user()->id;
            $patient_details->save();
            
            //PREPARE VARIABLES
            $fname = request('first_name');
            $mname = request('middle_name');
            $lname = request('last_name');
            $sname = request('suffix_name');
            $address = request('address');
            $birthdate = request('birthdate');

            //GET NEWLY CREATED PATIENT'S ID
            $patient_id = DB::table('patients')->select('id')
                                                ->where('first_name',  $fname)
                                                ->where('middle_name',  $mname)
                                                ->where('last_name',  $lname)
                                                ->where('suffix_name',  $sname)
                                                ->where('address',  $address)
                                                ->where('birthdate',  $birthdate)
                                                ->first();  
            
            //CREATE NEW ADMISSION
            $admission_details = new Admission();
            $admission_details->patient_id = $patient_id->id;
            $admission_details->ward_id = request('ward');
            $admission_details->admission_date_time = Carbon::now();
            $admission_details->status = 'Admitted';
            // $admission_details->author = Auth::user()->id;
            $admission_details->save();
            
        } else {

            //CREATE A NEW PATIENT
            $patient_details = new Patient();
            $patient_details->first_name = request('first_name');
            $patient_details->middle_name = request('middle_name');
            $patient_details->last_name = request('last_name');
            $patient_details->suffix_name = request('suffix_name');
            $patient_details->address = request('address');
            $patient_details->birthdate = request('birthdate');
            // $patient_details->status = "admitted";
            // $patient_details->author = Auth::user()->id;
            $patient_details->save();

        }
            return redirect()->route('patients.index')
                                ->with('success', 'New patient has been admitted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        return view('pages.patient.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientRequest  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
