@extends('layouts.main')

@section('content')

    <h3 class="m-0 font-weight-bold" style="text-align: center;">
        <b style="color: #d00606">P A T I E N T S </b><b> L I S T</b>
    </h3>
    
    <hr style="color: #d00606">

    <a  class="btn btn-outline-primary btn-sm" id="buttonEdit" href={{ route('patients.create') }}><b>NEW PATIENT</b></a><br><br>

    <div>
        <table class="table table-sm" style="text-align:left;">
            <thead class=""  style="color: black; background-color: #f5f5f5">
                <tr>
                    <th><b>NAME</b></th>
                    <th><b>STATUS</b></th>
                    <th><b>ADMISSION DATE</b></th>
                    <th><b>DISCHARGE DATE</b></th>
                    <th><b>ACTIONS</b></th>
                <tr>
            </thead>
            <tbody>
                @foreach ($patients_admissions as $patient_admission)
                <tr>
                    <td><b><?php if(empty($patient_admission->mname) && isset($patient_admission->sname)  ) {
                                        echo strtoupper($patient_admission->lname.', '.$patient_admission->fname.', '.$patient_admission->sname);
                                    } else if (empty($patient_admission->sname) && isset($patient_admission->mname)){
                                        echo strtoupper($patient_admission->lname.', '.$patient_admission->fname.', '.$patient_admission->mname);
                                    } else if (empty($patient_admission->sname) && empty($patient_admission->mname)){
                                        echo strtoupper($patient_admission->lname.', '.$patient_admission->fname);
                                    }else {
                                        echo strtoupper($patient_admission->lname.', '.$patient_admission->fname.', '.$patient_admission->mname.', '.$patient_admission->sname);
                                    } ?></b></td>
                    <td><b>{{ strtoupper($patient_admission->status); }}</b></td>
                    <td><b><?php $date = date_create($patient_admission->admission); echo date_format($date, "h:i A - M. d") ?></b></td>
                    <td><b><?php if(is_null($patient_admission->discharge)){ echo 'N/A';}else{$date = date_create($patient_admission->discharge); echo date_format($date, "h:i A");} ?></b></td>
                    <td><a class="btn btn-outline-warning btn-sm" id="buttonEdit" href="{{ route('patients.show',  $patient_admission->id)}}"><b>VIEW</b></a>&nbsp<a class="btn btn-outline-info btn-sm" id="buttonEdit" href="{{ route('patients.edit',  $patient_admission->id)}}"><b>EDIT</b></a>&nbsp<a class="btn btn-outline-danger btn-sm" id="buttonEdit" href="{{ route('patientSoftDelete', $patient_admission->id) }}"><b>DELETE</b></a></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5">{{ $patients_admissions->links() }}</td>
                </tr>
            </tbody>
        </table>
    </div>


    
@stop