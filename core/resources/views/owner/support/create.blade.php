@extends('owner.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card">              
            <div class="card-body">
                <form  action="{{route('owner.ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name" class="w-100" >@lang('Name') <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{@$owner->firstname . ' '.@$owner->lastname}}" class="form-control" placeholder="@lang('Enter your name')" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="w-100">@lang('Email address')  <span class="text-danger">*</span></label>
                            <input type="email"  name="email" value="{{@$owner->email}}" class="form-control" placeholder="@lang('Enter your email')" readonly>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="website" class="w-100">@lang('Subject') <span class="text-danger">*</span></label>
                            <input type="text" name="subject" value="{{old('subject')}}" class="form-control" placeholder="@lang('Subject')" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="priority" class="w-100">@lang('Priority') <span class="text-danger">*</span></label>
                            <select name="priority" class="form-control">
                                <option value="">@lang('Select One')</option>
                                <option value="3">@lang('High')</option>
                                <option value="2">@lang('Medium')</option>
                                <option value="1">@lang('Low')</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label for="inputMessage" class="w-100">@lang('Message') <span class="text-danger">*</span></label>
                            <textarea name="message" id="inputMessage" rows="6" class="form-control">{{old('message')}}</textarea>
                        </div>
                    </div>

                    <div class="row form-group ">
                        <div class="col-md-12 file-upload">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <label for="inputAttachments">@lang('Attachments')</label>
                                <button type="button" class="addFile btn btn-sm btn--success mb-2">@lang('Add More Files')</button>
                            </div>
                            <div class="input-group mb-2">
                                <input type="file" name="attachments[]" id="inputAttachments" class="form-control" />
                            </div>
                           
                            <div id="fileUploadsContainer"></div>
                            <p class="ticket-attachments-message text-muted">
                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                            </p>
                        </div>
                    </div>
                    <div class="row form-group justify-content-center">
                        <div class="col-md-12">
                            <button class="btn btn--primary btn-block" type="submit" id="recaptcha" >@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- card end -->
    </div>
</div>
@endsection

@push('style')
    <style>
        .input-group-append{
            cursor: default;
        }
        input[type="file"] {
            padding: 5px 10px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control" required />  
                        <div class="input-group-append">
                            <span class="input-group-text icon-btn btn--danger support-btn remove-btn"><i class="fa fa-times"></i></span>
                        </div>                     
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
