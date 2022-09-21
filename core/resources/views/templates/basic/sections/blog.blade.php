@php
    $blog   = getContent('blog.content', true);
    $blogs  = getContent('blog.element', false, 3);
@endphp
<section class="blog-section pt-120 pb-120">
    <div class="container">
        <div class="section__header">
            <h3 class="section__title">{{ __($blog->data_values->heading) }}</h3>
            <p class="section__txt">{{ __($blog->data_values->subheading) }}</p>
            <div class="progress progress--bar">
                <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="post-item">
                        <div class="post-thumb"> <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}"><img src="{{ getImage('assets/images/frontend/blog/thumb_'.$blog->data_values->blog_image, '425x285') }}" alt="blog"></a></div>
                        <div class="post-content">
                            <ul class="meta-post d-flex flex-wrap justify-content-between">
                                <li>
                                    <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}"><i class="far fa-calendar"></i>{{ showDateTime($blog->created_at) }}</a>
                                </li>
                            </ul>
                            <h5 class="title"><a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}">{{ __($blog->data_values->title) }}</a></h5>
                            <p> @php
                                echo shortDescription(strip_tags($blog->data_values->description_nic));
                            @endphp</p>
                            <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}" class="read-more">@lang('Read More')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
