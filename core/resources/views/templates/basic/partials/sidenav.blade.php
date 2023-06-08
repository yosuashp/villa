<div class="col-xl-3 col-lg-6 pe-xl-4">
    <div class="user-sidebar">
      <button class="btn btn-close sidebar-close d-xl-none"></button>
      <div class="user-menu-widget">
        <ul class="user-menu">
          <li class="{{ menuActive('user.home') }}">
            <a href="{{ route('user.home') }}"><i class="las la-layer-group"></i> <span>@lang('Dashboard')</span></a>
          </li>
          <li class="{{ menuActive('user.property.history') }}">
            <a href="{{ route('user.property.history') }}"><i class="las la-history"></i> <span>@lang('Booking History')</span></a>
          </li>
          <li class="{{ menuActive(['user.review', 'user.review.pending', 'user.review.complete']) }}">
            <a href="{{ route('user.review') }}"><i class="lar la-star"></i> <span>@lang('Reviews')</span></a>
          </li>
          <li class="{{ menuActive(['ticket', 'ticket.view', 'ticket.open']) }}">
            <a href="{{ route('ticket') }}"><i class="las la-cog"></i> <span>@lang('Support Tickets')</span></a>
          </li>
          <li class="{{ menuActive('user.profile.setting') }}">
            <a href="{{ route('user.profile.setting') }}"><i class="las la-user"></i> <span>@lang('Profile Setting')</span></a>
          </li>
          <li class="{{ menuActive('user.change.password') }}">
            <a href="{{ route('user.change.password') }}"><i class="las la-user"></i> <span>@lang('Change Password')</span></a>
          </li>
          <li class="{{ menuActive('user.twofactor') }}">
            <a href="{{ route('user.twofactor') }}"><i class="las la-user-lock"></i><span> @lang('2FA Security')</span></a>
          </li>
          <li>
            <a href="{{ route('user.logout') }}"><i class="las la-sign-out-alt"></i> <span>@lang('Logout')</span></a>
          </li>
        </ul>
      </div>
    </div><!-- user-sidebar end -->
  </div>