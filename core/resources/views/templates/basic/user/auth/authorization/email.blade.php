@extends($activeTemplate .'layouts.frontend')
@php
    $emailVerify = getContent('email_verify.content', true);
@endphp
@section('content')
<div class="account-section bg_img" data-background="{{ getImage('assets/images/frontend/email_verify/'.$emailVerify->data_values->background_image, '1920x1080') }}">
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
                    <h6 class="mb-0">@lang('Verify Your Email'): {{auth()->user()->email}}</h6>
                </div>
                <form method="POST" action="{{ route('user.verify.email')}}" class="account--form g-4">
                    @csrf
                    <div class="mb-3">
                        <label for="code" class="form--label-2">@lang('Verification Code')</label>
                        <input type="text" id="code" name="email_verified_code" value="{{ old('email_verified_code') }}" class="form-control"  maxlength="7" autocomplete="off">
                    </div>
                    <button type="submit" class="cmn--btn w-100">@lang('Submit')</button>
                </form>

                <div class="mt-4 text-center text--white">
                    @lang('Please check including your Junk/Spam Folder. if not found, you can') <a href="{{route('user.send.verify.code')}}?type=email" class="forget-pass text--base"> @lang('Resend code')</a>
                    @if ($errors->has('resend'))
                        <br/>
                        <small class="text-danger">{{ $errors->first('resend') }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function($){
        "use strict";
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;

              $(this).val(function (index, value) {
                 value = value.substr(0,7);
                  return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
              });

      });
    })(jQuery)
</script>
@endpush
