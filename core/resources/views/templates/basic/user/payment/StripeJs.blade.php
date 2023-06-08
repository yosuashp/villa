@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-lg-6">
                <div class="custom--card">
                    <div class="card-header bg--base">
                        <h5 class="text-white text-center">@lang('Payment Confirm')</h5>
                    </div>
                    <div class="card-body text-center">
                        <form action="{{$data->url}}" method="{{$data->method}}" class="text-center">
                            <h3 class="text-center mb-2">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                            <h3>@lang('To book the property')</h3>
                            <script src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("btn btn--base w-100 mt-4");
        })(jQuery);
    </script>
@endpush
