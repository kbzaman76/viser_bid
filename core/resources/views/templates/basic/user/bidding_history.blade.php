@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="container-fluid">
        <div>
            <table class="table cmn--table">
                <thead>
                    <tr>
                        <th scope="col">@lang('S.N.')</th>
                        <th scope="col">@lang('Product Name')</th>
                        <th scope="col">@lang('Product Price')</th>
                        <th scope="col">@lang('Bid Amount')</th>
                        <th scope="col">@lang('Bid Time')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($biddingHistories as $bid)
                        <tr>
                            <td data-label="@lang('S.N')">{{ $biddingHistories->firstItem() + $loop->index }}</td>
                            <td data-label="@lang('Product Name')">{{ __($bid->product->name) }}</td>
                            <td data-label="@lang('Product Price')">
                                {{ $general->cur_sym }}{{ showAmount($bid->product->price) }}</td>
                            <td data-label="@lang('Bid Amount')">{{ $general->cur_sym }}{{ showAmount($bid->amount) }}
                            </td>
                            <td data-label="@lang('Bid Time')">{{ showDateTime($bid->created_at) }} <br>
                                {{ diffForHumans($bid->created_at) }}</td>
                            <td data-label="@lang('Action')">
                                <a href="{{ route('product.details', [$bid->product->id, slug($bid->product->name)]) }}" target="__blank"
                                    class="btn cmn--btn btn--sm">@lang('View')</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $biddingHistories->links() }}
        </div>
    </div>
@endsection
