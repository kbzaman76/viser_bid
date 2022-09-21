@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container-fluid">
        <div>
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
                    @forelse ($transactions as $transaction)     
                        <tr>
                            <td data-label="@lang('S.N')">{{ $loop->index + $transactions->firstItem() }}</td>
                            <td data-label="@lang('Date')">{{ showDateTime($transaction->created_at) }}</td>
                            <td data-label="@lang('TRX')">{{ $transaction->trx }}</td>
                            <td data-label="@lang('Details')"> 
                                <div class="details">{{ __($transaction->details) }}</div>
                            </td>
                            <td data-label="@lang('Amount')" class="{{ $transaction->trx_type == '+' ? 'text--success':'text--danger' }}">{{ $transaction->trx_type.showAmount($transaction->amount) }} {{ __($general->cur_text) }}</td>
                            <td data-label="@lang('Balance')" class="text--info">{{ showAmount($transaction->post_balance) }} {{ __($general->cur_text) }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>
@endsection