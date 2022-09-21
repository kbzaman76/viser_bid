@extends($activeTemplate.'layouts.master')
@section('content')
<div class="deposit-preview bg--body">
    <div class="deposit-thumb">
        <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="@lang('Image')">
    </div>
    <div class="deposit-content">
        <ul>
            <li>
                @lang('Amount'): <span class="text--success"><strong>{{showAmount($data->amount)}} </strong> {{__($general->cur_text)}}</span>
            </li>
            <li>
                @lang('Charge'): <span class="text--danger"><strong>{{showAmount($data->charge)}}</strong> {{__($general->cur_text)}}</span>
            </li>
            <li>
                @lang('Payable'): <span class="text--warning"><strong> {{showAmount($data->amount + $data->charge)}}</strong> {{__($general->cur_text)}}</span>
            </li>
            <li>
                @lang('Conversion Rate'): <span class="text--info"><strong>1 {{__($general->cur_text)}} = {{showAmount($data->rate)}}  {{__($data->baseCurrency())}}</strong>
                </p></span>
            </li>
            <li>
                @lang('In') {{$data->baseCurrency()}}: <span class="text--primary"><strong>{{showAmount($data->final_amo)}}</strong></span>
            </li>
            @if ($data->gateway->crypto==1)
                <li>
                    @lang('Conversion with')  <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')
                </li>
            @endif
        </ul>
        @if( 1000 >$data->method_code)
            <a href="{{route('user.deposit.confirm')}}" class="cmn--btn w-100">@lang('Pay Now')</a>
        @else
            <a href="{{route('user.deposit.manual.confirm')}}" class="cmn--btn w-100">@lang('Pay Now')</a>
        @endif
    </div>
</div>
@endsection


