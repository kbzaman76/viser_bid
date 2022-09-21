@extends($activeTemplate.'layouts.frontend')
@php
    $email = getContent('reset_password_email.content', true);
@endphp
@section('content')
<div class="account-section bg_img" data-background="{{ getImage('assets/images/frontend/reset_password_email/'.$email->data_values->background_image, '1920x1080') }}">
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

                <div class="section__header text--white">
                    <h4 class="mb-0">@lang('Reset Password')</h4>
                </div>

                <form method="POST" action="{{ route('user.password.email')}}" class="account--form row g-4">
                    @csrf
                    <div class="col-sm-12">
                        <label for="type" class="form--label-2">@lang('Select One')</label>
                        <select name="type" id="type" class="form-control">
                            <option value="email">@lang('E-Mail Address')</option>
                            <option value="username">@lang('Username')</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="user" class="form--label-2 my_value"></label>
                        <input type="text" id="user" name="value" class="form-control @error('value') is-invalid @enderror" autocomplete="off" required>
                        @error('value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="cmn--btn w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>

    (function($){
        "use strict";

        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }
    })(jQuery)
</script>
@endpush
