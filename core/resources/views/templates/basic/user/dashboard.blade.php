@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('ticket') }}" class="d-widget">
                <div class="d-widget__icon">
                    <i class="las la-envelope"></i>
                </div>
                <div class="d-widget__content">
                    <h3 class="amount">{{ __($widget['total_tickets']) }}</h3>
                    <p class="caption text-dark">@lang('Total Ticket')</p>
                </div>
            </a><!-- d-widget end -->
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('user.property.history') }}" class="d-widget">
                <div class="d-widget__icon">
                    <i class="menu-icon las la-store-alt"></i>
                </div>
                <div class="d-widget__content">
                    <h3 class="amount">{{ __($widget['total_booked']) }}</h3>
                    <p class="caption text-dark">@lang('Total Booked')</p>
                </div>
            </a><!-- d-widget end -->
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('user.review') }}" class="d-widget">
                <div class="d-widget__icon">
                    <i class="las la-star"></i>
                </div>
                <div class="d-widget__content">
                    <h3 class="amount">{{ __($widget['total_pending_review']) }}</h3>
                    <p class="caption text-dark">@lang('Pending Review')</p>
                </div>
            </a><!-- d-widget end -->
        </div>
        
    </div><!-- row end -->
    <div class="custom--card mt-5">
        <div class="card-header pb-3">
            <h6 class="d-inline">@lang('Booking History')</h6>
            <a href="{{ route('user.property.history') }}" class="btn btn--base btn-sm float-end">@lang('View All')</a>
        </div>
        <div class="card-body">
            <div class="table-responsive--md">
                <table class="table custom--table">
                    <thead>
                        <tr>
                            <th>@lang('Hotel Name')</th>
                            <th>@lang('Check In')</th>
                            <th>@lang('Check Out')</th>
                            <th>@lang('Phone')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($propertyBookings as $propertyBooking)
                        <tr>
                            <td data-label="@lang('Hotel Name')">{{ __($propertyBooking->property->name) }}</td>
                            <td data-label="@lang('Check In')">{{ __($propertyBooking->date_from) }}</td>
                            <td data-label="@lang('Check Out')">{{ $propertyBooking->date_to }}</td>
                            <td data-label="@lang('Phone')">{{ __($propertyBooking->property->phone) }}</td>
                            <td data-label="@lang('Action')">
                                <button class="icon-btn btn--base showProperty"
                                    data-name="{{ __($propertyBooking->property->name) }}"
                                    data-check_in="{{ __($propertyBooking->date_from) }}"
                                    data-check_out="{{ __($propertyBooking->date_to) }}"
                                    data-phone="{{ __($propertyBooking->property->phone) }}"
                                    data-booked_rooms="{{ $propertyBooking->bookedRooms }}"
                                    data-price="{{ $general->cur_sym }}{{ showAmount($propertyBooking->total_price) }}"
                                    data-image="{{ getImage(imagePath()['property']['path'].'/'. $propertyBooking->property->image,imagePath()['property']['size'])}}"
                                ><i class="las la-eye"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .icon-btn {
            border-radius: 5px;
        }
    </style>
@endpush

@push('modal')
<div id="propertyModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Rate It')</h5>
                <button type="button" class="btn btn-sm btn--danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>@lang('Name')</td>
                            <td class="name"></td>
                        </tr>
                        <tr>
                            <td>@lang('Check In')</td>
                            <td class="check_in"></td>
                        </tr>
                        <tr>
                            <td>@lang('Check Out')</td>
                            <td class="check_out"></td>
                        </tr>
                        <tr>
                            <td>@lang('Phone')</td>
                            <td class="phone"></td>
                        </tr>
                        <tr>
                            <td>@lang('Room Number')</td>
                            <td class="room_number"></td>
                        </tr>
                        <tr>
                            <td>@lang('Price')</td>
                            <td class="price"></td>
                        </tr>                       
                    </table>
                   <img src="" class="showImage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
        </div>
    </div>
</div>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.showProperty').click(function () {
            var modal = $('#propertyModal');
            var data = $(this).data();
            var roomList = '';
            var action = `{{ route('user.review.store') }}`;
            modal.find('.modal-title').text(data.name);
            modal.find('.name').text(data.name);
            modal.find('.check_in').text(data.check_in);
            modal.find('.check_out').text(data.check_out);
            modal.find('.phone').text(data.phone);
            modal.find('.price').text(data.price);
            modal.find('.showImage').attr('src', data.image);

            data.booked_rooms.forEach((bookedRoom, index) => {
                roomList += index+1+'. '+ bookedRoom.room.room_number+'</br>';
            });

            modal.find('.room_number').html(roomList);
            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush
