@extends($activeTemplate.'layouts.frontend')
@php
    $contact = getContent('contact_us.content', true);
@endphp
@section('content')
    <!-- Contact -->
    <section class="contact-section pt-120 pb-120 pb-lg-0">
        <div class="container">
            <div class="contact-area">
                <div class="contact-content">
                    <div class="contact-content-top">
                        <h3 class="title">{{ __($contact->data_values->title) }}</h3>
                        <p>{{ __($contact->data_values->short_details) }}</p>
                    </div>
                    <div class="contact-content-botom">
                        <h5 class="subtitle">@lang('More Information')</h5>
                        <ul class="contact-info">
                            <li>
                                <div class="icon">
                                    <i class="las la-map-marker-alt"></i>
                                </div>
                                <div class="cont">
                                    <h6 class="name">@lang('Address')</h6>
                                    <span class="info">{{ __($contact->data_values->contact_details) }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="las la-envelope"></i>
                                </div>
                                <div class="cont">
                                    <h6 class="name">@lang('Email')</h6>
                                    <span class="info"><a href="mailto:{{ $contact->data_values->email_address }}">{{ __($contact->data_values->email_address) }}</a></span>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="las la-phone-volume"></i>
                                </div>
                                <div class="cont">
                                    <h6 class="name">@lang('Phone')</h6>
                                    <a href="tel:{{ $contact->data_values->contact_number }}">
                                        <span class="info">{{ __($contact->data_values->contact_number) }}</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="contact-wrapper bg--section">
                    <div class="section__header text-start icon__contain">
                        <h3 class="section__title">
                            <div class="contact-icon">
                                <i class="las la-place-of-worship"></i>
                            </div>
                            <div class="cont">
                                @lang('Send Message')
                            </div>
                        </h3>
                        <div class="progress progress--bar">
                            <div class="progress-bar bg--base progress-bar-striped progress-bar-animated"></div>
                        </div>
                    </div>
                    <form action="{{ route('contact') }}" method="POST" class="contact-form row">
                        @csrf
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="form--label">@lang('Name')</label>
                                <input type="text" name="name" id="name" class="form-control form--control"
                                    value="{{ auth()->user() ? auth()->user()->fullname : old('name') }}"
                                    @if (auth()->user()) readonly @endif required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email" class="form--label">@lang('Email')</label>
                                <input type="text" name="email" id="email" class="form-control form--control"
                                    value="{{ auth()->user() ? auth()->user()->email : old('email') }}"
                                    @if (auth()->user()) readonly @endif required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="subject" class="form--label">@lang('Subject')</label>
                                <input type="text" name="subject" id="subject" class="form-control form--control"
                                    value="{{ old('subject') }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="message" class="form--label">@lang('Message')</label>
                                <textarea name="message" id="message"
                                    class="form-control form--control">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group mb-0">
                                <button type="submit" class="cmn--btn w-100">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact -->

    @if ($sections != null)
        @foreach (json_decode($sections) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
