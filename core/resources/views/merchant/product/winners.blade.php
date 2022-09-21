@extends('merchant.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('User Name')</th>
                                    <th>@lang('Product Name')</th>
                                    <th>@lang('Winning Date')</th>
                                    <th>@lang('Product Delivered')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($winners as $winner)
                                    <tr>
                                        <td data-label="@lang('S.N')">{{ $winners->firstItem() + $loop->index }}</td>
                                        <td data-label="@lang('User Name')">{{ __($winner->user->fullname) }}</td>
                                        <td data-label="@lang('Product Name')"><a href="{{ route('product.details', [$winner->product->id, slug($winner->product->name)]) }}" target="_blank">{{ __($winner->product->name) }}</a></td>
                                        <td data-label="@lang('Winning Date')">{{ showDateTime($winner->created_at) }}</td>
                                        <td data-label="@lang('Product Delivered')">
                                            @if ($winner->product_delivered == 0)
                                                <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Delivered')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button type="button" class="icon-btn bid-details" data-toggle="tooltip" data-original-title="@lang('Details')" data-user="{{ $winner->user }}">
                                                <i class="las la-desktop text--shadow"></i>
                                            </button>
                                            <button type="button" class="icon-btn btn--success productDeliveredBtn" data-toggle="tooltip" data-original-title="@lang('Delivered')" data-id="{{ $winner->id }}" {{ $winner->product_delivered ? 'disabled' : '' }}>
                                                <i class="las la-check text--shadow"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($winners->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($winners) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- User information modal --}}
    <div id="bidModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('User Information')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Name'):
                                <span class="user-name"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Mobile'):
                                <span class="user-mobile"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Email'):
                                <span class="user-email"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Address'):
                                <span class="user-address"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('State'):
                                <span class="user-state"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Zip Code'):
                                <span class="user-zip"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('City'):
                                <span class="user-city"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Country'):
                                <span class="user-country"></span>
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" name="bid_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Delivered Confirmation --}}
    <div id="productDeliveredModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Product Delivered Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('merchant.bid.delivered') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Is the product delivered')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--success">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.bid-details').click(function() {
                var modal = $('#bidModal');
                var user = $(this).data().user;
                modal.find('.user-name').text(user.firstname + ' ' + user.lastname);
                modal.find('.user-mobile').text(user.mobile);
                modal.find('.user-email').text(user.email);
                modal.find('.user-address').text(user.address.address);
                modal.find('.user-state').text(user.address.state);
                modal.find('.user-zip').text(user.address.zip);
                modal.find('.user-city').text(user.address.city);
                modal.find('.user-country').text(user.address.country);
                modal.modal('show');
            });

            $('.productDeliveredBtn').click(function() {
                var modal = $('#productDeliveredModal');
                modal.find('[name=id]').val($(this).data('id'));
                modal.modal('show');

            });

            $('#bidModal').on('hidden.bs.modal', function() {
                $('#bidModal form')[0].reset();
            });


        })(jQuery);
    </script>
@endpush
