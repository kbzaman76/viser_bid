@php
    $winnerContent = getContent('winner.content', true);
    $winners = App\Models\Winner::groupBy('user_id')->with('user')->latest()->limit(5)->get();
@endphp

@if( $winners->count())
<section class="latest-winner-section pt-120 pb-60">
    <div class="container">
        <div class="section__header text-center">
            <h3 class="section__title mt-0 text-center">{{ __($winnerContent->data_values->heading) }}</h3>
            <p class="section__txt">
                {{ __($winnerContent->data_values->subheading) }}
            </p>
            <div class="progress progress--bar">
                <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <table class="table cmn--table ">
                    <thead class="bg--base">
                        <tr>
                            <th>@lang('Winner')</th>
                            <th>@lang('Product Name')</th>
                            <th>@lang('Product Price')</th>
                            <th>@lang('Bid Amount')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($winners as $winner)
                            <tr>
                                <td>
                                    <div class="latest__winner-item">
                                        <div class="latest__winner-thumb">
                                            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $winner->user->image, null, true) }}"
                                            alt="winner">
                                        </div>
                                        <div class="latest__winner-content">
                                            <h6 class="title mb-2">{{ __($winner->user->fullname) }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="product-name">{{ __($winner->product->name) }}</span>
                                </td>
                                <td>
                                    <span class="text--base">{{ $general->cur_sym }}{{ showAmount($winner->product->price) }}</span>
                                </td>
                                <td>
                                <span class="text--base">{{ $general->cur_sym }}{{ showAmount($winner->bid->amount) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endif
