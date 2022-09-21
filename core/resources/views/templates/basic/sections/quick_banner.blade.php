@php
    $quickBanners = getContent('quick_banner.element');
@endphp

<div class="quick-banner-section bg--section pb-120 pt-60">
    <div class="container">
        <div class="overflow-hidden">
            <div class="quick-banner-wrapper">
                @foreach ($quickBanners as $quickBanner)     
                    <div class="quick-banner-item">
                        <a href="{{ $quickBanner->data_values->url }}">
                            <img src="{{ getImage('assets/images/frontend/quick_banner/'.$quickBanner->data_values->image, '700x400') }}" alt="quick-banner">
                            <span class="border-shape"></span>
                            <span class="border-shape2"></span>
                            <div class="quick-banner-content">
                                <span class="cmn--btn">{{ __($quickBanner->data_values->button) }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
