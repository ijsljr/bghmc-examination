@extends('layouts.main')

@section('content')
<h3 class="m-0 font-weight-bold" style="text-align: center;">
    <b style="color: #d00606"> P A T I E N T</b><b> D E T A I L S</b>
</h3>
    
<hr style="color: #d00606">

<div class="card" style="width: 70%; margin: auto; margin-top: 20px">


    <div class="card-head">
        <h5 style="text-align: center">Patient Details</h5>
    </div>

    <div class="card-body">

        <form>
         
            <div class="row mb-3">
                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" id="first_name" maxlength="64" value="{{ $patient_details->first_name }}" disabled>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ $patient_details->middle_name }}" disabled>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $patient_details->last_name }}" maxlength="64" disabled>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="suffix_name" class="col-sm-2 col-form-label">Suffix Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="suffix_name" id="suffix_name" value="{{ $patient_details->suffix_name }}" maxlength="16" disabled>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" id="address" value="{{ $patient_details->address }}" maxlength="120" disabled>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="birthdate" class="col-sm-2 col-form-label">Birthdate</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="birthdate" id="birthdate" value="{{ $patient_details->birthdate }}" max="<?php echo date('Y-m-d'); ?>" disabled>
                </div>
            </div>
    
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-2">
                    <a type="button" class="btn font-weight-bold btn-outline-success btn-sm" href="{{ route('patients.edit',  $patient_details->id) }}" id="buttonEdit"><b>
                        {{ __('EDIT') }}</b>
                    </a>
                </div>
            </div>
    
        </form>

    </div>

</div>

@stop