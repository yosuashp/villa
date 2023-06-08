@extends($activeTemplate.'layouts.master')
@section('content')
<div class="custom--card">
    <div class="card-header pb-3">
        <h6 class="d-inline">@lang('Property Waiting for Review')</h6>
        <a href="{{ route('user.review.pending') }}" class="btn btn--base btn-sm float-end">@lang('View All')</a>
    </div>
    <div class="card-body">
        <div class="table-responsive--md">
            <table class="table custom--table">
                <thead>
                    <tr>
                        <th>@lang('Property Name')</th>
                        <th>@lang('Location')</th>
                        <th>@lang('Phone')</th>
                        <th>@lang('Rate It')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingReviewProperties as $property)
                    <tr>
                        <td data-label="@lang('Property Name')">{{ $property->name }}</td>
                        <td data-label="@lang('Location')">{{ $property->location->name }}</td>
                        <td data-label="@lang('Phone')">{{ $property->phone }}</td>
                        <td data-label="@lang('Action')">
                            <button class="icon-btn addReview" data-property_id="{{ $property->id }}" data-name="{{ $property->name }}"><i class="las la-star"></i></button>
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
<div class="custom--card mt-5">
    <div class="card-header pb-3">
        <h6 class="d-inline">@lang('Reviewed Property')</h6>
        <a href="{{ route('user.review.complete') }}" class="btn btn--base btn-sm float-end">@lang('View All')</a>
    </div>
    <div class="card-body">
        <div class="table-responsive--md">
            <table class="table custom--table">
                <thead>
                    <tr>
                        <th>@lang('Property Name')</th>
                        <th>@lang('Location')</th>
                        <th>@lang('Phone')</th>
                        <th>@lang('Rating')</th>
                        <th>@lang('Rate It')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviewedProperties as $property)
                    <tr>
                        <td data-label="@lang('Property Name')">{{ $property->name }}</td>
                        <td data-label="@lang('Location')">{{ $property->location->name }}</td>
                        <td data-label="@lang('Phone')">{{ $property->phone }}</td>
                        <td data-label="@lang('Rating')">
                            @for ($i = 0; $i < $property->review->rating; $i++)
                                <span class="rating">★ </span>
                            @endfor
                        </td>
                        <td data-label="@lang('Action')">
                            <button class="icon-btn updateReview"
                            data-review_id = "{{ $property->review->id }}"
                            data-property_id="{{ $property->id }}"
                            data-name="{{ $property->name }}"
                            data-rating="{{ $property->review->rating }}"
                            data-description="{{ $property->review->description }}"
                            ><i class="las la-star"></i></button>
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

@push('modal')
<div id="starModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Rate It')</h5>
                <button type="button" class="btn btn-sm btn--danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                @csrf
                <div class="modal-body">
                    <div class="rate">
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5" title="text">@lang('5 stars')</label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4" title="text">@lang('4 stars')</label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3" title="text">@lang('3 stars')</label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2" title="text">@lang('2 stars')</label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1" title="text">@lang('1 star')</label>
                    </div>
                    <div class="description">
                        <label>@lang('Description')</label>
                        <div class="input-group has_append">
                            <textarea name="description" class="form-control" placeholder="@lang('Enter review description')"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="property_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('style')
    <style>
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }
        .description{
            margin-top: 50px;
        }
        .rating{
            color: #FFD700;
            font-size: 18px;
        }
        .icon-btn{
            background-color: #FFD700;
        }
    </style>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.addReview').click(function () {
            var modal = $('#starModal');
            var data = $(this).data();
            var action = `{{ route('user.review.store') }}`;
            modal.find('.modal-title').text(data.name+' review');
            modal.find('[name=property_id]').val(data.property_id);
            modal.find('[name="description"]').text('');
            modal.find('[name="rating"]').attr('checked', false);
            modal.find('form').attr('action', action);
            modal.modal('show');
        });

        $('.updateReview').click(function () {
            var modal = $('#starModal');
            var data = $(this).data();
            var action = `{{ route('user.review.update', '') }}/${data.review_id}`;
            modal.find('.modal-title').text(data.name+' review');
            modal.find('[name="rating"]').attr('checked', false);
            modal.find('[name=property_id]').val($(this).data('property_id'));
            modal.find('[name="description"]').text(data.description);
            modal.find('#star'+data.rating).attr('checked', true);
            modal.find('form').attr('action', action);
            console.log(data.rating);
            console.log(data.description);
            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush
