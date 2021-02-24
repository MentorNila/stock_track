@extends('layouts.admin')
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="row grid-title">
    <div class="col-lg-12">
            <h1>{{ trans('cruds.plans.title') }}</h1>
    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        @can('plan_create')
            <a type="button" href="{{ route("admin.plans.create") }}" class="btn btn-primary btn-icon rounded-circle glow mr-1 mb-1"><i class="bx bx-plus"></i></a>
        @endcan
    </div>
</div>


<div class="plans-list-table">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table id="plans-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('cruds.plans.fields.id') }}</th>
                                <th>{{ trans('cruds.plans.fields.title') }}</th>
                                <th>{{ trans('cruds.plans.fields.price') }}</th>
                                <th>{{ trans('cruds.plans.fields.company_number') }}</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($plans as $key => $plan)
                            <tr data-entry-id="{{ $plan->id }}">
                                <td>{{ $plan->id }}</td>
                                <td>{{ $plan->title ?? '' }}</td>
                                <td>{{ $plan->price ?? '' }}</td>
                                <td>{{ $plan->company_number ?? '' }}</td>
                                <td>
                                    @can('plan_show')
                                        <a class="icons" href="{{ route('admin.plans.show', $plan->id) }}">
                                            <button type="button" class="btn btn-icon btn-light-info mr-1 mb-1">
                                                <i class="bx bxs-info-circle"></i></button>
                                        </a>
                                    @endcan
                                    @can('plan_edit')
                                        <a class="icons" href="{{ route('admin.plans.edit', $plan->id) }}">
                                            <button type="button" class="btn btn-icon btn-light-warning mr-1 mb-1">
                                                <i class="bx bx-edit-alt"></i></button>
                                        </a>
                                    @endcan
                                    @can('plan_delete')
                                        <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $plan->name }}?');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-icon btn-light-danger mr-1 mb-1" name="submit" alt="Submit">
                                                <i class="bx bx-x"></i></button>
                                        </form>
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
    <script src="{{asset('js/scripts/pages/page-plans.js')}}"></script>
@endsection
