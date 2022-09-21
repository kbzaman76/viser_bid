@extends($activeTemplate.'layouts.frontend')
@php
	$banner = getContent('banner.content', true);
    $features = getContent('feature.element');
@endphp
@section('content')

<section class="banner-section bg--overlay bg_img" data-background="{{ getImage('assets/images/frontend/banner/'.$banner->data_values->background_image, '1920x1280') }}">
	<div class="banner__inner">
		<div class="container">
			<div class="banner__content">
				<h2 class="banner__title cd-headline letters type">
					<span>{{ __($banner->data_values->heading) }}</span>
				</h2>
				<p class="banner__content-txt">{{ __($banner->data_values->subheading) }}</p>
				<div class="btn__grp">
					<a href="{{ $banner->data_values->button_url }}" class="cmn--btn">{{ __($banner->data_values->button) }}</a>
					<a href="{{ $banner->data_values->link_url }}" class="cmn--btn active">{{ __($banner->data_values->link) }}</a>
				</div>
			</div>
		</div>
	</div>
</section>

 <section class="feature-section pb-60 ">
    <div class="container">
        <div class="feature__wrapper">
            <div class="row g-4">
                @foreach ($features as $feature)
                <div class="col-lg-3 col-sm-6">
                    <div class="feature__item bg--section">
                        <div class="feature__item-icon">
                           @php
                               echo $feature->data_values->feature_icon
                           @endphp
                        </div>
                        <h6 class="feature__item-title">{{ __($feature->data_values->title) }}</h6>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif

@endsection
