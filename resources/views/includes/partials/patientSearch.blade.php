@foreach ($patient_admissions as $patient_admission)
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
        <td style="width: 8%"><b>{{ strtoupper($patient_admission->status); }}</b></td>
        <td style="width: 15%"><b><?php $date = date_create($patient_admission->admission); echo date_format($date, "h:i A - M. d") ?></b></td>
        <td style="width: 15%"><b><?php if(is_null($patient_admission->discharge)){ echo 'N/A';}else{$date = date_create($patient_admission->discharge); echo date_format($date, "h:i A");} ?></b></td>
        <td style="width: 27%"><a class="btn btn-warning btn-sm active" id="buttonEdit" href="{{ route('patients.show',  $patient_admission->id)}}"><b>VIEW</b></a>&nbsp<a class="btn btn-outline-warning btn-sm" id="buttonEdit" href="{{ route('admit',  $patient_admission->id)}}"><b>ADMIT</b></a>&nbsp<a class="btn btn-outline-warning btn-sm" id="buttonEdit" href="{{ route('patients.show',  $patient_admission->id)}}"><b>DISCHARGE</b></a>&nbsp<a class="btn btn-outline-info btn-sm" id="buttonEdit" href="{{ route('patients.edit',  $patient_admission->id)}}"><b>EDIT</b></a>&nbsp<a class="btn btn-outline-danger btn-sm" id="buttonEdit" href="{{ route('patientSoftDelete', $patient_admission->id) }}"><b>DELETE</b></a></td>
    </tr>
@endforeach
