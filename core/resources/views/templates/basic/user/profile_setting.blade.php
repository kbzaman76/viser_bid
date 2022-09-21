@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ticket__wrapper bg--section">
    <div class="profile-wrapper">
        <form action="" method="post" enctype="multipart/form-data" class="row mb--25">
            @csrf
            <div class="profile-user mb-xl-0">
                <div class="thumb">
                    <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image, imagePath()['profile']['user']['size']) }}"
                        alt="user">
                </div>
                <div class="content">
                    <h6 class="title">@lang('Name'): {{ __($user->fullname) }}</h6>
                    <span class="subtitle">@lang('Username'): {{ __($user->username) }}</span>
                    <div class="mt-4">
                        <label class="btn btn--primary" for="profile-image">@lang('Update Profile Picture')</label>
                        <input type="file" name="image" class="form-control form--control" id="profile-image" hidden>
                    </div>
                </div>
                <div class="remove-image">
                    <i class="las la-times"></i>
                </div>
            </div>
            <div class="profile-form-area row">
                <div class="form--group col-md-6">
                    <label class="form--label-2" for="first-name">@lang('First Name')</label>
                    <input type="text" class="form-control form--control-2" name="firstname" id="first-name" value="{{ auth()->user()->firstname }}">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label-2" for="last-name">@lang('Last Name')</label>
                    <input type="text" class="form-control form--control-2" name="lastname" id="last-name" value="{{ auth()->user()->lastname }}">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label-2" for="email">@lang('Email')</label>
                    <input type="text" class="form-control form--control-2" id="email" value="{{ auth()->user()->email }}" readonly>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label-2" for="mobile">@lang('Mobile')</label>
                    <input type="text" class="form-control form--control-2" id="mobile" value="{{ auth()->user()->mobile }}" readonly>
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label-2" for="address">@lang('Address')</label>
                    <input type="text" class="form-control form--control-2" id="address" name="address" value="{{ auth()->user()->address->address }}">
                </div>
                <div class="form--group col-md-6">
                    <label class="form--label-2" for="state">@lang('State')</label>
                    <input type="text" class="form-control form--control-2" id="state" name="state" value="{{ auth()->user()->address->state }}">
                </div>
                <div class="form--group col-md-4">
                    <label class="form--label-2" for="city">@lang('Zip Code')</label>
                    <input type="text" class="form-control form--control-2" id="city" name="zip" value="{{ auth()->user()->address->zip }}">
                </div>
                <div class="form--group col-md-4">
                    <label class="form--label-2" for="city">@lang('City')</label>
                    <input type="text" class="form-control form--control-2" id="city" name="city" value="{{ auth()->user()->address->city }}">
                </div>
                <div class="form--group col-md-4">
                    <label class="form--label-2" for="country">@lang('Country')</label>
                    <input type="text" class="form-control form--control-2" id="country" value="{{ auth()->user()->address->country }}" readonly>
                </div>
                <div class="form--group w-100 col-md-6 mb-0 text-end">
                    <button type="submit" class="cmn--btn">@lang('Update Profile')</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        var prevImg = $('.profile-user .thumb').html();
        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $('.profile-user').find('.thumb');
                    preview.html(`<img src="${e.target.result}" alt="user">`);
                    preview.addClass('has-image');
                    preview.hide();
                    preview.fadeIn(650);
                    $(".remove-image").show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#profile-image").on('change', function() {
            proPicURL(this);
        });

        $(".remove-image").on('click', function() {
            $(".profile-user .thumb").html(prevImg);
            $(".profile-user .thumb").removeClass('has-image');
            $(this).hide();
        })

    })(jQuery);
</script>
@endpush
