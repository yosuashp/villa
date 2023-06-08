@extends('owner.layouts.master')
@section('content')
    <div class="page-wrapper default-version">
        <div class="form-area bg_img" data-background="{{asset('assets/laramin/images/1.jpg')}}">
            <div class="form-wrapper">
                <h4 class="logo-text mb-15">@lang('Welcome to') <strong>{{__($general->sitename)}}</strong></h4>
                <p>{{__($pageTitle)}} @lang('to')  {{__($general->sitename)}} @lang('dashboard')</p>
                <form action="{{ route('owner.login') }}" method="POST" class="cmn-form mt-30">
                    @csrf
                    <div class="form-group">
                        <label for="email">@lang('Username')</label>
                        <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}" placeholder="@lang('Enter your username')">
                    </div>
                    <div class="form-group">
                        <label for="pass">@lang('Password')</label>
                        <input type="password" name="password" class="form-control" id="pass" placeholder="@lang('Enter your password')">
                    </div>
                    <div class="form-group">
                        @php echo loadReCaptcha() @endphp
                    </div>
                    @include('owner.partials.custom_captcha')
                    <div class="form-group d-flex justify-content-between align-items-center">
                        <a href="{{ route('owner.password.request') }}" class="text-muted text--small"><i class="las la-lock"></i>@lang('Forgot password?')</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="submit-btn mt-25">@lang('Login') <i class="las la-sign-in-alt"></i></button>
                    </div>
                </form>
                <div class="text-center">
                   <span class="text-dark"> @lang('Don\'t have an account?') </span> <a href="{{ route('owner.register') }}">@lang('Register now.')</a>
                </div>
            </div>
        </div><!-- login-area end -->
    </div>
@endsection

