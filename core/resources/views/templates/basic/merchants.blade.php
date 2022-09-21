@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="vendor-section pt-120 pb-120">
    <div class="container">
        <div class="row g-4">
            @forelse ($merchants as $merchant)
                <div class="col-md-6 col-lg-4">
                    <div class="vendor__item bg--section">
                        <div class="vendor__top">
                            <h6 class="title">
                                <a href="{{ route('merchant.profile.view', [$merchant->id, slug($merchant->fullname)]) }}">{{ __($merchant->fullname) }}</a>
                            </h6>
                            <div class="ratings">
                                @php
                                      echo displayAvgRating($merchant->avg_rating)
                                @endphp
                            </div>
                            <ul class="vendor__info">
                                <li>
                                    <i class="las la-map-marker-alt"></i> {{ __($merchant->address->address) }}
                                </li>
                                <li>
                                    <a href="Tel:{{ $merchant->mobile }}"><i class="las la-phone"></i> {{ __($merchant->mobile) }}</a>
                                </li>
                                <li>
                                    <a href="Mailto:{{ $merchant->email }}"><i class="las la-envelope"></i> {{ $merchant->email }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="vendor__bottom">
                            <a href="{{ route('merchant.profile.view', [$merchant->id, slug($merchant->fullname)]) }}" class="read-more">@lang('View Store')</a>
                            <a href="{{ route('merchant.profile.view', [$merchant->id, slug($merchant->fullname)]) }}" class="vendor-author">
                                <img src="{{getImage(imagePath()['profile']['merchant']['path'].'/'.$merchant->image, null, true)}}" alt="vendor">
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center">
                    {{ __($emptyMessage) }}
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
