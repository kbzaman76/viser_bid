@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="product-section pt-120 pb-120">
    <div class="container">
        <div class="categories__wrapper bg--body">
            <div class="inner__grp">
                @forelse ($categories as $category)     
                    <a href="{{ route('category.products', [$category->id, slug($category->name)]) }}" class="category__item">
                        <div class="category__item-icon">
                            @php
                                echo $category->icon;
                            @endphp
                        </div>
                        <h6 class="category__item-title">{{ __($category->name) }}</h6>
                    </a>                
                @empty
                    <div class="text-center my-3">
                        <p>{{ __($emptyMessage) }}</p>
                    </div>
                @endforelse
            </div>
        </div>
        {{ $categories->links() }}
    </div>
</section>
@endsection