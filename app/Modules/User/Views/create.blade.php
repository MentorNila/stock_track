@extends('layouts.admin')
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab"
                           aria-selected="true">
                            <i class="bx bx-user align-middle"></i>
                            <span class="align-middle">Account</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="information-tab" data-toggle="tab" href="#information" aria-controls="information" role="tab"
                           aria-selected="false">
                            <i class="bx bx-info-circle align-middle"></i>
                            <span class="align-middle">Information</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                        <form action="{{ route("admin.users.store") }}" id="userForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                                        @if($errors->has('name'))
                                            <em class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </em>
                                        @endif
                                        <p class="helper-block">
                                            {{ trans('cruds.user.fields.name_helper') }}
                                        </p>
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                               value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        <span class="text-danger">
                                <span id="email-error">This email address is already being used</span>
                            </span>
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                                        <input type="password" id="password" name="password" class="form-control" required>
                                        <span class="text-danger">
                                            <span id="password-error">Password must be longer than 6 characters</span>
                                        </span>
                                    </div>
                                    <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                                        <label for="roles">{{ trans('cruds.user.fields.roles') }}*</label>
                                        <select name="role_id" id="roles" class="form-control select2" required>
                                            @foreach($roles as $id => $role)
                                                <option value="{{ $id }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('role'))
                                            <em class="invalid-feedback">
                                                {{ $errors->first('role') }}
                                            </em>
                                        @endif
                                        <p class="helper-block">
                                            {{ trans('cruds.user.fields.roles_helper') }}
                                        </p>
                                    </div>

                                    <div class="form-group {{ $errors->has('companies') ? 'has-error' : '' }}">
                                        <label for="companies">Companies</label>
                                        <select name="companies[]" id="companies" class="select2 select2-container select2-container--default" multiple="multiple" >
                                            @foreach($companies as $id => $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('companies'))
                                            <em class="invalid-feedback">
                                                {{ $errors->first('companies') }}
                                            </em>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save changes</button>
                                    <a type="reset" href="{{ route("admin.users.index") }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
                        <form action="" method="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="controls position-relative">
                                            <label>Birth date</label>
                                            <input type="text" class="form-control birthdate-picker" required placeholder="Birth date">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control">
                                            <option value="Alabama">Alabama</option>
                                            <option value="Alaska">Alaska</option>
                                            <option value="Arizona">Arizona</option>
                                            <option value="Arkansas">Arkansas</option>
                                            <option value="California">California</option>
                                            <option value="Colorado">Colorado</option>
                                            <option value="Connecticut">Connecticut</option>
                                            <option value="Delaware">Delaware</option>
                                            <option value="District Of Columbia">District Of Columbia</option>
                                            <option value="Florida">Florida</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Hawaii">Hawaii</option>
                                            <option value="Idaho">Idaho</option>
                                            <option value="Illinois">Illinois</option>
                                            <option value="Indiana">Indiana</option>
                                            <option value="Iowa">Iowa</option>
                                            <option value="Kansas">Kansas</option>
                                            <option value="Kentucky">Kentucky</option>
                                            <option value="Louisiana">Louisiana</option>
                                            <option value="Maine">Maine</option>
                                            <option value="Maryland">Maryland</option>
                                            <option value="Massachusetts">Massachusetts</option>
                                            <option value="Michigan">Michigan</option>
                                            <option value="Minnesota">Minnesota</option>
                                            <option value="Mississippi">Mississippi</option>
                                            <option value="Missouri">Missouri</option>
                                            <option value="Montana">Montana</option>
                                            <option value="Nebraska">Nebraska</option>
                                            <option value="Nevada">Nevada</option>
                                            <option value="New Hampshire">New Hampshire</option>
                                            <option value="New Jersey">New Jersey</option>
                                            <option value="New Mexico">New Mexico</option>
                                            <option value="New York">New York</option>
                                            <option value="North Carolina">North Carolina</option>
                                            <option value="North Dakota">North Dakota</option>
                                            <option value="Ohio">Ohio</option>
                                            <option value="Oklahoma">Oklahoma</option>
                                            <option value="Oregon">Oregon</option>
                                            <option value="Pennsylvania">Pennsylvania</option>
                                            <option value="Rhode Island">Rhode Island</option>
                                            <option value="South Carolina">South Carolina</option>
                                            <option value="South Dakota">South Dakota</option>
                                            <option value="Tennessee">Tennessee</option>
                                            <option value="Texas">Texas</option>
                                            <option value="Utah">Utah</option>
                                            <option value="Vermont">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="Virginia">Washington</option>
                                            <option value="West Virginia">West Virginia</option>
                                            <option value="Wisconsin">Wisconsin</option>
                                            <option value="Wyoming">Wyoming</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" required placeholder="Phone number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Address</label>
                                            <input type="text" class="form-control" placeholder="Address">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button type="button" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save changes</button>
                                    <a type="reset" href="{{ route("admin.users.index") }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
