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
    <link rel="stylesheet" href="{{asset('css/Aimara.css')}}">

    {{-- Include core + vendor Styles --}}
    @include('panels.styles')
    <style>
        .main-menu .main-menu-content {
            display: none;
        }
        .main-menu.expanded .main-menu-content{
            display: block;
        }
        .main-menu {
            z-index: 99999;
        }
    </style>

    <title>{{ trans('panel.site_title') }}</title>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-sticky footer-static pace-done menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
<!-- BEGIN: Header-->
@include('panels.user-navbar')
<!-- END: Header-->

@if($formType === '10Q')
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('home.user')}}">
                        {{--                    <div class="brand-logo"><img class="logo" src="{{asset('images/logo/logo.png')}}" /></div>--}}
                        <h2 class="brand-text mb-0">iEdgar</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none f ont-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div id="taxonomy-tree" class="main-menu-content">
            @include('partials.taxonomy')
        </div>
    </div>
@else
    @include('partials.editor')
@endif

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
<script src="{{ asset('js/scripts/main.js') }}"></script>
<script>
    window.user = @json(
        [
            'user' => auth()->user()->load('notifications')
        ]
    );
</script>
</body>
<!-- END: Body-->

</html>
