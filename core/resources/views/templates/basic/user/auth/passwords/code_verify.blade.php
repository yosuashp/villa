@extends($activeTemplate.'layouts.auth')
@section('content')
@php
    $codeVerify = getContent('code_verify.content', true);
@endphp
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
            <form method="POST" action="{{ route('user.password.verify.code') }}" class="account-form mt-3">
                @csrf

                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label>@lang('Verification Code')</label>
                    <input type="text" name="code" id="code" class="form--control" placeholder="@lang('Verification code')">
                </div>

            
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn--base w-100">@lang('Verify Code')</button>
                </div>
        

                <div class="form-group d-flex justify-content-between align-items-center">
                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                    <a href="{{ route('user.password.request') }}" class="w-25">@lang('Try again')</a>
                </div>

               
            </form>
        </div>
    </div>
    <div class="right bg_img"
        style="background-image: url('{{ getImage('assets/images/frontend/code_verify/'.$codeVerify->data_values->background_image, '1920x2190') }}');">
        <div class="content text-center">
            <h2 class="title text-white">{{ __($codeVerify->data_values->heading) }}</h2>
            <p class="text-white mt-3">{{ __($codeVerify->data_values->sub_heading) }}</p>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    (function($){
        "use strict";
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          $(this).val(function (index, value) {
             value = value.substr(0,7);
              return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
          });
      });
    })(jQuery)
</script>
@endpush