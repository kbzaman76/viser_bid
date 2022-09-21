@extends('admin.layouts.app')
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
                                <th>@lang('Icon')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Products')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td data-label="@lang('S.N')">{{ $categories->firstItem() + $loop->index }}</td>
                                <td data-label="@lang('Icon')">@php echo $category->icon; @endphp</td>
                                <td data-label="@lang('Name')">{{ __($category->name) }}</td>
                                <td data-label="@lang('Products')">{{ $category->products->count() }}</td>
                                <td data-label="@lang('Status')">
                                    @if($category->status == 1)
                                        <span class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                    @else
                                        <span class="text--small badge font-weight-normal badge--warning">@lang('Inactive')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <button type="button" class="icon-btn editCategory" data-id="{{ $category->id }}" data-name="{{ __($category->name) }}" data-icon="{{ $category->icon }}" data-status="{{ $category->status }}" data-toggle="tooltip"  data-original-title="@lang('Edit')">
                                        <i class="las la-pen text-shadow"></i>
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
                @if($categories->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($categories) }}
                </div>
                @endif
            </div>
        </div>
    </div>

{{-- Category modal --}}
<div id="categoryModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.category.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Name')<span class="text-danger">*</span></label>
                        <div class="input-group has_append">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('Icon')<span class="text-danger">*</span></label>
                        <div class="input-group has_append">
                            <input type="text" class="form-control icon" name="icon" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group statusGroup">
                        <label>@lang('Status')</label>
                        <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" data-width="100%" name="status">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn--primary box--shadow1 text--small addCategory"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            var modal   = $('#categoryModal');
            var action  = `{{ route('admin.category.store') }}`;

            $('.addCategory').click(function(){
                modal.find('.modal-title').text("@lang('Add Category')");
                modal.find('.statusGroup').hide();
                modal.find('form').attr('action', action);
                modal.modal('show');
            });

            modal.on('shown.bs.modal', function (e) {
                $(document).off('focusin.modal');
            });

            $('.editCategory').click(function () {
                var data = $(this).data();
                modal.find('.modal-title').text("@lang('Update Category')");
                modal.find('.statusGroup').show();
                modal.find('[name=name]').val(data.name);
                modal.find('[name=icon]').val(data.icon);

                if(data.status == 1){
                    modal.find('input[name=status]').bootstrapToggle('on');
                }else{
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                modal.find('form').attr('action', `${action}/${data.id}`);
                modal.modal('show');
            })

            modal.on('hidden.bs.modal', function () {
                modal.find('form')[0].reset();
            });

            $('.iconPicker').iconpicker().on('change', function (e) {
                $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
            });

        })(jQuery);
    </script>
@endpush
