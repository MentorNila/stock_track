@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.filingData.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("filing-datas.update", [$filingData->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('cruds.filingData.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($filingData) ? $filingData->code : '') }}" required>
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.filingData.fields.code_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.filingData.fields.name') }}</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($filingData) ? $filingData->name : '') }}">
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.filingData.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
                <label for="value">{{ trans('cruds.filingData.fields.value') }}</label>
                <input type="text" id="value" name="value" class="form-control" value="{{ old('value', isset($filingData) ? $filingData->value : '') }}">
                @if($errors->has('value'))
                    <em class="invalid-feedback">
                        {{ $errors->first('value') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.filingData.fields.value_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('source') ? 'has-error' : '' }}">
                <label for="source">{{ trans('cruds.filingData.fields.source') }}</label>
                <input type="text" id="source" name="source" class="form-control" value="{{ old('source', isset($filingData) ? $filingData->source : '') }}">
                @if($errors->has('source'))
                    <em class="invalid-feedback">
                        {{ $errors->first('source') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.filingData.fields.source_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
