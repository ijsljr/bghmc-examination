@extends('layouts.main')

@section('content')

    <h3 class="m-0 font-weight-bold" style="text-align: center;">
        <b style="color: #d00606">P A T I E N T S </b><b> R E C Y C L E B I N</b>
    </h3>
    
    <hr style="color: #d00606">

    <a  class="btn btn-dark btn-sm" id="buttonEdit" href={{ route('patients.create') }}><b>NEW PATIENT</b></a>&nbsp<a  class="btn btn-dark btn-sm" id="buttonEdit" href={{ route('recycleBinList') }}><b>RECYCLE BIN</b></a><br><br>

    <div>
        <table class="table table-sm" style="text-align:left;">
            <thead class=""  style="color: black; background-color: #f5f5f5">
                <tr>
                    <th style="width: 25%"><b>NAME</b></th>
                    <th style="width: 25%"><b>ADDRESS</b></th>
                    <th style="width: 25%"><b>BIRTHDATE</b></th>
                    <th style="width: 25%"><b>ACTIONS</b></th>
                <tr>
            </thead>
            <tbody style="font-size:13px; vertical-align:middle">
                @foreach ($patients as $patient)
                <!-- MODAL FOR HARD DELETING PATIENT DATA-->
               <div class="modal fade" id="exampleModal-{{ $patient->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title" id="exampleModalLabel"><b>DELETE CONFIRMATION</b></p>
                            </div>
                            <div class="modal-body">
                                <div class="card-head">
                                    <form method='POST' action="{{ route('patientHardDelete', $patient->id) }}">
                                        @csrf
                                        @method('DELETE')
                                    <div class="row mb-3">
                                        <label for="password_confirmation" class="col-sm-2 col-form-label" style="font-size: 13px; font-weight: bold">PASSWORD</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" maxlength="64" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal" style="font-size: 13px">CANCEL</button>
                            <button type="submit" class="btn btn-dark" style="font-size: 13px">CONFIRM</button>
                            </form>
                        </div>
                    </div>
                <tr>
                    <td style="width: 25%"><b><?php if(empty($patient->middle_name) && isset($patient->suffix_name)  ) {
                                        echo strtoupper($patient->last_name.', '.$patient->first_name.', '.$patient->suffix_name);
                                    } else if (empty($patient->suffix_name) && isset($patient->middle_name)){
                                        echo strtoupper($patient->last_name.', '.$patient->first_name.', '.$patient->middle_name);
                                    } else if (empty($patient->suffix_name) && empty($patient->middle_name)){
                                        echo strtoupper($patient->last_name.', '.$patient->first_name);
                                    }else {
                                        echo strtoupper($patient->last_name.', '.$patient->first_name.', '.$patient->middle_name.', '.$patient->suffix_name);
                                    } ?></b></td>
                    <td style="width: 25%"><b>{{ strtoupper($patient->address )}}</b></td>
                    <td style="width: 25%"><b><?php $date = date_create($patient->birthdate); echo date_format($date, "m-d-Y"); ?></b></td>
                    <td style="width: 25%"><a class="btn btn-dark btn-sm" id="buttonEdit" href="{{ route('patientRestore',  $patient->id)}}"><b style="font-size: 13px">RESTORE</b></a>&nbsp<a class="btn btn-dark btn-sm" id="buttonEdit" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $patient->id }}"><b  style="font-size: 13px">DELETE</b></a></td>
                </tr>
                </div>
            </div>
                @endforeach
                <tr>
                    <td colspan="5">{{ $patients->links() }}</td>
                </tr>
            </tbody>
        </table>
    </div>

@stop