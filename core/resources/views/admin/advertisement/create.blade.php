@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-5">
                    <form action="{{ route('admin.currency.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row ">
                            <div class="col-lg-2">
                                <div class="form-group mt-2">
                                    <div class="payment-method-item">
                                        <div class="payment-method-header">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <label for="">@lang('Currency Image') <strong
                                                            class="text-danger">*</strong> </label>
                                                    <div class="profilePicPreview"
                                                        style="background-image: url('{{ getImage(imagePath()['currency']['path'], imagePath()['currency']['size']) }}')">
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" name="image" class="profilePicUpload" id="image"
                                                        accept=".png, .jpg, .jpeg">
                                                    <label for="image" class="bg--primary"><i
                                                            class="la la-pencil"></i></label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">@lang("Name") <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" value="{{old('name')}}" class="form-control" name="name" title="name"
                                                placeholder="@lang('Enter Currency Name')">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">@lang("Symbol") <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" value="{{old('symbol')}}" class="form-control" name="symbol" title="symbol"
                                                placeholder="@lang('Symbol')">
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">@lang('Price') <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" value="{{old('price')}}" class="form-control" name="price"
                                                placeholder="@lang('Parcent Change 24 Hours')">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">@lang('Price Change Percent 24 Hours') <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" value="{{old('percent_change_24h')}}" class="form-control" name="percent_change_24h"
                                                placeholder="@lang('Parcent Change 24 Hours')">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">@lang('Price Change Percent 7 Days') <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" name="percent_change_7d"
                                                placeholder="@lang('Pricing Chaning Percent In Last 7days')" value="{{old('percent_change_7d')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">@lang('Market Cap') <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" name="market_cap" value="{{old('market_cap')}}"
                                                placeholder="@lang('Market Cap')">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">@lang('Volume 24 Hours') <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" name="volume_24h"
                                                placeholder="@lang('Volume 24 Hours')" value="{{old('volume_24h')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="btn btn--primary btn-block">@lang("Create")</button>
                                  </div>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>


    </div>




@endsection


@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" href="{{ route('admin.currency.create') }}"><i
            class="la la-backward"></i>@lang('Back')</a>
@endpush





{{-- @push('script')
    <script>
        (function($) {

            ///=======open modal=========
            $(".editBtn").on('click', function(e) {
                let url = $(this).data('url');
                let currency = JSON.parse($(this).attr('data-currency'));

                let modal = $("#createModal");
                modal.find('form').attr('action', url);
                modal.find("#createModalLabel").text("Edit currency:" + currency.name)
                modal.find("#btn-save").text("Update");

                modal.find('input[name=name]').val(currency.name);
                modal.modal('show');


            });

            $("#createBtn").on('click', function(e) {
                let modal = $("#createModal");
                modal.find("#createModalLabel").text("Create currency");
                let btnText = "@lang('Save')";
                modal.find("#btn-save").text(btnText);
                modal.modal('show');


            })





        })(jQuery);
    </script>
@endpush --}}
