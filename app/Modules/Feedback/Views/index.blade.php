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
        <h1>Feedbacks</h1>
    </div>
</div>
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
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
                                <th>From</th>
                                <th>For</th>
                                <th>Goal</th>
                                <th>Feedback</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($feedbacks as $key => $feedback)
                            <tr>
                                <td>{{$feedback->from_first_name}} {{$feedback->from_last_name}}
                                </td>
                                <td>{{$feedback->first_name}} {{$feedback->last_name}}
                                </td>
                                <td>{{$feedback->goal_name}}
                                </td>
                                <td>{{$feedback->feedback}}
                                </td>
                                <td>
                                    <a href="/admin/feedbacks/delete/{{$feedback->id}}" title="delete" onclick="return confirm('Are you sure?')">
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
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Feedback</h4>
    </div>
    <div class="modal-body">
        <form action="{{ route("admin.feedbacks.store") }}" id="goalForm" method="POST" enctype="multipart/form-data">
    @csrf
            <div class="form-group">
                <label>Employee</label>
                <select name="employee_id" id="employeeId" class="form-control" required="">
                    <option ></option>
                    @foreach($employees as $employee)
                    <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Goal</label>
                <select name="goal_id" id="goalId" class="form-control" required="">
                    <option></option>
                </select>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description">Feedback</label>
                            <textarea class="form-control" name="feedback" rows="6"></textarea>
                            @if($errors->has('description'))
                            <em class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.user.fields.name_helper') }}
                            </p>
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
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).on('change', '#employeeId', function() {
        let employeeId = this.value;
        console.log(employeeId);
        if(employeeId) {
            $.get("/admin/goals/employee_goals/" + employeeId, function(data, status){
                if(data['goals']) {
                    $.each(data['goals'], function( index, value ) {
                      $("#goalId").append("<option value='" + value.id + "'>" + value.name + "</option>");
                    });
                }
            });
        }
    });
</script>