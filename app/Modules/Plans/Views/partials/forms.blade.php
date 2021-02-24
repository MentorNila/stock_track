
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="price_per_form">Price per form</label>
            <input type="number" min="0" step=".01" id="price_per_form" name="price_per_form" placeholder="Price" value="{{ old('price_per_form') }}"  class="form-control input-md">
        </div>
        <div class="form-group">
            <button id="set_ppf" class="btn btn-primary">Set price per form</button>
            <button id="default_price_per_form" class="btn btn-primary">Set default</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="price_per_page">Price per page</label>
            <input type="number" min="0" step=".01" id="price_per_page" name="price_per_page"   value="{{ old('price_per_page') }}"   placeholder="Price" class="form-control input-md">
        </div>
        <div class="form-group">
            <button id="set_ppp" class="btn btn-primary">Set price per page</button>
            <button id="default_price_per_page" class="btn btn-primary">Set default</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button id="activate_forms" class="btn btn-primary">Activate all forms</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button id="deactivate_forms" class="btn btn-primary">Deactivate all forms</button>
        </div>
    </div>
</div>





{{--@foreach($forms as $form)--}}
{{--<div id="accordion">--}}
{{--    <div class="card">--}}
{{--        <div style="cursor: pointer;"  class="card-header" id="heading-{{$form['id']}}" data-toggle="collapse" data-target="#collapse-{{$form['id']}}" aria-expanded="false" aria-controls="collapse-{{$form['id']}}">--}}
{{--            <h5 class="mb-0">--}}
{{--                <label class="btn-link collapsed">--}}
{{--                    {{$form['name']}}--}}
{{--                </label>--}}
{{--            </h5>--}}
{{--        </div>--}}

{{--        <div id="collapse-{{$form['id']}}" class="collapse" aria-labelledby="heading-{{$form['id']}}" data-parent="#accordion">--}}
{{--            <div class="card-body">--}}
{{--                <div class="form-row">--}}
{{--                    <div class="form-group col-md-6">--}}
{{--                        <label class="control-label" for="form_name_{{$form['id']}}">SEC Form Name</label>--}}
{{--                        <input id="form_name_{{$form['id']}}" name="forms[{{$form['id']}}][form_name]" type="text" placeholder="Name" class="form-control input-md" required="" value="{{$form['name']}}">--}}
{{--                    </div>--}}

{{--                    <div class="form-group col-md-6">--}}
{{--                        <label class="control-label" for="price_per_page_{{$form['id']}}">Price per page</label>--}}
{{--                        <input id="price_per_page_{{$form['id']}}" @if(isset($planForms)) @foreach($planForms as $planForm) @if($planForm['id'] == $form['id']) value="{{ $planForm['price_per_page'] }}" @endif @endforeach @else value="1" @endif name="forms[{{$form['id']}}][price_per_page]" type="text" placeholder="Price per page"  class="form-control input-md price_per_page">--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-row">--}}
{{--                    <div class="form-group col-md-6">--}}
{{--                        <label class="control-label" for="price_per_form_{{$form['id']}}">Price per form</label>--}}
{{--                        <input id="price_per_form_{{$form['id']}}" @if(isset($planForms)) @foreach($planForms as $planForm) @if($planForm['id'] == $form['id'])  value="{{ $planForm['price_per_form'] }}" @endif @endforeach @else value="10" @endif name="forms[{{$form['id']}}][price_per_form]" type="text" placeholder="Price per form" class="form-control input-md price_per_form">--}}
{{--                    </div>--}}

{{--                    <div class="form-group col-md-6">--}}
{{--                        <label class="col-md-4 control-label" for="is_activated_{{$form['id']}}">Is Activated</label>--}}
{{--                            <label class="checkbox-inline" for="is_activated-0">--}}
{{--                                <input class="is_activated" type="checkbox" name="forms[{{$form['id']}}][is_activated]" id="is_activated_{{$form['id']}}" value="1" @if(isset($planForms)) @foreach($planForms as $planForm) @if($planForm['id'] == $form['id'] && $planForm['is_active'] == 1) checked @endif @endforeach @endif>--}}
{{--                            </label>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endforeach--}}



<section id="accordionWrapa">
    <div class="row">
@foreach($forms as $form)

    <div class="col-sm-4">

    <div class="accordion" id="accordionWrapa1">
        <div class="card collapse-header">
            <div id="heading1-{{$form['id']}}" class="card-header" role="tablist"  data-toggle="collapse" data-target="#accordion1-{{$form['id']}}" aria-expanded="false" aria-controls="accordion1-{{$form['id']}}">
                <span class="collapse-title">
                     {{$form['name']}}
                </span>
            </div>


            <div id="accordion1-{{$form['id']}}"  role="tabpanel" class="collapse" aria-labelledby="heading1-{{$form['id']}}" data-parent="#accordionWrapa1" aria-expanded="false">
                <div class="card-content">
                    <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="price_per_page_{{$form['id']}}">Price per page</label>
                            <input id="price_per_page_{{$form['id']}}" @if(isset($planForms)) @foreach($planForms as $planForm) @if($planForm['id'] == $form['id'])  value="{{ $planForm['price_per_page'] }}" @endif @endforeach @else value="1" @endif name="forms[{{$form['id']}}][price_per_page]" type="text" placeholder="Price per page"  class="form-control input-md price_per_page">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="price_per_form_{{$form['id']}}">Price per form</label>
                            <input id="price_per_form_{{$form['id']}}" @if(isset($planForms)) @foreach($planForms as $planForm) @if($planForm['id'] == $form['id'])  value="{{ $planForm['price_per_form'] }}" @endif @endforeach @else value="10" @endif name="forms[{{$form['id']}}][price_per_form]" type="text" placeholder="Price per form" class="form-control input-md price_per_form">
                        </div>
                    </div>

                        <div class="form-group col-md-12">
                            <label class="col-md-4 control-label" for="is_activated_{{$form['id']}}">Is Activated</label>
                            <label class="checkbox-inline" for="is_activated-0">
                                <input class="is_activated" type="checkbox" name="forms[{{$form['id']}}][is_activated]" id="is_activated_{{$form['id']}}" value="1" @if(isset($planForms)) @foreach($planForms as $planForm) @if($planForm['id'] == $form['id'] && $planForm['is_active'] == 1) checked @endif @endforeach @endif>
                            </label>
                        </div>


{{--                        <div class="custom-control custom-checkbox">--}}
{{--                            <input type="checkbox" class="custom-control-input" checked name="customCheck" id="customCheck1">--}}
{{--                            <label class="custom-control-label" for="customCheck1">Active</label>--}}
{{--                        </div>--}}

            </div>
            </div>
            </div>

        </div>
    </div>
    </div>
@endforeach
    </div>
</section>
