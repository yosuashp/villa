@extends($activeTemplate.'layouts.auth')
@php
$login = getContent('login.content', true);
@endphp
@section('content')
<!-- account section start -->
<section class="account-section">
  <div class="left">
    <div class="top-el">
      <img src="{{ asset($activeTemplateTrue.'images/bg/ele-bg2.png') }}" alt="image">
    </div>
    <div class="bottom-el">
      <img src="{{ asset($activeTemplateTrue.'images/bg/ele-bg.png') }}" alt="image">
    </div>
    <div class="account-form-area">
      <div class="text-center">
        <a href="{{ route('home') }}" class="account-logo"><img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="image"></a>
      </div>
      <form method="POST" action="{{ route('user.login')}}" onsubmit="return submitUserForm();" class="account-form mt-5">
        @csrf
        <div class="form-group">
          <label>@lang('Username or Email')</label>
          <input type="text" name="username" value="{{ old('username') }}" placeholder="@lang('Username or Email')" class="form--control" required>
        </div>
        <div class="form-group">
          <label>@lang('Password')</label>
          <input id="password" type="password" class="form--control" placeholder="@lang('Password')" name="password" required required>
        </div>
        <div class="form-group">
            @php echo loadReCaptcha() @endphp
        </div>
        @include($activeTemplate.'partials.custom_captcha')

        <p class="text-end"><a href="{{ route('user.password.request') }}" class="text--dark">@lang('Forgot password?')</a></p>
        <div class="form-group mt-4">
          <button type="submit" id="recaptcha" class="btn btn--base w-100">@lang('Login Now')</button>
        </div>
        <div class="row gy-1">
          <div class="col-lg-6">
            <div class="form-check custom--checkbox">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                @lang(' Remember me')
              </label>
            </div>
          </div>
          <div class="col-lg-6 text-lg-end">
            <a href="{{ route('user.register') }}" class="text--base">@lang('Haven\'t an account?')</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="right bg_img" style="background-image: url('{{ getImage('assets/images/frontend/login/'.$login->data_values->background_image, '1920x2190') }}');">
    <div class="content text-center">
      <h2 class="title text-white">{{ __($login->data_values->heading) }}</h2>
      <p class="text-white mt-3">{{ __($login->data_values->sub_heading) }}</p>
    </div>
  </div>
</section>
<!-- account section end -->

@endsection

@push('script')
<script>
  "use strict";

  function submitUserForm() {
    var response = grecaptcha.getResponse();
    if (response.length == 0) {
      document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
      return false;
    }
    return true;
  }
</script>
@endpush
