@extends($activeTemplate.'layouts.frontend')

@section('content')
<?php
$socials = getContent('social_icon.element');
?>
    <!-- contact section start -->
<section class="pt-100 pb-100 dot--bg">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-5">
          <div class="section-header">
            <h2 class="section-title">{{ __($contact->data_values->title) }}</h2>
          </div>
        </div>
      </div><!-- row end -->
      <div class="row gy-4 justify-content-center">
        <div class="col-lg-4 col-md-6">
          <div class="contact-card">
            <div class="contact-card__header">
              <div class="icon">
                <i class="las la-map-marked-alt"></i>
              </div>
              <h3 class="title">@lang('Location')</h3>
            </div>
            <p>{{ __($contact->data_values->contact_address) }}</p>
          </div><!-- contact-card end -->
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="contact-card">
            <div class="contact-card__header">
              <div class="icon">
                <i class="las la-address-card"></i>
              </div>
              <h3 class="title">@lang('Email & Phone')</h3>
            </div>
            <p><a href="mailto:demo@email.com">{{ $contact->data_values->email_address }}</a></p>
            <p><a href="tel:15455545445">{{ $contact->data_values->contact_number }}</a></p>
          </div><!-- contact-card end -->
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="contact-card">
            <div class="contact-card__header">
              <div class="icon">
                <i class="las la-map-marked-alt"></i>
              </div>
              <h3 class="title">@lang('Socail Media')</h3>
            </div>
            <ul class="social-media-list d-flex align-items-center">
              @foreach ($socials as $social)
              <li><a href="{{ $social->data_values->url }}" target="_blank">@php echo $social->data_values->social_icon @endphp</a></li>
              @endforeach
            </ul>
          </div><!-- contact-card end -->
        </div>
      </div><!-- row end -->
    </div>
  </section>
  <!-- contact section end -->
      <!-- map section start -->
<div class="google-map-section">
    <iframe src="{{ $contact->data_values->google_map_embed_url }}" allowfullscreen="" loading="lazy"></iframe>
  </div>
  <!-- map section end -->

  <!-- contact form section start -->
  <section class="pt-100 pb-100 dot--bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="section-header">
            <h2 class="section-title">@lang('Do you have any question?')</h2>
          </div>
        </div>
      </div><!-- row end -->
      <div class="row">
        <div class="col-lg-12">
          <form action="{{ route('contact') }}" method="POST" class="contact-form">
            @csrf
            <div class="row">
              <div class="col-md-6 form-group">
                <label>@lang('Name')</label>
                <input type="text" name="name" placeholder="Enter your name" class="form--control" value="{{ auth()->user() ? auth()->user()->fullname : old('name') }}" @if(auth()->user()) readonly @endif required>
              </div>
              <div class="col-md-6 form-group">
                <label>@lang('Email')</label>
                <input type="email" name="email" placeholder="Enter email address" class="form--control" value="{{ auth()->user() ? auth()->user()->email : old('email')}}" @if(auth()->user()) readonly @endif required>
              </div>

              <div class="col-md-12 form-group">
                <label>@lang('Subject')</label>
                <input type="text" name="subject" placeholder="@lang('Enter subject')" class="form--control" value="{{old('subject')}}" required>
              </div>
              <div class="col-lg-12 form-group">
                <label>@lang('Message')</label>
                <textarea placeholder="Your message" name="message" class="form--control">{{old('message')}}</textarea>
              </div>
              <div class="col-lg-12">
                <button type="submit" class="btn btn--base">@lang('Submit')</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<!-- contact form section end -->

@if($sections != null)
  @foreach(json_decode($sections) as $sec)
      @include($activeTemplate.'sections.'.$sec)
  @endforeach
@endif

@endsection
