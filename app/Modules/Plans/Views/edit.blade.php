
@extends('layouts.admin')
@section('content')
    <section class="plans-edit">

        <div class="row add-item-title">
            @if ($errors->any())
                <ul>{!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}</ul>
            @endif

            <div class="col-lg-12">
                <h1 class="blue">Edit Plan</h1>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" aria-controls="details" role="tab"
                               aria-selected="true">
{{--                                <i class="bx bx-user align-middle"></i>--}}
                                <span class="align-middle">Details</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" aria-controls="form" role="tab"
                               aria-selected="false">
{{--                                <i class="bx bx-info-circle align-middle"></i>--}}
                                <span class="align-middle">Forms</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="details" aria-labelledby="details-tab" role="tabpanel">
                            <form action="{{ route("admin.plans.update", [$plan->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">

                                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                            <label for="name">{{ trans('cruds.plans.fields.title') }}*</label>
                                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($plan) ? $plan->title : '') }}" required>
                                            @if($errors->has('title'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('title') }}
                                                </em>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                            <label for="name">{{ trans('cruds.plans.fields.price') }}*</label>
                                           <input required type="number" min="0" step=".01" id="price" name="price" class="form-control" value="{{ old('price', isset($plan) ? $plan->price : '') }}">
                                            @if($errors->has('price'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('price') }}
                                                </em>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('company_number') ? 'has-error' : '' }}">
                                            <label for="name">{{ trans('cruds.plans.fields.company_number') }}*</label>
                                        <input required type="number" min="0" step=".01" id="company_number" name="company_number" class="form-control" value="{{ old('company_number', isset($plan) ? $plan->company_number : '') }}">
                                            @if($errors->has('company_number'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('company_number') }}
                                                </em>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                            <label for="name">{{ trans('cruds.plans.fields.description') }}*</label>
                                           <textarea class="form-control" id="description" name="description" required>{{ old('description', isset($plan) ? $plan->description : '') }}</textarea>
                                            @if($errors->has('description'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('description') }}
                                                </em>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('is_public') ? 'has-error' : '' }}">
                                            <label for="name">{{ trans('cruds.plans.fields.is_public') }}*</label>
                                            <input type="checkbox" style="margin-left: 10px;"  id="is_public" name="is_public"   value="1" {{ (isset($plan) && $plan->is_public) || old('is_public', 0) === 1 ? 'checked' : '' }}>
                                            @if($errors->has('is_public'))
                                                <em class="invalid-feedback">
                                                    {{ $errors->first('is_public') }}
                                                </em>
                                            @endif
                                        </div>


                                    </div>
                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save changes</button>
                                        <a type="reset" href="{{ route("admin.plans.index") }}" class="btn btn-light">Cancel</a>
                                    </div>
                                </div>

                            </form>
                        </div>


                        <div class="tab-pane" id="form" aria-labelledby="form-tab" role="tabpanel">
                            <form action="{{ route("admin.plans.update-forms", [$plan->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        @include('Plans::partials.forms')
                                    </div>
                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                        <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save changes</button>
                                        <a type="reset" href="{{ route("admin.plans.index") }}" class="btn btn-light">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {


        $('#set_ppf').on('click', function (e) {
            let pricePerForm = $('#price_per_form').val();
            if(pricePerForm == ''){
                $('.price_per_form').val(0);
            } else {
                $('.price_per_form').val(pricePerForm);
            }
            e.preventDefault();
        });
        $('#set_ppp').on('click', function (e) {
            let pricePerPage = $('#price_per_page').val();
            if(pricePerPage == ''){
                $('.price_per_page').val(0);
            } else {
                $('.price_per_page').val(pricePerPage);
            }
            e.preventDefault();
        });


        $('#default_price_per_form').on('click', function (e) {
            let pricePerForm = 10;

            e.preventDefault();
            $('.price_per_form').val(pricePerForm);
        });

        $('#default_price_per_page').on('click', function (e) {
            let pricePerPage = 1;

            e.preventDefault();
            $('.price_per_page').val(pricePerPage);
        });
        $('#activate_forms').on('click', function (e) {
            e.preventDefault();
            $('.is_activated').prop('checked',true);

        });
        $('#deactivate_forms').on('click', function (e) {
            e.preventDefault();
            $('.is_activated').prop('checked', false);

        });
        });
    </script>
@endsection

@section('scripts')

@endsection
