@extends($activeTemplate.'layouts.frontend')
@section('content')
<div class="as-location-page">
    <div class="container">
        <div class="row g-4 justify-content-center">

            @forelse ($locations as $location)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="as-location-card">
                    <a href="{{ route('search.location.property', [$location->id, slug($location->name)]) }}" class="as-location-card__link">
                        <img src="{{getImage(imagePath()['location']['path'].'/'. $location->image,imagePath()['location']['size'])}}" alt="hotel" class="as-location-card__img">
                    </a>
                    <div class="as-location-card__info">
                        <div class="as-location-card__content">
                            <h3 class="as-location-card__title">
                                <a href="{{ route('search.location.property', [$location->id, slug($location->name)]) }}" class="as-location-card__title-link">
                                    {{ __($location->name) }}
                                </a>
                            </h3>
                            <span class="as-location-card__subtitle">
                                @lang('Average price')
                            </span>
                        </div>
                        <div class="as-location-card__price">
                           {{ $general->cur_sym }}{{ __(showAmount($location->average_price)) }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <h4 class="text-center mb-0">{{ __($emptyMessage) }}</h4>
            @endforelse
            <div class="col-12">
                {{ $locations->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
