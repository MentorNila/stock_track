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
        <h1>360 Degree Feedback</h1>
    </div>
</div>
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#threeSixtyModal" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
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
                                <th>Title</th>
                                <th>Description</th>
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
<div id="threeSixtyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New 360 Degree Feedback</h4>
    </div>
    <div class="modal-body">
        <form action="{{ route("admin.feedbacks.store") }}" id="goalForm" method="POST" enctype="multipart/form-data">
    @csrf
            <div class="form-group">
                <label>Who is this 360 degree feedback for</label>
                <select name="employees" id="employees" class="form-control" required="" multiple>
                    <option ></option>
                    @foreach($employees as $employee)
                    <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Members who will give feedback</label>
                <select name="members[]" id="members" class="form-control" required="" multiple>
                    <option ></option>
                    @foreach($employees as $employee)
                    <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                    @endforeach
                </select>
            </div>

            <h6>Questions</h6>

            <div class="form-group">
                <input type="checkbox" id="default_questions" name="default_questions" value="1">
                <label for="superuser">Add Default Questions</label><br>
            </div>
            <div id="forms" style="border:1px solid lightgray; border-radius: 5px; padding:10px;" hidden="hidden">
                <div id="inputQuestionRow">
                </div>

                <div id="newQuestion">
                </div>
            </div>
            <button id="addQuestion" type="button" class="btn btn-info btn-xs pull-right " style="margin:10px;">Add Question</button>


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
    $(document).on('click', '#addQuestion', function() {
        console.log('asd');
        let employees = {!! json_encode($employees) !!};
        let employeeOptions = '';
        for (i = 0; i < employees.length; i++) {
          employeeOptions += '<option value="' + employees[i].id + '">' + employees[i].first_name + ' ' + employees[i].last_name + '</option>';
        } 
        $('#forms').removeAttr('hidden');
        var html = '';
        html += '<div id="inputQuestionRow">';
        html += '<button id="removeRow" type="button" class="close pull-right">×</button>';
        html += '<div class="form-group">';
        html += '<label style="margin-top:5px;">Question</label>';
        html += '<input type="text"  class="form-control" name="days_to_author[]" required=""></input>';
        html += '<div class="input-group-append">';
        html += '</div>';
        html += '</div>';
        html += '<hr>';

        $('#newQuestion').append(html);
    });
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputQuestionRow').remove();
    });
</script>