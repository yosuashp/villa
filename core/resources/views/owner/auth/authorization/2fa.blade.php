@extends('owner.layouts.master')

@section('content')
<div class="page-wrapper default-version">
    <div class="form-area bg_img" data-background="{{asset('assets/laramin/images/1.jpg')}}">
        <div class="form-wrapper">
            <div class="text-center mt-5">
                <h6>@lang('2FA Verification')</h6>
            </div>
            <form method="POST" action="{{ route('owner.go2fa.verify') }}"
                onsubmit="return submitUserForm();" class="cmn-form mt-30 account-form">
                @csrf
                <div class="form-group">
                    <p class="text-center">@lang('Current Time'): {{ \Carbon\Carbon::now() }}</p>
                </div>

                <div class="form-group">
                    <label>@lang('Verification Code')</label>
                    <input type="text" name="code" class="form-control" placeholder="@lang('Enter verification code')" maxlength="7" id="code">
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="submit-btn mt-25">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
