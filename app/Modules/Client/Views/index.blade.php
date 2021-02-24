@extends('layouts.admin')
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection

@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
            <h1>Clients</h1>
    </div>
</div>
@can('client_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a type="button" href="{{ route("admin.clients.register") }}" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
        </div>
    </div>
@endcan
<div class="clients-list-wrapper">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="clients-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.client.fields.name') }}</th>
                                <th>{{ trans('cruds.client.fields.subdomain') }}</th>
                                <th>{{ trans('cruds.client.fields.status') }}</th>
                                <th>{{ trans('cruds.client.fields.plan') }}</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $key => $client)
                                <tr data-entry-id="{{ $client->id }}">
                                    <td>{{ $client->name ?? '' }}</td>
                                    <td>{{ $client->subdomain ?? '' }}</td>
                                    <td><span class="badge badge-light-success">{{ \App\Modules\Client\Facades\ViewVars::returnClientCode($client->status) ?? '' }}</span></td>
                                    <td>{{ $client->plan->title ?? '' }}</td>
                                    <td>
                                        @can('client_edit')
                                            <a class="icons" href="{{ route('admin.clients.edit', $client->id) }}">
                                                <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1">
                                                    <i class="bx bx-edit-alt"></i></button>
                                            </a>
                                        @endcan
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
@endsection
{{-- page scripts --}}
@section('page-scripts')
    <script>
        // datatable initialization
        if ($("#clients-list-datatable").length > 0) {
            $("#clients-list-datatable").DataTable({
                responsive: true,
                'columnDefs': [
                    {
                        "orderable": false,
                        "targets": [4]
                    }]
            });
        }
    </script>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection

