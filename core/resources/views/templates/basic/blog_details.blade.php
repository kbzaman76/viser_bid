@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="blog-details pt-120 pb-120">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-8">
                <div class="blog-details-wrapper">
                    <div class="blog-details-thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->blog_image, '850x570') }}" alt="blog">
                    </div>
                    <div class="blog-details-content">
                        <div class="blog-details-header">
                            <ul class="meta-1 d-flex flex-wrap">
                                <li><i class="far fa-calendar"></i>{{ showDateTime($blog->created_at) }} -- {{ diffForHumans($blog->created_at) }}</li>
                            </ul>
                            <h3 class="title mb-4 mt-3">{{ __($blog->data_values->title) }}</h3>
                        </div>
                        @php echo $blog->data_values->description_nic @endphp
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <div class="sidebar-item">
                        <div class="recent-post-wrapper">
                            <h5 class="title mb-4">@lang('Recent Post')</h5>
							@foreach ($recentBlogs as $blog)
								<div class="blog__item recent-blog">
									<div class="blog__thumb">
										<img src="{{ getImage('assets/images/frontend/blog/thumb_'.$blog->data_values->blog_image, '425x285') }}" alt="blog">
									</div>
									<div class="blog__content">
										<h6 class="title"><a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}">{{ __($blog->data_values->title) }}</a></h6>
										<span class="date"><i class="flaticon-calendar"></i>{{ showDateTime($blog->created_at) }}</span>
									</div>
								</div>
							@endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="fb-comments" data-href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" data-numposts="5"></div>
        </div>
    </div>
</div>
@endsection

@push('fbComment')
	@php echo loadFbComment() @endphp
@endpush