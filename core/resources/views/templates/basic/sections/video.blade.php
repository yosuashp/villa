@php
$video = getContent('video.content', true);
@endphp
<!-- video section start -->
<section class="pt-100 pb-100 bg_img dark-overlay" style="background-image: url('{{ getImage('assets/images/frontend/video/'.$video->data_values->background_image, '1920x1280') }}')">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-header text-center">
                    <h2 class="section-title text-white wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        {{ __($video->data_values->heading) }}
                    </h2>
                    <p class="mt-3 text-white wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.5s">
                        {{ __($video->data_values->sub_heading) }}
                    </p>
                    <a href="{{ $video->data_values->video_url }}" class="video--btn mt-5 wow fadeInUp" data-rel="lightcase:myCollection" data-wow-duration="0.5s" data-wow-delay="0.7s"><i class="las la-play"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- video section end -->