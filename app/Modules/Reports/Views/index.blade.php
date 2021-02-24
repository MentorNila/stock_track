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
        <h1>Reports</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" href="" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
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
                                <th>Name</th>
                                <th>Description</th>
                                <th>Tags</th>
                                <th class="actions"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td><a href="/admin/reporting/forms">Forms Report</a></td>
                                <td>List all review forms.</td>
                                <td></td>
                                <td></td>
                            </tr> -->
                            <!-- <tr>
                                <td><a href="/admin/reporting/todos">To-dos Report</a></td>
                                <td>List all workflow todos.</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><a href="/admin/reporting/feedback">Feedback Report</a></td>
                                <td>List all feedback shared in the organization.</td>
                                <td></td>
                                <td></td>
                            </tr> -->
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
