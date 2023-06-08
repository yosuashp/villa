@extends($activeTemplate .'layouts.auth')
@section('content')
@php
    $smsVerify = getContent('sms_verify.content', true);
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
                <a href="{{ route('home') }}" class="account-logo"><img
                        src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}"
                        alt="image"></a>
            </div>
            <div class="text-center mt-5">
                <h6>@lang('Please Verify Your Mobile to Get Access')</h6>
            </div>
            <form method="POST" action="{{ route('user.verify.sms') }}"
                onsubmit="return submitUserForm();" class="account-form mt-3">
                @csrf
                <div class="form-group">
                    <p class="text-center">@lang('Your Mobile Number'): <strong>{{ auth()->user()->mobile }}</strong>
                    </p>
                </div>

                <div class="form-group">
                    <label>@lang('Verification Code')</label>
                    <input type="text" name="sms_verified_code" id="code" class="form--control">
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>
                <div class="form-group">
                    <p>@lang('If you don\'t get any code'), <a
                            href="{{ route('user.send.verify.code') }}?type=phone"
                            class="forget-pass"> @lang('Try again')</a></p>
                    @if($errors->has('resend'))
                        <br />
                        <small class="text-danger">{{ $errors->first('resend') }}</small>
                    @endif
                </div>

            </form>
        </div>
    </div>
    <div class="right bg_img"
        style="background-image: url('{{ getImage('assets/images/frontend/sms_verify/'.$smsVerify->data_values->background_image, '1920x2190') }}');">
        <div class="content text-center">
            <h2 class="title text-white">{{ __($smsVerify->data_values->heading) }}</h2>
            <p class="text-white mt-3">{{ __($smsVerify->data_values->sub_heading) }}</p>
        </div>
    </div>
</section>
@endsection
@push('script')
    <script>
        (function ($) {
            "use strict";
            $('#code').on('input change', function () {
                var xx = document.getElementById('code').value;
                $(this).val(function (index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });
            });
        })(jQuery)

    </script>
@endpush
