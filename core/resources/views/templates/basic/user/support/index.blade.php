@extends($activeTemplate.'layouts.master')

@section('content')
<table class="table cmn--table">
    <thead>
    <tr>
        <th scope="col">@lang('Subject')</th>
        <th scope="col">@lang('Status')</th>
        <th scope="col">@lang('Priority')</th>
        <th scope="col">@lang('Last Reply')</th>
        <th scope="col">@lang('Action')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($supports as $key => $support)
        <tr>
            <td data-label="@lang('Subject')"><a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
            <td data-label="@lang('Status')">
                <div>
                    @if($support->status == 0)
                        <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                    @elseif($support->status == 1)
                        <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                    @elseif($support->status == 2)
                        <span class="badge badge--warning py-2 px-3">@lang('Customer Reply')</span>
                    @elseif($support->status == 3)
                        <span class="badge badge--dark py-2 px-3">@lang('Closed')</span>
                    @endif
                </div>
            </td>
            <td data-label="@lang('Priority')">
                <div>
                    @if($support->priority == 1)
                        <span class="badge badge--dark py-2 px-3">@lang('Low')</span>
                    @elseif($support->priority == 2)
                        <span class="badge badge--success py-2 px-3">@lang('Medium')</span>
                    @elseif($support->priority == 3)
                        <span class="badge badge--primary py-2 px-3">@lang('High')</span>
                    @endif
                </div>
            </td>
            <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }}</td>
        
            <td data-label="@lang('Action')">
                <div>
                    <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn-sm btn--base">
                        <i class="fa fa-desktop"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection
