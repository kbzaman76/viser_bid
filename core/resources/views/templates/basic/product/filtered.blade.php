<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<div class="overlay-2" id="overlay2"></div>
<div class="d-flex flex-wrap justify-content-sm-between justify-content-center mb-4" style="gap:15px 30px">
    <p class="mb-0">@lang('Showing Results'): <span>{{ $products->count() }}</span></p>
    <p class="mb-0">@lang('Results Found'): <span>{{ $products->total() }}</span></p>
</div>
<div class="row g-4">
    @forelse ($products as $product)
        <div class="col-sm-6 col-xl-4">
            <div class="auction__item bg--body">
                <div class="auction__item-thumb">
                    <a href="{{ route('product.details', [$product->id, slug($product->name)]) }}">
                        <img src="{{ getImage(imagePath()['product']['path'] . '/thumb_' . @collect($product->images)->first(), imagePath()['product']['thumb']) }}" alt="auction">
                    </a>
                    <span class="total-bids">
                        <span><i class="las la-gavel"></i></span>
                        <span>@lang('x') {{ $product->total_bid }} @lang('Bids')</span>
                    </span>
                </div>
                <div class="auction__item-content">
                    <h6 class="auction__item-title">
                        <a href="{{ route('product.details', [$product->id, slug($product->name)]) }}">{{ __($product->name) }}</a>
                    </h6>
                    <div class="auction__item-countdown">
                        <div class="inner__grp">
                            <ul class="countdown" data-date="{{ showDateTime($product->expired_at, 'm/d/Y H:i:s') }}">
                                <li>
                                    <span class="days">@lang('00')</span>
                                </li>
                                <li>
                                    <span class="hours">@lang('00')</span>
                                </li>
                                <li>
                                    <span class="minutes">@lang('00')</span>
                                </li>
                                <li>
                                    <span class="seconds">@lang('00')</span>
                                </li>
                            </ul>
                            <div class="total-price">
                                {{ $general->cur_sym }}{{ showAmount($product->price) }}
                            </div>
                        </div>
                    </div>
                    <div class="auction__item-footer">
                        <a href="{{ route('product.details', [$product->id, slug($product->name)]) }}" class="cmn--btn w-100">@lang('Details')</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center">
            {{ __($emptyMessage) }}
        </div>
    @endforelse
</div>
{{ $products->links() }}
