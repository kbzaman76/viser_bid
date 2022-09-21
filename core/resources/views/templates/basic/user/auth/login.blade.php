@extends($activeTemplate.'layouts.frontend')
@php
$login = getContent('login.content', true);
@endphp
@section('content')
    <div class="account-section bg_img"
        data-background="{{ getImage('assets/images/frontend/login/' . $login->data_values->background_image, '1920x1080') }}">
        <div class="account__section-wrapper">
            <div class="account__section-content bg--section">
                <div class="w-100">
                    <div class="d-flex justify-content-center">
                        <div class="logo mb-5">
                            <a href="{{ route('home') }}" class="text-center" >
                                <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="logo">
                            </a>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('user.login') }}" onsubmit="return submitUserForm();"
                        class="account--form g-4">
                        @csrf
                        <div class="mb-3">
                            <label for="name">@lang('Username') / @lang('Email')</label>
                            <input type="text" id="name" name="username" value="{{ old('username') }}" class="form-control" autocomplete="off" required>
                        </div>

                        <div class="mb-3">
                            <label for="password">@lang('Password')</label>
                            <input type="password" id="password" name="password" class="form-control" autocomplete="off" required>
                        </div>

                        @php $recaptcha = loadReCaptcha() @endphp

                        @if($recaptcha)
                            <div class="mb-3">
                                @php echo $recaptcha @endphp
                            </div>
                        @endif

                        @include($activeTemplate . 'partials.custom_captcha')

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label fs--14px" for="remember">
                                        @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check ps-0 text-right">
                                    <a href="{{ route('user.password.request') }}" class="fs--14px text--base">@lang('Forgot password?')</a>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="cmn--btn w-100">@lang('Sign In')</button>
                    </form>

                    <div class="mt-5 text-center text--white">
                        @lang('Don\'t have an Account ?') <a href="{{ route('user.register') }}"
                            class="text--base">@lang('Create New')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
