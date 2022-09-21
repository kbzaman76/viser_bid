@forelse ($reviews as $review)
    <div class="review-item">
        <div class="thumb">
            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$review->user->image, null, true) }}" alt="winner">
        </div>
        <div class="content">
            <div class="entry-meta">
                <h6 class="posted-on">
                    <p>{{ __($review->user->fullname) }}</p>
                    <span>@lang('Posted on') {{ showDateTime($review->created_at, 'M d, \a\t g:i a') }}</span>
                </h6>
                <div class="ratings">
                    @php
                        echo displayAvgRating($review->rating)
                    @endphp
                </div>
            </div>
            <div class="entry-content">
                <p>{{ __($review->description) }}</p>
            </div>
        </div>
    </div>
@empty
    <div class="text-center">@lang('No review yet')</div>
@endforelse

@if($reviews->currentPage() != $reviews->lastPage())
    <div id="load_more">
        <button type="button" name="load_more_button" class="cmn--btn btn--sm w-100 mt-3" id="load_more_button" data-url="{{ $reviews->nextPageUrl() }}">@lang('Load More')</button>
    </div>
@endif
