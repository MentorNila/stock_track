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
        <h1>Log Transactions</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#createTransaction" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
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
                                <th>Sec Tracking</th>
                                <th>Item Count</th>
                                <th>Company</th>
                                <th>ID/SCL</th>
                                <th>Control Ticket</th>
                                <th>Received From</th>
                                <th>How Received</th>
                                <th>Tracking #</th>
                                <th>Assigned</th>
                                <th class="actions" style="min-width:110px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $currentTransact)
                            <tr>
                                <td>
                                    {{$currentTransact->sec_tracking}}
                                </td>
                                <td>
                                    {{$currentTransact->item_count}}
                                </td>
                                <td>
                                    {{$companiesArray[$currentTransact->company_id]}}
                                </td>
                                <td>
                                    {{$currentTransact->scl}}
                                </td>
                                <td>
                                    {{$currentTransact->control_ticket}}
                                </td>
                                <td>
                                    {{$currentTransact->received}}
                                </td>
                                <td>
                                    {{$currentTransact->how_received}}
                                </td>
                                <td>
                                    {{$currentTransact->track}}
                                </td>
                                <td>
                                    {{$usersArray[$currentTransact->assigned_to]}}
                                </td>
                                <td style="min-width:110px;">
                                    <a class="icons" href="{{ route('admin.transacts.edit', $currentTransact->id) }}">
                                        <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                    </a>
                                    <a href="/admin/transacts/delete/{{$currentTransact->id}}" title="delete" onclick="return confirm('Are you sure you want to delete this Transaction?')">
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
<div id="createTransaction" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Issue</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route("admin.transacts.store") }}" id="transactForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">SEC Tracking</label>
                            <input type="text" id="sec_tracking" name="sec_tracking" class="form-control " value="" required>
                        </div>

                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Item Count</label>
                            <input type="text" id="item_count" name="item_count" class="form-control " value="" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">ID/SCL</label>
                            <input type="text" id="scl" name="scl" class="form-control " value="" required>
                        </div>

                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Control Ticket</label>
                            <input type="text" id="control_ticket" name="control_ticket" class="form-control " value="" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Received</label>
                            <input type="text" id="received" name="received" class="form-control datepicker" value="" required>
                        </div>

                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">at</label>
                            <input type="text" id="received_at" name="received_at" class="form-control " value="" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Received From</label>
                            <input type="text" id="received_from" name="received_from" class="form-control " value="" required>
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
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Assigned</label>
                            <select name="assigned_to" id="assigned_to" class="form-control">
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
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