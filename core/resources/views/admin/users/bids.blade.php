@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th scope="col">@lang('S.N.')</th>
                                <th scope="col">@lang('Product Name')</th>
                                <th scope="col">@lang('Product Price')</th>
                                <th scope="col">@lang('Bid Amount')</th>
                                <th scope="col">@lang('Bid Time')</th>
                                <th scope="col">@lang('View Product')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bids as $bid)
                            <tr>
                                <td data-label="@lang('S.N')">{{ $bids->firstItem() + $loop->index }}</td>
                                <td data-label="@lang('Product Name')">{{ __($bid->product->name) }}</td>
                                <td data-label="@lang('Product Price')">{{ $general->cur_sym }}{{ showAmount($bid->product->price) }}</td>
                                <td data-label="@lang('Bid Amount')">{{ $general->cur_sym }}{{ showAmount($bid->amount) }}</td>
                                <td data-label="@lang('Bid Time')">{{ showDateTime($bid->created_at) }} <br> {{ diffForHumans($bid->created_at) }}</td>
                                <td data-label="@lang('View Product')">
                                    <a href="{{ route('product.details', [$bid->product->id, slug($bid->product->name)]) }}" target="__blank" class="icon-btn">
                                        <i class="las la-eye text--shadow"></i>
                                    </a>
                                </td>
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
        @if ($bids->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($bids) }}
            </div>
        @endif
    </div><!-- card end -->
</div>
</div>

@endsection


@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.users.bids'))
        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @else
        <form action="{{ route('admin.report.transaction.search') }}" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush


