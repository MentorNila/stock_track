@extends('layouts.admin')
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
@endsection
@section('page-styles')
    <style>
        .checkbox input:checked ~ label:before {
            border: 1px solid #778491 !important;
        }
        .checkbox label:after {
            border: 1px solid #778491 !important;
        }
        .checkbox input:checked ~ label:after{
            border-top-style: none !important;
            border-right-style: none !important;
            border-color: #5A8DEE !important;
            border-width: 2px !important;
        }
    </style>
@endsection

@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Roles</h1>
    </div>
</div>
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
            <a type="button" href="" data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
        </div>
    </div>
@endcan
<div class="roles-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="roles-tab" data-toggle="tab" href="#roles" aria-controls="roles" role="tab"
                           aria-selected="true">
                            <i class="bx bx-circle align-middle"></i>
                            <span class="align-middle">Roles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="roles-permissions-tab" data-toggle="tab" href="#roles-permissions" aria-controls="roles-permissions" role="tab"
                           aria-selected="false">
                            <i class="bx bx-lock-open align-middle"></i>
                            <span class="align-middle">Permissions</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="roles" aria-labelledby="roles-tab" role="tabpanel">
                        <div class="table-responsive">
                            <table id="roles-list-datatable" class="table">
                                <thead>
                                <tr>
                                    <th>{{ trans('cruds.role.fields.id') }}</th>
                                    <th>{{ trans('cruds.role.fields.code') }}</th>
                                    <th>{{ trans('cruds.role.fields.title') }}</th>
                                    <th>{{ trans('cruds.role.fields.level') }}</th>
                                    <th class="actions">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $key => $role)
                                    <tr data-entry-id="{{ $role->id }}">
                                        <td>{{ $role->id ?? '' }}</td>
                                        <td>{{ $role->code ?? '' }}</td>
                                        <td>{{ $role->title ?? '' }}</td>
                                        <td>{{ $role->level ?? '' }}</td>
                                        <td>
                                            @can('role_show')
                                                <a class="icons" href="{{ route('admin.roles.show', $role->id) }}">
                                                    <button type="button" class="btn btn-icon btn-light-info mr-1 mb-1">
                                                        <i class="bx bxs-info-circle"></i></button>
                                                </a>
                                            @endcan

                                            @can('role_edit')
                                                <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1" data-toggle="modal" data-target="#editRole" data-id="{{$role->id}}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </button>
                                            @endcan

                                            @can('role_delete')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-icon btn-light-danger mr-1 mb-1" name="submit" alt="Submit">
                                                        <i class="bx bx-x"></i></button>
                                                    {{--                                            <input class="delete-tooltip bx bx-edit-alt" type="image" name="submit" src="{{ asset('images/delete.svg ')}}" border="0" alt="Submit" />--}}
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="roles-permissions" aria-labelledby="roles-permissions-tab" role="tabpanel">
                        <form action="{{ route("admin.role.permissions") }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mt-1">
                                            <thead>
                                            <tr>
                                                <th>Permission</th>
                                                @foreach($roles as $role)
                                                    <th>{{ $role->title }}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($permissions as $id => $permission)
                                                <tr>
                                                    <td>{{ $permission }}</td>
                                                    @foreach($roles as $role)
                                                        <td>
                                                            <div class="checkbox">
                                                                <input type="checkbox" id="users-checkbox-{{$role->id}}-{{$id}}" class="checkbox-input" name="permissions[{{$role->id}}][]" value="{{$id}}" @if($role->permissions->contains($id)) checked @endif>
                                                                <label for="users-checkbox-{{$role->id}}-{{$id}}"></label>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                                        changes</button>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Add Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                {{--                <form action="{{ route("admin.roles.store") }}" id="createRoleForm" method="POST" enctype="multipart/form-data">--}}
                <form id="createRoleForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="code">{{ trans('cruds.role.fields.code') }}* </label>
                        <div class="form-group">
                            <input type="text" id="code" name="code" class="form-control" placeholder="Code" required>
                            <span class="text-danger">
                                <span id="code-error"></span>
                                </span>
                            <span class="text-danger">
                                    <span id="code-alert">Please write a code</span>
                                </span>
                        </div>
                        <label for="title">{{ trans('cruds.role.fields.title') }}* </label>
                        <div class="form-group">
                            <input type="text" id="title" name="title" class="form-control" placeholder="Title" required>
                            <span class="text-danger">
                                <span id="title-error"></span>
                                     <span class="text-danger">
                                    <span id="title-alert">Please write a title</span>
                                </span>
                            </span>
                        </div>
                        <label for="level">{{ trans('cruds.role.fields.level') }}* </label>
                        <div class="form-group">
                            <input type="number"  min="0" step="1" oninput="validity.valid||(value='')" id="level" name="level" class="form-control" placeholder="Level" required>
                            <span class="text-danger">
                                    <span id="level-alert">Please write a level</span>
                                </span>
                        </div>
                        <p id="error-role" style="color:red; display:none;">You can't create a role that has a level lower than yours</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" id="submitButton" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Add</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editRole" tabindex="-1" role="dialog" aria-labelledby="editRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title" id="editRoleLabel">Edit Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <form action="" id="editRoleForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input hidden type="text" name="id" class="form-control" placeholder="Code" value={{$role->id}} required>
                        <label>{{ trans('cruds.role.fields.code') }}* </label>
                        <div class="form-group">
                            <input type="text" name="code" id="codeEdit" class="form-control" placeholder="Code" value="" required>
                            <span class="text-danger">
                                <span id="code-edit-error"></span>
                            </span>
                            <span class="text-danger">
                                    <span id="code-edit-alert">Please write a code</span>
                                </span>
                        </div>
                        <label>{{ trans('cruds.role.fields.title') }}* </label>
                        <div class="form-group">
                            <input type="text" id="titleEdit" name="title" class="form-control" placeholder="Title" value="" required>
                            <span class="text-danger">
                                <span id="title-edit-error"></span>
                            </span>
                            <span class="text-danger">
                                    <span id="title-edit-alert">Please write a title</span>
                                </span>
                        </div>
                        <label>{{ trans('cruds.role.fields.level') }}* </label>
                        <div class="form-group">
                            <input type="number" min="0" id="levelEdit" step="1" oninput="validity.valid||(value='')" name="level" class="form-control" placeholder="Level" value="" required>
                            <span class="text-danger">
                                    <span id="level-edit-alert">Please write a level</span>
                                </span>
                        </div>
                        <p id="error-role-edit" style="color:red; display:none;">You can't create a role that has a level lower than yours</p>
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
</div>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')


    <script src="{{asset('js/scripts/pages/page-roles.js')}}"></script>


    <script type="text/javascript">
        $('#submitButton').click(function(e){

            let  userLevel = {{Auth::user()->role->level}};

            let level = $("#level").val();

            if(level < userLevel){
                $('#error-role').show();
                return  false;
            }


            $('#code-error').html('');
            $('#title-error').html('');

            e.preventDefault();
            e.stopPropagation();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                }
            });

            $('#title-error').html("");

            $.ajax({
                url: 'roles/store',
                type: 'POST',
                data:  $('#createRoleForm').serialize(),
                success: function (data) {

                    if(data.error_code_unique){
                        $('#code-error').html(data.error_code_unique);
                    }
                    if (data.error_title_unique) {
                        $('#title-error').html(data.error_title_unique);

                    }
                    if (data.success) {
                        window.location.href = "{{ route('admin.roles.index') }}"
                    }
                },
            });
            return false;
        });
    </script>


    <script type="text/javascript">

        $(document).ready(function () {

            $('#editRole').on('shown.bs.modal', function (e) {
                var oldTitle = $('#titleEdit').val();
                var oldCode = $('#codeEdit').val();

                $('#editButton').click(function(e){

                    let  userLevel = {{Auth::user()->role->level}};

                    let level = $("#levelEdit").val();

                    if(level < userLevel){
                        $('#error-role-edit').show();
                        return  false;
                    }


                    $('#code-edit-error').html('');
                    $('#title-edit-error').html('');


                    if (($('#titleEdit').val() != oldTitle) || ($('#codeEdit').val() != oldCode)){
                        e.preventDefault();
                        e.stopPropagation();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                            }
                        });
                        var dataToSend = $('#editRoleForm').serializeArray();
                        $.ajax({
                            url: 'roles/update',
                            type: 'PUT',
                            data:  dataToSend,
                            success: function (data) {

                                if(data.error_code_unique){
                                    $('#code-edit-error').html(data.error_code_unique);
                                }
                                if (data.error_title_unique) {
                                    $('#title-edit-error').html(data.error_title_unique);

                                }
                                if (data.success) {
                                    window.location.href = "{{ route('admin.roles.index') }}"
                                }
                            },
                        });
                    }else{
                        window.location.href = "{{ route('admin.roles.index') }}"
                    }
                    return false;
                });
            })
        });
    </script>

    //Validation for Create
    <script>

        $('#code-alert').hide();
        $('#title-alert').hide();
        $('#level-alert').hide();


        $('#submitButton').click(function() {
            if ($('#code').val().length === 0) {
                $('#code-alert').show();
                return false;
            }
            else{
                $('#code-alert').hide();
                return true;
            }
        });

        $('#submitButton').click(function() {
            if ($('#title').val().length === 0) {
                $('#title-alert').show();
                return false;
            }
            else{
                $('#title-alert').hide();
                return true;
            }
        });

        $('#submitButton').click(function() {
            if ($('#level').val().length === 0) {
                $('#level-alert').show();
                return false;
            }
            else{
                $('#level-alert').hide();
                return true;
            }
        });
    </script>

    //Validation for Edit
    <script>

        $('#code-edit-alert').hide();
        $('#title-edit-alert').hide();
        $('#level-edit-alert').hide();

        $('#editButton').click(function() {
            if ($('#codeEdit').val().length === 0) {
                $('#code-edit-alert').show();
                return false;
            }
            else{
                $('#code-edit-alert').hide();
                return true;
            }
        });

        $('#editButton').click(function() {
            if ($('#titleEdit').val().length === 0) {
                $('#title-edit-alert').show();
                return false;
            }
            else{
                $('#title-edit-alert').hide();
                return true;
            }
        });


        $('#editButton').click(function() {
            if ($('#levelEdit').val().length === 0) {
                $('#level-edit-alert').show();
                return false;
            }
            else{
                $('#level-edit-alert').hide();
                return true;
            }
        });
    </script>
    <script src="{{asset('js/scripts/navs/navs.js')}}"></script>
@endsection
