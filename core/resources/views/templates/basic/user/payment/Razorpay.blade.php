@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card cmn--card">
                    <div class="card-header">
                        <h5 class="title my-0 text-center"><span>@lang('Payment Preview')</span></h5>
                    </div>
                    <div class="card-body text-center p-4">
                        <h6 class="mt-0">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h6>
                        <h6 class="mt-3">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h6>
                    </div>
                    <div class="card-footer">
                        <form action="{{$data->url}}" method="{{$data->method}}">
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
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("btn btn--base btn-custom2 w-100");
        })(jQuery);
    </script>
@endpush
