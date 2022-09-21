@php
$expiredAuction = getContent('recently_expired.content', true);
$recentlyExpiredProducts = \App\Models\Product::where('expired_at', '<', now())
    ->latest()
    ->limit(4)
    ->get();
@endphp

<section class="auction-section pt-120 pb-60 bg--section">
    <div class="container">
        <div class="section__header text-center icon__contain">
            <h3 class="section__title justify-content-center">
                <div class="icon">
                    <i class="las la-running"></i>
                </div>
                <div class="cont">{{ __($expiredAuction->data_values->heading) }}</div>
            </h3>
            <p class="section__txt">{{ __($expiredAuction->data_values->subheading) }}</p>
            <div class="progress progress--bar">
                <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($recentlyExpiredProducts as $product)
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
                                    <a href="{{ route('product.details', [$product->id, slug($product->name)]) }}">{{ __($product->name) }}</a>
                                </h6>
                                <div class="auction__item-countdown">
                                    <div class="inner__grp">

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
    </div>
</section>
