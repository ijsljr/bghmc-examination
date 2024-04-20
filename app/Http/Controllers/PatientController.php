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
                                    ->select('patients.id','patients.last_name as lname', 'patients.first_name as fname', 'patients.middle_name as mname', 'patients.suffix_name as sname', 'admissions.admission_date_time as admission', 'admissions.discharge_date_time as discharge', 'patients.status as status')->paginate(10);
                                    

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
    public function show(Patient $patient)
    {
        $expense = Expenses::find($request->expense);

        return view('expenses.show', compact('expense'));
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

    public function admitPatient(Request $request, Patient $patient)
    {
        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $request->id)->first();

        if($patient_status->status == 'Admitted'){
            return redirect()->route('patients.index')
                                      ->with('danger', 'Admission failed. Patient is already admitted.');
        } else if($patient_status->status == 'Inactive'){
            $patient = DB::table('patients')
            ->where('id', $request->id)
            ->update(['status' => 'Recycled']);
  
            return redirect()->route('patients.index')
                                      ->with('success', 'Successfully deleted the patients account. You can still restore deleted files from the recycle bin.');
        } else{
            return redirect()->route('patients.index');
  
        }
    }

    public function dischargePatient(Request $request, Patient $patient)
    {
        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $request->id)->first();

        if($patient_status->status == 'Admitted'){
            $patient = DB::table('patients')
            ->where('id', $request->id)
            ->update(['status' => 'Discharged']);
  
            return redirect()->route('patients.index')
                                      ->with('success', 'Successfully discharged the patient.');
        } else if($patient_status->status == 'Inactive'){
            return redirect()->route('patients.index')
                                      ->with('danger', 'Discharge failed. Patient is not admitted.');
        } else{
            return redirect()->route('patients.index');
  
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
            ->join('admissions', 'patients.id', '=', 'admissions.patient_id')
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
                            })
                            ->get();
    
            return view('includes.partials.patientSearch', compact('patient_admissions'))->render();
    }
}
