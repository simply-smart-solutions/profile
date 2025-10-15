@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form id="serviceUpdateForm" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="price" value="0">

                        <input type="hidden" name="id" value="{{ $service->id }}">

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="category" class="font-weight-bold">@lang('Category')</label>
                                    <select class="form-control" name="category_id" required>
                                        <option selected disabled>@lang('Select Category')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $service->category_id ? 'selected' : '' }}>
                                                {{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">@lang('Name')</label>
                                    <input type="text" name="name" id="name" value="{{ $service->name }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="thumbnail" class="font-weight-bold">@lang('Thumbnail') (500x370)</label>
                                    <div class="file-upload-wrapper" data-text="Select your image!">
                                        <input type="file" name="image" id="thumbnail" class="file-upload-field">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">@lang('Description')</label>
                                    <textarea class="form-control trumEdit " name="description" id="descripton" rows="3">@php echo $service->description @endphp</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="status" class="font-weight-bold">@lang('Status')?</label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="status"
                                            {{ $service->status ? 'checked' : null }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <div class="thumbnail-wrap mb-3">
                                    <h5 class="thumb-img-text">@lang('Thumbnail Image')</h5>
                                    <img class="thumb-img" src="{{ getImage(getFilePath('serviceImage').'/'. (@$service->image ?? ''))}}" alt="Image" class="rounded" style="width:100px;">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-end">
                                <button type="submit" class="btn btn--primary btn-global">@lang('Update')</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    {{-- remove modal --}}
    <div class="modal fade" id="imageRemoveBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Image Delete Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.service.image.delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to remove this image?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary"
                            data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.service.index') }}" class="btn btn-sm btn--primary ">@lang('Back')</a>
@endpush

@push('style')
    <style>
        .ck.ck-editor__main>.ck-editor__editable {
            min-height: 131px;
        }

        #loadingSpinnerWrapper {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            width: 100%;
            height: 100vh;
        }


        #loadingSpinner {
            position: relative;
            width: 60px;
            height: 60px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 2s linear infinite;
            z-index: 999999;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #spinnerPercentage {
            position: absolute;
            top: 52%;
            left: 51%;
            font-size: 14px;
            color: white;
        }
    </style>
@endpush



@push('script')
    <script>
        (function($) {
            "use strict";


            // image remove modal open
            $('.imageRemove').on('click', function() {
                var modal = $('#imageRemoveBy');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });



            // prodduct update
            $('#serviceUpdateForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                var loadingSpinnerWrapper = $('#loadingSpinnerWrapper');
                var loadingSpinner = $('#loadingSpinner');

                loadingSpinnerWrapper.fadeIn();
                loadingSpinner.css('opacity', '1');

                var xhr = new XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(event) {
                    if (event.lengthComputable) {

                    }
                });

                xhr.open("POST", "{{ route('admin.service.update') }}");

                // Success
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.hasOwnProperty('message')) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                        }

                        loadingSpinnerWrapper.fadeOut();

                        // redirect checkout page
                        window.location.href = '{{ route('admin.service.index') }}';

                    } else if (xhr.status === 422) {

                        loadingSpinnerWrapper.fadeOut();

                        var response = JSON.parse(xhr.responseText);
                        if (response.hasOwnProperty('errors')) {
                            var errors = response.errors;
                            var errorMessage = '';

                            Object.keys(errors).forEach(function(key) {
                                errorMessage = errors[key][0];
                            });

                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        }
                    } else {

                        if (xhr.status === 500) {
                            loadingSpinnerWrapper.fadeOut();
                            errorMessage = 'Service could not be update. Please try again later.';

                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        } else {
                            loadingSpinnerWrapper.fadeOut();
                            var errorMessage = 'Service could not be update. Please try again later.';
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        }
                    }
                };

                // Error
                xhr.onerror = function() {

                    loadingSpinnerWrapper.fadeOut();

                    var errorMessage = 'An error occurred during the request. Please try again later.';
                    Toast.fire({
                        icon: 'error',
                        title: errorMessage
                    });
                };

                xhr.send(formData);
            });



        })(jQuery);
    </script>
@endpush
