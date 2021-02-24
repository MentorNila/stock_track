@extends('layouts.admin')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Certificates</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#createCertificate" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
    </div>
</div>
<div class="users-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>Stock Class</th>
                                <th>Total Shares</th>
                                <th>Issued Date</th>
                                <th>Number of Paper Certificates to Issue</th>
                                <th>Reason/Reservation</th>
                                <th>Received From</th>
                                <th>Restriction</th>
                                <th>Sale Amt/Share</th>
                                <th>Acquired</th>
                                <th>FMW</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <a href="/admin/shareholders/delete/" title="delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- datatable ends -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="createCertificate" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Issue</h4>
    </div>
    <div class="modal-body">
        <form action="{{ route("admin.shareholders.store") }}" id="shareholderForm" method="POST" enctype="multipart/form-data">
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
                    <input type="text" id="stock_class" name="stock_class" class="form-control " value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6" >
                    <label for="target">Total Shares</label>
                    <input type="text" id="total_shares" name="total_shares" class="form-control" value="" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Issued Date</label>
                    <input type="text" id="issued_date" name="issued_date" class="form-control datepicker" value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Reason/Reservation</label>
                    <input type="text" id="reservation" name="reservation" class="form-control " value="" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Nr of Paper Certificates to Issue</label>
                    <input type="text" id="nr_of_paper" name="nr_of_paper" class="form-control " value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Restriction</label>
                    <input type="text" id="restriction" name="restriction" class="form-control " value="" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Received From</label>
                    <input type="text" id="received_from" name="received_from" class="form-control " value="" required>
                </div>

                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                    <label for="target">Broker involved for Cost Basis</label>
                    <input type="text" id="broker" name="broker" class="form-control " value="" required>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <input type="checkbox" id="cost_of_basis_received" name="cost_of_basis_received" style="margin-top:5px;">
                    <label for="vehicle1" style="margin-top:0px; margin-left: 2px;">Cost Basis Received?</label><br>
                </div>
            </div>

            <hr />

            <div id="costItems" class="row hidden" style="margin-top: 10px;">
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                    <label for="target">Sale Amt/share</label>
                    <input type="text" id="address" name="address" class="form-control " value="" required>
                </div>
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                    <label for="target">Acquired</label>
                    <input type="text" id="address" name="address" class="form-control " value="" required>
                </div>
                <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-4">
                    <label for="target">FMV</label>
                    <input type="text" id="address" name="address" class="form-control " value="" required>
                </div>
            </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
        </div>
        </form>
    </div>

</div>
</div>
<style type="text/css">
    .hidden {
        display: none;
    }
</style>
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
  $( document ).ready(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
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