@extends('layouts.main')

@section('content')

    <h3 class="m-0 font-weight-bold" style="text-align: center;">
        <b style="color: #d00606">W A R D</b><b> L I S T</b>
    </h3>
    
    <hr style="color: #d00606">

    <a  class="btn btn-outline-primary btn-sm" id="buttonEdit" href={{ route('wards.create') }}><b>NEW WARD</b></a>
    <br><br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><b></b> &nbsp<i class="fa-solid fa-magnifying-glass"></i></span>
        </div>
            <input type="text" name="search" id="search-patients" class="form-control my-0 py-1 " aria-label="Search transactions..." placeholder="..."> <a class="btn " onClick="window.location.reload();" style="color: rgb(6, 196, 6)"><i class="fa-solid fa-arrows-rotate"></i></a>
        </div>
    <div>
        <table class="table table-sm" style="text-align:left;">
            <thead class=""  style="color: black; background-color: #f5f5f5">
                <tr>
                    <th><b>NAME</b></th>
                    <th><b>STATUS</b></th>
                    <th><b>ADMISSION DATE</b></th>
                    <th><b>DISCHARGE DATE</b></th>
                    <th><b>ACTIONS</b></th>
                <tr>
            </thead>
            <tbody id="dynamic-row">

                <tr>
                    <td><b></b></a></td>
                </tr>

                <tr>

                </tr>
            </tbody>
        </table>
    </div>


    
@stop