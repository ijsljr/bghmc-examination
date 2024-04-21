@extends('layouts.main')

@section('content')

    <h3 class="m-0 font-weight-bold" style="text-align: center;">
        <b style="color: #d00606">P A T I E N T S </b><b> L I S T</b>
    </h3>
    
    <hr style="color: #d00606">

    <a  class="btn btn-dark btn-sm" id="buttonEdit" href={{ route('patients.create') }}><b>NEW PATIENT</b></a>&nbsp<a  class="btn btn-dark btn-sm" id="buttonEdit" href={{ route('recycleBinList') }}><b>RECYCLE BIN</b></a><br><br>
    <div class="input-group mb-3">
            <input type="text" name="search" id="search-patients" class="form-control my-0 py-1 " aria-label="Search transactions..." placeholder="..."> <a class="btn " onClick="window.location.reload();" style="color: rgb(6, 196, 6)"><i class="fa-solid fa-arrows-rotate"></i></a>
        </div>
    <div>
        <table class="table table-sm" style="text-align:left;">
            <thead class=""  style="color: black; background-color: #f5f5f5">
                <tr>
                    <th style="width: 35%"><b>NAME</b></th>
                    <th style="width: 8%"><b>STATUS</b></th>
                    <th style="width: 27%"><b>ACTIONS</b></th>
                <tr>
            </thead>
            <tbody id="dynamic-row" style="font-size:13px; vertical-align:middle">
                @foreach ($patients_admissions as $patient_admission)
                <tr>
                    <td style="width: 35%"><b><?php if(empty($patient_admission->middle_name) && isset($patient_admission->suffix_name)  ) {
                                        echo strtoupper($patient_admission->last_name.', '.$patient_admission->first_name.', '.$patient_admission->suffix_name);
                                    } else if (empty($patient_admission->suffix_name) && isset($patient_admission->middle_name)){
                                        echo strtoupper($patient_admission->last_name.', '.$patient_admission->first_name.', '.$patient_admission->middle_name);
                                    } else if (empty($patient_admission->suffix_name) && empty($patient_admission->middle_name)){
                                        echo strtoupper($patient_admission->last_name.', '.$patient_admission->first_name);
                                    }else {
                                        echo strtoupper($patient_admission->last_name.', '.$patient_admission->first_name.', '.$patient_admission->middle_name.', '.$patient_admission->suffix_name);
                                    } ?></b></td>
                    <td style="width: 8%"><b>{{ strtoupper($patient_admission->status); }}</b></td>
                    <td style="width: 27%;"><a class="btn btn-dark btn-sm" id="buttonEdit" href="{{ route('patients.show',  $patient_admission->id)}}"><b style="font-size: 13px">VIEW</b></a>&nbsp
                    <a class="btn btn-dark btn-sm" id="buttonEdit" href="{{ route('admit',  $patient_admission->id)}}"><b  style="font-size: 13px">ADMIT</b></a>&nbsp<a class="btn btn-dark btn-sm" id="buttonEdit" href="{{ route('discharge',  $patient_admission->id)}}"><b  style="font-size: 13px">DISCHARGE</b></a>&nbsp
                    <a class="btn btn-dark btn-sm" id="buttonEdit" href="{{ route('patientSoftDelete', $patient_admission->id) }}"><b  style="font-size: 13px">DELETE</b></a></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5">{{ $patients_admissions->links() }}</td>
                </tr>
            </tbody>
        </table>
    </div>


    
@stop