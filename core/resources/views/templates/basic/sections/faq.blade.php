@php
   $faq = getContent('faq.content', true);
   $faqs = getContent('faq.element');
@endphp

<section class="faq-section pt-120 pb-120 bg--section">
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-lg-10 col-xxl-8">
                <div class="section__header">
                    <h3 class="section__title">{{ __($faq->data_values->heading) }}</h3>
                    <p class="section__txt">{{ __($faq->data_values->subheading) }}</p>
                    <div class="progress progress--bar">
                        <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="faq__wrapper">
                        @foreach ($faqs as $faq)
                            @if($loop->odd)
                                <div class="faq__item">
                                    <div class="faq__title">
                                        <h5 class="title">{{ __($faq->data_values->question) }}</h5>
                                        <span class="right--icon"></span>
                                    </div>
                                    <div class="faq__content">
                                        @php echo $faq->data_values->answer @endphp
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq__wrapper">
                        @foreach ($faqs as $faq)
                            @if($loop->even)
                                <div class="faq__item">
                                    <div class="faq__title">
                                        <h5 class="title">{{ __($faq->data_values->question) }}</h5>
                                        <span class="right--icon"></span>
                                    </div>
                                    <div class="faq__content">
                                        @php echo $faq->data_values->answer @endphp
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
