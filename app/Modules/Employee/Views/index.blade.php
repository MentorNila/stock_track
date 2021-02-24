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
        <h1>Directory</h1>
    </div>
</div>
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
            <a type="button" href="{{ route("admin.employees.create") }}" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
        </div>
    </div>
@endcan
<div class="users-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="users-list-datatable" class="table">
                        <thead>
                        <tr>
                            <th>{{ trans('cruds.user.fields.id') }}</th>
                            <th>{{ trans('cruds.user.fields.name') }}</th>
                            <th>Supervisor</th>
                            <th>{{ trans('cruds.user.fields.email') }}</th>
                            <th>Job Title</th>
                            <th>Phone</th>
                            <th class="actions">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>
                                    <a href="/admin/employees/set/{{$user->employee_id}}">
                                        {{$user->first_name}} {{$user->last_name}}
                                    </a>
                                </td>
                                <td>
                                    @if($user->supervisor_first_name != '')
                                    <a href="/admin/employees/set/{{$user->employee_id}}">
                                        {{$user->supervisor_first_name}} {{$user->supervisor_last_name}}
                                    </a>
                                    @else
                                    Not Set
                                    @endif
                                </td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->job_title}}</td>
                                <td>{{$user->phone_nr}}</td>
                                <td>
                                    <a type="button" href="{{ route("admin.employees.edit", $user->id) }}" class="btn btn-icon btn-light-warning mr-1 mb-1"> <i class="bx bx-edit-alt"></i></a>
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
