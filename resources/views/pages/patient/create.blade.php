@extends('layouts.main')

@section('content')

<div class="card" style="width: 70%; margin: auto; margin-top: 100px">


    <div class="card-head">
        <h5 style="text-align: center">Patient Details</h5>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('patients.store')}}">
            @csrf

                                    
            <div class="row mb-3">
                <div class="col-sm-10">
                  <input type="checkbox" id="checkbox_admit" name="checkbox_admit" value="1" onclick="show_ward()">
                  <label for="checkbox_admit">Admit New Patient</label><br>
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" id="first_name" maxlength="64" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="middle_name" id="middle_name" maxlength="64">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" id="last_name" maxlength="64" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="suffix_name" class="col-sm-2 col-form-label">Suffix Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="suffix_name" id="suffix_name" maxlength="16">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" id="address" maxlength="120" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="birth_date" class="col-sm-2 col-form-label">Birthdate</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="birth_date" id="birthdate" required>
                </div>
            </div>

            <div class="row mb-3" id="ward_div">
                <label for="ward" class="col-sm-2 col-form-label">Ward</label>
                <div class="col-sm-10">
                  <select style="color: black;" class="form-control" id="ward" name="ward" disabled>
                    <option value=""selected disabled>---</option>
                    @foreach ($wards as $ward)
                      <option value="{{ $ward->id }}">{{ $ward->ward_name}}</option>
                    @endforeach
                  </select>
                </div>
            </div>
    
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-2">
                    <button type="submit" class="btn font-weight-bold btn-outline-success btn-sm" id="buttonEdit"><b>
                        {{ __('SAVE') }}</b>
                    </button>
                </div>
            </div>
    
        </form>

    </div>

</div>

@stop