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
            <form action="{{ route("admin.certificates.update", $certificate->id) }}" id="certificateForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                        <label for="target">Add to Shareholder</label>
                        <select name="shareholder_id" id="shareholder_id" class="form-control">
                            @foreach($shareholders as $shareholder)
                            <option value="{{$shareholder->id}}">{{$shareholder->name_as_appears_on_certificate}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Stock Class</label>
                        <input type="text" id="stock_class" name="stock_class" class="form-control " value="{{$certificate->stock_class}}" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Total Shares</label>
                        <input type="text" id="total_shares" name="total_shares" class="form-control" value="{{$certificate->total_shares}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Issued Date</label>
                        <input type="text" id="issued_date" name="issued_date" class="form-control datepicker" value="{{$certificate->issued_date}}" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Reason/Reservation</label>
                        <input type="text" id="reservation" name="reservation" class="form-control " value="{{$certificate->reservation}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Nr of Paper Certificates to Issue</label>
                        <input type="text" id="nr_of_paper" name="nr_of_paper" class="form-control " value="{{$certificate->nr_of_paper}}" required>
                    </div>

                    <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                        <label for="target">Restriction</label>
                        <input type="text" id="restriction" name="restriction" class="form-control " value="{{$certificate->restriction}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('received_from') ? 'has-error' : '' }} col-lg-6">
                        <label for="received_from">Received From</label>
                        <input type="text" id="received_from" name="received_from" class="form-control " value="{{$certificate->received_from}}" required>
                    </div>

                    <div class="form-group {{ $errors->has('broker') ? 'has-error' : '' }} col-lg-6">
                        <label for="broker">Broker involved for Cost Basis</label>
                        <input type="text" id="broker" name="broker" class="form-control " value="{{$certificate->broker}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <input type="checkbox" id="costOfBasisReceived" value="1" name="cost_of_basis_received" style="margin-top:5px;">
                        <label for="vehicle1" style="margin-top:0px; margin-left: 2px;">Cost Basis Received?</label><br>
                    </div>
                </div>

                <hr />

                <div id="costItems" class="hidden">
                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                            <label for="target">Acquired</label>
                            <select name="acquired" id="acquired" class="form-control">
                                <option></option>
                                <option selected>{{$certificate->acquired}}</option>
                                @foreach($shareholders as $shareholder)
                                <option value="{{$shareholder->id}}">{{$shareholder->name_as_appears_on_certificate}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Sale Amt/Share</label>
                            <input type="text" id="amt_share" name="amt_share" class="form-control " value="{{$certificate->amt_share}}">
                        </div>

                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">FMW</label>
                            <input type="text" id="fmw" name="fmw" class="form-control " value="{{$certificate->fmw}}">
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
    {{-- vendor scripts --}}
    @section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
    @endsection

    {{-- page scripts --}}
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
    <script type="text/javascript">
        $(document).on('click', function() {
            if ($('#costOfBasisReceived').is(':checked')) {
                $('#costItems').removeClass('hidden');
            } else {
                $('#costItems').addClass('hidden');
            }
        })
    </script>