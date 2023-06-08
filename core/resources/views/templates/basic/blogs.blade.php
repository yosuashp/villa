@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="as-location-page">
        <div class="container">
            <div class="row g-4">
                @foreach ($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                    <div class="blog-post">
                        <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}" class="t-link blog-post__img">
                        <img
                            src="{{ getImage('assets/images/frontend/blog/thumb_'.$blog->data_values->blog_image, '430x275') }}"
                            alt="viserfly"
                            class="blog-post__img-is"
                        />
                        </a>
                        <div class="blog-post__body">
                        <div class="blog-post__date">
                            <h2 class="text-white">{{ showDateTime($blog->created_at, 'd') }}</h2>
                                <p class="text-white text-capitalize">{{ showDateTime($blog->created_at, 'M') }}</p>
                        </div>
                        <h4 class="text-capitalize mb-3 mt-0">
                            <a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}" class="t-link blog-post__title">
                            {{ __($blog->data_values->title) }}
                            </a>
                        </h4>
                        <ul class="list list--row">
                            <li class="list--row__item">
                            <div class="blog-post__meta">
                                <div class="blog-post__meta-icon me-2">
                                    <i class="las la-clock"></i>
                                </div>
                                <div class="blog-post__meta-text text-uppercase">
                                    <span class="blog-post__link">{{ diffForHumans($blog->created_at) }}</span>
                                </div>
                            </div>
                            </li>
                        </ul>
                            <p class="blog-post__article mt-3 mb-0">
                                @php
                                    echo shortDescription(strip_tags($blog->data_values->description_nic));
                                @endphp
                            </p>
                        </div>
                    </div>
                    </div>
                @endforeach

              </div>
        </div>
    </div>
        
    @if($sections != null)
        @foreach(json_decode($sections) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
