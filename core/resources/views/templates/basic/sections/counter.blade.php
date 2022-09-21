@php
    $counters = getContent('counter.element');
@endphp
<section class="counter-section pt-60 pb-60">
    <div class="container">
        <div class="row justify-content-center g-4">
            @foreach ($counters as $counter)     
                <div class="col-xl-3 col-sm-6">
                    <div class="counter-item bg--section">
                        <div class="counter-header">
                            <h4 class="title">{{ $counter->data_values->counter_digit }}</h4>
                        </div>
                        <div class="counter-content text--body">
                            {{ __($counter->data_values->title) }}
                        </div>
                        <div class="icon text--title">
                            @php echo $counter->data_values->counter_icon @endphp
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>
</section>