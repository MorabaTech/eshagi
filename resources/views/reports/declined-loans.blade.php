<?php
/**
 *Created by PhpStorm for eshagi
 *User: Vincent Guyo
 *Date: 10/26/2020
 *Time: 11:39 AM
 */

?>
@extends('layouts.app')

@section('template_title')
    Declined Loans Report
@endsection

@section('template_linked_css')

    <link href="{{ asset('css/select2.min.css')}}" rel="stylesheet" />
    <!-- DataTables -->
    <link href="{{url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{url('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="page-title-box">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title mb-1">Declined Loans Report For All Clients</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                        <li class="breadcrumb-item active">Declined Loans For All Clients</li>
                    </ol>
                </div>

                <div class="col-md-4">
                    <div class="float-right d-none d-md-block">

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- end page title end breadcrumb -->
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(array('route' => 'declined.report', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Range of dates</label>
                                        <input type="text" name="date_range" class="form-control datepicker-here" data-range="true" data-multiple-dates-separator=" - " data-language="en" required/>
                                    </div>
                                </div>

                                <div class="col-lg-2 float-right">
                                    {!! Form::button('Get Report', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                                </div>
                            </div>

                            {!! Form::close() !!}

                            @if(isset($loans))
                                <strong>Showing Declined Loans for all clients</strong>
                                <br>
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>National ID</th>
                                        <th>Loan Type</th>
                                        <th>Amount</th>
                                        <th>Monthly</th>
                                        <th>Tenure</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($loans as $loan)
                                        <tr>
                                            <td>{{$loan->created_at}}</td>
                                            <td>{{$loan->first_name}} {{$loan->last_name}}</td>
                                            <td>{{$loan->natid}}</td>
                                            <td>@if ($loan->loan_type == 1)
                                                    Store Credit
                                                @elseif($loan->loan_type == 2)
                                                    Cash Loan
                                                @elseif($loan->loan_type == 3)
                                                    Recharge Credit
                                                @endif</td>
                                            <td>{{$loan->amount}}</td>
                                            <td>{{$loan->monthly}}</td>
                                            <td>{{$loan->paybackPeriod}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

    <!-- Required datatable js -->
    <script src="{{url('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{url('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{url('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{url('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{url('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <!-- Datatable init js -->
    <script src="{{url('assets/js/pages/datatables.init.js')}}"></script>
@endsection