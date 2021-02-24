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
        <h1>Forms Report</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
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
                                <th></th>
                                <th>Subject</th>
                                <th>Form</th>
                                <th>Authors Due Date</th>
                                <th>Signers Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $key => $form)
                            <tr>
                                <td>
                                    <a href="/admin/reviews/form/{{$form->id}}">Open Form</a>
                                </td>
                                <td>
                                    <a href="/admin/employees/set/{{$form->signer}}">
                                        {{$form->signer_first_name}} {{$form->signer_last_name}}
                                    </a>
                                </td>
                                <td>
                                    {{$form->form_title}}
                                </td>
                                <td>
                                    {{$form->due_date_authors}}
                                </td>
                                <td>
                                    {{$form->due_date_signers}}
                                </td>
                                <td>
                                    {{ App\Modules\Review\Classes\ReviewFormStatusCode::returnCode($form->status) }}
                                </td>
                                <td>
                                    <a href="/admin/reviews/form/delete/{{$form->form_id}}" title="delete" onclick="return confirm('Are you sure?')">
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
