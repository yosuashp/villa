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
                    <div class="card-body">
                        <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                            @csrf
                            <h3 class="mb-2">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                            <h3>@lang('To book the property')</h3>
                            <button type="button" class="mt-4 btn-success btn-round text-center btn-lg btn--base w-100" id="btn-confirm">@lang('Pay Now')</button>
                            <script
                                src="//js.paystack.co/v1/inline.js"
                                data-key="{{ $data->key }}"
                                data-email="{{ $data->email }}"
                                data-amount="{{$data->amount}}"
                                data-currency="{{$data->currency}}"
                                data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm"
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
