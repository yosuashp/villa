@extends($activeTemplate .'layouts.auth')
@section('content')
@php
    $twoFA = getContent('2fa_verify.content', true);
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
            <div class="text-center mt-5">
                <h6>@lang('2FA Verification')</h6>
            </div>
            <form method="POST" action="{{ route('user.go2fa.verify') }}" onsubmit="return submitUserForm();" class="account-form mt-3">
                @csrf

                <div class="form-group">
                    <p class="text-center">@lang('Current Time'): {{ \Carbon\Carbon::now() }}</p>
                </div>

                <div class="form-group">
                    <label>@lang('Verification Code')</label>
                    <input type="text" name="code" id="code" class="form--control">
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
    <div class="right bg_img"
        style="background-image: url('{{ getImage('assets/images/frontend/2fa_verify/'.$twoFA->data_values->background_image, '1920x2190') }}');">
        <div class="content text-center">
            <h2 class="title text-white">{{ __($twoFA->data_values->heading) }}</h2>
            <p class="text-white mt-3">{{ __($twoFA->data_values->sub_heading) }}</p>
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
