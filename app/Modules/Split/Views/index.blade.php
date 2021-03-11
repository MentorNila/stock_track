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
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Dividend/Splits</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
        <a type="button" data-toggle="modal" data-target="#createSplit" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1" style="color:white;"><i class="bx bx-plus" style="top: 0px;"></i></a>
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
                                <th>Type of Dividend/Split</th>
                                <th>Stock Class</th>
                                <th>Record Date</th>
                                <th>Pay Date</th>
                                <th>Ordinary Dividend</th>
                                <th>Rate per Share</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($splits as $currentSplit)
                            <tr>
                                <td>
                                    {{$currentSplit->type}}
                                </td>
                                <td>
                                    {{$currentSplit->stock_class}}
                                </td>
                                <td>
                                    {{$currentSplit->record_date}}
                                </td>
                                <td>
                                    {{$currentSplit->pay_date}}
                                </td>
                                <td>
                                    {{$currentSplit->ordinary_dividend}}
                                </td>
                                <td>
                                    {{$currentSplit->rate}}
                                </td>
                                <td>
                                    <a class="icons" href="{{ route('admin.splits.edit', $currentSplit->id) }}">
                                        <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1">
                                            <i class="bx bx-edit-alt"></i></button>
                                    </a>
                                    <form action="{{ route('admin.splits.delete', $currentSplit->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to set delete this Split?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-icon btn-light-danger mr-1 mb-1" name="submit" alt="Submit">
                                            <i class="bx bx-x"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- datatable ends -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="createSplit" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Dividend, Distribution or Split</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route("admin.splits.store") }}" id="splitForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="type">Type of dividend or Split</label>
                            <select name="type" id="type" class="form-control">
                                <option value="cd">CD -Cash Distribution</option>
                                <option value="sd">SD -Stock Dividend</option>
                                <option value="is">IS -Incremental Split</option>
                                <option value="rs">RS -Forward Replacement Split</option>
                                <option value="vs">VS -Reverse Replacement Split</option>
                                <option value="sc">SC -S-Corp Distrib - Allocate State WH tax</option>
                                <option value="sf">SF -S-Corp Distrib - Flat State WH tax</option>
                            </select>
                        </div>

                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Select a Stock Class</label>
                            <select name="stock_class" id="stock_class" class="form-control">
                                <option value="cs1">CS1</option>
                                <option value="cs2">CS2</option>
                                <option value="cs3">CS3</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Record Date</label>
                            <input type="text" id="record_date" name="record_date" class="form-control datepicker" value="" required>
                        </div>
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-6">
                            <label for="target">Pay Date</label>
                            <input type="text" id="pay_date" name="pay_date" class="form-control datepicker" value="" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                            <label for="target">Ordinary dividend</label>
                            <input type="text" id="ordinary_dividend" name="ordinary_dividend" class="form-control " value="" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                            <label for="target">This Cash Distribution consists of:</label><br>
                            <input type="checkbox" id="cash_dividend" name="cash_dividend" value="1">
                            <label for="vehicle1">Ordinary Cash dividend</label><br>
                            <input type="checkbox" id="capital_gains" name="capital_gains" value="1">
                            <label for="vehicle1">Capital Gains</label><br>
                            <input type="checkbox" id="non_dividend_distribution" name="non_dividend_distribution" value="1">
                            <label for="vehicle1">Non-dividend Distribution (Return of Capital)</label><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group {{ $errors->has('target') ? 'has-error' : '' }} col-lg-12">
                            <label for="target">Total rate/share for this Cash Distribution</label>
                            <input type="text" id="rate" name="rate" class="form-control " value="" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Create</button>
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