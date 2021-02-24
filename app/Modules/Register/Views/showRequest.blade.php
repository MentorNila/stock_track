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
                            {{ trans('cruds.request.fields.id') }}
                        </th>
                        <td>
                            {{ $clientRequest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.first_name') }}
                        </th>
                        <td>
                            {{ $clientRequest->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.last_name') }}
                        </th>
                        <td>
                            {{ $clientRequest->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.email') }}
                        </th>
                        <td>
                            {{ $clientRequest->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $clientRequest->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.company') }}
                        </th>
                        <td>
                            {{ $clientRequest->company }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.job_title') }}
                        </th>
                        <td>
                            {{ $clientRequest->job_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.country') }}
                        </th>
                        <td>
                            {{ $clientRequest->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.method_of_contact') }}
                        </th>
                        <td>
                            {{ $clientRequest->method_of_contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.plan') }}
                        </th>
                        <td>
                            {{ $clientRequest->plan['title'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request.fields.request') }}
                        </th>
                        <td>
                            {{ $clientRequest->request }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ route('admin.register.requests.decline',$clientRequest->id ) }}">
                    {{ trans('global.decline_request') }}
                </a>
                @if($clientRequest->status !== 1)
                    @can('client_create')
                        <a style="margin-top:20px;" class="btn btn-default" href="{{ route('admin.clients.register', $clientRequest->id) }}">
                            {{ trans('cruds.request.fields.new_client') }}
                        </a>
                    @endcan
                @endif
            </div>
        </div>
    </div>
@endsection
