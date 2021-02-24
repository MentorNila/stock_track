@extends('layouts.admin')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Reviews</h1>
    </div>
</div>
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#reviewModal" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
    </div>
</div>
@endcan
<div class="users-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="active borderedLi">
                        <a data-toggle="tab" href="#formsINeedToDo" style="margin: 10px;">
                            @if(isset($activeEmployee))
                            Forms {{ $activeEmployee->first_name }} Need To Do
                            @else
                            Forms I Need To Do
                            @endif
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#formsIDid" style="margin: 10px;">
                            @if(isset($activeEmployee))
                            Forms {{ $activeEmployee->first_name }} Did
                            @else
                            Forms I Did
                            @endif
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#reviewsOfMe" style="margin: 10px;">
                        @if(isset($activeEmployee))
                            Reviews of {{$activeEmployee->first_name}}
                        @else
                            Reviews of Me
                        @endif
                        </a>
                    </li>
                    @if(Session::has('currentEmployee') && Session::has('activeEmployee'))
                        @if(Session::get('currentEmployee')->id == Session::get('activeEmployee')->employee_id)
                    <li><a data-toggle="tab" href="#myTeam" style="margin:10px;">My Team</a></li>
                        @endif
                    @endif
                </ul>

                <div class="tab-content">
                    <div id="formsINeedToDo" class="tab-pane fade in active show">
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($formsINeedToDo as $key => $form)
                                    <tr>
                                        <td>
                                            <a href="/admin/reviews/form/{{$form->id}}">Open Form</a>
                                        </td>
                                        <td>
                                            <a href="/admin/employees/set/{{$form->signer}}">
                                            {{$form->author_first_name}} {{$form->author_last_name}}
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
                    </div>
                    <div id="formsIDid" class="tab-pane fade">
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
                                    @foreach($formsIDid as $key => $form)
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
                    </div>
                    <div id="reviewsOfMe" class="tab-pane fade">
                        <div class="table-responsive">
                            <table id="users-list-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th>Review Name</th>
                                        <th>Start Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviewsOfMe as $key => $review)
                                    <tr>
                                        <td>{{$review->title}}</td>
                                        <td>
                                            <?php
                                            $startDate=date_create($review->start_date);
                                            ?>
                                            {{date_format($startDate,"M d, Y H:i")}}
                                        </td>
                                        <td>
                                            {{ App\Modules\Review\Classes\ReviewStatusCode::returnCode($review->status) }}
                                        </td>
                                        <td>
                                            <a href="/admin/reviews/view/{{$review->id}}">
                                                <i class="fas fa-align-justify"></i>
                                            </a>
                                            <a href="/admin/reviews/delete/{{$review->id}}" title="delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="myTeam" class="tab-pane fade in show">
                        <div class="table-responsive">
                            <table id="users-list-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Review Name</th>
                                        <th>Start Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $key => $review)
                                    <tr>
                                        <td>{{$review->first_name}} {{$review->last_name}}</td>
                                        <td>{{$review->title}}</td>
                                        <td>
                                            <?php
                                            $startDate=date_create($review->start_date);
                                            ?>
                                            {{date_format($startDate,"M d, Y H:i")}}
                                        </td>
                                        <td>
                                            {{ App\Modules\Review\Classes\ReviewStatusCode::returnCode($review->status) }}
                                        </td>
                                        <td>
                                            <a href="/admin/reviews/view/{{$review->id}}">
                                                <i class="fas fa-align-justify"></i>
                                            </a>
                                            <a href="/admin/reviews/delete/{{$review->id}}" title="delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="reviewModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Review</h4>
    </div>
    <div class="modal-body">
        <form action="{{ route("admin.reviews.store") }}" id="reviewForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Which template would you like to use*</label>
                <select name="template_id" id="templateId" class="form-control" required="">
                    <option value="none">None</option>
                    @foreach($templates as $key => $template)
                    <option value="{{$template->id}}">{{$template->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Choose a subject*</label>
                <select name="employee_id" id="employeeId" class="form-control" required="">
                    <option ></option>
                    @foreach($employees as $key => $employee)
                    <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                <label for="target">Start Date*</label>
                <input type="text" id="startDate" name="start_date" class="form-control birthdate-picker" value="" required>
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
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
@endsection
<style>
    .picker__holder {
        margin-top:-100px;
    }
    .borderedLi {
        border-top: 1px solid lightgray;
        border-right: 1px solid lightgray;
        border-left: 1px solid lightgray;
        border-radius: 5px;
    }
</style>
{{-- page scripts --}}
@section('page-scripts')
<script type="text/javascript">
    $('.birthdate-picker').pickadate({
        format: 'yyyy-mm-dd',
    });

    $(document).on('click', 'li', function () {
        $('li').removeClass('borderedLi');
        $(this).addClass('borderedLi');
    });
</script>
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection