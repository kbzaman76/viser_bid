@php
    $header = getContent('header.content', true);
@endphp
 <!-- Header -->
 <div class="header-top bg--section">
    <div class="container">
        <div class="header__top__wrapper">
            <ul>
                <li>
                    <span class="name">@lang('Email'): </span><a href="mailto:{{ $header->data_values->email }}" class="text--base">{{ __($header->data_values->email) }}</a>
                </li>
                <li>
                    <span class="name">@lang('Call Us'): </span><a href="tel:{{ $header->data_values->mobile }}" class="text--base">{{ __($header->data_values->mobile) }}</a>
                </li>
            </ul>
            <form action="{{ route('product.search') }}" class="search-form">
                <div class="input-group input--group">
                    <input type="text" class="form-control" name="search_key" value="{{ request()->search_key }}" placeholder="@lang('Product Name')">
                    <button type="submit" class="cmn--btn"><i class="las la-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="header-bottom">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo me-lg-4">
                <a href="{{ route('home') }}">
                    <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo">
                </a>
            </div>
            <div class="menu-area">
                <div class="menu-close">
                    <i class="las la-times"></i>
                </div>
                <ul class="menu">
                    <li>
                        <a href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    <li>
                        <a href="{{ route('product.all') }}">@lang('Products')</a>
                    </li>
                    <li>
                        <a href="{{ route('merchants') }}">@lang('Merchants')</a>
                    </li>
                    <li>
                        <a href="{{ route('about.us') }}">@lang('About Us')</a>

                    </li>
                    <li>
                        <a href="{{ route('blog') }}">@lang('Blog')</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                </ul>
                <div class="change-language d-md-none mt-4 justify-content-center">
                    <div class="sign-in-up">
                        <span><i class="fas la-user"></i></span>
                        <a href="{{ route('user.login') }}">@lang('User Login')</a>
                        <a href="{{ route('merchant.login') }}">@lang('Merchant Login')</a>
                    </div>
                </div>
            </div>
            <div class="change-language ms-auto me-3 me-lg-0">
                <div class="sign-in-up d-none d-sm-block">
                    <span><i class="fas la-user"></i></span>

                    @auth
                        <a href="{{ route('user.home') }}">@lang('User Dashboard')</a>
                    @endauth

                    @auth('merchant')
                        <a href="{{ route('merchant.dashboard') }}">@lang('Merchant Dashboard')</a>
                    @endauth

                    @if (!auth()->check() && !auth()->guard('merchant')->check())
                        <a href="{{ route('user.login') }}">@lang('User Login')</a>
                        <a href="{{ route('merchant.login') }}">@lang('Merchant Login')</a>
                    @endif

                </div>
                <select class="language langSel">
                    @foreach($language as $item)
                    <option value="{{$item->code}}" @if(session('lang')==$item->code) selected @endif>{{ __($item->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="header-bar d-lg-none">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</div>
<!-- Header -->
