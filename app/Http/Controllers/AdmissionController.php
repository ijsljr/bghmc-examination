<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Http\Requests\StoreAdmissionRequest;
use App\Http\Requests\UpdateAdmissionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Ward;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients_admissions = DB::table('admissions')
                                ->join('patients', 'admissions.patient_id', '=', 'patients.id')
                                ->select('patients.id','patients.last_name as lname', 'patients.first_name as fname', 'patients.middle_name as mname', 'patients.suffix_name as sname', 'admissions.admission_date_time as admission', 'admissions.discharge_date_time as discharge', 'admissions.status as status')
                                ->whereDate('admissions.admission_date_time', DATE(Carbon::now()->format('Y-m-d')))
                                ->orderBy('lname', 'asc')
                                ->paginate(10);

        return view('pages.admission.index', ['patients_admissions' => $patients_admissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $wards = DB::table('wards')->orderBy('ward_name', 'asc')->get();
        $patients = DB::table('patients')->orderBy('last_name', 'asc')->get();
        
        return view('pages.admission.create', ['wards' => $wards], ['patients' => $patients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdmissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $patient_status = DB::table('patients')->select('status')->where('id', request('patient_id'))->first();

        if($patient_status->status == 'Admitted'){
            return redirect()->route('admissions.index')
                                      ->with('danger', 'Admission failed. Patient is already admitted.');
        }else{
            //TEST WHICH ADMISSION DATE AND TIME TO USE(CURRENT OR USER INPUT)
            if(is_null(request('admission_date')) == 'true'){
            
                $patient = DB::table('patients')
                                ->where('id', request('patient_id'))
                                ->update(['status' => 'Admitted']);
                
                //CREATE NEW ADMISSION
                $admission_details = new Admission();
                $admission_details->patient_id = request('patient_id');
                $admission_details->ward_id = request('ward_id');
                $admission_details->admission_date_time = Carbon::now('+8:00');
                $admission_details->status = 'Admitted';
                $admission_details->save();

            return redirect()->route('admissions.index')
                                ->with('success', 'Patient has been admitted.');
            }else{
                $ad = request('admission_date');
                $at = request('admission_time');
                $seconds = '00';
            
                $patient = DB::table('patients')
                                ->where('id', request('patient_id'))
                                ->update(['status' => 'Admitted']);
                
                //CREATE NEW ADMISSION
                $admission_details = new Admission();
                $admission_details->patient_id = $request->patient_id;
                $admission_details->ward_id = request('ward_id');
                $admission_details->admission_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $ad. ' '. $at .':'. $seconds);
                $admission_details->status = 'Admitted';
                $admission_details->save();

            return redirect()->route('admissions.index')
                                        ->with('success', 'Patient has been admitted.');

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function show(Admission $admission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function edit(Admission $admission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdmissionRequest  $request
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdmissionRequest $request, Admission $admission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admission  $admission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admission $admission)
    {
        //
    }

    public function admitPatientPage($id)
    {
        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
            $patient_status = DB::table('patients')->select('status')->where('id', $id)->first();

        if($patient_status->status == 'Admitted'){  
           
            return redirect()->route('admissions.index')
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
        $data = DB::table('admissions')->where('patient_id', $id)->whereNull('discharge_date_time')->first();

        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $id)->first();

        if($patient_status->status == 'Admitted'){  
 
            $patient_details = Patient::find($id);
  
            $patients_admission_details = DB::table('admissions')
                                ->join('wards', 'admissions.ward_id', '=', 'wards.id')
                                ->select('admissions.*', 'wards.id as ward_id', 'wards.ward_name as ward_name')
                                ->where('admissions.patient_id', $id)
                                ->first();

            return view('pages.admission.discharge', ['patient_details' => $patient_details], ['patients_admission_details' => $patients_admission_details]);

        } else{
            return redirect()->route('admissions.index')
                                ->with('danger', 'Patient is not admitted.');
        }
    }

    public function admitPatients(Request $request)
    {
        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $request->patient_id)->first();

        if($patient_status == 'Admitted'){

            return redirect()->route('admissions.index')
                                      ->with('danger', 'Patient is already admitted.');
        } else{
            $patient_status_update = DB::table('patients')
                            ->where('id', $request->patient_id)
                            ->update(['status' => 'Admitted']);

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

            return redirect()->route('admissions.index')
                                ->with('success', 'Patient has been admitted.');
        }


    }

    public function dischargePatients(Request $request, Patient $patient)
    {

        //CHECK IF PATIENT HAS AN EXISTING ADMISSION
        $patient_status = DB::table('patients')->select('status')->where('id', $request->patient_id)->first();

   
        if($patient_status->status == 'Inactive'){

            return redirect()->route('admissions.index')
                                      ->with('danger', 'Patient is not admitted.');
        } else{
            
            //TEST WHICH ADMISSION DATE AND TIME TO USE(CURRENT OR USER INPUT)
            if(is_null(request('discharge_date')) == 'true'){
                
                $discharge_date_time = Carbon::now('+8:00');
            }else{
                $dd = request('discharge_date');
                $dt = request('discharge_time');
                $seconds = '00';
                $discharge_date_time = Carbon::createFromFormat('Y-m-d H:i:s', $dd. ' '. $dt .':'. $seconds);
            }

            //UPDATE THIS
            $data = DB::table('admissions')->where('patient_id', $request->patient_id)->whereNull('discharge_date_time')->first();


            //UPDATE ADMISSION
             $admission_status = DB::table('admissions')
                        ->where('id', $data->id)
                        ->update(['status' => 'Discharged' ]);
            
            $admission_date_time = DB::table('admissions')
                        ->where('id', $data->id)
                        ->update(['discharge_date_time' => $discharge_date_time]);
            
            $patient_status = DB::table('patients')
                        ->where('id', $request->patient_id)
                        ->update(['status' => 'Discharged']);
                        

            return redirect()->route('admissions.index')
                                ->with('success', 'Patient has been successfully discharged.');
        }
    }

    public function searchAdmissions(Request $request)
    {
            $keyword = $request->get('keyword');

            $patients_admissions = DB::table('admissions')
            ->join('patients', 'admissions.patient_id', '=', 'patients.id')
            ->select('patients.id','patients.last_name as lname', 'patients.first_name as fname', 'patients.middle_name as mname', 'patients.suffix_name as sname', 'admissions.admission_date_time as admission', 'admissions.discharge_date_time as discharge', 'admissions.status as status')
                            ->where(function ($query) use ($keyword) {
                                $query->where('admissions.id', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('admissions.patient_id', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('admissions.ward_id', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('admissions.status', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('admissions.admission_date_time', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('admissions.discharge_date_time', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.first_name', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.middle_name', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.last_name', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.suffix_name', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.address', 'LIKE', '%'.$keyword.'%')
                                        ->orWhere('patients.birthdate', 'LIKE', '%'.$keyword.'%');
                            })->orderby('id', 'asc')
                            ->get();
            
            $results = view('includes.partials.admissionSearch', compact('patients_admissions'));
            $view = $results->render();

            return json_encode($view);

    }
}
