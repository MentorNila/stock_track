@extends('layouts.admin')
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@section('content')
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <div class="row add-item-title">
                <div class="col-lg-12">
                    <h1 class="blue">Edit Transaction</h1>
                </div>
            </div>
            <form action="{{ route("admin.transacts.update", $transaction->id) }}" id="transactForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">SEC Tracking</label>
                        <input type="text" id="sec_tracking" name="sec_tracking" class="form-control " value="{{$transaction->sec_tracking}}" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Item Count</label>
                        <input type="text" id="item_count" name="item_count" class="form-control " value="{{$transaction->item_count}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">ID/SCL</label>
                        <input type="text" id="scl" name="scl" class="form-control " value="{{$transaction->scl}}" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Control Ticket</label>
                        <input type="text" id="control_ticket" name="control_ticket" class="form-control " value="{{$transaction->control_ticket}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Received</label>
                        <input type="text" id="received" name="received" class="form-control datepicker" value="{{$transaction->received}}">
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">at</label>
                        <input type="text" id="received_at" name="received_at" class="form-control " value="{{$transaction->received_at}}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Received From</label>
                        <input type="text" id="received_from" name="received_from" class="form-control " value="{{$transaction->received}}" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">How Received</label>
                        <input type="text" id="how_received" name="how_received" class="form-control " value="{{$transaction->how_received}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Tracking #</label>
                        <input type="text" id="track" name="track" class="form-control " value="{{$transaction->track}}" required>
                    </div>
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Assigned</label>
                        <select name="assigned_to" id="assigned_to" class="form-control">
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <a type="button" href="/admin/log_transact" class="btn btn-warning glow mb-1 mb-sm-0 mr-0 mr-sm-1">Cancel</a>
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
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>