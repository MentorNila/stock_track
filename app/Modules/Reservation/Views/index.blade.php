@extends('layouts.admin')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@endsection
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Reservations</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#createReservation" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
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
                                <th>Stock ID</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>
                                    {{$reservation->class}}
                                </td>
                                <td>
                                    {{$reservation->code}}
                                </td>
                                <td>
                                    {{$reservation->description}}
                                </td>
                                <td>
                                    <a class="icons" href="{{ route('admin.reservations.edit', $reservation->id) }}">
                                        <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1">
                                            <i class="bx bx-edit-alt"></i></button>
                                    </a>
                                    <form action="{{ route('admin.reservations.delete', $reservation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $reservation->code }}?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-icon btn-light-danger mr-1 mb-1" name="submit" alt="Submit">
                                            <i class="bx bx-x"></i></button>
                                    </form>
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
<div id="createReservation" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Reservation</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route("admin.reservations.store") }}" id="reservationForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Reservation Code</label>
                                    <input type="text" id="code" name="code" class="form-control" value="" required>
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Class</label>
                                    <input type="text" id="class" name="class" class="form-control " value="" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Reserved</label>
                                    <input type="text" id="reserved" name="reserved" class="form-control" value="">
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Shares Issued</label>
                                    <input type="text" id="shares_issued" name="shares_issued" class="form-control " value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">Start Date</label>
                                    <input type="text" id="start_date" name="start_date" class="form-control datepicker" value="">
                                </div>

                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                    <label for="target">End Date</label>
                                    <input type="text" id="end_date" name="end_date" class="form-control datepicker" value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                    <label for="target">Description</label>
                                    <textarea class="form-control" name="description">
                                    </textarea>
                                </div>
                            </div>

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