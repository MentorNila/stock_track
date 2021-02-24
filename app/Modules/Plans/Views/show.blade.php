@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.user.title') }}
        </div>

        <div class="card-body">
            <div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plans.fields.id') }}
                        </th>
                        <td>
                            {{ $plan->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plans.fields.title') }}
                        </th>
                        <td>
                            {{ $plan->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plans.fields.price') }}
                        </th>
                        <td>
                            {{ $plan->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plans.fields.company_number') }}
                        </th>
                        <td>
                            {{ $plan->company_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plans.fields.description') }}
                        </th>
                        <td>
                            {{ $plan->description }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
@endsection
