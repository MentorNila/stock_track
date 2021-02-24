@extends('layouts.app')
{{-- title --}}
@section('title','Login Page')
{{-- page scripts --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
    <!-- login page start -->
    <section id="auth-login" class="row flexbox-container">
        <div class="col-xl-8 col-11">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- left section-login -->
                    <div class="col-md-3" style="background-color: white;">
                    </div>
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="text-center mb-2">Welcome Back</h4>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {{-- form  --}}
                                    <form method="POST" action="user/login">
                                        @csrf
                                        <div class="form-group mb-50">
                                            <label class="text-bold-600" for="email">Email address</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="Email">
                                        </div>

                                        <div class="form-group">
                                            <label class="text-bold-600" for="password">Password</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password" placeholder="Password">
                                            <p class="loginError" style="color:red; display:none;">Please type your password.</p>
                                        </div>

                                        @if ($message = Session::get('message'))
                                            <div class="alert alert-danger alert-block">
                                                <button type="submit" data-dismiss="alert"></button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif

                                        <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                            <div class="text-left">
                                                <div class="checkbox checkbox-sm">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        <small>Keep me logged in</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <a href="{{ route('password.request') }}" class="card-link"><small>Forgot Password?</small></a>
                                            </div>
                                        </div>
                                        <button type="submit"   onclick="return handleChange()" class="btn btn-primary glow w-100 position-relative">Login
                                            <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" style="background-color: white;">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login page ends -->

    <script type="text/javascript">
        function handleChange(input) {
            var x = document.getElementById("password").value;
            if (x === "") {
                $('.loginError').show();
                return false;
            }
            return true;
        }
    </script>



{{--    <script>--}}
{{--        $(document).ready(function(e) {--}}
{{--            document.getElementById("button").onclick = function fun() {--}}
{{--                var password = document.getElementById("password").value;--}}
{{--                if (password === '') {--}}
{{--                    alert("Type Password");--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}





{{--    <script>--}}
{{--    $(document).ready(function(){--}}
{{--    var form = $("#form");--}}
{{--    var password = $("#password");--}}

{{--    //On Submitting--}}
{{--    form.submit(function(){--}}
{{--    if(password.val().length==0)--}}
{{--    {--}}
{{--    alert('Please enter the password');--}}
{{--    return false;--}}
{{--    }--}}
{{--        return true;--}}
{{--    });--}}
{{--    });--}}
{{--    </script>--}}





    {{--<div class="row justify-content-center">--}}
{{--    <div class="col-md-4" style="color:#fff;">--}}
{{--        @if(\Session::has('message'))--}}
{{--            <p class="alert alert-info">--}}
{{--                {{ \Session::get('message') }}--}}
{{--            </p>--}}
{{--        @endif--}}
{{--        <form id="login" method="POST" action="user/login">--}}
{{--            {{ csrf_field() }}--}}
{{--            <h1>--}}
{{--                <div class="login-logo center">--}}
{{--                    <img src="{{ asset('images/edgarizer.svg ')}}">--}}
{{--                </div>--}}
{{--            </h1>--}}
{{--            <p class="center">Please log in to continue</p>--}}
{{--            <div class="input-group mb-3">--}}
{{--                <input name="email" type="text" class="form-control" placeholder="{{ trans('global.login_email') }}">--}}
{{--            </div>--}}
{{--            <div class="input-group mb-4">--}}
{{--                <input name="password" type="password" class="form-control" placeholder="{{ trans('global.login_password') }}">--}}
{{--            </div>--}}
{{--            <p>--}}
{{--                <a class="btn btn-link px-0" style="color:#fff;" href="{{ route('password.request') }}">--}}
{{--                    {{ trans('global.forgot_password') }}--}}
{{--                </a>--}}
{{--            </p>--}}
{{--            <input type="submit" class="btn btn-primary" value='LOG IN'>--}}
{{--            <p class="center">--}}
{{--                <input name="remember" type="checkbox" checked/> {{ trans('global.remember_me') }}--}}
{{--            </p>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection






