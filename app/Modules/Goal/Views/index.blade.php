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
        <h1>Goals</h1>
    </div>
</div>
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" href="{{ route("admin.goals.create") }}" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
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
                                <th>Goal Name/Title</th>
                                <th>Employee</th>
                                <th>Target</th>
                                <th>Units</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($goals as $key => $goal)
                            <tr>
                                <td>
                                    {{$goal->name}}
                                </td>
                                <td>
                                    <a href="/admin/employees/set/{{$goal->employee_id}}">
                                        {{$goal->first_name}} {{$goal->last_name}}
                                    </a>
                                </td>
                                <td>{{$goal->target}}</td>
                                <td>{{$goal->units}}</td>
                                <td>{{$goal->start_date}}</td>
                                <td>{{$goal->due_date}}</td>
                                <td>
                                    <!-- <a href="/admin/goals/view/{{$goal->id}}">
                                        <i class="fas fa-align-justify"></i>
                                    </a> -->
                                    <a href="/admin/goals/delete/{{$goal->id}}" title="delete" onclick="return confirm('Are you sure?')">
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
