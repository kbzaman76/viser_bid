@extends('merchant.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Total Bid')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td data-label="@lang('S.N')">{{ $products->firstItem() + $loop->index }}</td>
                                <td data-label="@lang('Name')">{{ __($product->name) }}</td>
                                <td data-label="@lang('Category')">{{ __($product->category->name) }}</td>
                                <td data-label="@lang('Price')">{{ $general->cur_sym }}{{ showAmount($product->price) }}</td>
                                <td data-label="@lang('Total Bid')">
                                    <a href="{{ route('merchant.product.bids', $product->id) }}" class="icon-btn btn--info ml-1">
                                        {{ $product->total_bid }}
                                    </a> 
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($product->status == 0 && $product->expired_at > now())
                                        <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                    @elseif($product->status == 1 && $product->started_at < now() && $product->expired_at > now())
                                        <span class="text--small badge font-weight-normal badge--success">@lang('Live')</span>
                                    @elseif($product->status == 1 && $product->started_at > now())
                                        <span class="text--small badge font-weight-normal badge--primary">@lang('Upcoming')</span>
                                    @else
                                        <span class="text--small badge font-weight-normal badge--danger">@lang('Expired')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('merchant.product.edit', $product->id) }}" class="icon-btn mr-1" data-toggle="tooltip" data-original-title="@lang('Edit')">
                                        <i class="las la-pen text--shadow"></i>
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
                @if ($products->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($products) }}
                </div>
                @endif
            </div>
        </div>


    </div>
@endsection

@push('breadcrumb-plugins')
<div class="d-flex flex-wrap justify-content-sm-end header-search-wrapper">
    <form action="" method="GET" class="header-search-form">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Product or Merchant')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
    <a class="btn btn-sm btn--primary box--shadow1 text--small" href="{{ route('merchant.product.create') }}"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
</div>
@endpush

@push('style')
    <style>
        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center
        }
        .header-search-wrapper {
            gap: 15px
        }
        
        @media (max-width:400px) {
            .header-search-form {
                width: 100%
            }
        }
    </style>
@endpush