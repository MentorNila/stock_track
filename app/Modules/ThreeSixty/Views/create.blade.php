@extends('layouts.admin')
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
@section('content')
<form action="{{ route("admin.goals.store") }}" id="goalForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="text-center">
                    <h5>CREATE GOAL</h5><h6>Fill out this form to create a goal.</h6>
                </div>
        <div class="tab-content">
            <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">Goal Title/Name*</label>
                                <input type="text" id="name" name="name" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }}">
                            <div class="row">
                                <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                                    <label for="target">Target*</label>
                                    <input type="text" id="target" name="target" class="form-control" value="" required>
                                    @if($errors->has('target'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('target') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.name_helper') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('units') ? 'has-error' : '' }} ">
                                    <label for="units">Units*</label>
                                    <input type="text" id="units" name="units" class="form-control" value="" required>
                                    @if($errors->has('units'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('units') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.name_helper') }}
                                    </p>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                            <div class="row">
                                <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }} ">
                                    <label for="start_date">Start Date*</label>
                                    <input type="text" id="start_date" name="start_date" class="form-control birthdate-picker" value="" required>
                                    @if($errors->has('start_date'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('start_date') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.name_helper') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('due_date') ? 'has-error' : '' }} ">
                                    <label for="due_date">Due Date*</label>
                                    <input type="text" id="due_date" name="due_date" class="form-control birthdate-picker" value="" required>
                                    @if($errors->has('due_date'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('due_date') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.user.fields.name_helper') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <textarea class="form-control"  rows="3"></textarea>
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
                                <div class="form-group">
                                    <label>Employees</label>
                                    <select name="employees" class="form-control" multiple="">
                                        <option ></option>
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Create Goal</button>
                        <a type="reset" href="{{ route("admin.users.index") }}" class="btn btn-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</form>
@endsection
@section('vendor-scripts')
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
@endsection
@section('page-scripts')
<script>
    $('#email-error').hide();
    $('#password-error').hide();

    $(".select2").select2({
        width: '100%'
    });
    $('.birthdate-picker').pickadate({
        format: 'yyyy-mm-dd',
    });

    $("#userForm").submit(function(e){
        e.preventDefault();

        var password = $('#password').val();

        if (password.length < 6) {
            $('#password-error').show();

        } else{

            var email = $('#email').val();

            $.ajax({
                type: 'POST',
                data: {
                    email: email,
                        // id: id,
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/admin/users/check-email',
                    success: function (response) {
                        if (response.success === 'true') {
                            $('#email-error').show();
                            $("#email").focus();
                        } else {
                            $('#userForm').unbind().submit();
                        }
                    }
                });
        }


    });

</script>
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection
