@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="vendor-profile pb-60">
    <div class="container">
        <div class="vendor__single__item">
            <div class="vendor__single__item-thumb">
                @if ($admin)
                    <img src="{{getImage(imagePath()['profile']['admin_cover']['path'].'/'.@$general->merchant_profile->cover_image)}}" alt="vendor">
                @else
                    <img src="{{getImage(imagePath()['profile']['merchant_cover']['path'].'/'.$merchant->cover_image)}}" alt="vendor">
                @endif
            </div>
            <div class="vendor__single__item-content">
                <div class="vendor__single__author">
                    <div class="thumb">
                        @if ($admin)
                            <img src="{{getImage(imagePath()['profile']['admin']['path'].'/'.@$general->merchant_profile->image, null, true)}}" alt="vendor">
                        @else
                            <img src="{{getImage(imagePath()['profile']['merchant']['path'].'/'.$merchant->image, null, true)}}" alt="vendor">
                        @endif
                    </div>
                    <div class="content">
                        <div class="title__area">
                            <h4 class="title">{{ __($admin ? @$general->merchant_profile->name : $merchant->fullname) }}</h4>
                            <ul class="social__icons">
                                @if (!$admin && $merchant->social_links)
                                    @foreach ($merchant->social_links as $social_link)
                                        <li>
                                            <a href="{{ $social_link['link'] }}" target="_blank">
                                                @php
                                                    echo $social_link['icon'];
                                                @endphp
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="content-area">
                            <ul>
                                <li>
                                    <i class="las la-map-marker"></i>{{ __($admin ? @$general->merchant_profile->address: $merchant->address->address) }}
                                </li>
                                <li>
                                    <i class="las la-phone"></i> {{ __($admin ? @$general->merchant_profile->mobile : $merchant->mobile) }}
                                </li>

                                @if(!$admin)
                                <li>
                                    <i class="las la-star"></i> {{ showAmount($merchant->avg_rating) }} @lang('rating from') {{ $merchant->review_count }} @lang('reviews')
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="vendor-section pt-60 pb-60">
    <div class="container">
        <div class="section__header text-start icon__contain">
            <h4 class="section__title">
                <div class="author-icon">
                    <i class="las la-user-tag"></i>
                </div>
                <div class="cont">
                    @lang('Merchant Products')
                </div>
            </h4>
            <div class="progress progress--bar">
                <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($products as $product)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="auction__item bg--body">
                        <div class="auction__item-thumb">
                            <a href="{{ route('product.details', [$product->id, slug($product->name)]) }}">
                                <img src="{{getImage(imagePath()['product']['path'].'/thumb_'.$product->image,imagePath()['product']['thumb'])}}" alt="auction">
                            </a>
                            <span class="total-bids">
                                <span><i class="las la-gavel"></i></span>
                                <span>@lang('x') {{ ($product->total_bid) }} @lang('Bids')</span>
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
            @endforeach
            {{ $products->links() }}
        </div>
    </div>
</section>

@if(!$admin)
<section class="bp-60">
    <div class="container">
        @if ($merchant->bids()->where('user_id', auth()->id())->count())
            @php
                $review = $merchant->reviews->where('user_id', auth()->id())->where('merchant_id', $merchant->id)->first();
            @endphp
            <div class="add-review pt-4 pt-sm-5">
                <h5 class="title bold mb-3 mb-lg-4">{{ $review ? __('Update Review') : __('Add Review') }}</h5>
                <form action="{{ route('user.merchant.review.store') }}" method="POST" class="review-form rating row">
                    @csrf
                    <input type="hidden" value="{{ $merchant->id }}" name="merchant_id">
                    <div class="review-form-group mb-20 col-md-6">
                        <label for="your-name" class="review-label">@lang('Name')</label>
                        <input type="text" class="form-control form--control" id="your-name" value="{{ auth()->user()->fullname }}" readonly>
                    </div>
                    <div class="review-form-group mb-20 col-md-6">
                        <label for="your-email" class="review-label">@lang('Email')</label>
                        <input type="text" class="form-control form--control" id="your-email" value="{{ auth()->user()->email }}" readonly>
                    </div>
                    <div class="review-form-group mb-20 col-md-6 d-flex flex-wrap">
                        <label class="review-label mb-0 me-3">@lang('Your Ratings') :</label>
                        <div class="rating-form-group">
                            <label class="star-label">
                                <input type="radio" name="rating" value="1" {{ ($review && $review->rating ==1) ? 'checked': ''  }} />
                                <span class="icon"><i class="las la-star"></i></span>
                            </label>

                            <label class="star-label">
                                <input type="radio" name="rating" value="2" {{ ($review && $review->rating ==2) ? 'checked': ''  }} />
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                            </label>

                            <label class="star-label">
                                <input type="radio" name="rating" value="3" {{ ($review && $review->rating ==3) ? 'checked': ''  }} />
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                            </label>
                            <label class="star-label">
                                <input type="radio" name="rating" value="4" {{ ($review && $review->rating ==4) ? 'checked': ''  }} />
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                            </label>
                            <label class="star-label">
                                <input type="radio" name="rating" value="5" {{ ($review && $review->rating ==5) ? 'checked': ''  }} />
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                                <span class="icon"><i class="las la-star"></i></span>
                            </label>
                        </div>
                    </div>
                    <div class="review-form-group mb-20 col-12 d-flex flex-wrap">
                        <label class="review-label" for="review-comments">@lang('Say something about this merchant')</label>
                        <textarea name="description" class="form-control form--control" id="review-comments">{{ $review ? __($review->description) : old('description') }}</textarea>
                    </div>
                    <div class="review-form-group mb-20 col-12 d-flex flex-wrap">
                        <button type="submit" class="cmn--btn w-100">@lang('Submit Review')</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</section>
@endif

@endsection
