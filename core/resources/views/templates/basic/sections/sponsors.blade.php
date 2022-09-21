@php
    $sponsors = getContent('sponsors.element');
@endphp
<section class="sponsors-section pt-80 pb-80">
    <div class="container">
        <div class="partner-slider owl-theme owl-carousel">
            @foreach ($sponsors as $sponsor)     
                <div class="partner-thumb">
                    <img src="{{ getImage('assets/images/frontend/sponsors/'.$sponsor->data_values->image, '350x150') }}" alt="partner">
                    <img src="{{ getImage('assets/images/frontend/sponsors/'.$sponsor->data_values->image, '350x150') }}" alt="partner">
                </div>
            @endforeach
        </div>
    </div>
</section>