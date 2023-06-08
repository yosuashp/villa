@extends($activeTemplate.'layouts.auth')

@section('content')
@php
    $register = getContent('register.content', true);
    $policyPages = getContent('policy_pages.element');
@endphp
<!-- account section start -->
<section class="account-section">
    <div class="left sign-up">
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
            <form method="POST" action="{{ route('user.register') }}" onsubmit="return submitUserForm();" class="account-form mt-5">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="form-group">
                            <label>@lang('First Name')</label>
                            <input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="@lang('Enter firstname')" class="form--control" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="form-group">
                            <label>@lang('Last Name')</label>
                            <input type="text" name="lastname" value="{{ old('lastname') }}" placeholder="@lang('Enter lastname')" class="form--control" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="form-group">
                            <label for="country">{{ __('Country') }}</label>
                            <select name="country" id="country" class="form--control">
                                @foreach($countries as $key => $country)
                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <label for="mobile">@lang('Mobile')</label>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text mobile-code bg--base text-white"></span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" class="form--control checkUser" placeholder="@lang('Your Phone Number')">
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="form-group">
                            <label for="username">{{ __('Username') }}</label>
                            <input id="username" type="text" class="form--control checkUser" name="username" placeholder="@lang('Enter your username')" value="{{ old('username') }}" required>
                            <small class="text-danger usernameExist"></small>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="form-group">
                            <label for="email">@lang('E-Mail Address')</label>
                            <input id="email" type="email" class="form--control checkUser" placeholder="@lang('Enter your email address')" name="email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="form-group hover-input-popup">
                            <label for="password">@lang('Password')</label>
                            <input id="password" type="password" class="form--control" name="password" placeholder="@lang('Enter your password')" required>
                            @if($general->secure_password)
                                <div class="input-popup">
                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                    <p class="error number">@lang('1 number minimum')</p>
                                    <p class="error special">@lang('1 special character minimum')</p>
                                    <p class="error minimum">@lang('6 character password')</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="form-group">
                            <label for="password-confirm">@lang('Confirm Password')</label>
                            <input id="password-confirm" type="password" class="form--control" name="password_confirmation" placeholder="@lang('Enter your confirmation password')" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4 ">
                        </div>
                        <div class="col-md-6 ">
                            @php echo loadReCaptcha() @endphp
                        </div>
                    </div>
                    @include($activeTemplate.'partials.custom_captcha')

                    @if($general->agree)
                        <div class="form-group">
                            <input type="checkbox" id="agree" name="agree">
                            <label for="agree" class="ms-1">@lang('I agree with')
                                @foreach ($policyPages as $policyPage)
                                    <a href="{{ route('policy', [$policyPage, slug($policyPage->data_values->title)]) }}" target="_blank">
                                        {{ __($policyPage->data_values->title) }}@if(!$loop->last), @endif
                                    </a>
                                @endforeach
                            </label>
                        </div>
                    @endif

                    <div class="form-group mt-4">
                        <button type="submit" id="recaptcha" class="btn btn--base w-100">@lang('Register')</button>
                    </div>
                    <div class="row gy-1">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 text-lg-end">
                            <a href="{{ route('user.login') }}" class="text--base">@lang('Have an account?')</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="right sign-up bg_img"
        style="background-image: url('{{ getImage('assets/images/frontend/register/'.$register->data_values->background_image, '1920x2190') }}');">
        <div class="content text-center">
            <h2 class="title text-white">{{ __($register->data_values->heading) }}</h2>
            <p class="text-white mt-3">{{ __($register->data_values->sub_heading) }}</p>
        </div>
    </div>
</section>
<!-- account section end -->
@endsection

@push('modal')
<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
          <button type="button" class="btn btn-sm btn--danger" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h6 class="text-center">@lang('You already have an account please Sign in ')</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
          <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
        </div>
      </div>
    </div>
  </div>
@endpush

@push('style')
    <style>
        .country-code .input-group-prepend .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

        .hover-input-popup {
            position: relative;
        }

        .hover-input-popup:hover .input-popup {
            opacity: 1;
            visibility: visible;
        }

        .input-popup {
            position: absolute;
            bottom: 70%;
            left: 50%;
            width: 280px;
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            opacity: 0;
            visibility: hidden;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .input-popup::after {
            position: absolute;
            content: '';
            bottom: -19px;
            left: 50%;
            margin-left: -5px;
            border-width: 10px 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent #1a1a1a transparent;
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .input-popup p {
            padding-left: 20px;
            position: relative;
        }

        .input-popup p::before {
            position: absolute;
            content: '';
            font-family: 'Line Awesome Free';
            font-weight: 900;
            left: 0;
            top: 4px;
            line-height: 1;
            font-size: 18px;
        }

        .input-popup p.error {
            text-decoration: line-through;
        }

        .input-popup p.error::before {
            content: "\f057";
            color: #ea5455;
        }

        .input-popup p.success::before {
            content: "\f058";
            color: #28c76f;
        }

    </style>
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
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
      (function ($) {
          @if($mobile_code)
          $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
          @endif
          $('select[name=country]').change(function(){
              $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
              $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
              $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
          });
          $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
          $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
          $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
          @if($general->secure_password)
              $('input[name=password]').on('input',function(){
                  secure_password($(this));
              });
          @endif
          $('.checkUser').on('focusout',function(e){
              var url = '{{ route('user.checkUser') }}';
              var value = $(this).val();
              var token = '{{ csrf_token() }}';
              if ($(this).attr('name') == 'mobile') {
                  var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                  var data = {mobile:mobile,_token:token}
              }
              if ($(this).attr('name') == 'email') {
                  var data = {email:value,_token:token}
              }
              if ($(this).attr('name') == 'username') {
                  var data = {username:value,_token:token}
              }
              $.post(url,data,function(response) {
                if (response['data'] && response['type'] == 'email') {
                  $('#existModalCenter').modal('show');
                }else if(response['data'] != null){
                  $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
                }else{
                  $(`.${response['type']}Exist`).text('');
                }
              });
          });
      })(jQuery);
  </script>
@endpush
