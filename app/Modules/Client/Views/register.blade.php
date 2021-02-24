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
                            <h1 class="blue">Add a Client</h1>
                        </div>
                    </div>



                    <form id="add-client-form" action="{{ route("admin.client.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row add-client">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input required type="text" id="name" name="name" value="{{ old('name', isset($data) ? $data->company : '') }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="subdomain">Subdomain</label>
                                    <input required type="text" id="subdomain" name="subdomain" value="{{ old('subdomain', isset($data) ? trim(str_replace(' ', '', $data->company)) : '') }}" class="form-control">
                                    <span class="text-danger">
                    <span id="subdomain-error">Invalid Subdomain format</span>
                </span>
                                    <p class="loginError" style="color:red; display:none;">This subdomain is already used. Please enter an unique subdomain</p>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="controls position-relative">
                                        <label>Active Date</label>
                                        <input  id="datepicker"  value="{{ old('active_date') }}" name="active_date" class="form-control activedate-picker" >
                                        <span class="text-danger">
                       <span id="date-error">Please choose a date</span>
                    </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Package</label>
                                    <select class="form-control" name="plan_id" required>
                                        <option selected disabled></option>
                                        @foreach($packages as $package)
                                            <option @if(isset($data) && $data->plan_id ==  $package->id) selected @endif value="{{ $package->id  }}">{{ $package->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="admin_id" value="1" class="form-control">
                                {{--            <input type="hidden" name="plan_id" value="1" class="form-control">--}}
                                <input type="hidden" name="is_domain" value="0" class="form-control">
                                <input type="hidden" name="request_id" value="{{ old('name', isset($data) ? $data->id : '') }}" class="form-control">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option selected disabled></option>
                                        <option value="0">PENDING</option>
                                        <option value="1">CONFIRMED</option>
                                        <option value="2">DECLINED</option>
                                        <option value="3">ACTIVATED</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="add-client" style="margin-top: 20px;">
                            <input class="btn btn-danger add-button"  id="addButton"  type="submit" value="Add">
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
        });
    </script>
    <script src="{{asset('js/scripts/client.js')}}"></script>
@endsection

