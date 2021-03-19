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
            <form action="{{ route("admin.reservations.update", $reservation->id) }}" id="reservationForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <h6>Reservation</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                <label for="target">Reservation Code</label>
                                <input type="text" id="code" name="code" class="form-control" value="{{$reservation->code}}">
                            </div>

                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                <label for="target">Class</label>
                                <input type="text" id="class" name="class" class="form-control " value="{{$reservation->class}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                <label for="target">Reserved</label>
                                <input type="text" id="reserved" name="reserved" class="form-control" value="{{$reservation->reserved}}">
                            </div>

                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                <label for="target">Shares Issued</label>
                                <input type="text" id="shares_issued" name="shares_issued" class="form-control " value="{{$reservation->shares_issued}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                <label for="target">Start Date</label>
                                <input type="text" id="start_date" name="start_date" class="form-control datepicker" value="{{$reservation->start_date}}">
                            </div>

                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                <label for="target">End Date</label>
                                <input type="text" id="end_date" name="end_date" class="form-control datepicker" value="{{$reservation->end_date}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                <label for="target">Description</label>
                                <textarea class="form-control" name="description">
                                {{$reservation->description}}
                                </textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
@endsection