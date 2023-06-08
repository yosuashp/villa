<header class="header">
  <div class="header__bottom">
    <div class="container">
      <nav class="navbar navbar-expand-xl p-0 align-items-center">
        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="menu-toggle"></span>
        </button>
        <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
          <ul class="navbar-nav main-menu ms-auto">
            <li><a href="{{ route('home') }}">@lang('Home')</a></li>
            <li><a href="{{ route('property.search') }}">@lang('Properties')</a></li>
            @foreach($pages as $k => $data)
            <li><a href="{{route('pages', $data->slug)}}">{{__($data->name)}}</a></li>
            @endforeach
            <li><a href="{{ route('blog') }}">@lang('Blog')</a></li>
            <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
          </ul>
          <div class="nav-right d-flex flex-wrap" style="gap:10px">
            <select class="language-select langSel">
              @foreach($language as $item)
              <option value="{{$item->code}}" @if(session('lang')==$item->code) selected @endif>{{ __($item->name) }}</option>
              @endforeach
            </select>

            @if (!auth()->check() && !auth()->guard('owner')->check())
            <div class="d-flex flex-wrap" style="gap:10px">
              <a href="{{ route('user.login') }}" class="btn btn-sm btn-outline--base">@lang('User Login')</a>
              <a href="{{ route('owner.login') }}" class="btn btn-sm btn--base">@lang('Owner Login')</a>
            </div>
            @endif

            @auth
            <a href="{{ route('user.home') }}" class="btn btn-sm btn--base">@lang('Dashboard')</a>
            @endauth

            @auth('owner')
            <a href="{{ route('owner.dashboard') }}" class="btn btn-sm btn--base">@lang('Dashboard')</a>
            @endauth


          </div>
        </div>
      </nav>
    </div>
  </div><!-- header__bottom end -->
</header>