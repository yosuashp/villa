@php
    $footer = getContent('footer.content', true);
    $contact = getContent('contact_us.content', true);
    $socials = getContent('social_icon.element');
    $policyPages = getContent('policy_pages.element');
@endphp
<footer class="footer bg_img" style="background-image: url('{{ getImage('assets/images/frontend/footer/'.$footer->data_values->background_image, '1920x840') }}');">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-4 col-sm-6 order-lg-1 order-1">
          <div class="footer-widget">
            <a href="{{ route('home') }}" class="footer-logo"><img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="image"></a>
            <p class="mt-3">{{ __($footer->data_values->short_description) }}</p>
          </div>
        </div>
        <div class="col-lg-2 col-sm-6 order-lg-2 order-3">
          <div class="footer-widget">
            <h4 class="footer-widget__title"><span>@lang('Site Links')</span></h4>
            <ul class="footer-menu-list">
              <li><a href="{{ route('property.search') }}">@lang('Properties')</a></li>
              <li><a href="{{ route('locations') }}">@lang('Locations')</a></li>
              @foreach($pages as $k => $data)
              <li><a href="{{route('pages', $data->slug)}}">{{__($data->name)}}</a></li>
              @endforeach
              <li><a href="{{ route('blog') }}">@lang('Blog')</a></li>
              <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-2 col-sm-6 order-lg-3 order-4">
          <div class="footer-widget">
            <h4 class="footer-widget__title"><span>@lang('Importants links')</span></h4>
            <ul class="footer-menu-list">
              @foreach ($policyPages as $policyPage)
                <li>
                  <a href="{{ route('policy', [$policyPage, slug($policyPage->data_values->title)]) }}">
                  {{ __($policyPage->data_values->title) }}
                  </a>
                </li>
              @endforeach
              <li><a href="{{ route('user.register') }}">@lang('User Registration')</a></li>
              <li><a href="{{ route('owner.register') }}">@lang('Owner Registration')</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 order-lg-4 order-2">
          <div class="footer-widget">
            <h4 class="footer-widget__title"><span>@lang('Contact Info')</span></h4>
            <ul class="footer-contact-list">
              <li>
                <div class="icon">
                  <i class="las la-phone-volume"></i>
                </div>
                <div class="content"> 
                  <a href="tel:2454541544">{{ __($contact->data_values->contact_number) }}</a>
                </div>
              </li>
              <li>
                <div class="icon">
                  <i class="las la-map-marker-alt"></i>
                </div>
                <div class="content"> 
                  <p>{{ __($contact->data_values->contact_address) }}</p>
                </div>
              </li>
              <li>
                <div class="icon">
                  <i class="las la-phone-volume"></i>
                </div>
                <div class="content"> 
                  <a href="mailto:demo@gmail.com">{{ __($contact->data_values->email_address) }}</a>
                </div>
              </li>
              <li>
                <ul class="social-media-list d-flex flex-wrap align-items-center">
                  @foreach ($socials as $social)
                  <li><a href="{{ $social->data_values->url }}" target="_blank">@php echo $social->data_values->social_icon @endphp</a></li>
                  @endforeach
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div><!-- row end -->
    </div>
    <div class="footer__bottom">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <p>&copy; {{ date('Y') }} {{ __($general->sitename ) }}. @lang('All Right Reserved')</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
  