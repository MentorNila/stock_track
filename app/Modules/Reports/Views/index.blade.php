@extends('layouts.admin')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@endsection
@section('content')
<div class="users-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>Reports</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#transactionJournal">
                                        Transaction Journal
                                    </button>
                                </td>
                                <td>
                                    <a type="button" href="/admin/reports/active_shares" class="btn btn-info btn-lg">
                                        Total Active Shares by Stock Class/Shareholder
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a type="button" href="/admin/reports/certificates" class="btn btn-info btn-lg">
                                        Certificates Issued
                                    </a>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Modal -->
                    <div id="transactionJournal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Transaction Journal</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route("admin.splits.store") }}" id="splitForm" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                                <label for="target">Date Range</label>
                                                <input type="text" id="date_range" name="date_range" class="form-control datepicker" value="">
                                            </div>

                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                                <label for="target">Through</label>
                                                <input type="text" id="through" name="through" class="form-control datepicker" value="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                                <label for="target">Stock Class</label>
                                                <select name="type" id="stock_type" class="form-control">
                                                    <option value="cd">CS1</option>
                                                    <option value="sd">CS2</option>
                                                    <option value="is">CS3</option>
                                                </select>
                                            </div>
                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                                <label for="target">Stock Type</label>
                                                <select name="type" id="stock_type" class="form-control">
                                                    <option value="cd">CS1</option>
                                                    <option value="sd">CS2</option>
                                                    <option value="is">CS3</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                                                <input type="radio" id="cash_dividend" name="first_radio" value="1">
                                                <label for="vehicle1">All Transaction Types</label><br>
                                                <input type="radio" id="capital_gains" name="first_radio" value="1">
                                                <label for="vehicle1">New Issues</label><br>
                                                <input type="radio" id="non_dividend_distribution" name="first_radio" value="1">
                                                <label for="vehicle1">Transfer Transactions</label><br>
                                                <input type="radio" id="non_dividend_distribution" name="first_radio" value="1">
                                                <label for="vehicle1">Retired/Void Transactions</label><br>
                                                <input type="radio" id="non_dividend_distribution" name="first_radio" value="1">
                                                <label for="vehicle1">Conversions</label><br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                                <input type="radio" id="cash_dividend" name="second_radio" value="1">
                                                <label for="vehicle1">Landscape version</label><br>
                                                <input type="radio" id="capital_gains" name="second_radio" value="1">
                                                <label for="vehicle1">Count of Transactions and Certificates Processed Only</label><br>
                                                <input type="radio" id="non_dividend_distribution" name="second_radio" value="1">
                                                <label for="vehicle1">Portrait version (includes price/share)</label><br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                                <input type="checkbox" id="cash_dividend" name="cash_dividend" value="1">
                                                <label for="vehicle1">Exclude Unprinted Certificates</label><br>
                                                <input type="checkbox" id="capital_gains" name="capital_gains" value="1">
                                                <label for="vehicle1">Show Voids in Transfers/Conversions</label><br>
                                                <input type="checkbox" id="non_dividend_distribution" name="non_dividend_distribution" value="1">
                                                <label for="vehicle1">Supress Routine/Non Routine and Mailed Date Information</label><br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                                                <input type="checkbox" id="cash_dividend" name="cash_dividend" value="1">
                                                <label for="vehicle1">Include totals page(s) - Count of transactions</label><br>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Preview</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- datatable ends -->
            </div>
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