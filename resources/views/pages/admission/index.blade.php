@extends('layouts.main')

@section('content')

    <h3 class="m-0 font-weight-bold" style="text-align: center;">
        <b style="color: #d00606">A D M I S S I O N S </b><b> L I S T</b>
    </h3>
    
    <hr style="color: #d00606">

    <a  class="btn btn-outline-primary btn-sm" id="buttonEdit" href="{{ route('admissions.create')}}"><b>NEW ADMISSION</b></a><br><br>

        <table class="table table-sm" style="text-align:left;">
            <thead class=""  style="color: black; background-color: #f5f5f5">
                <tr>
                    <th style="width: 35%"><b>NAME</b></th>
                    <th style="width: 25%"><b>ADMISSION DATE</b></th>
                    <th style="width: 25%"><b>DISCHARGE DATE</b></th>
                    <th style="width: 15%"><b>ACTIONS</b></th>
                <tr>
            </thead>
            <tbody id="dynamic-row" style="font-size:13px; vertical-align:middle">
                @foreach ($patients_admissions as $patient_admission)
                <tr>
                    <td style="width: 35%"><b><?php if(empty($patient_admission->mname) && isset($patient_admission->sname)  ) {
                                        echo strtoupper($patient_admission->lname.', '.$patient_admission->fname.', '.$patient_admission->sname);
                                    } else if (empty($patient_admission->sname) && isset($patient_admission->mname)){
                                        echo strtoupper($patient_admission->lname.', '.$patient_admission->fname.', '.$patient_admission->mname);
                                    } else if (empty($patient_admission->sname) && empty($patient_admission->mname)){
                                        echo strtoupper($patient_admission->lname.', '.$patient_admission->fname);
                                    }else {
                                        echo strtoupper($patient_admission->lname.', '.$patient_admission->fname.', '.$patient_admission->mname.', '.$patient_admission->sname);
                                    } ?></b></td>
                    <td style="width:25%"><b><?php $date = date_create($patient_admission->admission); echo date_format($date, "h:i A - M. d") ?></b></td>
                    <td style="width: 25%"><b><?php if(is_null($patient_admission->discharge)){ echo 'N/A';}else{$date = date_create($patient_admission->discharge); echo date_format($date, "h:i A - M. d");} ?></b></td>
                    <td style="width: 15%"><b><a class="btn btn-outline-warning btn-sm" id="buttonEdit" href="{{ route('dischargePage',  $patient_admission->id)}}"><b  style="font-size: 13px">DISCHARGE</b></a></b></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5">{{ $patients_admissions->links() }}</td>
                </tr>
            </tbody>
        </table>
    </div>


    
@stop