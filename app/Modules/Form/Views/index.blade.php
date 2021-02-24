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
        <h1>Forms</h1>
    </div>
</div>
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#formModal" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
    </div>
</div>
@endcan
<div class="users-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Questions</th>
                                <th>Last Update</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($forms as $key => $form)
                            <tr>
                                <td>{{$form->title}}</td>
                                <td>
                                    <?php
                                    $questions = App\Modules\Form\Models\Form::find($form->id)->questions;
                                    ?>
                                    @foreach($questions as $currentQuestion)
                                    <p style="border-bottom: 1px solid lightgray; margin:1px;">{{$currentQuestion->question}}</p> <br>
                                    @endforeach
                                </td>
                                <td>{{$form->updated_at}}</td>
                                <td>
                                    <a href="/admin/forms/delete/{{$form->id}}" title="delete" onclick="return confirm('Are you sure?')">
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
<!-- Modal -->
<div id="formModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Form</h4>
    </div>
    <div class="modal-body">
        <form action="{{ route("admin.forms.store") }}" id="reviewForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                <label for="target">Form Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="" required>
            </div>

            <h6>Questions</h6>

            <div id="questions" style="border:1px solid lightgray; border-radius: 5px; padding:5px;" hidden="hidden">
                <div id="inputFormRow">
                </div>

                <div id="newRow"></div>
            </div>
            <button id="addQuestion" type="button" class="btn btn-info btn-xs pull-right " style="margin:10px;">Add Question</button>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
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
    // add row

    $(document).on('click', '#addQuestion', function() {
        $('#questions').removeAttr('hidden');
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<button id="removeRow" type="button" class="close pull-right">×</button>';
        html += '<div class="form-group">';
        html += '<label>Type of Question</label>';
        html += '<select name="type[]" class="form-control typeOfQuestion" required=""><option value="long_answer">Long Answer</option><option value="multiple_line_answer">Multiple Line Answer</option><option value="numeric_answer">Numeric Answer</option><option value="date">Date</option><option value="multiple_choice">Multiple Choice</option><option value="instructions">Instructions</option><option value="rating_scale">Rating Scale</option><option value="goal_discussion">Goal Discussion</option><option value="goal_creation">Goal Creation</option><option value="numeric_calculation">Numeric Calculation</option></select>';
        html += '<label style="margin-top:5px;">What is your Question?</label>';
        html += '<textarea class="form-control" name="question[]" required=""></textarea>';
        html += '<label style="margin-top:5px;">Question subtext</label>';
        html += '<textarea class="form-control" name="subtext[]" required=""></textarea>';
        html += '<div class="input-group-append">';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    $(document).on('change', '.typeOfQuestion', function() {
        let selectedValue = $('.typeOfQuestion :selected').value();

    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>