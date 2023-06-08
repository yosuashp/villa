@extends($activeTemplate.'layouts.master')
@section('content')
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if(Auth::user()->ts)
                    <div class="custom--card">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mx-auto text-center">
                                <button  class="btn btn-block w-100 btn-lg btn-danger" data-bs-toggle="modal" data-bs-target="#disableModal">
                                    @lang('Disable Two Factor Authenticator')</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="custom--card">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="key" value="{{$secret}}" class="form--control form-control-lg" id="referralURL" readonly>
                                        <button type="button" class="input-group-text copytext bg--base text-white" id="copyBoard"> <i class="fa fa-copy"></i> </button>
                                </div>
                            </div>
                            <div class="form-group mx-auto text-center">
                                <img class="mx-auto" src="{{$qrCodeUrl}}">
                            </div>
                            <div class="form-group mx-auto text-center">
                                <button class="btn btn--base w-100 btn-lg mt-3 mb-1" data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-6 google_auth_url">
                <div class="custom--card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Google Authenticator')</h5>
                    </div>
                    <div class="card-body">
                        <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                        <a class="btn btn--success btn-md mt-3" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('DOWNLOAD APP')</a>
                    </div>
                </div><!-- //. single service item -->
            </div>
        </div>


@endsection

@push('modal')
      <!--Enable Modal -->
      <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify Your Otp')</h4>
                    <button type="button" class="btn btn-sm btn--danger" data-bs-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <label class="form-label">@lang('Authentication Code')</label>
                            <input type="text" class="form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--base">@lang('Verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify Your Otp Disable')</h4>
                    <button type="button" class="btn btn-sm btn--danger" data-bs-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label class="form-label">@lang('Authentication Code')</label>
                            <input type="text" class="form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--base">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('style')
    <style>
        @media (max-width: 767px) {
            .google_auth_url {
                margin-top: 15px;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


