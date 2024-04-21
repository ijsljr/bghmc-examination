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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $patients_admissions = DB::table('patients')
        // ->join('admissions', 'patients.id', '=', 'admissions.patient_id')
        // ->select('patients.id','patients.last_name as lname', 'patients.first_name as fname', 'patients.middle_name as mname', 'patients.suffix_name as sname', 'admissions.admission_date_time as admission', 'admissions.discharge_date_time as discharge', 'admissions.status as status')
        // ->paginate(10);

        $patients_admissions = DB::table('patients')
                                    ->leftJoin('admissions', 'patients.id', '=', 'admissions.patient_id')
                                    ->select('patients.id','patients.last_name as lname', 'patients.first_name as fname', 'patients.middle_name as mname', 'patients.suffix_name as sname', 'admissions.admission_date_time as admission', 'admissions.discharge_date_time as discharge', 'patients.status as status')->orderby('last_name', 'asc')->paginate(10);
                                    

        return view('pages.patient.index', ['patients_admissions' => $patients_admissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $wards = DB::table('wards')->orderBy('ward_name', 'asc')->get();

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

            //TEST WHICH ADMISSION DATE AND TIME TO USE(CURRENT OR USER INPUT)
            if(is_null(request('admission_date')) == 'true'){
                $admission_details->admission_date_time = Carbon::now('+8:00');
            }else{
                $ad = request('admission_date');
                $at = request('admission_time');
                $seconds = '00';
                $admission_details->admission_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $ad. ' '. $at .':'. $seconds);
            }
            
            $admission_details->status = 'Admitted';
            // $admission_details->author = Auth::user()->id;
            $admission_details->save();

            return redirect()->route('patients.index')
                                ->with('success', 'New patient has been admitted.');
            
        } else {

            //CREATE A NEW PATIENT
            $patient_details = new Patient();
            $patient_details->first_name = request('first_name');
            $patient_details->middle_name = request('middle_name');
            $patient_details->last_name = request('last_name');
            $patient_details->suffix_name = request('suffix_name');
            $patient_details->address = request('address');
            $patient_details->birthdate = request('birthdate');
            // $patient_details->author = Auth::user()->id;
            $patient_details->save();

            return redirect()->route('patients.index')
                                ->with('success', 'New patient has been added.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $patient_details = Patient::find($request->patient);

        return view('pages.patient.show', compact('patient_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {      
            $patient_details = Patient::find($patient->id);

        return view('pages.patient.edit', compact("patient_details"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientRequest  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {

        $patient->update([
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'suffix_name' => $request->suffix_name,
                    'birthdate' => $request->birthdate,
                    'address' => $request->address,
                ]);

        return redirect()->route('patients.index')
                                    ->with('success', 'Successfully updated the patients details.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        
    }

    public function restore(Request $request, Patient $patient)
    {
        $patient = DB::table('patients')
                                ->where('id', $request->id)
                                ->update(['status' => 'Inactive']);

        return redirect()->route('recycleBinList')
                                    ->with('success', 'Successfully restored the patients account.');
    }

    public function softDelete(Request $request, Patient $patient)
    {
        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $request->id)->first();

        if($patient_status->status == 'Admitted'){
            return redirect()->route('patients.index')
                                      ->with('danger', 'Deletion failed. Patient is currently admitted.');
        } else{
            $patient = DB::table('patients')
            ->where('id', $request->id)
            ->update(['status' => 'Recycled']);
  
            return redirect()->route('patients.index')
                                      ->with('success', 'Successfully deleted the patients account. You can still restore deleted files from the recycle bin.');
  
        }
    }

    public function hardDelete(Request $request, Patient $id)
    {

       if(Hash::check($request->password_confirmation, Auth::user()->password)){

            $id->delete();
            
            return redirect()->route('recycleBinList')
            ->with('success', 'Successfully deleted patient data.');
       } else {
            return redirect()->route('recycleBinList')
            ->with('danger', 'Incorrect password.');
       }
    }


    public function admitPatientPage($id)
    {
        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
            $patient_status = DB::table('patients')->select('status')->where('id', $id)->first();

        if($patient_status->status == 'Admitted'){  
           
            return redirect()->route('patients.index')
                                      ->with('danger', 'Patient is already admitted.');
        } else{

            $patient_details = Patient::find($id);

            $wards = DB::table('wards')->orderBy('ward_name', 'asc')->get();

            return view('pages.patient.admission', ['patient_details' => $patient_details], ['wards' => $wards]);
        }
    }

    public function dischargePatientPage($id)
    {
        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $id)->first();

        if($patient_status->status == 'Admitted'){  
 
            $patient_details = Patient::find($id);
  
            $patients_admission_details = DB::table('admissions')
                                ->join('wards', 'admissions.ward_id', '=', 'wards.id')
                                ->select('admissions.*', 'wards.id as ward_id', 'wards.ward_name as ward_name')
                                ->where('admissions.patient_id', $id)
                                ->first();

            return view('pages.patient.discharge', ['patient_details' => $patient_details], ['patients_admission_details' => $patients_admission_details]);

        } else{
            return redirect()->route('patients.index')
                                ->with('danger', 'Patient is not admitted.');
        }
    }

    public function admitPatient(Request $request)
    {
        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $request->patient_id)->first();

        if($patient_status == 'Admitted'){

            return redirect()->route('patients.index')
                                      ->with('danger', 'Patient is already admitted.');
        } else{
            $x = 0;

            //CREATE NEW ADMISSION
            $admission_details = new Admission();
            $admission_details->patient_id = $request->patient_id;
            $admission_details->ward_id = request('ward');

            //TEST WHICH ADMISSION DATE AND TIME TO USE(CURRENT OR USER INPUT)
            if(is_null(request('admission_date')) == 'true'){
                $admission_details->admission_date_time = request('alt_datetime');
            }else{
                $ad = request('admission_date');
                $at = request('admission_time');
                $seconds = '00';
                $admission_details->admission_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $ad. ' '. $at .':'. $seconds);
            }
            
            $admission_details->status = 'Admitted';
            // $admission_details->author = Auth::user()->id;
            $admission_details->save();

            return redirect()->route('patients.index')
                                ->with('success', 'Patient has been admitted.');
        }


    }

    public function dischargePatient(Request $request, Patient $patient)
    {

        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $request->patient_id)->first();

        if($patient_status == 'Inactive'){

            return redirect()->route('patients.index')
                                      ->with('danger', 'Patient is not admitted.');
        } else{

            //TEST WHICH ADMISSION DATE AND TIME TO USE(CURRENT OR USER INPUT)
            if(is_null(request('discharge_date')) == 'true'){
                $discharge_date_time = Carbon::now('+8:00');
            }else{
                $dd = request('discharge_time_date');
                $dt = request('discharge_time_time');
                $seconds = '00';
                $discharge_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $dd. ' '. $dt .':'. $seconds);
            }

            //UPDATE ADMISSION
             $admission = DB::table('admissions')
                        ->where('id', $request->id)
                        ->update(['status' => 'Discharged',
                                    'discharge_date_time' => $discharge_date_time]);


            return redirect()->route('patients.index')
                                ->with('success', 'Patient has been successfully discharged.');
        }
    }

    public function recycleBinList()
    {
        $patients = DB::table('patients')->select('id', 'first_name', 'middle_name', 'last_name', 'suffix_name', 'address', 'birthdate', 'status')->where('status', 'Recycled')->orderBy('last_name', 'desc')->paginate(10);

        return view('pages.patient.recycle_bin', ['patients' => $patients]);
    }

    public function searchPatients(Request $request)
    {
            $keyword = $request->get('keyword');

            $patient_admissions = DB::table('patients')
            ->leftJoin('admissions', 'patients.id', '=', 'admissions.patient_id')
            ->select('patients.id','patients.last_name as lname', 'patients.first_name as fname', 'patients.middle_name as mname', 'patients.suffix_name as sname', 'patients.status as status', 'admissions.admission_date_time as admission', 'admissions.discharge_date_time as discharge')
            ->where(function ($query) use ($keyword) {
                                $query->where('patients.id', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.first_name', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.middle_name', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.last_name', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.suffix_name', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.address', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.birthdate', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.status', 'LIKE', '%'.$keyword.'%');
                            })->orderby('last_name', 'asc')
                            ->get();
            
            $results = view('includes.partials.patientSearch', compact('patient_admissions'));
            $view = $results->render();

            return json_encode($view);

    }
}
