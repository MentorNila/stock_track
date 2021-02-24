@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.filingData.title') }}
    </div>

    <div class="card-body">
        <div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.filingData.fields.id') }}
                        </th>
                        <td>
                            {{ $filingData->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.filingData.fields.code') }}
                        </th>
                        <td>
                            {{ $filingData->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.filingData.fields.name') }}
                        </th>
                        <td>
                            {{ $filingData->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.filingData.fields.value') }}
                        </th>
                        <td>
                            {{ $filingData->value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.filingData.fields.source') }}
                        </th>
                        <td>
                            {{ $filingData->source }}
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