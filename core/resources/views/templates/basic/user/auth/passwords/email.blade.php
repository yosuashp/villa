@extends($activeTemplate.'layouts.auth')

@section('content')
@php
    $email = getContent('reset_password_email.content', true);
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
                <h6>@lang('Reset Password')</h6>
            </div>
            <form method="POST" action="{{ route('user.password.email') }}" class="account-form mt-3">
                @csrf
                        <div class="form-group">
                            <label>@lang('Select One')</label>
                            <div>
                                <select class="form--control" name="type">
                                    <option value="email">@lang('E-Mail Address')</option>
                                    <option value="username">@lang('Username')</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="my_value"></label>
                            <div>
                                <input type="text" class="form--control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required autofocus="off">
                                @error('value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn--base w-100">@lang('Send Password Code')</button>
                </div>
            </form>
        </div>
    </div>
    <div class="right bg_img"
        style="background-image: url('{{ getImage('assets/images/frontend/reset_password_email/'.$email->data_values->background_image, '1920x2190') }}');">
        <div class="content text-center">
            <h2 class="title text-white">{{ __($email->data_values->heading) }}</h2>
            <p class="text-white mt-3">{{ __($email->data_values->sub_heading) }}</p>
        </div>
    </div>
</section>

@endsection
@push('script')
<script>

    (function($){
        "use strict";
        
        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush