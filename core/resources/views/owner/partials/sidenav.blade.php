<div class="sidebar {{ sidebarVariation()['selector'] }} {{ sidebarVariation()['sidebar'] }} {{ @sidebarVariation()['overlay'] }} {{ @sidebarVariation()['opacity'] }}"
    data-background="{{ getImage('assets/laramin/images/sidebar/2.jpg','400x800') }}">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('owner.dashboard') }}" class="sidebar__main-logo"><img
                    src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo_2.png') }}"
                    alt="@lang('image')"></a>
            <a href="{{ route('owner.dashboard') }}" class="sidebar__logo-shape"><img
                    src="{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}"
                    alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('owner.dashboard') }}">
                    <a href="{{ route('owner.dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('owner.property*', 3) }}">
                        <i class="menu-icon las la-store-alt"></i>
                        <span class="menu-title">@lang('Property')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('owner.property*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('owner.property.index')}} ">
                                <a href="{{ route('owner.property.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Property')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('owner.property.room.category*') }}">
                                <a href="{{ route('owner.property.room.category.index') }}" class="nav-link ">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Room Category')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('owner.withdraw*',3)}}">
                        <i class="menu-icon las la-wallet"></i>
                        <span class="menu-title">@lang('Withdraw')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('owner.withdraw*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('owner.withdraw')}} ">
                                <a href="{{route('owner.withdraw')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdraw Money')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('owner.withdraw.history')}} ">
                                <a href="{{route('owner.withdraw.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdraw Log')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('owner.ticket*',3)}}">
                        <i class="menu-icon las la-envelope"></i>
                        <span class="menu-title">@lang('Support Ticket')</span>

                    </a>
                    <div class="sidebar-submenu {{menuActive('owner.ticket*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('owner.ticket.open')}} ">
                                <a href="{{route('owner.ticket.open')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Open Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('owner.ticket')}} ">
                                <a href="{{route('owner.ticket')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('My Tickets')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item {{ menuActive('owner.profile') }}">
                    <a href="{{ route('owner.profile') }}" class="nav-link ">
                        <i class="menu-icon las la-user"></i>
                        <span class="menu-title">@lang('Profile')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('owner.twofactor') }}">
                    <a href="{{ route('owner.twofactor') }}" class="nav-link ">
                        <i class="menu-icon las la-user-lock"></i>
                        <span class="menu-title">@lang('2FA Security')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('owner.logout') }}">
                    <a href="{{ route('owner.logout') }}" class="nav-link ">
                        <i class="menu-icon las la-sign-out-alt"></i>
                        <span class="menu-title">@lang('logout')</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- sidebar end -->
