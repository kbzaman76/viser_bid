@extends($activeTemplate.'layouts.frontend')
@php
    $about = getContent('about.content', true);
    $abouts = getContent('about.element');
@endphp
@section('content')
<section class="about-section pt-120 pb-60">
    <div class="container">
        <div class="row gy-sm-5 gy-4">
            <div class="col-lg-6">
                <div class="about-thumb me-xl-4">
                    <img src="{{ getImage('assets/images/frontend/about/'.$about->data_values->about_image, '800x530') }}" alt="about">
                    <a href="{{ $about->data_values->video_url }}" class="video__btn" data-lightbox>
                        <i class="las la-play"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section__header text-start">
                        <h3 class="section__title mt-0">{{ __($about->data_values->heading) }}</h3>
                        <p class="section__txt">{{ __($about->data_values->subheading) }}</p>
                        <div class="progress progress--bar">
                            <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
                        </div>
                    </div>
                    <p class="txt">
                        {{ __($about->data_values->description) }}
                    </p>
                    <ul class="about--list">
                        @foreach ($abouts as $about)
                            <li>{{ __($about->data_values->about_list) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

    @if($sections != null)
        @foreach(json_decode($sections) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
