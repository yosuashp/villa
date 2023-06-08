@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="custom--card">
                    <div class="card-header p-3">
                       <h6 class="d-inline">{{ __($pageTitle) }}</h6> 
                        <a href="{{route('ticket') }}" class="btn btn-sm btn--base float-end">
                            @lang('My Support Ticket')
                        </a>
                    </div>

                    <div class="card-body">
                        <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">@lang('Name')</label>
                                    <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form--control " placeholder="@lang('Enter your name')" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">@lang('Email address')</label>
                                    <input type="email"  name="email" value="{{@$user->email}}" class="form--control " placeholder="@lang('Enter your email')" readonly>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="website">@lang('Subject')</label>
                                    <input type="text" name="subject" value="{{old('subject')}}" class="form--control " placeholder="@lang('Subject')" >
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="priority">@lang('Priority')</label>
                                    <select name="priority" class="form--control ">
                                        <option value="3">@lang('High')</option>
                                        <option value="2">@lang('Medium')</option>
                                        <option value="1">@lang('Low')</option>
                                    </select>
                                </div>
                                <div class="col-12 form-group">
                                    <label for="inputMessage">@lang('Message')</label>
                                    <textarea name="message" id="inputMessage" rows="6" class="form--control ">{{old('message')}}</textarea>
                                </div>
                            </div>

                            <div class="row form-group ">
                                <div class="col-md-12 file-upload">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <label for="inputAttachments">@lang('Attachments')</label>
                                        <button type="button" class="addFile btn btn-sm btn--base mb-2">@lang('Add More Files')</button>
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="file" name="attachments[]" id="inputAttachments" class="form--control" />
                                    </div>
                                   
                                    <div id="fileUploadsContainer"></div>
                                    <p class="ticket-attachments-message text-muted">
                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                    </p>
                                </div>

                              
                            </div>

                            <div class="row form-group justify-content-center mb-0">
                                <div class="col-md-12">
                                    <button class="btn btn--base w-100" type="submit" id="recaptcha" ><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form--control" required />                       
                            <span class="input-group-text btn btn-danger support-btn remove-btn"><i class="fa fa-times"></i></span>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
