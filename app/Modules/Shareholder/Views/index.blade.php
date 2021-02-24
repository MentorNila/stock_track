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
                                <th>SSno</th>
                                <th>Address</th>
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
                                    {{$shareholder->ssno}}
                                </td>
                                <td>
                                    {{$shareholder->address}}
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
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Shareholder</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route("admin.shareholders.store") }}" id="shareholderForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                        <label for="target">Ref Name</label>
                        <input type="text" id="refName" name="ref_name" class="form-control " value="" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                        <label for="target">Name as appears on certificate</label>
                        <input type="text" id="nameAsAppearsOnCertificate" name="name_as_appears_on_certificate" class="form-control birthdate-picker" value="" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                        <label for="target">Registration</label>
                        <input type="text" id="registration" name="registration" class="form-control " value="" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                        <label for="target">SSno</label>
                        <input type="text" id="ssno" name="ssno" class="form-control " value="" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                        <label for="target">Address</label>
                        <input type="text" id="address" name="address" class="form-control " value="" required>
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