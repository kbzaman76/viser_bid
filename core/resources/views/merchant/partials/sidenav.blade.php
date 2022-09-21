<div class="sidebar {{ sidebarVariation()['selector'] }} {{ sidebarVariation()['sidebar'] }} {{ @sidebarVariation()['overlay'] }} {{ @sidebarVariation()['opacity'] }}" data-background="{{ getImage('assets/admin/images/sidebar/2.jpg', '400x800') }}">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('home') }}" class="sidebar__main-logo"><img src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="@lang('image')"></a>
            <a href="{{ route('home') }}" class="sidebar__logo-shape"><img src="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('merchant.dashboard') }}">
                    <a href="{{ route('merchant.dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('merchant.product*', 3) }}">
                        <i class="menu-icon lab la-product-hunt"></i>
                        <span class="menu-title">@lang('Products')</span>

                    </a>
                    <div class="sidebar-submenu {{ menuActive('merchant.product*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('merchant.product.index') }} ">
                                <a href="{{ route('merchant.product.index') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Products')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('merchant.product.live') }} ">
                                <a href="{{ route('merchant.product.live') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Live Products')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('merchant.product.pending') }} ">
                                <a href="{{ route('merchant.product.pending') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Products')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('merchant.product.upcoming') }} ">
                                <a href="{{ route('merchant.product.upcoming') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Upcoming Products')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('merchant.product.expired') }} ">
                                <a href="{{ route('merchant.product.expired') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Expired Products')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item {{ menuActive('merchant.bids') }}">
                    <a href="{{ route('merchant.bids') }}" class="nav-link ">
                        <i class="menu-icon las la-list"></i>
                        <span class="menu-title">@lang('Bid Logs')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('merchant.bid.winners') }}">
                    <a href="{{ route('merchant.bid.winners') }}" class="nav-link ">
                        <i class="menu-icon las la-trophy"></i>
                        <span class="menu-title">@lang('Winner Logs')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('merchant.transactions') }}">
                    <a href="{{ route('merchant.transactions') }}" class="nav-link ">
                        <i class="menu-icon las la-exchange-alt"></i>
                        <span class="menu-title">@lang('Transactions')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('merchant.withdraw*', 3) }}">
                        <i class="menu-icon las la-wallet"></i>
                        <span class="menu-title">@lang('Withdraw')</span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('merchant.withdraw*', 2) }} ">
                        <ul>

                            <li class="sidebar-menu-item {{ menuActive('merchant.withdraw') }} ">
                                <a href="{{ route('merchant.withdraw') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdraw Money')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('merchant.withdraw.history') }} ">
                                <a href="{{ route('merchant.withdraw.history') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdraw Log')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('merchant.ticket*', 3) }}">
                        <i class="menu-icon las la-envelope"></i>
                        <span class="menu-title">@lang('Support Ticket')</span>

                    </a>
                    <div class="sidebar-submenu {{ menuActive('merchant.ticket*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('merchant.ticket.open') }} ">
                                <a href="{{ route('merchant.ticket.open') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Open Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('merchant.ticket') }} ">
                                <a href="{{ route('merchant.ticket') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('My Tickets')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item {{ menuActive('merchant.profile') }}">
                    <a href="{{ route('merchant.profile') }}" class="nav-link ">
                        <i class="menu-icon las la-user"></i>
                        <span class="menu-title">@lang('Profile')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('merchant.twofactor') }}">
                    <a href="{{ route('merchant.twofactor') }}" class="nav-link ">
                        <i class="menu-icon las la-user-lock"></i>
                        <span class="menu-title">@lang('2FA Security')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('merchant.logout') }}">
                    <a href="{{ route('merchant.logout') }}" class="nav-link ">
                        <i class="menu-icon las la-sign-out-alt"></i>
                        <span class="menu-title">@lang('logout')</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- sidebar end -->
