@php
$work = getContent('works.content', true);
$works = getContent('works.element', false, null, true);
@endphp
    <!-- how work section start -->
<section class="pt-100 pb-100 bg_img how-work-section" style="background-image: url('{{ getImage('assets/images/frontend/works/'.$work->data_values->background_image, '1920x1090') }}')">
    <div class="left-el">
        <img src="{{ getImage('assets/images/frontend/works/'.$work->data_values->left_image, '575x755') }}" alt="image">
    </div>
    <div class="right-el">
        <img src="{{ getImage('assets/images/frontend/works/'.$work->data_values->right_image, '665x785') }}" alt="image">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <div class="section-subtitle">{{ __($work->data_values->title) }}</div>
                    <h2 class="section-title">{{ __($work->data_values->heading) }}</h2>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row gy-4">
            @foreach ($works as $work)    
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.1s">
                <div class="work-card">
                    <div class="work-card__number">{{ $loop->iteration }}</div>
                    <div class="work-card__content">
                        <h3 class="title">{{ __($work->data_values->step) }}</h3>
                    </div>
                </div><!-- work-card end -->
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- how work section end -->