@extends($activeTemplate.'layouts.master')
@section('content')
<div class="ticket__wrapper bg--section">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <h6 class="ticket__wrapper-title mb-4 me-3">@lang('Create Tickets')</h6>
        <a href="{{ route('ticket') }}" class="cmn--btn mb-4">@lang('All Tickets')</a>
    </div>
    <div class="message__chatbox__body">
        <form action="{{route('ticket.store')}}" method="POST" enctype="multipart/form-data" onsubmit="return submitUserForm();" class="message__chatbox__form row">
            @csrf
            <div class="form--group col-sm-6">
                <label for="name" class="form--label-2">@lang('Name')</label>
                <input type="text" id="name" name="name" class="form-control form--control-2" value="{{ __(auth()->user()->fullname) }}" readonly>
            </div>
            <div class="form--group col-sm-6">
                <label for="email" class="form--label-2">@lang('Email')</label>
                <input type="text" id="email" name="email" class="form-control form--control-2" value="{{ auth()->user()->email }}" readonly>
            </div>
            <div class="form--group col-sm-12">
                <label for="subject" class="form--label-2">@lang('Subject')</label>
                <input type="text" id="subject" name="subject" class="form-control form--control-2" value="{{ old('subject') }}">
            </div>
            <div class="form--group col-sm-12">
                <label for="priority" class="form--label-2">@lang('Priority')</label>
                <select name="priority" id="priority" class="form-control form--control-2">
                    <option value="3">@lang('High')</option>
                    <option value="2">@lang('Medium')</option>
                    <option value="1">@lang('Low')</option>
                </select>
            </div>
            <div class="form--group col-sm-12">
                <label for="message" class="form--label-2">@lang('Message')</label>
                <textarea id="message" name="message" class="form-control form--control-2">{{ old('message') }}</textarea>
            </div>
            <div class="form--group col-sm-12">
                <div class="d-flex">
                    <div class="left-group col p-0">
                        <label for="inputAttachments" class="form--label-2">@lang('Attachments')</label>
                        <input type="file" class="overflow-hidden form-control form--control-2 mb-2" name="attachments[]" id="inputAttachments">
                        <div id="fileUploadsContainer"></div>
                        <span class="info fs--14">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')</span>
                    </div>
                    <div class="add-area">
                        <label class="form--label-2 d-block">&nbsp;</label>
                        <button class="cmn--btn btn--sm bg--primary ms-2 ms-md-4 form--control-2 addFile" type="button"><i class="las la-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="form--group col-sm-12 mb-0">
                <button type="submit" class="cmn--btn w-100">@lang('Submit')</button>
            </div>
        </form> 
    </div>
</div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="input-group mb-2">
                        <input type="file" class="overflow-hidden form-control form--control-2" name="attachments[]">
                        <span class="input-group-text btn btn-danger remove-btn d-flex align-item-center justify-content-center"><i class="las la-times"></i></span>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
