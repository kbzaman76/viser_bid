@php
    $categories = App\Models\Category::where('status', 1)->inRandomOrder()->limit(4)->get();
    $policyPages = getContent('policy_pages.element');
    $contact = getContent('contact_us.content', true);

@endphp
<footer class="footer-section footer--section">
    <div class="container">
        <div class="footer-top">
            <div class="footer-wrapper">
                <div class="footer-widget widget-links">
                    <h5 class="title">@lang('Categories')</h5>
                    <ul class="links">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('category.products', [$category->id, slug($category->name)]) }}">{{ __($category->name) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-widget widget-links">
                    <h5 class="title">@lang('Importants links')</h5>
                    <ul class="links">
                        @foreach ($policyPages as $policyPage)
                            <li>
                            <a href="{{ route('policy', [$policyPage, slug($policyPage->data_values->title)]) }}">
                            {{ __($policyPage->data_values->title) }}
                            </a>
                            </li>
                        @endforeach
                        <li><a href="{{ route('user.register') }}">@lang('User Registration')</a></li>
                        <li><a href="{{ route('merchant.register') }}">@lang('Merchant Registration')</a></li>
                    </ul>
                </div>
                <div class="footer-widget widget-links">
                    <h5 class="title">@lang('Site Links')</h5>
                    <ul class="links">
                        <li><a href="{{ route('merchants') }}">@lang('Merchants')</a></li>
                        @foreach($pages as $k => $data)
                        <li><a href="{{route('pages', $data->slug)}}">{{__($data->name)}}</a></li>
                        @endforeach
                        <li><a href="{{ route('blog') }}">@lang('Blog')</a></li>
                        <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                    </ul>
                </div>
                <div class="footer-widget widget-links">
                    <h5 class="title">@lang('Contact Information')</h5>
                    <ul class="footer-contact">
                        <li><a href="tel:{{ $contact->data_values->contact_number }}"><i class="las la-phone-volume"></i> {{ __($contact->data_values->contact_number) }}</a></li>
                        <li><a href="mailto:{{ $contact->data_values->email_address }}"><i class="las la-envelope-open"></i> {{ __($contact->data_values->email_address) }}</a></li>
                        <li><i class="las la-map-marker"></i>{{ __($contact->data_values->contact_details) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle">
        <div class="container">
            <div class="footer-middle-wrapper">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo">
                    </a>
                </div>
                <div class="cont">
                    <p>&copy; {{ date('Y') }} <a href="{{ route('home') }}">{{ __($general->sitename ) }}</a>. @lang('All Right Reserved')</p>
                </div>
            </div>
        </div>
    </div>
</footer>
