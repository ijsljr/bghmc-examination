@extends('layouts.main')

@section('content')
<h3 class="m-0 font-weight-bold" style="text-align: center;">
    <b>E D I T</b><b style="color: #d00606"> P A T I E N T</b>
</h3>
    
<hr style="color: #d00606">

<div class="card" style="width: 70%; margin: auto; margin-top: 20px">


    <div class="card-head">
        <h5 style="text-align: center">Patient Details</h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('patients.update', $patient_details->id)}}" style="font-size: 13px; vertical-align: middle; font-weight: bold">
            @csrf
            @method('PUT')
   
         
            <div class="row mb-3">
                <label for="first_name" class="col-sm-2 col-form-label">FIRST NAME</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" id="first_name" style="font-size: 13px; vertical-align: middle; font-weight: bold" maxlength="64" value="{{ $patient_details->first_name }}" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="middle_name" class="col-sm-2 col-form-label">MIDDLE NAME</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="middle_name" id="middle_name" style="font-size: 13px; vertical-align: middle; font-weight: bold" value="{{ $patient_details->middle_name }}" maxlength="64">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="last_name" class="col-sm-2 col-form-label">LAST NAME</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" id="last_name" style="font-size: 13px; vertical-align: middle; font-weight: bold" value="{{ $patient_details->last_name }}" maxlength="64" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="suffix_name" class="col-sm-2 col-form-label">SUFFIX NAME</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="suffix_name" id="suffix_name" style="font-size: 13px; vertical-align: middle; font-weight: bold" value="{{ $patient_details->suffix_name }}" maxlength="16">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">ADDRESS</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" id="address" style="font-size: 13px; vertical-align: middle; font-weight: bold" value="{{ $patient_details->address }}" maxlength="120" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="birthdate" class="col-sm-2 col-form-label">DATE OF BIRTH</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="birthdate" id="birthdate" style="font-size: 13px; vertical-align: middle; font-weight: bold" value="{{ $patient_details->birthdate }}" max="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>
    
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-2">
                    <button type="submit" class="btn font-weight-bold btn-dark btn-sm" id="buttonEdit"><b style="font-size: 13px; vertical-align: middle; font-weight: bold">
                        {{ __('SAVE') }}</b>
                    </button>
                </div>
            </div>
    
        </form>

    </div>

</div>

@stop