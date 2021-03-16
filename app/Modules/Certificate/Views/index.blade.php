@extends('layouts.admin')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Certificates</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#createCertificate" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
    </div>
</div>
<div class="users-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>Stock Class</th>
                                <th>Total Shares</th>
                                <th>Issued Date</th>
                                <th>Number of Paper Certificates to Issue</th>
                                <th>Reason/Reservation</th>
                                <th>Received From</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $currentCertificate)
                            <tr>
                                <td>
                                    {{$currentCertificate->stock_class}}
                                </td>
                                <td>
                                    {{$currentCertificate->total_shares}}
                                </td>
                                <td>
                                    {{$currentCertificate->issued_date}}
                                </td>
                                <td>
                                    {{$currentCertificate->nr_of_paper}}
                                </td>
                                <td>
                                    {{$currentCertificate->reservation}}
                                </td>
                                <td>
                                    {{$currentCertificate->received_from}}
                                </td>
                                <td style="min-width:160px;">
                                    <a href="/admin/certificates/show/{{$currentCertificate->id}}" title="Show">
                                        <button type="button" class="btn btn-icon btn-light-info mr-1 mb-1">
                                            <i class="bx bxs-info-circle"></i>
                                        </button>
                                    </a>
                                    <a class="icons" href="{{ route('admin.certificates.edit', $currentCertificate->id) }}" title="Edit">
                                        <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1">
                                            <i class="bx bx-edit-alt"></i></button>
                                    </a>
                                    <a href="/admin/certificates/delete/{{$currentCertificate->id}}" class="btn btn-icon btn-light-danger mr-1 mb-1" title="delete" onclick="return confirm('Are you sure you want to delete this Certificate?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- datatable ends -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="createCertificate" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Issue</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route("admin.certificates.store") }}" id="certificateForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <nav>
                        <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" style="margin-right:5px;">Step 1</a>
                            <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2">Step 2</a>
                        </div>
                    </nav>
                    <div class="tab-content py-4" id="nav-tabContent" style="padding-top:1.5rem !important;">
                        <div class="tab-pane fade show active" id="step1">
                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                    <input class="first_radio" type="radio" id="capital_gains" name="first_radio" value="transfer" checked>
                                    <label for="vehicle1">Transfer</label>
                                    <input class="first_radio" type="radio" id="non_dividend_distribution" name="first_radio" value="new_issue">
                                    <label for="vehicle1">New Issue</label>
                                    <input class="first_radio" type="radio" id="non_dividend_distribution" name="first_radio" value="replace_lost">
                                    <label for="vehicle1">Replace Lost/Stolen</label><br>
                                    <input class="first_radio" type="radio" id="non_dividend_distribution" name="first_radio" value="replace_damaged">
                                    <label for="vehicle1">Replace Damaged/Destroyed</label>
                                    <input class="first_radio" type="radio" id="non_dividend_distribution" name="first_radio" value="retire_certs">
                                    <label for="vehicle1">Retire Certs</label>
                                    <input class="first_radio" type="radio" id="non_dividend_distribution" name="first_radio" value="stock_conversion">
                                    <label for="vehicle1">Stock Conversion</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                    <label for="target">SEC Tracking</label>
                                    <br>
                                    <input class="second_first_radio" type="radio" id="non_dividend_distribution" name="sec_tracking" value="routine">
                                    <label for="vehicle1">Routine</label>
                                    <input class="second_first_radio" type="radio" id="non_dividend_distribution" name="sec_tracking" value="non_routine">
                                    <label for="vehicle1">Non Routine</label>
                                    <input class="second_radio" type="radio" id="non_dividend_distribution" name="sec_tracking" value="void" disabled>
                                    <label for="vehicle1">Void</label>
                                    <input class="second_radio" type="radio" id="non_dividend_distribution" name="sec_tracking" value="rejected" disabled>
                                    <label for="vehicle1">Rejected</label>
                                    <input class="second_radio" type="radio" id="non_dividend_distribution" name="sec_tracking" value="not_an_item" disabled>
                                    <label for="vehicle1">Not an Item</label>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                    <label for="target">Item Count</label>
                                    <input type="text" id="item_count" name="item_count" class="form-control " value="" disabled>
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                    <label for="target">ID/SCL</label>
                                    <input type="text" id="scl" name="scl" class="form-control " value="">
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                    <label for="target">Control Ticket</label>
                                    <input type="text" id="control_ticket" name="control_ticket" class="form-control " value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Received</label>
                                    <input type="text" id="received" name="received" class="form-control datepicker" value="">
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">at</label>
                                    <input type="text" id="received_at" name="received_at" class="form-control " value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Received From</label>
                                    <select name="received_from" id="received_from" class="form-control">
                                        @foreach($shareholders as $shareholder)
                                        <option value="{{$shareholder->id}}">{{$shareholder->name_as_appears_on_certificate}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">How Received</label>
                                    <input type="text" id="how_received" name="how_received" class="form-control " value="" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Tracking #</label>
                                    <input type="text" id="track" name="track" class="form-control " value="" required>
                                </div>
                            </div>
                        </div>
                        <!-- End of first step -->
                        <!-- Start of second step -->
                        <div class="tab-pane fade" id="step2">
                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                    <label for="target">Add to Shareholder</label>
                                    <select name="shareholder_id" id="shareholder_id" class="form-control">
                                        @foreach($shareholders as $shareholder)
                                        <option value="{{$shareholder->id}}">{{$shareholder->name_as_appears_on_certificate}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Stock Class</label>
                                    <input type="text" id="stock_class" name="stock_class" class="form-control " value="" required>
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Total Shares</label>
                                    <input type="text" id="total_shares" name="total_shares" class="form-control" value="" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Issued Date</label>
                                    <input type="text" id="issued_date" name="issued_date" class="form-control datepicker" value="" required>
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Reason/Reservation</label>
                                    <input type="text" id="reservation" name="reservation" class="form-control " value="" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Nr of Paper Certificates to Issue</label>
                                    <input type="text" id="nr_of_paper" name="nr_of_paper" class="form-control " value="" required>
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Restriction</label>
                                    <input type="text" id="restriction" name="restriction" class="form-control " value="" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('received_from') ? 'has-error' : '' }} col-lg-6">
                                    <label for="received_from">Received From</label>
                                    <input type="text" id="received_from_certificate" name="received_from_certificate" class="form-control " value="" required>
                                </div>

                                <div class="col-lg-6" style="padding-top: 25px;">
                                    <input type="checkbox" id="broker" name="broker" value="1">
                                    <label for="broker">Broker involved</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="checkbox" id="costOfBasisReceived" value="1" name="cost_of_basis_received" style="margin-top:5px;">
                                    <label for="vehicle1" style="margin-top:0px; margin-left: 2px;">Cost Basis Received?</label><br>
                                </div>
                            </div>

                            <hr />

                            <div id="costItems" class="hidden">
                                <div class="row">
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                        <label for="target">Acquired</label>
                                        <select name="acquired" id="acquired" class="form-control">
                                            <option></option>
                                            @foreach($shareholders as $shareholder)
                                            <option value="{{$shareholder->id}}">{{$shareholder->name_as_appears_on_certificate}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                        <label for="target">Sale Amt/Share</label>
                                        <input type="text" id="amt_share" name="amt_share" class="form-control " value="">
                                    </div>

                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                        <label for="target">FMW</label>
                                        <input type="text" id="fmw" name="fmw" class="form-control " value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Complete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <style type="text/css">
        .hidden {
            display: none;
        }
    </style>
    @endsection
    {{-- vendor scripts --}}
    @section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
    @endsection

    {{-- page scripts --}}
    @section('page-scripts')
    <script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    @endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', function() {
            if ($('#costOfBasisReceived').is(':checked')) {
                $('#costItems').removeClass('hidden');
            } else {
                $('#costItems').addClass('hidden');
            }
        })
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $('.first_radio').click(function() {
                if ($(this).val() == 'transfer') {
                    $('.second_first_radio').removeAttr('disabled');
                    $('.second_radio').prop("disabled", true);
                    $('#item_count').prop("disabled", true);
                } else {
                    $('.second_first_radio').prop("disabled", true);
                    $('.second_radio').removeAttr('disabled');
                    $('#item_count').removeAttr('disabled');
                }
            });
        });
    </script>