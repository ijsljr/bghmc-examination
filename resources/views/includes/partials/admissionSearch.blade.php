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
    <td style="width:15%"><b>{{ strtoupper($patient_admission->status) }}</b></td>
    <td style="width:20%"><b><?php $date = date_create($patient_admission->admission); echo date_format($date, "h:i A - M. d") ?></b></td>
    <td style="width: 20%"><b><?php if(is_null($patient_admission->discharge)){ echo 'N/A';}else{$date = date_create($patient_admission->discharge); echo date_format($date, "h:i A - M. d");} ?></b></td>
    <td style="width: 10%"><b><a class="btn btn-dark btn-sm" id="buttonEdit" href="{{ route('dischargePage',  $patient_admission->id)}}"><b  style="font-size: 13px">DISCHARGE</b></a></b></td>
</tr>
@endforeach