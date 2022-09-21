@extends('admin.layouts.app')
@section('panel')
<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Merchant Name')</label>
                                <input class="form-control form-control-lg" type="text" name="merchant_name" value="{{ @$general->merchant_profile->name }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Merchant Mobile')</label>
                                <input class="form-control form-control-lg" type="text" name="merchant_mobile" value="{{ @$general->merchant_profile->mobile }}">
                            </div>
                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Merchant Address')</label>
                                <input class="form-control form-control-lg" type="text" name="merchant_address" value="{{ @$general->merchant_profile->address }}">
                            </div>
                            
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            
                        </div>
                        <div class="col-xl-4 col-lg-6  col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Profile Image')</label>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['profile']['admin']['path'].'/'.@$general->merchant_profile->image, imagePath()['profile']['admin']['size']) }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload1" class="bg--success">@lang('Browse')</label>
                                            <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 400x400px') </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-6  col-md-8">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Cover Image')</label>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['profile']['admin_cover']['path'].'/'.@$general->merchant_profile->cover_image,imagePath()['profile']['admin_cover']['size']) }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="cover_image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload2" class="bg--success">@lang('Browse')</label>
                                            <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 1300x520px') </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</form>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush