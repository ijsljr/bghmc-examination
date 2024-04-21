@extends('layouts.main')

@section('content')
<h3 class="m-0 font-weight-bold" style="text-align: center;">
    <b>N E W</b><b style="color: #d00606"> P A T I E N T</b>
</h3>
    
<hr style="color: #d00606">

<div class="card" style="width: 70%; margin: auto; margin-top: 20px">


    <div class="card-head">
        <h5 style="text-align: center">Patient Details</h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('patients.store')}}" style="font-size: 13px">
            @csrf

                                    
            <div class="row mb-3">
                <div class="col-sm-10">
                  <input type="checkbox" id="checkbox_admit" name="checkbox_admit" value="1" onclick="show_admission_fields()">
                  <label for="checkbox_admit">Admit New Patient</label><br>
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" id="first_name" style="font-size: 13px; font-weight: bold;" maxlength="64" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="middle_name" id="middle_name" style="font-size: 13px; font-weight: bold;" maxlength="64">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" id="last_name" style="font-size: 13px; font-weight: bold;" maxlength="64" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="suffix_name" class="col-sm-2 col-form-label">Suffix Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="suffix_name" id="suffix_name" style="font-size: 13px; font-weight: bold;" maxlength="16">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" id="address" style="font-size: 13px; font-weight: bold;" maxlength="120" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="birthdate" class="col-sm-2 col-form-label">Birthdate</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="birthdate" id="birthdate" style="font-size: 13px; font-weight: bold;" max="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>

            <!-- FIELDS FOR ADMITTING PATIENT-->
            <div id="hidden_fields" style="display: none">
                <div class="row mb-3" id="ward_div" >
                    <label for="ward" class="col-sm-2 col-form-label">Ward</label>
                    <div class="col-sm-10" style="font-size: 13px; font-weight: bold;">
                    <select style="color: black;" class="form-control" style="font-size: 13px; font-weight: bold;" id="ward" name="ward">
                        <option value=""selected disabled>---</option>
                        @foreach ($wards as $ward)
                        <option value="{{ $ward->id }}" style="font-size: 13px; font-weight: bold;">{{ $ward->ward_name}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="admission_date" class="col-sm-2 col-form-label">Admission Date/Time</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="admission_date" id="admission_date" style="font-size: 13px; font-weight: bold;" max="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-sm-5">
                        <input type="time" class="form-control" name="admission_time" id="admission_time" style="font-size: 13px; font-weight: bold;">
                    </div>
                    <div class="row mb-3">
                        <label for="alt_datetime" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <input type="checkbox" id="alt_datetime" name="alt_datetime" value="{{ date('Y-m-d H:i:s'); }}" onclick="use_current_datetime()">
                            <label for="checkbox_admit"><span style="font-size: 13px; font-weight: bold;">Use current date and time ({{date('F j, Y ');}}</span><span id="clock" style="font-size: 13px; font-weight: bold;"></span><span>)</span></label><br>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END -->
    
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-2">
                    <button type="submit" class="btn font-weight-bold btn-dark btn-sm" id="buttonEdit" style="font-size: 13px"><b>
                        {{ __('SAVE') }}</b>
                    </button>
                </div>
            </div>
    
        </form>

    </div>

</div>

@stop