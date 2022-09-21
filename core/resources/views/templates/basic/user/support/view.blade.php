@php
    $template = Auth::check() ? 'master' : 'frontend';
@endphp
@extends($activeTemplate.'layouts.'.$template)

@section('content')
<div class="{{ $template == 'frontend' ? 'container pt-120 pb-60':'' }}">
    <div class="ticket__wrapper bg--section">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <h6 class="banner__widget-title me-2">
                @if($my_ticket->status == 0)
                    <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                @elseif($my_ticket->status == 1)
                    <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                @elseif($my_ticket->status == 2)
                    <span class="badge badge--warning py-2 px-3">@lang('Replied')</span>
                @elseif($my_ticket->status == 3)
                    <span class="badge badge--dark py-2 px-3">@lang('Closed')</span>
                @endif
                <span>@lang('Ticket')</span>
                <span>#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}</span>
            </h6>
            <button class="btn btn-danger close-button" type="button" title="@lang('Close Ticket')" data-bs-toggle="modal" data-bs-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i>
            </button>
        </div>
        <div class="message__chatbox__body">
            @if($my_ticket->status != 3)
                <form action="{{ route('ticket.reply', $my_ticket->id) }}" method="POST" enctype="multipart/form-data" class="message__chatbox__form row">
                    @csrf
                    <input type="hidden" name="replayTicket" value="1">
                    <div class="form--group col-sm-12">
                        <label for="message" class="form--label-2">@lang('Message')</label>
                        <textarea id="message" name="message" class="form-control form--control-2">{{ old('message') }}</textarea>
                    </div>
                    <div class="form--group col-sm-12">
                        <div class="d-flex">
                            <div class="left-group col p-0">
                                <label for="file2" class="form--label-2">@lang('Attachments')</label>
                                <input type="file" class="overflow-hidden form-control form--control-2 mb-2" name="attachments[]" id="file2">
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
                        <button type="submit" class="cmn--btn w-100">@lang('Reply')</button>
                    </div>
                </form>
            @endif
        </div>
    </div>


    <div class="ticket__wrapper bg--section mt-5">
        <div class="message__chatbox__body">
            <ul class="reply-message-area">
                <li>
                    @foreach ($messages as $message)
                        @if ($message->admin_id == 0)
                        <div class="reply-item bg--section">
                            <div class="name-area">
                                <div class="reply-thumb">
                                    @php
                                        $image = auth()->check() ? auth()->user()->image : '';
                                    @endphp
                                    <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$image, null, true) }}" alt="user">
                                </div>
                                <h6 class="title">{{ $message->ticket->name }}</h6>
                            </div>
                            <div class="content-area">
                                <span class="meta-date">
                                    @lang('Posted on') , {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                </span>
                                <p>{{ $message->message }}</p>
                                @if($message->attachments()->count() > 0)
                                    <div class="mt-2">
                                        @foreach($message->attachments as $k=> $image)
                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @else
                            <ul>
                                <li>
                                    <div class="reply-item bg--section">
                                        <div class="name-area">
                                            <div class="reply-thumb">
                                                <img src="{{ getImage(imagePath()['profile']['admin']['path'].'/'.$message->admin->image, null, true) }}" alt="user">
                                            </div>
                                            <h6 class="title">{{ $message->admin->name }}</h6>
                                        </div>
                                        <div class="content-area">
                                            <span class="meta-date">
                                                @lang('Posted on') , {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                            </span>
                                            <p>{{ $message->message }}</p>
                                            @if($message->attachments()->count() > 0)
                                                <div class="mt-2">
                                                    @foreach($message->attachments as $k=> $image)
                                                        <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    @endforeach
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('modal')
<div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                @csrf
                <input type="hidden" name="replayTicket" value="2">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Confirmation')!</h5>
                    <button type="button" class="btn text--danger modal-close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h6>@lang('Are you sure you want to close this support ticket')?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal">
                        @lang('No')
                    </button>
                    <button type="submit" class="btn btn--base btn-sm"><i class="fa fa-check"></i> @lang("Yes")
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="input-group mb-2">
                        <input type="file" class="overflow-hidden form-control form--control-2" name="attachments[]">
                        <span class="input-group-text btn btn-danger remove-btn d-flex align-item-center justify-content-center"><i class="las la-times"></i></span>
                    </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);

    </script>
@endpush
