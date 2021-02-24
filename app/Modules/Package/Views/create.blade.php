
@extends('layouts.admin')
@section('content')
    <section class="plans-create">

                <div class="row add-item-title">
{{--                    @if ($errors->any())--}}
{{--                        <ul>{!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}</ul>--}}
{{--                    @endif--}}

                    <div class="col-lg-12">
                        <h1 class="blue">Create Plan</h1>
                    </div>
                </div>

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="tab-content">
                    <form id="form" action="{{ route("admin.plans.store") }}" method="POST" enctype="multipart/form-data">
                        @csrf

                    <div class="details">
                            <div class="row">
                                <div class="col-12">

                                    <div class="form-group {{ $errors->has('title') ? 'error' : '' }}">
                                        <label for="title">{{ trans('cruds.plans.fields.title') }}</label>
                                        <input required type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
                                        <p class="loginError" style="color:red; display:none;">This title is already used. Please enter a unique title</p>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('title') }}
                                        </div>
                                    </div>

                                         <div class="form-group ">
                                             <label for="price">{{ trans('cruds.plans.fields.price') }}</label>
                                             <input required type="number" min="0" step=".01" id="price" name="price" class="form-control" value="{{ old('price') }}">
                                         </div>
                                         <div class="form-group error">
                                            <label for="company_number">{{ trans('cruds.plans.fields.company_number') }}</label>
                                            <input required type="number" min="0" step=".01" id="company_number" name="company_number" class="form-control" value="{{ old('company_number') }}">
                                         </div>
                                          <div class="form-group">
                                             <label for="description">{{ trans('cruds.plans.fields.description') }}</label>
                                              <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
                                          </div>
                                          <div class="form-group">
                                             <label for="is_public">{{ trans('cruds.plans.fields.is_public') }}</label>
                                             <input style="margin-left: 10px;" type="checkbox" id="is_public" name="is_public"  value="1" {{ old('is_public', 0) == 1 ? 'checked' : '' }}>
                                          </div>

                                </div>

                            <div class="col-12">
                                @include('Plans::partials.forms')
                            </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button type="submit"  class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save changes</button>
                                    <a type="reset" href="{{ route("admin.plans.index") }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>


                    </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    </section>


        <script>
                document.addEventListener("DOMContentLoaded", function (event) {

                    $("#form").submit(function(e){
                        e.preventDefault();
                        var title = $('#title').val();

                        $.ajax({
                            type: 'GET',
                            data: {
                                title: title,
                                // id: id,
                            },
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: '/admin/plans/check-title',
                            success: function (response) {
                                if(response.success == 'true'){
                                    $('.loginError').show();
                                    $("#title").focus();
                                }else{
                                    $('#form').unbind().submit();
                                }
                            }
                        });
                    });

                    $('#set_ppf').on('click', function (e) {
                        let pricePerForm = $('#price_per_form').val();

                        if (pricePerForm == '') {
                            $('.price_per_form').val(0);
                        } else {
                            $('.price_per_form').val(pricePerForm);
                        }
                        e.preventDefault();

                    });



                    $('#set_ppp').on('click', function (e) {
                        let pricePerPage = $('#price_per_page').val();
                        if (pricePerPage == '') {
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
                        $('.is_activated').prop('checked', true);

                    });

                    $('#deactivate_forms ').on('click', function (e) {
                        e.preventDefault();
                        $('.is_activated').prop('checked', false);

                    });



                });



        </script>
@endsection

