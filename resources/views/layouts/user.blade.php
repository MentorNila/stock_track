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

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
<style>
    .header-navbar.fixed-top {
        left: 0;
    }
    .content {
        margin-left: 0px !important;
    }
</style>
<!-- BEGIN: Header-->
@include('panels.user-navbar')
<!-- END: Header-->

{{--@include('partials.menu')--}}

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

{{-- scripts --}}
@include('panels.scripts')

</body>
<!-- END: Body-->

</html>
<script>
    window.user = @json(
        [
            'user' => auth()->user()->load('notifications')
        ]
    );
</script>
