@extends('layouts.main')

@section('content')
<h3 class="m-0 font-weight-bold" style="text-align: center;">
    <b>A D M I T</b><b style="color: #d00606"> P A T I E N T</b>
</h3>
    
<hr style="color: #d00606">

<div class="card" style="width: 70%; margin: auto; margin-top: 20px">


    <div class="card-head">
        <h5 style="text-align: center">Patient Details</h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('admitPatient')}}">
            @csrf
            
            <input type="hidden" id="patient_id" name="patient_id" value="{{ $patient_details->id }}">

            <div class="row mb-3">
                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $patient_details->first_name }}" readonly>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ $patient_details->middle_name }}" readonly>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $patient_details->last_name }}" readonly>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="suffix_name" class="col-sm-2 col-form-label">Suffix Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="suffix_name" id="suffix_name" value="{{ $patient_details->suffix_name }}" readonly>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" id="address" value="{{ $patient_details->address }}"  readonly>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="birthdate" class="col-sm-2 col-form-label">Birthdate</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="birthdate" id="birthdate" value="{{ $patient_details->birthdate }}"  readonly>
                </div>
            </div>

            <div class="row mb-3" id="ward_div">
                <label for="ward" class="col-sm-2 col-form-label">Ward</label>
                <div class="col-sm-10">
                <select style="color: black;" class="form-control" id="ward" name="ward" required>
                    <option value=""selected disabled>---</option>
                    @foreach ($wards as $ward)
                    <option value="{{ $ward->id }}">{{ $ward->ward_name}}</option>
                    @endforeach
                </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="admission_date" class="col-sm-2 col-form-label">Admission Date/Time</label>
                <div class="col-sm-5">
                    <input type="date" class="form-control" name="admission_date" id="admission_date" max="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="col-sm-5">
                    <input type="time" class="form-control" name="admission_time" id="admission_time" required>
                </div>
                <div class="row mb-3">
                    <label for="alt_datetime" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="checkbox" id="alt_datetime" name="alt_datetime" value="{{ date('Y-m-d H:i:s'); }}" onclick="use_current_datetime()">
                        <label for="checkbox_admit"><span style="b">Use current date and time ({{date('F j, Y ');}}</span><span id="clock"></span><span>)</span></label><br>
                    </div>
                </div>
            </div>

            <!-- END -->
    
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-2">
                    <button type="submit" class="btn font-weight-bold btn-outline-success btn-sm" id="buttonEdit"><b>
                        {{ __('ADMIT') }}</b>
                    </button>
                </div>
            </div>
    
        </form>

    </div>

</div>

@stop