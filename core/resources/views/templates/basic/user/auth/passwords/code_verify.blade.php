@extends($activeTemplate.'layouts.frontend')
@php
    $codeVerify = getContent('code_verify.content', true);
@endphp
@section('content')

<div class="account-section bg_img" data-background="{{ getImage('assets/images/frontend/code_verify/'.$codeVerify->data_values->background_image, '1920x1080') }}">
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
                    <h4 class="mb-0">@lang('Verify Code')</h4>
                </div>

                <form method="POST" action="{{ route('user.password.verify.code')}}" class="account--form g-4">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="mb-3">
                        <label for="code">@lang('Verification Code')</label>
                        <input type="text" id="code" name="code" class="form-control" autocomplete="off" required>
                    </div>

                    <button type="submit" class="cmn--btn w-100">@lang('Submit')</button>

                </form>
                <div class="mt-3">
                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                    <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try again')</a>
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
