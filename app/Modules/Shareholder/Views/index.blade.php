@extends('layouts.admin')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Shareholders</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#createShareholder" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
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
                                <th>Ref Name</th>
                                <th>Name as Appears on Certificate</th>
                                <th>Registration</th>
                                <th>Address One</th>
                                <th>Reservations</th>
                                <th>Status</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shareholders as $shareholder)
                            <tr>
                                <td>
                                    {{$shareholder->ref_name}}
                                </td>
                                <td>
                                    {{$shareholder->name_as_appears_on_certificate}}
                                </td>
                                <td>
                                    {{$shareholder->registration}}
                                </td>
                                <td>
                                    {{$shareholder->address_one}}
                                </td>
                                <td>
                                    @if(count($shareholder->reservations) > 0)
                                    <a href="#" data-toggle="tooltip" title="
                                        @foreach($shareholder->reservations as $reservation)
                                            Code {{$reservation->code}} / Description {{$reservation->description}} , 
                                        @endforeach
                                    ">Hover to View</a>
                                    @else
                                    No Reservations
                                    @endif
                                </td>
                                <td>
                                    @if($shareholder->active == 1)
                                    <h6><span class="label text-success">Active</span></h6>
                                    @else
                                    <h6><span class="label text-warning">Unactive</span></h6>
                                    @endif
                                </td>
                                <td>
                                    <a class="icons" href="{{ route('admin.shareholders.edit', $shareholder->id) }}">
                                        <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1">
                                            <i class="bx bx-edit-alt"></i></button>
                                    </a>
                                    @if($shareholder->active == 1)
                                    <form action="{{ route('admin.shareholders.unactive', $shareholder->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to set UnActive {{ $shareholder->ref_name }}?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-icon btn-light-danger mr-1 mb-1" name="submit" alt="Submit">
                                            <i class="bx bx-x"></i></button>
                                    </form>
                                    @endif
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
<div id="createShareholder" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Shareholder</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route("admin.shareholders.store") }}" id="shareholderForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <nav>
                        <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" style="margin-right:5px;">Shareholder</a>
                            <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2">Other</a>
                        </div>
                    </nav>
                    <div class="tab-content py-4" id="nav-tabContent" style="padding-top:1.5rem !important;">
                        <div class="tab-pane fade show active" id="step1">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Ref Name</label>
                                        <input type="text" id="refName" name="ref_name" class="form-control " value="" required>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                            <label for="target">Name as appears on certificate</label>
                                            <input type="text" id="nameAsAppearsOnCertificate" name="name_as_appears_on_certificate" class="form-control birthdate-picker" value="" required>
                                        </div>

                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                            <label for="target">Registration</label>
                                            <input type="text" id="registration" name="registration" class="form-control " value="" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                            <label for="target">Address1</label>
                                            <input class="first_radio" type="radio" id="capital_gains" name="country_one" value="usa" checked>
                                            <label for="vehicle1">USA</label>
                                            <input class="first_radio" type="radio" id="non_dividend_distribution" name="country_one" value="canada">
                                            <label for="vehicle1">CANADA</label>
                                            <input class="first_radio" type="radio" id="non_dividend_distribution" name="country_one" value="other">
                                            <label for="vehicle1">OTHER</label><br>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                            <label for="target">Address</label>
                                            <input type="text" id="registration" name="address_one" class="form-control " value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                            <label for="target">City</label>
                                            <input type="text" id="registration" name="city_one" class="form-control " value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                            <label for="target">State</label>
                                            <input type="text" id="registration" name="state_one" class="form-control " value="">
                                        </div>
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                            <label for="target">ZIP</label>
                                            <input type="text" id="registration" name="zip_one" class="form-control " value="">
                                        </div>
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                            <label for="target">Deliv Pt.</label>
                                            <input type="text" id="registration" name="deliv_one" class="form-control " value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                            <label for="target">Primary TIN Name</label>
                                            <input type="text" id="primary_tin_name" name="primary_tin_name" class="form-control" value="" required>
                                        </div>

                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                            <label for="target"> </label><br>
                                            <input class="first_radio" type="radio" id="capital_gains" name="primary_tin_radio" value="ssn" checked>
                                            <label for="vehicle1">SSN</label>
                                            <input class="first_radio" type="radio" id="non_dividend_distribution" name="primary_tin_radio" value="ein">
                                            <label for="vehicle1">EIN</label>
                                            <input class="first_radio" type="radio" id="non_dividend_distribution" name="primary_tin_radio" value="sin">
                                            <label for="vehicle1">SIN</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                            <label for="target">2ND TIN Name</label>
                                            <input type="text" id="second_tin_name" name="second_tin_name" class="form-control birthdate-picker" value="" required>
                                        </div>

                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                            <label for="target"> </label><br>
                                            <input class="first_radio" type="radio" id="capital_gains" name="second_tin_radio" value="ssn" checked>
                                            <label for="vehicle1">SSN</label>
                                            <input class="first_radio" type="radio" id="non_dividend_distribution" name="second_tin_radio" value="ein">
                                            <label for="vehicle1">EIN</label>
                                            <input class="first_radio" type="radio" id="non_dividend_distribution" name="second_tin_radio" value="sin">
                                            <label for="vehicle1">SIN</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6" style="padding-top: 25px;">
                                            <input type="checkbox" id="broker" name="use_address_two_for_checks" value="1">
                                            <label for="">Use Address Two for checks</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                            <label for="target">Address2</label>
                                            <input class="first_radio" type="radio" id="capital_gains" name="country_two" value="usa" checked>
                                            <label for="vehicle1">USA</label>
                                            <input class="first_radio" type="radio" id="non_dividend_distribution" name="country_two" value="canada">
                                            <label for="vehicle1">CANADA</label>
                                            <input class="first_radio" type="radio" id="non_dividend_distribution" name="country_two" value="other">
                                            <label for="vehicle1">OTHER</label><br>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                            <label for="target">Address</label>
                                            <input type="text" id="registration" name="address_two" class="form-control " value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                            <label for="target">City</label>
                                            <input type="text" id="registration" name="city_two" class="form-control " value="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                            <label for="target">State</label>
                                            <input type="text" id="registration" name="state_two" class="form-control " value="">
                                        </div>
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                            <label for="target">ZIP</label>
                                            <input type="text" id="registration" name="zip_two" class="form-control " value="">
                                        </div>
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                                            <label for="target">Deliv Pt.</label>
                                            <input type="text" id="registration" name="deliv_two" class="form-control " value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End of first step -->
                        <!-- Start of second step -->
                        <div class="tab-pane fade" id="step2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Benefical Owner</label>
                                        <input type="text" id="refName" name="benefical_owner" class="form-control " value="" required>
                                    </div>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Family</label>
                                        <input type="text" id="refName" name="family" class="form-control " value="" required>
                                    </div>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Sponsor</label>
                                        <input type="text" id="refName" name="sponsor" class="form-control " value="" required>
                                    </div>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Financial Advisor</label>
                                        <input type="text" id="refName" name="financial_advisor" class="form-control " value="" required>
                                    </div>
                                    <h7>Insider</h7>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }}">
                                        <label for="target">Employee Title</label>
                                        <input type="text" id="registration" name="employee_title" class="form-control " value="">
                                    </div>
                                    <div class="row">
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                            <label for="target">Officer</label>
                                            <input type="text" id="registration" name="officer" class="form-control " value="">
                                        </div>
                                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                            <label for="target">Director</label>
                                            <input type="text" id="registration" name="director" class="form-control " value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h7>Direct Deposit</h7>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Direct Dep Acct</label>
                                        <input type="text" name="direct_dep_one" class="form-control " value="" required>
                                    </div>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Bank Routing</label>
                                        <input type="text" name="bank_routing_one" class="form-control " value="" required>
                                    </div>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Addendum</label>
                                        <input type="text" name="addendum_one" class="form-control " value="" required>
                                    </div>
                                    <h7>Alternate Account</h7>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Direct Dep Acct</label>
                                        <input type="text" name="direct_dep_two" class="form-control " value="" required>
                                    </div>
                                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                        <label for="target">Bank Routing</label>
                                        <input type="text" name="bank_routing_two" class="form-control " value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
                            </div>
                        </div>
                    </div>
                    <!-- end of tabs -->
                </form>
            </div>

        </div>
    </div>
    @endsection
    {{-- vendor scripts --}}
    @section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
    @endsection

    {{-- page scripts --}}
    @section('page-scripts')
    <script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
    @endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>