@php
$upcomingAuction = getContent('upcoming_auction.content', true);
$upcomingProducts = \App\Models\Product::where('started_at', '>', now())
    ->where('status', 1)
    ->latest()
    ->limit(8)
    ->get();
@endphp
<section class="auction-section pt-60 pb-60 bg--section">
    <div class="container">
        <div class="section__header text-center icon__contain">
            <h3 class="section__title justify-content-center">
                <div class="icon">
                    <i class="lar la-hand-point-right"></i>
                </div>
                <div class="cont">{{ __($upcomingAuction->data_values->heading) }}</div>
            </h3>
            <p class="section__txt">{{ __($upcomingAuction->data_values->subheading) }}</p>
            <div class="progress progress--bar">
                <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($upcomingProducts as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10">
                    <div class="slide-item">
                        <div class="auction__item bg--body">
                            <div class="auction__item-thumb">
                                <a href="{{ route('product.details', [$product->id, slug($product->name)]) }}">
                                    <img src="{{ getImage(imagePath()['product']['path'] . '/thumb_' . collect($product->images)->first(), imagePath()['product']['thumb']) }}" alt="auction">
                                </a>

                                <span class="total-bids">
                                    <span><i class="las la-gavel"></i></span>
                                    <span>@lang('x') {{ $product->total_bid }} @lang('Bids')</span>
                                </span>
                            </div>
                            <div class="auction__item-content">
                                <h6 class="auction__item-title">
                                    <a href="{{ route('product.details', [$product->id, slug($product->name)]) }}">{{ shortDescription($product->name, 20) }}</a>
                                </h6>
                                <div class="auction__item-countdown">
                                    <div class="inner__grp">
                                        <ul class="countdown" data-date="{{ showDateTime($product->started_at, 'm/d/Y H:i:s') }}">
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
                </div>
            @endforeach
        </div>
        <div class="text-center mt-sm-5 mt-4">
            <a href="{{ route('upcoming.products') }}" class="cmn--btn">@lang('View All')</a>
        </div>
    </div>
</section>
