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
        <h1>Templates</h1>
    </div>
</div>
@can('user_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#templateModal" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
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
                                <th>Title</th>
                                <th>Last Update</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($templates as $key => $template)
                            <tr>
                                <td>{{$template->title}}</td>
                                <td>{{$template->updated_at}}</a>
                                </td>
                                <td>
                                    <a href="/admin/templates/delete/{{$template->id}}" title="delete" onclick="return confirm('Are you sure?')">
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
<div id="templateModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Template</h4>
    </div>
    <div class="modal-body">
        <form action="{{ route("admin.templates.store") }}" id="reviewForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                <label for="target">Template Title*</label>
                <input type="text" id="title" name="title" class="form-control" value="" required>
            </div>

            <h6>Forms</h6>

            <div id="forms" style="border:1px solid lightgray; border-radius: 5px; padding:10px;" hidden="hidden">
                <div id="inputFormRow">
                </div>

                <div id="newRow">
                </div>
            </div>
            <button id="addQuestion" type="button" class="btn btn-info btn-xs pull-right " style="margin:10px;">Add Form</button>

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
    $(document).on('click', '#addQuestion', function() {
        let employees = {!! json_encode($employees) !!};
        let employeeOptions = '';
        for (i = 0; i < employees.length; i++) {
          employeeOptions += '<option value="' + employees[i].id + '">' + employees[i].first_name + ' ' + employees[i].last_name + '</option>';
        } 
        let forms = {!! json_encode($forms) !!};
        let formOptions = '';
        for (i = 0; i < forms.length; i++) {
          formOptions += '<option value="' + forms[i].id + '">' + forms[i].title + '</option>';
        } 
        $('#forms').removeAttr('hidden');
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<button id="removeRow" type="button" class="close pull-right">×</button>';
        html += '<div class="form-group">';
        html += '<label>Which Form?</label>';
        html += '<select name="form[]" class="form-control forms" required="">' + formOptions + '</select>';
        html += '<label>Who authors this form?</label>';
        html += '<select name="author[]" class="form-control employees" required="">' + employeeOptions + '</select>';
        html += '<label>Who signs off on this form?</label>';
        html += '<select name="signer[]" class="form-control employees" required="">' + employeeOptions + '</select>';
        html += '<label style="margin-top:5px;">Days to author</label>';
        html += '<input type="number"  class="form-control" name="days_to_author[]" required=""></input>';
        html += '<label style="margin-top:5px;">Days to finish signing</label>';
        html += '<input type="number" class="form-control" name="days_to_finish_signing[]" required=""></input>';
        html += '<div class="input-group-append">';
        html += '</div>';
        html += '</div>';
        html += '<hr>';

        $('#newRow').append(html);
    });
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>