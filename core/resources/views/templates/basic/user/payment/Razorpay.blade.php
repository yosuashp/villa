@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="custom--card">
                    <div class="card-header bg--base">
                        <h5 class="text-white text-center">@lang('Payment Confirm')</h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="mb-2">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                        <h3>@lang('To book the property')</h3>
                        <form action="{{$data->url}}" method="{{$data->method}}" class="text-center">
                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >
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
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("btn mt-4 w-100 btn--base");
        })(jQuery);
    </script>
@endpush
