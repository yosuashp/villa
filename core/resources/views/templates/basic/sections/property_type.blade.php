@php
$property = getContent('property_type.content', true);
$propertyTypes = App\Models\PropertyType::with('properties')->where('status', 1)->orderBy('id', 'DESC')->limit(10)->get();
@endphp
<!-- property section start -->
<section class="pt-100 pb-100 property-section">
    <div class="bg-el"><img src="{{ asset($activeTemplateTrue.'images/bg/ele-bg.png') }}" alt="image"></div>
    <div class="bg-el2"><img src="{{ asset($activeTemplateTrue.'images/bg/ele-bg2.png') }}" alt="image"></div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 wow fadeInUp">
          <div class="section-header text-center">
            <h2 class="section-title">{{ __($property->data_values->heading) }}</h2>
            <p class="mt-3">{{ __($property->data_values->sub_heading) }}</p>
          </div>
        </div>
      </div><!-- row end -->
      <div class="property-slider wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
        @foreach ($propertyTypes as $propertyType)      
        <div class="single-slide">
          <div class="property-card rounded-3 has--link">
            <a href="{{ route('search.property.type', [$propertyType->id, slug($propertyType->name)]) }}" class="item--link"></a>
            <div class="property-card__thumb rounded-2">
              <img src="{{getImage(imagePath()['property_type']['path'].'/'. $propertyType->image, imagePath()['property_type']['size'])}}" alt="image">
            </div>
            <div class="property-card__content text-center">
              <h4 class="title">{{ __($propertyType->name) }}</h4>
              <span class="fs--14px">{{ $propertyType->properties->count() }} {{ $propertyType->name }}</span>
            </div>
          </div><!-- property-card end -->
        </div><!-- single-slide end -->
        @endforeach
      </div>
    </div>
  </section>
  <!-- property section end -->