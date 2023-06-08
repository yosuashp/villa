@extends('owner.layouts.app')

@section('panel')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center">
                        <h6 class="card-title mt-0">
                            @if($my_ticket->status == 0)
                                <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                            @elseif($my_ticket->status == 1)
                                <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                            @elseif($my_ticket->status == 2)
                                <span class="badge badge--warning py-2 px-3">@lang('Replied')</span>
                            @elseif($my_ticket->status == 3)
                                <span class="badge badge--dark py-2 px-3">@lang('Closed')</span>
                            @endif
                            [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                        </h6>
                        <button class="btn btn-danger close-button" type="button" title="@lang('Close Ticket')" data-toggle="modal" data-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        @if($my_ticket->status != 4)
                                            <form method="post" action="{{ route('owner.ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="replayTicket" value="1">
                                                <div class="row justify-content-between">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea name="message" class="form-control form-control-lg" id="inputMessage" placeholder="@lang('Your Reply')" rows="4" cols="10"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col-md-12">
                                                        <div class="row justify-content-between">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                                        <label for="inputAttachments">@lang('Attachments')</label>
                                                                        <button type="button" class="addFile btn btn-sm btn--success mb-2">@lang('Add More Files')</button>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <input type="file" name="attachments[]" id="inputAttachments" class="form-control"/>
                                                                    </div>
                                                                    <div id="fileUploadsContainer"></div>
                                                                    <p class="my-2 ticket-attachments-message text-muted">
                                                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn--primary mt-4 btn-block">
                                                            <i class="fa fa-reply"></i> @lang('Reply')
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        @foreach($messages as $message)
                                            @if($message->admin_id == 0)
                                                <div class="row border border-radius-3 my-3 py-3 mx-2">
                                                    <div class="col-md-3 border-right text-right">
                                                        <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <p class="text-muted font-weight-bold my-3">
                                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                        <p>{{$message->message}}</p>
                                                        @if($message->attachments()->count() > 0)
                                                            <div class="mt-2">
                                                                @foreach($message->attachments as $k=> $image)
                                                                    <a href="{{route('owner.ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row border border-radius-3 my-3 py-3 mx-2" style="background-color: #ffd96729">
                                                    <div class="col-md-3 border-right text-right">
                                                        <h5 class="my-3">{{ $message->admin->name }}</h5>
                                                        <p class="lead text-muted">@lang('Staff')</p>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <p class="text-muted font-weight-bold my-3">
                                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                        <p>{{$message->message}}</p>
                                                        @if($message->attachments()->count() > 0)
                                                            <div class="mt-2">
                                                                @foreach($message->attachments as $k=> $image)
                                                                    <a href="{{route('owner.ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  


    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('owner.ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <input type="hidden" name="replayTicket" value="2">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation')!</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <strong class="text-dark">@lang('Are you sure you want to close this support ticket')?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal"><i class="fa fa-times"></i>
                            @lang('Close')
                        </button>
                        <button type="submit" class="btn btn--primary btn-sm"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        input[type="file"] {
            padding: 5px 10px;
        }
    </style>
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
                    `<div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control" required />
                            <div class="input-group-append">
                                <span class="input-group-text btn btn--danger support-btn remove-btn"> <i class="fa fa-times m-0 px-2"></i></span>
                            </div>
                    </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);

    </script>
@endpush
