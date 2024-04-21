@foreach ($patient_admissions as $patient_admission)
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