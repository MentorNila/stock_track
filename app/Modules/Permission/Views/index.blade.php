@extends('layouts.admin')
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
    <style>
        /* user page css */

        /*---------------*/

        .permissions-list-wrapper .dataTables_length {
            margin-top: 0 !important;
        }

        .permissions-list-wrapper .dataTables_length select {
            margin: 0 0.5rem 0 0.5rem;
        }

        .permissions-list-wrapper .dataTables_filter {
            margin-top: 0 !important;
        }

    </style>
@endsection

@section('content')
    <div class="row grid-title">
        <div class="col-lg-12">
            <h1>Permissions</h1>
        </div>
    </div>
    @can('permission_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                <a type="button" href="" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
            </div>
        </div>
    @endcan

    <div class="permissions-list-wrapper">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <!-- datatable start -->
                    <div class="table-responsive">
                        <table id="permissions-list-datatable" class="table">
                            <thead>
                            <tr>
                                <th>{{ trans('cruds.permission.fields.id') }}</th>
                                <th>{{ trans('cruds.permission.fields.title') }}</th>
                                <th class="actions">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $key => $permission)
                                <tr>
                                    <td>{{ $permission->id ?? '' }}</td>
                                    <td>{{ $permission->title ?? '' }}</td>
                                    <td>
                                        @can('permission_edit')
                                            <a class="icons" href="" data-toggle="modal" data-target="#editPermissions" data-title="{{ $permission->title  }}" data-url="{{ route("admin.permissions.update", $permission->id) }}">
                                                <button type="button" class="btn btn-icon btn-light-info mr-1 mb-1">
                                                    <i class="bx bx-edit-alt client-icons"></i></button>
                                            </a>
                                        @endcan
                                        @can('permission_delete')
                                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-icon btn-light-danger mr-1 mb-1" name="submit" alt="Submit">
                                                    <i class="bx bx-x"></i></button>
                                            </form>
                                        @endcan
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



    <div class="modal" id="editPermissions" tabindex="-1" role="dialog" aria-labelledby="editPermissionsLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editPermissionsLabel">Edit Permission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <form id="edit-permission-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label>Title: </label>
                        <div class="form-group">
                            <input type="text" value="{{ old('title') }}" id="titleEdit" name="title" class="form-control" placeholder="Title" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <span class="text-danger">
                                <span id="update-title-error"></span>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" id="editButton" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Add Permission</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <form id="createPermissionForm" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label>Title: </label>
                            <div class="form-group">
                                <input type="text" value="{{ old('title') }}" id="title" name="title" class="form-control" placeholder="Title" required>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <span class="text-danger">
                                <span id="title-error"></span>
                            </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button id="submitButton" type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    @parent


@endsection
{{-- page scripts --}}
@section('page-scripts')
    <script src="{{asset('js/scripts/pages/page-permissions.js')}}"></script>

    <script type="text/javascript">
        $('#submitButton').click(function(e){

            e.preventDefault();
            e.stopPropagation();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                }
            });

            $('#title-error').html("");

            $.ajax({
                url: 'permissions/store',
                type: 'POST',
                data:  $('#createPermissionForm').serialize(),
                success: function (data) {
                    if (data.errors) {
                        if (data.errors.title){
                            $('#title-error').html(data.errors.title[0]);
                        }
                    }
                    if(data.success) {
                        window.location.href = "{{ route('admin.permissions.index') }}"
                    }
                },
            });
           return false;
        });
    </script>

    <script type="text/javascript">

        $(document).ready(function () {

            $('#editPermissions').on('shown.bs.modal', function (e) {
                var old = $('#titleEdit').val();

                $('#editButton').click(function(e){

                    if ($('#titleEdit').val() != old ){
                        e.preventDefault();
                        e.stopPropagation();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                            }
                        });
                        // $('#title-error').html("");
                        var dataToSend = $('#edit-permission-form').serializeArray();
                        dataToSend.push({
                            name: 'permission-id',
                            value: {{$permission->id}}
                        })
                        $.ajax({
                            url: 'permissions/update',
                            type: 'PUT',
                            data:  dataToSend,
                            success: function (data) {
                                if (data.errors) {
                                    if (data.errors.title){
                                        $('#update-title-error').html(data.errors.title[0]);
                                    }
                                }
                                if(data.success) {
                                    window.location.href = "{{ route('admin.permissions.index') }}"
                                }
                            },
                        });
                    }else{
                        window.location.href = "{{ route('admin.permissions.index') }}"
                    }
                    return false;
                });
            })
        });
    </script>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection
