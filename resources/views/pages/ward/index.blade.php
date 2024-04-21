@extends('layouts.main')

@section('content')

    <h3 class="m-0 font-weight-bold" style="text-align: center;">
        <b style="color: #d00606">W A R D</b><b> L I S T</b>
    </h3>
    
    <hr style="color: #d00606">

    <a  class="btn btn-outline-primary btn-sm" id="buttonEdit" href={{ route('wards.create') }}><b>NEW WARD</b></a>
    <br><br>

        <table class="table table-sm" style="text-align:left;">
            <thead class=""  style="color: black; background-color: #f5f5f5">
                <tr>
                    <th style="width: 25%"><b>NAME</b></th>
                    <th style="width: 25%"><b>DESCRIPTION</b></th>
                    <th style="width: 25%"><b>TOTAL PATIENTS</b></th>
                    <th style="width: 25%"><b>ACTIONS</b></th>
                <tr>
            </thead>
            <tbody id="dynamic-row">

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                </tr>
            </tbody>
        </table>
    </div>


    
@stop