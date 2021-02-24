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
        <h1>Pending Transactions</h1>
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
                                <th>Control Ticket</th>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Received</th>
                                <th>How Received</th>
                                <th>Count</th>
                                <th>SEC Tracking</th>
                                <th>Rcvd From</th>
                                <th>Tracking #</th>
                                <th>SCL #</th>
                                <th>Assigned</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
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
  <div class="modal-dialog">

    <!-- Modal content-->

                                <th>Control Ticket</th>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Received</th>
                                <th>How Received</th>
                                <th>Count</th>
                                <th>SEC Tracking</th>
                                <th>Rcvd From</th>
                                <th>Tracking #</th>
                                <th>SCL #</th>
                                <th>Assigned</th>


    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Issue</h4>
    </div>
    <div class="modal-body">
        <form action="{{ route("admin.shareholders.store") }}" id="shareholderForm" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Control Ticket</label>
                    <input type="text" id="refName" name="ref_name" class="form-control " value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6" >
                    <label for="target">ID</label>
                    <input type="text" id="nameAsAppearsOnCertificate" name="name_as_appears_on_certificate" class="form-control birthdate-picker" value="" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Received</label>
                    <input type="text" id="registration" name="registration" class="form-control " value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">How Received</label>
                    <input type="text" id="ssno" name="ssno" class="form-control " value="" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Count</label>
                    <input type="text" id="address" name="address" class="form-control " value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">SEC Tracking</label>
                    <input type="text" id="ssno" name="ssno" class="form-control " value="" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Received From</label>
                    <input type="text" id="address" name="address" class="form-control " value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Tracking #</label>
                    <input type="text" id="ssno" name="ssno" class="form-control " value="" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">SCL #</label>
                    <input type="text" id="address" name="address" class="form-control " value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Assigned</label>
                    <input type="text" id="address" name="address" class="form-control " value="" required>
                </div>
            </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
        </div>
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