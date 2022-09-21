@php
    
    $breadcrumb = getContent('breadcrumb.content', true);
@endphp

<section class="hero-section inner-hero" style="background: url({{ getImage('assets/images/frontend/breadcrumb/'.$breadcrumb->data_values->background_image, '1920x240') }})center">
    <div class="container">
        <div class="hero-content text-center">
            <h3 class="hero-title text--base">{{ __($pageTitle) }}</h3>
        </div>
    </div>
</section>
<!-- Hero -->