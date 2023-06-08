@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="as-location-page">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-8">
                    <div class="blog-post">
                        <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->blog_image, '860x550') }}" alt="viserfly"
                            class="img-fluid w-100" />
                        <div class="blog-post__body">
                            <div class="blog-post__date">
                                <h2 class="text-white">{{ showDateTime($blog->created_at, 'd') }}</h2>
                                <p class="text-white text-capitalize">{{ showDateTime($blog->created_at, 'M') }}</p>
                            </div>
                            <h2 class="text-capitalize mb-3">
                               {{ __($blog->data_values->title) }}
                            </h2>
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
                            <div>
                                @php echo $blog->data_values->description_nic @endphp
                            </div>
                            
                        </div>

                        <div class="fb-comments" data-href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" data-numposts="5"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sticky-top">
                        <ul class="list list--column">
                            <li class="list--column__item-xl">
                                <div class="widget">
                                    <h4 class="widget__title text-capitalize mb-4 mt-0">
                                        @lang('Recent Posts')
                                    </h4>
                                    <ul class="list list--column widget-category">
										@foreach ($recentBlogs as $blog)
											<li class="list--column__item widget-category__item">
												<div class="d-flex pb-3">
													<div class="me-3 flex-shrink-0">
														<div class="user__img user__img--md">
															<img src="{{ getImage('assets/images/frontend/blog/thumb_'.$blog->data_values->blog_image, '430x275') }}"
																alt="viserhyip" class="user__img-is" />
														</div>
													</div>
													<div class="article">
														<h5 class="texte-capitalize t-fw-md mt-0 mb-2">
															<a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}"
																class="t-link d-inline-block t-text-heading fw-md t-link--primary text-capitalize">
																{{ __($blog->data_values->title) }}
															</a>
														</h5>
														<ul class="list list--row">
															<li class="list--row__item">
																<div class="blog-post__meta">
																	<div class="blog-post__meta-icon me-2">
																		<i class="las la-clock"></i>
																	</div>
																	<div class="blog-post__meta-text text-uppercase">
																		
																		<a href="{{ route('blog.details', [$blog->id, slug($blog->data_values->title)]) }}" class="blog-post__link">{{ showDateTime($blog->created_at) }}</a>
																	</div>
																</div>
															</li>
														</ul>
													</div>
												</div>
											</li> 
										@endforeach
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('fbComment')
	@php echo loadFbComment() @endphp
@endpush
