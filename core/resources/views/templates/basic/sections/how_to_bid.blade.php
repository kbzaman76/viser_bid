@php
    $bid = getContent('how_to_bid.content', true);
    $bids = getContent('how_to_bid.element');
@endphp

<section class="how-section pt-60 pb-120">
    <div class="container">
        <div class="section__header">
            <h3 class="section__title"> {{ __($bid->data_values->heading) }}</h3>
            <p class="section__txt">
                {{ __($bid->data_values->subheading) }}
            </p>
            <div class="progress progress--bar">
                <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
            </div>
        </div>
        <div class="how__wrapper">
            @foreach ($bids as $bid)
            <div class="how__item">
                <div class="how__item-icon text--base">
                    @php
                        echo $bid->data_values->icon;
                    @endphp
                </div>
                <div class="how__item-content">
                    <h6 class="how__item-title">{{ __($bid->data_values->heading) }}</h6>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
