@extends('layouts.admin')
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
            <h1>Requests</h1>
    </div>
</div>


<div class="requests-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="requests-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.request.fields.first_name') }}</th>
{{--                                <th>{{ trans('cruds.request.fields.last_name') }}</th>--}}
{{--                                <th>{{ trans('cruds.request.fields.email') }}</th>--}}
{{--                                <th>{{ trans('cruds.request.fields.phone_number') }}</th>--}}
                                <th>{{ trans('cruds.request.fields.company') }}</th>
                                <th>{{ trans('cruds.request.fields.plan') }}</th>
                                <th>{{ trans('cruds.request.fields.status') }}</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($clientRequests as $key => $request)
                            <tr data-entry-id="{{ $request->id }}">
                                <td>{{ $request->first_name ?? '' }}</td>
{{--                                <td>{{ $request->last_name ?? '' }}</td>--}}
{{--                                <td>{{ $request->email ?? '' }}</td>--}}
{{--                                <td>{{ $request->phone_number ?? '' }}</td>--}}
                                <td>{{ $request->company ?? '' }}</td>
                                <td>{{ $request->plan->title ?? '' }}</td>
                                @if($request->status === 1)
                                    <td><span class="badge badge-success">Approved</span></td>
                                @elseif ($request->status === 2)
                                    <td><span class="badge badge-danger">Declined</span></td>
                                @else
                                    <td><span class="badge badge-warning">Pending</span></td>
                                @endif

                                <td>
                                    @can('request_show')
                                        <a class="icons" href="{{ route('admin.register.requests.show', $request->id) }}">
                                            <button type="button" class="btn btn-icon btn-light-info mr-1 mb-1">
                                                <i class="bx bxs-info-circle"></i></button>
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


{{-- vendor scripts --}}
@section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
    <script src="{{asset('js/scripts/pages/page-requests.js')}}"></script>
@endsection
