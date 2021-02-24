<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ trans('panel.site_title') }}</title>
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">

    @include('panels.styles')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout 1-column navbar-sticky footer-static blank-page semi-dark-layout bg-full-screen-image" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            @yield('content')
        </div>
    </div>
</div>
<!-- END: Content-->

{{-- scripts --}}
@include('panels.scripts')

</body>
<!-- END: Body-->
</html>
