
@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xxl-6">
                <div class="card cmn--card">
                    <div class="card-header">
                        <h5 class="title my-0 text-center"><span>@lang('Payment Preview')</span></h5>
                    </div>
                    <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                        <div class="card-body p-4">
                                @csrf
                                <h6 class="m-0">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h6>
                                <h6 class="mt-3">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h6>
                                
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn--base btn-round custom-success text-center w-100" id="btn-confirm">@lang('Pay Now')</button>
                           
                        </div>
                         
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
@endsection

