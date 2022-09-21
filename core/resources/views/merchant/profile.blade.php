@extends('merchant.layouts.app')

@section('panel')
    <form action="{{ route('merchant.profile.update') }}" method="POST" enctype="multipart/form-data">
        <div class="row mb-none-30">
            @csrf
            <div class="col-xl-3 col-lg-4 col-md-5 mb-30">
                <div class="card b-radius--5 overflow-hidden mb-4">
                    <div class="card-body p-0">
                        <div class="form-group">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"
                                            style="background-image: url({{ getImage(imagePath()['profile']['merchant']['path'] .'/' .auth()->guard('merchant')->user()->image,imagePath()['profile']['merchant']['size']) }})">
                                            <button type="button" class="remove-image"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit px-2">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1"
                                            accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload1" class="bg--success">@lang('Upload Profile
                                            Photo')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'),
                                                @lang('jpg').</b> @lang('Image will be resized into 400x400px') </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card b-radius--5 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="d-flex p-3 bg--primary align-items-center">
                            <div class="pl-3">
                                <h4 class="text--white">{{ __($merchant->fullname) }}</h4>
                            </div>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Name')
                                <span class="font-weight-bold">{{ __($merchant->fullname) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Username')
                                <span class="font-weight-bold">{{ __($merchant->username) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Email')
                                <span class="font-weight-bold">{{ $merchant->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Mobile')
                                <span class="font-weight-bold">{{ $merchant->mobile }}</span>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>

            <div class="col-xl-9 col-lg-8 col-md-7 mb-30">
                <div class="card b-radius--5 overflow-hidden mb-4">
                    <div class="card-body p-0">
                        <div class="form-group">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"
                                            style="background-image: url({{ getImage(imagePath()['profile']['merchant_cover']['path'] .'/' .auth()->guard('merchant')->user()->cover_image,imagePath()['profile']['merchant_cover']['size']) }})">
                                            <button type="button" class="remove-image"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit px-2">
                                        <input type="file" class="profilePicUpload" name="cover_image" id="profilePicUpload2"
                                            accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload2" class="bg--success">@lang('Upload Cover
                                            Photo')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'),
                                                @lang('jpg').</b> @lang('Image will be resized into 400x400px') </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">@lang('Profile Information')</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname"
                                        value="{{ $merchant->firstname }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname"
                                        value="{{ $merchant->lastname }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Email')</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ $merchant->email }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Mobile')</label>
                                    <input class="form-control" type="text" name="mobile"
                                        value="{{ $merchant->mobile }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Address')</label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ @$merchant->address->address }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('State')</label>
                                    <input class="form-control" type="text" name="state"
                                        value="{{ @$merchant->address->state }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Zip')</label>
                                    <input class="form-control" type="number" min="0" name="zip"
                                        value="{{ @$merchant->address->zip }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('City')</label>
                                    <input class="form-control" type="text" name="city"
                                        value="{{ @$merchant->address->city }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Country')</label>
                                    <input class="form-control" type="text" name="country"
                                        value="{{ @$merchant->address->country }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5 class="card-title mb-1">@lang('Social Links')</h5>
                                <div class="socials-wrapper">
                                    @if ($merchant->social_links)
                                        @foreach ($merchant->social_links as $social_link)
                                            <div class="socials" style="">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="social_links[{{ $loop->iteration }}][name]"
                                                                value="{{ $social_link['name'] }}">
                                                        </div>
                                                    </div>
                            
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="input-group has_append">
                                                                <input type="text" class="form-control icon" name="social_links[{{ $loop->iteration }}][icon]" value="{{ $social_link['icon'] }}" required>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                            
                                                    <div class="col-md-5">
                                                        <div class="input-group abs-form-group d-flex justify-content-between flex-wrap">
                                                            <input type="text" class="form-control icon" name="social_links[{{ $loop->iteration }}][link]" value="{{ $social_link['link'] }}">
                                                            <button type="button"
                                                                class="btn btn-outline--danger remove-social abs-button ml-4"><i
                                                                    class="la la-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-outline--success add-social "><i
                                                    class="la la-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('merchant.change.password') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i
            class="fa fa-key"></i>@lang('Change Password')</a>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            var count = `{{ $merchant->social_links ? count($merchant->social_links) : 0 }}`;
            count = parseInt(count);
            count = count ? count + 1 : 1;

            $('.add-social').on('click',function(){
              var html = `
               <div class="socials" style="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="social_links[${count}][name]"
                                    placeholder="@lang('Type Name Here')" required>
                            </div>
                        </div>

                        <div class="col-md-4">      
                            <div class="form-group ">
                                <div class="input-group has_append">
                                    <input type="text" class="form-control icon-name" name="social_links[${count}][icon]" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="input-group abs-form-group d-flex justify-content-between flex-wrap">
                                <input type="text" class="form-control" name="social_links[${count}][link]"
                                    placeholder="@lang('Type Link Here')" required>
                                <button type="button" class="btn btn-outline--danger remove-social abs-button ml-4"><i
                                        class="la la-minus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
               `;
               $('.socials-wrapper').append(html);
               count += 1;
               $(document).find('.iconPicker').iconpicker();
            });

            $(document).on('click', '.remove-social', function () {
                $(this).closest('.socials').remove();
            });

            

            $(document).on('change','.iconPicker' ,function (e) {
                    $(this).parent().siblings('.icon-name').val(`<i class="${e.icon}"></i>`);
            });

        })(jQuery);
    </script>
@endpush

