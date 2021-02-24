@extends('layouts.admin')
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
@section('content')

    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">


                    <div class="row add-item-title">
                        <div id="subdomainExists_danger_alert" class="alert alert-danger" role="alert" style="display:none;">
                            Subdomain already exists
                        </div>
                        <div class="col-lg-12">
                            <h1 class="blue">Edit Client</h1>
                        </div>
                    </div>

                    <form id="add-client-form" action="{{ route("admin.clients.update", [$client->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row add-client">
                            <div class="col-md-4">

                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name">{{ trans('cruds.client.fields.name') }}</label>
                                    <input required type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($client) ? $client->name : '') }}">
                                    @if($errors->has('name'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.client.fields.name_helper') }}
                                    </p>
                                </div>

                                <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                                    <label for="subdomain">{{ trans('cruds.client.fields.subdomain') }}</label>
                                    <input required type="text" id="subdomain" name="subdomain" class="form-control" value="{{ old('subdomain', isset($client) ? $client->subdomain : '') }}">
                                    <p class="loginError" style="color:red; display:none;">This subdomain is already used. Please enter an unique subdomain</p>
                                    <span class="text-danger">
                    <span id="subdomain-error">Invalid Subdomain format</span>
                </span>
                                    @if($errors->has('subdomain'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('subdomain') }}
                                        </em>
                                    @endif
                                    <p class="helper-block">
                                        {{ trans('cruds.client.fields.subdomain_helper') }}
                                    </p>
                                </div>

                                <div class="form-group">
                                    <div class="controls position-relative">
                                        <label class="label">Active Date</label>
                                        <input class="form-control activedate-picker" id="datepicker"  name="active_date" value="{{ old('active_date', isset($client) ? $client->active_date : '') }}">
                                        <span class="text-danger">
                       <span id="date-error">Please choose a date</span>
                    </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="controls position-relative">
                                        <label class="label">Expire Date</label>
                                        <input class="form-control expiredate-picker" id="expire-date-picker" name="expired_date"  value="{{ old('expired_date', isset($client) ? $client->expired_date : '') }}">
                                        <span class="text-danger">
                       <span id="expire-date-error">Please choose a date</span>
                    </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Plan</label>
                                    <select class="form-control" name="plan_id"  required>
                                        <option selected disabled></option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}" @if(isset($client->plan_id) && $client->plan_id == $plan->id) selected @endif>{{ $plan->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option selected disabled></option>
                                        <option @if($client->status == ViewVars::getClientStatusCode('PENDING')) selected @endif value="{{ ViewVars::getClientStatusCode('PENDING')}}">PENDING</option>
                                        <option @if($client->status == ViewVars::getClientStatusCode('CONFIRMED')) selected @endif value="{{ ViewVars::getClientStatusCode('CONFIRMED')}}">CONFIRMED</option>
                                        <option @if($client->status == ViewVars::getClientStatusCode('DECLINED')) selected @endif value="{{ ViewVars::getClientStatusCode('DECLINED')}}">DECLINED</option>
                                        <option @if($client->status == ViewVars::getClientStatusCode('ACTIVATED')) selected @endif value="{{ ViewVars::getClientStatusCode('ACTIVATED')}}">ACTIVATED</option>
                                    </select>
                                </div>
                                <input type="hidden" name="is_domain" value="0" class="form-control">
                                <input type="hidden" name="id" id ="client_id" value="{{isset($client) ? $client->id : ''}}" class="form-control">
                                <div class="form-check">
                                    <input type="checkbox" @if(!$client->expired_date) checked @endif class="form-check-input" value="1" name="never_expire" id="never_expire">
                                    <label class="form-check-label" for="never_expire">Never expire</label>
                                </div>
                            </div>
                        </div>
                        <div class="add-client" style="margin-top: 20px;">
                            <input class="btn btn-danger add-button" id="addButton" type="submit" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
@endsection

@section('page-scripts')


    <script>

        $('#date-error').hide();
        $('#subdomain-error').hide();
        $('#expire-date-error').hide();


        $(document).ready(function(){
            $('#addButton').click(function() {
                if ($('#datepicker').val().length === 0) {
                    $('#date-error').show();
                    $("#datepicker").focus();

                    return false;
                }
                else{
                    $('#date-error').hide();

                    return true;
                }
            });


            $('#addButton').click(function() {
                var subdomainReg = new RegExp(/^([a-z0-9]+[a-z0-9-]*[a-z0-9]+$)/);
                var subdomainText = $('#subdomain').val();

                if (!subdomainReg.test(subdomainText)) {
                    $('#subdomain-error').show();
                    return false;
                } else {
                    $('#subdomain-error').hide();
                    return true;
                }

            });



            $('#addButton').click(function() {

                var checkBox = document.getElementById("never_expire");
                if (checkBox.checked == false) {
                    if ($('#expire-date-picker').val().length === 0) {
                        $('#expire-date-error').show();
                        return false;
                    }
                }else {

                    $('#expire-date-error').hide();
                    return true;
                }
            });


        });

    </script>

    <script src="{{asset('js/scripts/client.js')}}"></script>
@endsection
