@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <!-- Product -->
    <section class="product-section pt-120 pb-120">
        <div class="container">
            <div class="row gy-5 justify-content-between">
                <div class="col-lg-8">
                    <div class="product__single-item">
                        <div class="product-thumb-area mb-5">
                            <div class="product-thumb pe-md-4">

                                <div class="slider-for">
                                    @if ($product->images)
                                        @foreach ($product->images as $image)
                                            <div class="slider-for__item">
                                                <img src="{{ getImage(imagePath()['product']['path'] . '/' . @$image, imagePath()['product']['size']) }}" data-zoom-image="{{ getImage(imagePath()['product']['path'] . '/' . @$image, imagePath()['product']['size']) }}" alt="image" class="slider-nav__img">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="slider-nav" id="gallery_01">
                                    @if ($product->images)
                                        @foreach ($product->images as $image)
                                            <div class="slider-nav__item">
                                                <img src="{{ getImage(imagePath()['product']['path'] . '/thumb_' . @$image, imagePath()['product']['size']) }}" alt="image" class="slider-nav__img">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="meta-post mt-4">
                                    <div class="meta-item me-sm-auto">
                                        <span class="text--base"><i class="las la-gavel"></i></span> {{ __($product->total_bid) }}
                                    </div>
                                    <div class="meta-item me-0">
                                        <span class="text--base"><i class="lar la-share-square"></i></span>
                                        <ul class="social-share">
                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" title="@lang('Facebook')" target="blank"><i class="fab fa-facebook"></i></a>
                                            </li>

                                            <li>
                                                <a href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ __($product->name) }}&media={{ getImage('assets/images/product/' . @collect($product->images)->first()) }}" title="@lang('Pinterest')" target="blank"><i class="fab fa-pinterest-p"></i></a>
                                            </li>

                                            <li>
                                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ __($product->name) }}&amp;summary={{ shortDescription(__($product->summary)) }}" title="@lang('Linkedin')" target="blank"><i class="fab fa-linkedin"></i></a>
                                            </li>

                                            <li>
                                                <a href="https://twitter.com/intent/tweet?text={{ __($product->name) }}%0A{{ url()->current() }}" title="@lang('Twitter')" target="blank">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @if ($product->images)
                                    @foreach ($product->images as $key => $image)
                                        @if ($key != 0)
                                            <span class="d-none" data-image="{{ getImage(imagePath()['product']['path'] . '/' . @$image, imagePath()['product']['size']) }}">{{ getImage(imagePath()['product']['path'] . '/' . @collect($product->images)->first(), imagePath()['product']['size']) }}</span> <br>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="product-content">
                                <h5 class="title mt-0 mb-2">{{ __($product->name) }}</h5>
                                <div class="ratings mb-4">
                                    @php echo displayAvgRating($product->avg_rating); @endphp
                                    ({{ $product->review_count }})
                                </div>
                                <p class="mb-4 mt-0">
                                    {{ __(shortDescription($product->short_description)) }}
                                </p>
                                <div class="product-price">
                                    <div>
                                        {{ showAmount($product->price) }} <span class="text--base">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                                @if ($product->status == 1 && $product->started_at < now() && $product->expired_at > now())
                                    <div class="btn__area">
                                        <div class="cart-plus-minus input-group w-auto">
                                            <span class="input-group-text bg--base border-0 text-white">{{ $general->cur_sym }}</span>
                                            <input type="number" placeholder="@lang('Enter your amount')" class="form-control" id="amount" min="0" step="any">
                                        </div>
                                        <div>
                                            <button class="cmn--btn btn--sm bid_now" data-cur_sym="{{ $general->cur_sym }}">@lang('Bid Now')</button>
                                        </div>
                                        <span class="text--danger empty-message">@lang('Please enter an amount to bid')</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="max-banner mb-4">
                            @php
                                showAd('780x80');
                            @endphp
                        </div>
                        <div class="content">
                            <ul class="nav nav-tabs nav--tabs">
                                <li>
                                    <a href="#bids" class="active" data-bs-toggle="tab">@lang('Bids')</a>
                                </li>
                                <li>
                                    <a href="#description" data-bs-toggle="tab">@lang('Description')</a>
                                </li>
                                <li>
                                    <a href="#specification" data-bs-toggle="tab">@lang('Specification')</a>
                                </li>
                                <li>
                                    <a href="#reviews" data-bs-toggle="tab">@lang('Reviews')({{ $product->reviews->count() }})</a>
                                </li>
                                <li>
                                    <a href="#related-products" data-bs-toggle="tab">@lang('Related Products')</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade fade  show active" id="bids">
                                    <div class="specification-wrapper">
                                        <h5 class="title">@lang('All Bids')</h5>
                                        <div class="table-wrapper">
                                            <table class="specification-table">
                                                <tr>
                                                    <th>@lang('User')</td>
                                                    <td>@lang('Bid Amount')</td>
                                                    <td>@lang('Status')</td>
                                                </tr>
                                                @if ($product->bids)
                                                    @forelse ($product->bids->sortByDesc('status') as $bid)
                                                        <tr>
                                                            <th>{{ __($bid->user->fullname) }}</th>
                                                            <td>{{ $general->cur_sym . showAmount($bid->amount) }}</td>
                                                            <td>
                                                                {{ $bid->status ? 'Highest Bid' : 'Refunded' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="100%" class="text-center">@lang('There is no bids available')</td>
                                                        </tr>
                                                    @endforelse
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="description">
                                    @php
                                        echo $product->long_description;
                                    @endphp
                                </div>
                                <div class="tab-pane fade" id="specification">
                                    <div class="specification-wrapper">
                                        <h5 class="title">@lang('Specification')</h5>
                                        <div class="table-wrapper">
                                            <table class="specification-table">
                                                <tr>
                                                    <th>@lang('Category')</td>
                                                    <td>{{ __($product->category->name) }}</td>
                                                </tr>
                                                @if ($product->specification)
                                                    @foreach ($product->specification as $spec)
                                                        <tr>
                                                            <th>{{ __($spec['name']) }}</th>
                                                            <td>{{ __($spec['value']) }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="reviews">
                                    <div class="review-area"></div>

                                    @if ($product->bids->where('user_id', auth()->id())->count())
                                        @php $review = $product->reviews->where('user_id', auth()->id())->first(); @endphp
                                        <div class="add-review pt-4 pt-sm-5">
                                            <h5 class="title bold mb-3 mb-lg-4">
                                                @if ($review)
                                                    @lang('Update Your Review')
                                                @else
                                                    @lang('Add Review')
                                                @endif
                                            </h5>
                                            <form action="{{ route('user.product.review.store') }}" method="POST" class="review-form rating row">
                                                @csrf
                                                <input type="hidden" value="{{ $product->id }}" name="product_id">


                                                <div class="review-form-group mb-20 col-md-6 d-flex flex-wrap">
                                                    <label class="review-label mb-0 me-3">@lang('Your Rating') :</label>
                                                    <div class="rating-form-group">
                                                        <label class="star-label">
                                                            <input type="radio" name="rating" value="1" {{ $review && $review->rating == 1 ? 'checked' : '' }} />
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                        </label>
                                                        <label class="star-label">
                                                            <input type="radio" name="rating" value="2" {{ $review && $review->rating == 2 ? 'checked' : '' }} />
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                        </label>
                                                        <label class="star-label">
                                                            <input type="radio" name="rating" value="3" {{ $review && $review->rating == 3 ? 'checked' : '' }} />
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                        </label>
                                                        <label class="star-label">
                                                            <input type="radio" name="rating" value="4" {{ $review && $review->rating == 4 ? 'checked' : '' }} />
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                        </label>
                                                        <label class="star-label">
                                                            <input type="radio" name="rating" value="5" {{ $review && $review->rating == 5 ? 'checked' : '' }} />
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                            <span class="icon"><i class="las la-star"></i></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="review-form-group mb-20 col-12 d-flex flex-wrap">

                                                    <textarea name="description" placeholder="@lang('Write your review')..." class="form-control form--control" id="review-comments">{{ $review ? __($review->description) : old('description') }}</textarea>
                                                </div>
                                                <div class="review-form-group mb-20 col-12 d-flex flex-wrap">
                                                    <button type="submit" class="cmn--btn w-100">@lang('Submit Review')</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane" id="related-products">
                                    <div class="slide-wrapper">
                                        <div class="related-slider owl-theme owl-carousel">
                                            @foreach ($relatedProducts as $relatedProduct)
                                                <div class="slide-item">
                                                    <div class="auction__item bg--body">
                                                        <div class="auction__item-thumb">
                                                            <a href="{{ route('product.details', [$relatedProduct->id, slug($relatedProduct->name)]) }}">
                                                                <img src="{{ getImage(imagePath()['product']['path'] . '/thumb_' . @collect($relatedProduct->images)->first(), imagePath()['product']['thumb']) }}" alt="auction">
                                                            </a>
                                                            <span class="total-bids">
                                                                <span><i class="las la-gavel"></i></span>
                                                                <span>@lang('x') {{ $relatedProduct->total_bid }} @lang('Bids')</span>
                                                            </span>
                                                        </div>
                                                        <div class="auction__item-content">
                                                            <h6 class="auction__item-title">
                                                                <a href="{{ route('product.details', [$relatedProduct->id, slug($relatedProduct->name)]) }}">{{ __($relatedProduct->name) }}</a>
                                                            </h6>
                                                            <div class="auction__item-countdown">
                                                                <div class="inner__grp">
                                                                    <ul class="countdown" data-date="{{ showDateTime($relatedProduct->expired_at, 'm/d/Y H:i:s') }}">
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
                                                                        {{ $general->cur_sym }}{{ showAmount($relatedProduct->price) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="auction__item-footer">
                                                                <a href="{{ route('product.details', [$relatedProduct->id, slug($relatedProduct->name)]) }}" class="cmn--btn w-100">@lang('Details')</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="max-banner mt-5">
                                @php
                                    showAd('780x80');
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <aside class="product-single-sidebar ms-xl-3 ms-xxl-5">
                        <div class="countdown-area bg--section mb-4">
                            <ul class="countdown sidebar-countdown" data-date="{{ showDateTime($product->expired_at, 'm/d/Y H:i:s') }}">
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
                        </div>
                        <div class="seller-area bg--section mb-4">
                            <h6 class="about-seller mb-4">
                                @lang('About Seller')
                            </h6>
                            @php
                                $admin = $product->admin_id != 0 ? true : false;
                            @endphp
                            <a href="{{ $admin ? route('admin.profile.view', [$product->admin->id, slug(@$general->merchant_profile->name)]) : route('merchant.profile.view', [$product->merchant->id, slug($product->merchant->fullname)]) }}" class="seller">
                                <div class="thumb">
                                    @if ($admin)
                                        <img src="{{ getImage(imagePath()['profile']['admin']['path'] . '/' . $general->merchant_profile->image, null, true) }}" alt="winner">
                                    @else
                                        <img src="{{ getImage(imagePath()['profile']['merchant']['path'] . '/' . $product->merchant->image, null, true) }}" alt="winner">
                                    @endif

                                </div>
                                <div class="cont">
                                    <h6 class="title">{{ __($admin ? @$general->merchant_profile->name : $product->merchant->fullname) }}</h6>
                                </div>
                            </a>
                            <ul class="seller-info mt-4">
                                <li>
                                    @lang('Since'): <span class="text--base">{{ showDateTime($admin ? $product->admin->created_at : $product->merchant->created_at, 'd M Y') }}</span>
                                </li>

                                @if (!$admin)
                                    <li>
                                        <div class="ratings">
                                            @php
                                                echo displayAvgRating($star = $admin ? $product->admin->avg_rating : $product->merchant->avg_rating);
                                            @endphp
                                            ({{ __($admin ? $product->admin->review_count : $product->merchant->review_count) }})
                                        </div>
                                    </li>
                                @endif
                                <li>
                                    @lang('Total Products') : <span class="text--base">{{ $admin ? $product->admin->products->count() : $product->merchant->products->count() }}</span>
                                </li>


                                <li>
                                    @lang('Total Sale') : <span class="text--base">{{ $admin ? $product->admin->products->sum('total_bid') : $product->merchant->products->sum('total_bid') }}</span>
                                </li>

                            </ul>
                        </div>
                        <div class="mini-banner">
                            @php
                                showAd('370x670');
                            @endphp
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- Product -->
    <div class="modal fade" id="bidModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert')</h5>
                    <button class="btn text--danger modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.bid') }}" method="POST">
                    @csrf
                    <input type="hidden" class="amount" name="amount" required>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="modal-body">
                        <h6 class="message"></h6>
                        @if ($product->bids->count())
                            @lang('The highest bid : ') {{ showAmount($product->bids->first()->amount) }} {{ __($general->cur_text) }} ,
                            @lang('make sure that your amount is bigger than highest bid')
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--base">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var pid = '{{ $product->id }}';
            loadData(pid);

            function loadData(pid, url = "{{ route('product.review.load') }}") {
                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        pid: pid
                    },
                    success: function(data) {
                        $('#load_more_button').remove();
                        $('.review-area').append(data);
                    }
                });
            }
            $(document).on('click', '#load_more_button', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                $('#load_more_button').html(`<b>{{ __('Loading') }} <i class="fa fa-spinner fa-spin"></i> </b>`);
                loadData(pid, url);
            });

            $('.empty-message').hide();
            $('.bid_now').on('click', function() {
                var modal = $('#bidModal');
                var cur_sym = $(this).data('cur_sym');
                var amount = $('#amount').val();
                modal.find('.message').html('Are you sure to bid on this product?');
                if (!amount) {
                    modal.find('.message').html('Please enter an amount to bid');
                    $('.empty-message').show();
                } else {
                    $('.empty-message').hide();
                    modal.find('.amount').val(amount);
                    modal.modal('show');
                }
            })

            $('.slider-for').slick({
                mobileFirst: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav'
            });

            $('.slider-nav').slick({
                mobileFirst: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                focusOnSelect: true,
                prevArrow: '<button type="button" class="client-slider__arrow client-slider__arrow-prev"><i class="las la-angle-left"></i></button>',
                nextArrow: '<button type="button" class="client-slider__arrow client-slider__arrow-next"><i class="las la-angle-right"></i></button>',
                responsive: [{
                    breakpoint: 1399,
                    settings: {
                        slidesToShow: 3,
                    },
                }]
            });

        })(jQuery);
    </script>
@endpush
