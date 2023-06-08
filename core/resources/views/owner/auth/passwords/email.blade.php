@extends('owner.layouts.master')
@section('content')
    <div class="page-wrapper default-version">
        <div class="form-area bg_img" data-background="{{asset('assets/laramin/images/1.jpg')}}">
            <div class="form-wrapper">
                <h4 class="logo-text mb-15"><strong>@lang('Recover Account')</strong></h4>
                <form action="{{ route('owner.password.email') }}" method="POST" class="cmn-form mt-30">
                    @csrf
                    <div class="form-group">
                        <label>@lang('Select One')</label>
                        <div>
                            <select class="form-control" name="type">
                                <option value="email">@lang('E-Mail Address')</option>
                                <option value="username">@lang('Username')</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="my_value"></label>
                        <input type="text" name="value" class="form-control" value="{{ old('value') }}">
                    </div>
                    <div class="form-group d-flex justify-content-between align-items-center">
                        <a href="{{ route('owner.login') }}" class="text-muted text--small"><i class="las la-lock"></i>@lang('Login Here')</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="submit-btn mt-25">@lang('Send Reset Code') <i class="las la-sign-in-alt"></i></button>
                    </div>
                </form>
            </div>
        </div><!-- login-area end -->
    </div>
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