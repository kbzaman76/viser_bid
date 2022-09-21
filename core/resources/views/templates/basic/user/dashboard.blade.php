@extends($activeTemplate.'layouts.master')
@section('content')
        
        <div class="row justify-content-center g-4 mb-5">
            <div class="col-sm-6 col-xl-4 col-xxl-3">
                <a href="{{ route('user.transactions') }}" class="dashboard__item bg--body">
                    <span class="dashboard__icon">
                        <i class="las la-wallet"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__title">
                            <h4 class="title">{{ $general->cur_sym }}{{ getAmount($widget['balance']) }}</h4>
                        </div>
                        @lang('Current Balance')
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-xxl-3">
                <a href="{{ route('user.deposit.history') }}" class="dashboard__item bg--body">
                    <span class="dashboard__icon">
                        <i class="las la-coins"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__title">
                            <h4 class="title">{{ $general->cur_sym }}{{ getAmount($widget['total_deposit']) }}</h4>
                        </div>
                       @lang('Total Deposit')
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-xxl-3">
                <a href="{{ route('user.transactions') }}" class="dashboard__item bg--body">
                    <span class="dashboard__icon">
                        <i class="las la-exchange-alt"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__title">
                            <h4 class="title">{{ $widget['total_transactions'] }}</h4>
                        </div>
                       @lang('Total Transaction')
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-xxl-3">
                <a href="{{ route('ticket') }}" class="dashboard__item bg--body">
                    <span class="dashboard__icon">
                        <i class="las la-envelope"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__title">
                            <h4 class="title">{{ $widget['total_tickets'] }}</h4>
                        </div>
                        @lang('Total Tickets')
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-xxl-3">
                <a href="{{ route('user.bidding.history') }}" class="dashboard__item bg--body">
                    <span class="dashboard__icon">
                        <i class="lab la-buffer"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__title">
                            <h4 class="title">{{ $widget['total_bid'] }}</h4>
                        </div>
                        @lang('Total Bid')
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-xxl-3">
                <a href="{{ route('user.bidding.history') }}" class="dashboard__item bg--body">
                    <span class="dashboard__icon">
                        <i class="las la-money-check-alt"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__title">
                            <h4 class="title">{{ $general->cur_sym }}{{ getAmount($widget['total_bid_amount']) }}</h4>
                        </div>
                        @lang('Total Bid Amount')
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-xxl-3">
                <a href="{{ route('user.winning.history') }}" class="dashboard__item bg--body">
                    <span class="dashboard__icon">
                        <i class="las la-trophy"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__title">
                            <h4 class="title">{{ $widget['total_wining_product'] }}</h4>
                        </div>
                       @lang('Win Products')
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4 col-xxl-3">
                <a href="{{ route('user.bidding.history') }}" class="dashboard__item bg--body">
                    <span class="dashboard__icon">
                        <i class="lab la-sketch"></i>
                    </span>
                    <div class="cont">
                        <div class="dashboard__title">
                            <h4 class="title">{{ $widget['waiting_for_result'] }}</h4>
                        </div>
                        @lang('Waiting for result')
                    </div>
                </a>
            </div>
        </div>

        <div>
            <h5 class="title mb-4">@lang('Recent Transactions')</h5>
            <table class="table cmn--table">
                <thead>
                    <tr>
                        <th scope="col">@lang('S.N.')</th>
                        <th scope="col">@lang('Date')</th>
                        <th scope="col">@lang('TRX')</th>
                        <th scope="col">@lang('Details')</th>
                        <th scope="col">@lang('Amount')</th>
                        <th scope="col">@lang('Balance')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td data-label="@lang('S.N')">{{ $loop->index + 1 }}</td>
                            <td data-label="@lang('Date')">{{ showDateTime($transaction->created_at) }}</td>
                            <td data-label="@lang('TRX')">{{ $transaction->trx }}</td>
                            <td data-label="@lang('Details')">
                                <div class="details">{{ __($transaction->details) }}</div>
                            </td>
                            <td data-label="@lang('Amount')" class="{{ $transaction->trx_type == '+' ? 'text--success':'text--danger' }}">{{ $transaction->trx_type.showAmount($transaction->amount) }} {{ __($general->cur_text) }}</td>
                            <td data-label="@lang('Balance')" class="text--info">{{ showAmount($transaction->post_balance) }} {{ __($general->cur_text) }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
