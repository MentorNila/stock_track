@extends('layouts.admin')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
        <h1>Companies</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a type="button" href="{{ route("admin.companies.create") }}" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
        <a type="button" data-toggle="modal" data-target="#import" class="btn btn-success pull-right btn-icon glow mr-1 mb-1" style="color:white;">Import</a>
    </div>
</div>
<div class="company-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="company-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.company.fields.name') }}</th>
                                <th>{{ trans('cruds.company.fields.state') }}</th>
                                <th>Code</th>
                                <th>{{ trans('cruds.company.fields.phone_nr') }}</th>
                                <th>Federal ID</th>
                                <th>Ticker Symbol</th>
                                <th>Status</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $key => $company)
                            <tr data-entry-id="{{ $company->id }}">
                                <td><a href="/admin/companies/set/{{$company->id}}">{{ $company->name ?? '' }}</a></td>
                                <td>{{ $company->state ?? '' }}</td>
                                <td>{{ $company->code ?? '' }}</td>
                                <td>{{ $company->phone_one ?? '' }}</td>
                                <td>{{ $company->federal_id ?? '' }}</td>
                                <td>{{ $company->ticker_symbol ?? '' }}</td>
                                <td>
                                    @if($company->active == 1)
                                    <h6><span class="label text-success">Active</span></h6>
                                    @else
                                    <h6><span class="label text-warning">Unactive</span></h6>
                                    @endif
                                </td>
                                <td>
                                    <a class="icons" href="{{ route('admin.companies.show', $company->id) }}">
                                        <button type="button" class="btn btn-icon btn-light-info mr-1 mb-1">
                                            <i class="bx bxs-info-circle"></i></button>
                                    </a>

                                    <a class="icons" href="{{ route('admin.companies.edit', $company->id) }}">
                                        <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1">
                                            <i class="bx bx-edit-alt"></i></button>
                                    </a>
                                    @if($company->active == 1)
                                    <form action="{{ route('admin.companies.unactive', $company->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to set UnActive {{ $company->name }}?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-icon btn-light-danger mr-1 mb-1" name="submit" alt="Submit">
                                            <i class="bx bx-x"></i>
                                        </button>
                                    </form>
                                    @else
                                    <a type="button" href="/admin/companies/active/{{$company->id}}" title="Make Company Active" class="btn btn-icon btn-light-success mr-1 mb-1" name="submit" alt="Submit">
                                        <i class="bx bx-been-here"></i>
                                    </a>
                                    @endif
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

<div id="import" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{ route("admin.companies.excel_import") }}" id="certificateForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Import Companies</h4>
                </div>
                <div class="modal-body">
                    <p>Upload Excel File</p>
                    <input type="file" id="companies" name="companies" accept="image/png, image/jpeg">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Import</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script src="{{asset('js/scripts/pages/page-company.js')}}"></script>
@endsection