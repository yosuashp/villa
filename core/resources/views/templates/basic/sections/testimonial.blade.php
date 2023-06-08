@php
$testimonialContent = getContent('testimonial.content', true);
$testimonialElements = getContent('testimonial.element');
@endphp


<!-- testimonial section start -->
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __($testimonialContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __($testimonialContent->data_values->sub_heading) }}</p>
                </div>
            </div>
        </div><!-- row end -->
        <div class="testimonial-slider wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
            @foreach ($testimonialElements as $testimonial)
            <div class="single-slide">
                <div class="testimonial-item">
                    <div class="thumb">
                        <img src="{{ getImage('assets/images/frontend/testimonial/'.$testimonial->data_values->image, '440x290') }}" alt="image">
                    </div>
                    <div class="content">
                        <p class="testimonial-speech">{{ __($testimonial->data_values->feedback) }}</p>
                        <div class="traveller-review mt-4 d-flex align-items-center justify-content-between">
                            <h6 class="name">-{{ __($testimonial->data_values->name) }}</h6>
                            <div class="ratings">
                                @for($i=0; $i < $testimonial->data_values->star; $i++)
                                    <i class="las la-star"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div><!-- testimonial-item end -->
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- testimonial section end -->
