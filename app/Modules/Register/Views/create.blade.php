<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">

    {{-- Include core + vendor Styles --}}
    @include('panels.styles')

    <title>{{ trans('panel.site_title') }}</title>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout" style="background-color: #1d2026;">

<div class="app-content" style="margin: 0 25% 0 25%;">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-header" style="font-size: 2rem;text-align: center">
                    Request a Quote
                </div>

                <div class="card-body">
                    <form action="{{ route("client.postRequest") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row add-client">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input required type="text" id="first_name" name="first_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input required type="text" id="last_name" name="last_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Work Email</label>
                                    <input required type="email" id="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input required type="number" id="phone_number" name="phone_number" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <input required type="text" id="company" name="company" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="job_title">Job Title</label>
                                    <input required type="text" id="job_title" name="job_title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select class="form-control" name="country" required>
                                        <option value="" disabled selected>Select a country</option>
                                        <option value="Alabama">Alabama</option>
                                        <option value="Alaska">Alaska</option>
                                        <option value="Arizona">Arizona</option>
                                        <option value="Arkansas">Arkansas</option>
                                        <option value="California">California</option>
                                        <option value="Colorado">Colorado</option>
                                        <option value="Connecticut">Connecticut</option>
                                        <option value="Delaware">Delaware</option>
                                        <option value="District Of Columbia">District Of Columbia</option>
                                        <option value="Florida">Florida</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Hawaii">Hawaii</option>
                                        <option value="Idaho">Idaho</option>
                                        <option value="Illinois">Illinois</option>
                                        <option value="Indiana">Indiana</option>
                                        <option value="Iowa">Iowa</option>
                                        <option value="Kansas">Kansas</option>
                                        <option value="Kentucky">Kentucky</option>
                                        <option value="Louisiana">Louisiana</option>
                                        <option value="Maine">Maine</option>
                                        <option value="Maryland">Maryland</option>
                                        <option value="Massachusetts">Massachusetts</option>
                                        <option value="Michigan">Michigan</option>
                                        <option value="Minnesota">Minnesota</option>
                                        <option value="Mississippi">Mississippi</option>
                                        <option value="Missouri">Missouri</option>
                                        <option value="Montana">Montana</option>
                                        <option value="Nebraska">Nebraska</option>
                                        <option value="Nevada">Nevada</option>
                                        <option value="New Hampshire">New Hampshire</option>
                                        <option value="New Jersey">New Jersey</option>
                                        <option value="New Mexico">New Mexico</option>
                                        <option value="New York">New York</option>
                                        <option value="North Carolina">North Carolina</option>
                                        <option value="North Dakota">North Dakota</option>
                                        <option value="Ohio">Ohio</option>
                                        <option value="Oklahoma">Oklahoma</option>
                                        <option value="Oregon">Oregon</option>
                                        <option value="Pennsylvania">Pennsylvania</option>
                                        <option value="Rhode Island">Rhode Island</option>
                                        <option value="South Carolina">South Carolina</option>
                                        <option value="South Dakota">South Dakota</option>
                                        <option value="Tennessee">Tennessee</option>
                                        <option value="Texas">Texas</option>
                                        <option value="Utah">Utah</option>
                                        <option value="Vermont">Vermont</option>
                                        <option value="VA">Virginia</option>
                                        <option value="Virginia">Washington</option>
                                        <option value="West Virginia">West Virginia</option>
                                        <option value="Wisconsin">Wisconsin</option>
                                        <option value="Wyoming">Wyoming</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="job_title">Preferred method of contact</label><br>
                                    <div class="form-check form-check-inline">
                                        <input name="method_of_contact" class="form-check-input" type="radio" id="inlineCheckbox1" value="Email" required>
                                        <label class="form-check-label" for="inlineCheckbox1">Email</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="method_of_contact" class="form-check-input" type="radio" id="inlineCheckbox2" value="Phone Number">
                                        <label class="form-check-label" for="inlineCheckbox2">Phone Number</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="request">Plan</label>
                                    <select class="form-control" name="plan_id" required>
                                        <option value="" disabled selected>Select a plan</option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="request">What's on your mind ?</label>
                                    <textarea name="request" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Send</button>
                                <a type="reset" href="/" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- scripts --}}
@include('panels.scripts')
</body>
<!-- END: Body-->

</html>
