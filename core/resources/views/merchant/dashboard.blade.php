@extends('merchant.layouts.app')

@section('panel')
<div class="row mb-none-30">
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
            <div class="icon">
                <i class="fa fa-wallet"></i>
            </div>
            <div class="details">
                <div class="numbers">
                    <span class="currency-sign">{{__($general->cur_sym)}}</span>
                    <span class="amount">{{showAmount($widget['balance'])}}</span>
                </div>
                <div class="desciption">
                    <span class="text--small">@lang('Available Balance')</span>
                </div>
                <a href="{{ route('merchant.withdraw') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Withdraw Money')</a>
            </div>
        </div>
    </div><!-- dashboard-w1 end -->
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--cyan b-radius--10 box-shadow">
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="numbers">
                    <span class="amount">{{ $widget['total_products'] }}</span>
                </div>
                <div class="desciption">
                    <span class="text--small">@lang('Total Products')</span>
                </div>
                <a href="{{ route('merchant.product.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--teal b-radius--10 box-shadow">
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="numbers">
                    <span class="amount">{{ $widget['total_bids'] }}</span>
                </div>
                <div class="desciption">
                    <span class="text--small">@lang('Total Bids')</span>
                </div>
                <a href="{{ route('merchant.bids') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--green b-radius--10 box-shadow">
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="numbers">
                    <span class="currency-sign">{{__($general->cur_sym)}}</span>
                    <span class="amount">{{showAmount($widget['total_bid_amounts'])}}</span>
                </div>
                <div class="desciption">
                    <span class="text--small">@lang('Total Bids Amount')</span>
                </div>
                <a href="{{ route('merchant.product.index') }}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View Producsts')</a>
            </div>
        </div>
    </div>
</div>


<div class="card b-radius--10 mt-4">
    <div class="card-header">
        <h5 class="d-inline">@lang('Transaction List')</h5>
        <a href="{{ route('merchant.transactions') }}" class="btn btn-sm btn--primary box--shadow1 text--small float-right">@lang('View All')</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive--md  table-responsive">
            <table class="table table--light style--two">
                <thead>
                <tr>
                    <th>@lang('S.N.')</th>
                    <th>@lang('Date')</th>
                    <th>@lang('Trx')</th>
                    <th>@lang('Details')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Balance')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td data-label="@lang('S.N.')">{{ $loop->index + 1 }}</td>
                    <td data-label="@lang('Date')">{{ showDateTime($transaction->created_at) }}</td>
                    <td data-label="@lang('Trx')">{{ __($transaction->trx) }}</td>
                    <td data-label="@lang('Details')">{{ __($transaction->details) }}</td>
                    <td data-label="@lang('Amount')">
                        <span class="font-weight-bold @if($transaction->trx_type == '+')text-success @else text-danger @endif">
                            {{ $transaction->trx_type }} {{showAmount($transaction->amount)}} {{ $general->cur_text }}
                        </span>
                    </td>
                    <td data-label="@lang('Balance')">{{ $general->cur_sym }}{{ showAmount($transaction->post_balance) }}</td>
                </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse

                </tbody>
            </table><!-- table end -->
        </div>
    </div>
</div>
 
@endsection
