@extends($activeTemplate .'layouts.auth')
@section('content')
@php
    $emailVerify = getContent('email_verify.content', true);
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
                <h6>@lang('Please Verify Your Email to Get Access')</h6>
            </div>
            <form method="POST" action="{{ route('user.verify.email') }}"
                onsubmit="return submitUserForm();" class="account-form mt-3">
                @csrf
                <div class="form-group">
                    <p class="text-center">@lang('Your Email'): <strong>{{ auth()->user()->email }}</strong></p>
                </div>

                <div class="form-group">
                    <label>@lang('Verification Code')</label>
                    <input type="text" name="email_verified_code" class="form--control" maxlength="7" id="code">
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>

                <div class="form-group">
                    <p>@lang('Please check including your Junk/Spam Folder. if not found, you can') <a
                            href="{{ route('user.send.verify.code') }}?type=email"
                            class="forget-pass"> @lang('Resend code')</a></p>
                    @if($errors->has('resend'))
                        <br />
                        <small class="text-danger">{{ $errors->first('resend') }}</small>
                    @endif
                </div>

            </form>
        </div>
    </div>
    <div class="right bg_img"
        style="background-image: url('{{ getImage('assets/images/frontend/email_verify/'.$emailVerify->data_values->background_image, '1920x2190') }}');">
        <div class="content text-center">
            <h2 class="title text-white">{{ __($emailVerify->data_values->heading) }}</h2>
            <p class="text-white mt-3">{{ __($emailVerify->data_values->sub_heading) }}</p>
        </div>
    </div>
</section>
<!-- account section end -->
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
