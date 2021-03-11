@extends('layouts.admin')
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@endsection
@section('content')
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <form action="{{ route("admin.splits.update", $split->id) }}" id="splitForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Type of dividend or Split</label>
                        <select name="type" id="type" class="form-control">
                            <option value="cd" @if($split->type == 'cd') selected @endif>CD -Cash Distribution</option>
                            <option value="sd" @if($split->type == 'sd') selected @endif>SD -Stock Dividend</option>
                            <option value="is" @if($split->type == 'is') selected @endif>IS -Incremental Split</option>
                            <option value="rs" @if($split->type == 'rs') selected @endif>RS -Forward Replacement Split</option>
                            <option value="vs" @if($split->type == 'vs') selected @endif>VS -Reverse Replacement Split</option>
                            <option value="sc" @if($split->type == 'sc') selected @endif>SC -S-Corp Distrib - Allocate State WH tax</option>
                            <option value="sf" @if($split->type == 'sf') selected @endif>SF -S-Corp Distrib - Flat State WH tax</option>
                        </select>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Select a Stock Class</label>
                        <select name="type" id="type" class="form-control">
                            <option value="cs1" @if($split->type == 'cs1') selected @endif>CS1</option>
                            <option value="cs2" @if($split->type == 'cs2') selected @endif>CS2</option>
                            <option value="cs3" @if($split->type == 'cs3') selected @endif>CS3</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Record Date</label>
                        <input type="text" id="record_date" name="record_date" class="form-control datepicker" value="{{$split->record_date}}" required>
                    </div>
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Pay Date</label>
                        <input type="text" id="pay_date" name="pay_date" class="form-control datepicker" value="{{$split->pay_date}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                        <label for="target">Ordinary dividend</label>
                        <input type="text" id="ordinary_dividend" name="ordinary_dividend" class="form-control " value="{{$split->ordinary_dividend}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                        <label for="target">This Cash Distribution consists of:</label><br>
                        <input type="checkbox" id="cash_dividend" name="cash_dividend" value="1" @if($split->cash_dividend) checked @else @endif">
                        <label for="vehicle1">Ordinary Cash dividend</label><br>
                        <input type="checkbox" id="capital_gains" name="capital_gains" value="1" @if($split->capital_gains) checked @else @endif">
                        <label for="vehicle1">Capital Gains</label><br>
                        <input type="checkbox" id="non_dividend_distribution" name="non_dividend_distribution" value="1" @if($split->non_dividend_distribution) checked @else @endif">
                        <label for="vehicle1">Non-dividend Distribution (Return of Capital)</label><br>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                        <label for="target">Total rate/share for this Cash Distribution</label>
                        <input type="text" id="rate" name="rate" class="form-control " value="{{$split->rate}}" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <a type="button" href="/admin/splits" class="btn btn-warning glow mb-1 mb-sm-0 mr-0 mr-sm-1">Cancel</a>
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
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
<script>
    $('#email-error').hide();

    $(".select2").select2({
        width: '100%'
    });

    $("#userForm").submit(function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var userId = $('#user_id').val();

        $.ajax({
            type: 'POST',
            data: {
                id: userId,
                email: email,
                // id: id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/users/check-email',
            success: function(response) {
                if (response.success === 'true') {

                    $('#email-error').show();
                    $("#email").focus();
                } else {
                    $('#userForm').unbind().submit();
                }
            }
        });
    });

    $('#password-error').hide();

    $("#update-password-form").submit(function(e) {
        e.preventDefault();
        var password = $('#password').val();

        if (password.length < 6) {
            $('#password-error').show();

        } else {
            $('#update-password-form').unbind().submit();
        }
    });
</script>
<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>
@endsection