@extends('layouts.admin')
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@endsection
@section('content')

    <section class="company-create">
        <div class="card">
            <div class="card-content">
                <div class="card-body">

<div class="row add-item-title">
    <div class="col-lg-12">
        <h1 class="blue">Add a Company</h1>
    </div>
</div>
<form action="{{ route("admin.companies.store") }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row add-client">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.company.fields.name') }}</label>
                <input required type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($client) ? $client->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('address_one') ? 'has-error' : '' }}">
                <label for="address_one">Address One</label>
                <input type="text" id="address_one" name="address_one" class="form-control" value="{{ old('address_one', isset($client) ? $client->address_one : '') }}">
                @if($errors->has('address_one'))
                    <em class="invalid-feedback">
                        {{ $errors->first('address_one') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.irs_employer_identification_no_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('address_two') ? 'has-error' : '' }}">
                <label for="address_two">Address Two</label>
                <input type="text" id="address_two" name="address_two" class="form-control" value="{{ old('address_two', isset($client) ? $client->address_two : '') }}">
                @if($errors->has('address_two'))
                    <em class="invalid-feedback">
                        {{ $errors->first('address_two') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.address_of_principal_executive_offices_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('address_three') ? 'has-error' : '' }}">
                <label for="address_three">Address Three</label>
                <input type="text" id="address_three" name="address_three" class="form-control" value="{{ old('address_three', isset($client) ? $client->address_three : '') }}">
                @if($errors->has('address_three'))
                    <em class="invalid-feedback">
                        {{ $errors->first('address_three') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.zip_code_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($client) ? $client->email : '') }}">
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.phone_nr_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('federal_id') ? 'has-error' : '' }}">
                <label for="federal_id"> Federal ID No.</label>
                <input type="text" id="federal_id" name="federal_id" class="form-control" value="{{ old('federal_id', isset($client) ? $client->federal_id : '') }}">
                @if($errors->has('federal_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('federal_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.nature_of_operations_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('last_trans_no') ? 'has-error' : '' }}">
                <label for="last_trans_no">Last Trans. No.</label>
                <input type="text" id="last_trans_no" name="last_trans_no" class="form-control" value="{{ old('last_trans_no', isset($client) ? $client->last_trans_no : '') }}">
                @if($errors->has('last_trans_no'))
                    <em class="invalid-feedback">
                        {{ $errors->first('last_trans_no') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.forward_looking_statements_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('after_proxy_date') ? 'has-error' : '' }}">
                <label for="after_proxy_date">After Proxy Date</label>
                <input type="text" id="after_proxy_date" name="after_proxy_date" class="form-control datepicker" value="{{ old('after_proxy_date', isset($client) ? $client->after_proxy_date : '') }}">
                @if($errors->has('after_proxy_date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('after_proxy_date') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.forward_looking_statements_helper') }}
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="state">Company Code</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($client) ? $client->code : '') }}">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.state_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('phone_one') ? 'has-error' : '' }}">
                <label for="phone_one">Phone One</label>
                <input type="text" id="phone_one" name="phone_one" class="form-control" value="{{ old('phone_one', isset($client) ? $client->phone_one : '') }}">
                @if($errors->has('phone_one'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phone_one') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.irs_employer_identification_no_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('phone_two') ? 'has-error' : '' }}">
                <label for="phone_two">Phone Two</label>
                <input type="text" id="phone_two" name="phone_two" class="form-control" value="{{ old('phone_two', isset($client) ? $client->phone_two : '') }}">
                @if($errors->has('phone_two'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phone_two') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.address_of_principal_executive_offices_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('phone_three') ? 'has-error' : '' }}">
                <label for="phone_three">Phone Three</label>
                <input type="text" id="phone_three" name="phone_three" class="form-control" value="{{ old('phone_three', isset($client) ? $client->phone_three : '') }}">
                @if($errors->has('phone_three'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phone_three') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.zip_code_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('ticker_symbol') ? 'has-error' : '' }}">
                <label for="ticker_symbol">Ticker Symbol</label>
                <input required type="text" id="ticker_symbol" name="ticker_symbol" class="form-control" value="{{ old('ticker_symbol', isset($client) ? $client->ticker_symbol : '') }}">
                @if($errors->has('ticker_symbol'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ticker_symbol') }}
                    </em>
                @endif
                <p class="helper-block">
                </p>
            </div>
            <div class="form-group {{ $errors->has('incorp_in_state') ? 'has-error' : '' }}">
                <label for="incorp_in_state">Incorp. in State/Province</label>
                <input required type="text" id="incorp_in_state" name="incorp_in_state" class="form-control" value="{{ old('incorp_in_state', isset($client) ? $client->incorp_in_state : '') }}">
                @if($errors->has('incorp_in_state'))
                    <em class="invalid-feedback">
                        {{ $errors->first('incorp_in_state') }}
                    </em>
                @endif
                <p class="helper-block">
                </p>
            </div>
            <div class="form-group {{ $errors->has('proxy_record_date') ? 'has-error' : '' }}">
                <label for="proxy_record_date">Proxy Record Date</label>
                <input type="text" id="proxy_record_date" name="proxy_record_date" class="form-control datepicker" value="{{ old('proxy_record_date', isset($client) ? $client->proxy_record_date : '') }}">
                @if($errors->has('proxy_record_date'))
                    <em class="invalid-feedback">
                        {{ $errors->first('proxy_record_date') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.nr_of_employees_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('proxy_record_date') ? 'has-error' : '' }}">
                <label for="last_holder_id">Last Holder ID</label>
                <input type="text" id="last_holder_id" name="last_holder_id" class="form-control" value="{{ old('last_holder_id', isset($client) ? $client->last_holder_id : '') }}">
                @if($errors->has('last_holder_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('last_holder_id') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.nr_of_employees_helper') }}
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group {{ $errors->has('date_terminated') ? 'has-error' : '' }}">
                <label for="date_terminated">Date Terminated</label>
                <input type="text" id="date_terminated" name="date_terminated" class="form-control datepicker" value="{{ old('date_terminated', isset($client) ? $client->date_terminated : '') }}">
                @if($errors->has('date_terminated'))
                    <em class="invalid-feedback">
                        {{ $errors->first('date_terminated') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.state_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                <label for="state">State</label>
                <input type="text" id="state" name="state" class="form-control datepicker" value="{{ old('state', isset($client) ? $client->state : '') }}">
                @if($errors->has('state'))
                    <em class="invalid-feedback">
                        {{ $errors->first('state') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.state_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('state_short') ? 'has-error' : '' }}">
                <input type="text" id="state_short" name="state_short" class="form-control datepicker" value="{{ old('state_short', isset($client) ? $client->state_short : '') }}" style="max-width: 250px;">
                @if($errors->has('state_short'))
                    <em class="invalid-feedback">
                        {{ $errors->first('state_short') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.state_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('zip_code') ? 'has-error' : '' }}">
                <input type="text" id="zip_code" name="zip_code" class="form-control datepicker" value="{{ old('zip_code', isset($client) ? $client->zip_code : '') }}" style="max-width: 100px;">
                @if($errors->has('zip_code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('zip_code') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.company.fields.state_helper') }}
                </p>
            </div>
        </div>
    </div>
    <div class="add-client" style="margin-top: 20px;">
        <input class="btn btn-success" type="submit" value="Add">
    </div>
</form>

                </div>
            </div>
        </div>
    </section>
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
  $( document ).ready(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
  </script>
    <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
    <script>
        $("#users").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
    </script>
    <script src="{{asset('js/scripts/pages/page-company.js')}}"></script>
    <script src="{{asset('js/scripts/navs/navs.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
@endsection
