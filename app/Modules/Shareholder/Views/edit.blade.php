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
            <div class="row add-item-title">
                <div class="col-lg-12">
                    <h1 class="blue">Edit Shareholder</h1>
                </div>
            </div>
            <form action="{{ route("admin.shareholders.update", $shareholder->id) }}" id="shareholderForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                    <label for="target">Ref Name</label>
                    <input type="text" id="refName" name="ref_name" class="form-control " value="{{$shareholder->ref_name}}" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                    <label for="target">Name as appears on certificate</label>
                    <input type="text" id="nameAsAppearsOnCertificate" name="name_as_appears_on_certificate" class="form-control birthdate-picker" value="{{$shareholder->name_as_appears_on_certificate}}" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                    <label for="target">Registration</label>
                    <input type="text" id="registration" name="registration" class="form-control " value="{{$shareholder->registration}}" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                    <label for="target">SSno</label>
                    <input type="text" id="ssno" name="ssno" class="form-control " value="{{$shareholder->ssno}}" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} ">
                    <label for="target">Address</label>
                    <input type="text" id="address" name="address" class="form-control " value="{{$shareholder->address}}" required>
                </div>

                <div class="modal-footer">
                    <a type="button" href="/admin/shareholders" class="btn btn-warning glow mb-1 mb-sm-0 mr-0 mr-sm-1">Cancel</a>
                    <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Update</button>
                </div>
            </form>
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

</script>
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection