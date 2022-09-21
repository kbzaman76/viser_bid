@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two custom-data-table" id="table">

                            <thead>
                                <tr>

                                    <th>@lang('Type')</th>
                                    <th>@lang('Value')</th>
                                    <th>@lang('Size')</th>
                                    <th>@lang('Impression')</th>
                                    <th>@lang('Click')</th>
                                    <th>@lang('Redirect')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($advertisements as $k=> $advertisement)
                                    <tr id={{ 'row_' . $advertisement->id }}>


                                        <td data-label="@lang('type')">
                                            {{ __(@$advertisement->type) }}
                                        </td>
                                        <td data-label="@lang('value')">

                                            @if (@$advertisement->type == 'image')
                                                <img id="image__{{ $advertisement->id }}"
                                                    src="{{ getImage(imagePath()['advertisement']['path'] . '/' . @$advertisement->value) }}"
                                                    alt="" class="max-w-50">
                                            @else
                                                <span class="badge badge--primary">@lang('Script')</span>
                                            @endif
                                            {{ __(@$advertisement->symbol) }}
                                        </td>

                                        <td data-label="@lang('size')">
                                            {{ __(@$advertisement->size) }}
                                        </td>
                                        <td data-label="@lang('Impression')">

                                            <span class="badge badge--success"> {{ @$advertisement->impression }}</span>

                                        </td>
                                        <td data-label="@lang('click')">

                                            <span class="badge badge--primary">
                                                {{ @$advertisement->click }}
                                            </span>
                                        </td>
                                        <td data-label="@lang('redirect')">

                                            <a target="_blank" href="{{ @$advertisement->redirect_url }}">
                                                {{ @$advertisement->redirect_url }}
                                            </a>

                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($advertisement->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @else
                                                <span class="text--small badge font-weight-normal badge--warning">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button
                                                data-advertisement="{{ json_encode($advertisement->only('id', 'type', 'value', 'size', 'redirect_url', 'status')) }}"
                                                class="icon-btn ml-1 editBtn">
                                                <i class="la la-edit"></i>
                                            </button>
                                            <button class="icon-btn btn--danger deleteBtn" data-id="{{ $advertisement->id }}"><i class="la la-trash"></i></button>
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
                @if ($advertisements->hasPages())    
                    <div class="card-footer py-4">
                        {{ paginateLinks($advertisements) }}
                    </div>
                @endif
            </div>
        </div>
    </div>


{{-- ========Create Modal========= --}}
<div class="modal   fade " id="modal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="modalLabel"> @lang('Add Advertisement')</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
        </div>
        <form class="form-horizontal" method="post" action="{{ route('admin.advertisement.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Advertisement Type') <span
                                    class="text-danger">*</span></label>
                            <select class="form-control" id="__type" name="type">
                                <option value="" selected disabled>@lang('---Please Select One -----')</option>
                                <option value="image">@lang('Image')</option>
                                <option value="script">@lang('Script')</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="image-size">
                                <label for="" class="font-weight-bold">@lang('Size') <strong
                                        class="text-danger">*</strong></label>
                                <select class="form-control" id="__size" name="size">
                                    <option value="" selected>@lang('---Please Select One ----')</option>
                                    <option value="370x670">@lang('370X670')</option>
                                    <option value="300x250">@lang('300x250')</option>
                                    <option value="780x80">@lang('780x80')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="__image">
                        <div class="form-group">

                            <div class="image-upload mt-3">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <label for="" class="font-weight-bold">@lang('Image') <strong
                                                class="text-danger">*</strong></label>
                                        <div class="profilePicPreview" style="background-position: center;">
                                            <button type="button" class="remove-image"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" size-validation="" class="profilePicUpload d-none"
                                            name="image" id="imageUpload" accept=".png, .jpg, .jpeg, .gif">
                                        <label for="imageUpload" class="bg--primary mt-3">@lang('Upload
                                            Image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'):
                                            <b>@lang('jpeg,jpg,png,gif') <span id="__image_size"></span></b>

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">@lang('Redirect Url') <strong
                                    class="text-danger">*</strong> </label>
                            <input type="text" class="form-control" name="redirect_url"
                                placeholder="@lang('Redirect Url')">
                        </div>
                    </div>
                    <div class="col-lg-12" id="__script">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">@lang('Script') <strong
                                    class="text-danger">*</strong> </label>
                            <textarea name="script" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group statusGroup">
                            <label class="font-weight-bold">@lang('Status')</label>
                            <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" data-width="100%" name="status">
                        </div>
                    </div>
                
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn--primary btn-block" id="btn-save" value="add">@lang('Submit')</button>
            </div>
        </form>
    </div>
    </div>
</div>

{{-- DELETE MODAL --}}
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Delete Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.advertisement.delete')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to') <span class="font-weight-bold">@lang('delete')</span> @lang('this advertisement') <span class="font-weight-bold withdraw-user"></span>?</p>
                </div>
                <input type="hidden" name="advertisement_id">
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small __advertisement" href="#"><i
            class="fa fa-fw fa-plus"></i>@lang('New Advertisement')</a>
@endpush




@push('style')
    <style>
        #__script,
        #__image {
            display: none;
        }
        .max-w-50 {
            max-width: 50px !important;
        }
        .image-upload .thumb .profilePicPreview {
            max-width: 100%;
        }

    </style>
@endpush


@push('script')
    <script>
        (function($) {

            ///=======open modal=========
            $(".__advertisement").on('click', function(e) {

                let modal = $("#modal");
                modal.find("#modalLabel").text("@lang('Add Advertisement')")
                $(modal).find('#__image').css('display', 'none');
                $(modal).find('#__script').css('display', 'none');
                $(modal).find('#btn-save').text("@lang('Submit')");
                modal.find('.statusGroup').hide();
                modal.modal('show');

            });


            $(document).on('change', '#__type', function(e) {

                let value = $(this).val();
                if (value == 'script') {
                    $(document).find('#__image').css('display', 'none');
                    $(document).find('#__script').css('display', 'block');
                } else {
                    $(document).find('#__script').css('display', 'none');

                }

            });


            $(document).on('change', '#__size', function(e) {

                let size = $(this);
                let type = $("#__type").val();
                if (type == null || type.length <= 0) {
                    alert("@lang('Please Type Select First')")
                    $("#__type").focus();
                    size.val(" ");
                    return;
                }

                if (type == "image") {
                    let placeholderImageUrl = `{{ route('placeholder.image', ':size') }}`;
                    $(document).find('.image-upload').css('display', 'block')
                    $(document).find('.profilePicPreview').css('background-image',
                        `url(${placeholderImageUrl.replace(':size',size.val())})`)
                    $(document).find('#__image_size').text(`, Upload Image Size Must Be ${size} px`);
                    $(document).find("#imageUpload").attr('size-validation', size.val())
                    changeImagePreview()
                }

            });

            $(document).on('click', '.editBtn', function(e) {

                let advertisement = JSON.parse($(this).attr('data-advertisement'));
                let modal = $("#modal");
                let action = "{{ route('admin.advertisement.update', ':id') }}";
                $(modal).find('#__size').val(advertisement.size || "")
                modal.find("#__type").val(advertisement.type)

                if (advertisement.type == "image") {
                    let imageSrc = $(document).find("#image__" + advertisement.id).attr('src');

                    $(modal).find('.profilePicPreview').css('background-image', `url(${imageSrc})`)
                    $(modal).find('.image-upload').css('display', 'block')

                    modal.find('textarea[name=script]').text("");
                    changeImagePreview()

                } else {
                    $(document).find('#__image').css('display', 'none');
                    $(document).find('#__script').css('display', 'block');
                    modal.find('textarea[name=script]').text(advertisement.value);
                    $(modal).find('.profilePicPreview').css('background-image', `url("")`)


                }


                modal.find('form').attr('action', action.replace(":id", advertisement.id));
                modal.find('input[name=redirect_url]').val(advertisement.redirect_url);


                modal.find("#modalLabel").text("@lang('Edit Advertisement')")
                $(modal).find('#btn-save').text("@lang('Update')");
                modal.find('.statusGroup').show();

                if(advertisement.status == 1){
                    modal.find('input[name=status]').bootstrapToggle('on');
                }else{
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                modal.modal('show');
            });


            $(document).on('click', '.deleteBtn', function(e) {

                var modal = $('#deleteModal');
                $('input[name="advertisement_id"]').val($(this).data('id'));
                modal.modal('show');
            });

            function changeImagePreview() {


                let selectSize = $(document).find("#__size").val()

                let size = selectSize.split('x');

                $(document).find('#__image').css('display', 'block');
                $(document).find('#__script').css('display', 'none');

                $(document).find(".profilePicPreview").css({
                    'width': `${size[0]}px`,
                    'height': `${size[1]}px`
                })
            }


        })(jQuery);
    </script>
@endpush
