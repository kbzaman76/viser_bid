<aside class="dashboard__sidebar">
    <div class="sidebar-container">
        <div class="dashboard__logo">
            <a href="{{ route('home') }}">
                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo">
            </a>
            <span class="close-sidebar d-lg-none">
                <i class="las la-times"></i>
            </span>
        </div>
        <div class="side__menu__area">
            <div class="side__menu__area-inner">
                <ul class="side__menu"> 
                    <li>
                        <a href="{{ route('user.home') }}" class="{{ menuActive('user.home') }}">
                            <i class="las la-home"></i>
                            <span class="cont">@lang('Dashboard')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.bidding.history') }}" class="{{ menuActive('user.bidding.history') }}">
                            <i class="las la-history"></i>
                            <span class="cont">@lang('Bidding History')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.winning.history') }}" class="{{ menuActive('user.winning.history') }}">
                            <i class="las la-trophy"></i>
                            <span class="cont">@lang('Wining History')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.transactions') }}" class="{{ menuActive('user.transactions') }}">
                            <i class="las la-list"></i>
                            <span class="cont">@lang('Transaction')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.deposit') }}" class="{{ menuActive('user.deposit') }}">
                            <i class="las la-credit-card"></i>
                            <span class="cont">@lang('Deposit')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.deposit.history') }}" class="{{ menuActive('user.deposit.history') }}">
                            <i class="las la-wallet"></i>
                            <span class="cont">@lang('Deposit History')</span>
                        </a>
                    </li>
                    <li>
                        <div class="side__menu-title">
                            <span>@lang('More')</span>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('ticket') }}" class="{{ menuActive('ticket') }}">
                            <i class="las la-envelope"></i>
                            <span class="cont">@lang('Ticket')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ticket.open') }}" class="{{ menuActive('ticket.open') }}">
                            <i class="las la-envelope-open-text"></i>
                            <span class="cont">@lang('Create Ticket')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.profile.setting') }}" class="{{ menuActive('user.profile.setting') }}">
                            <i class="lar la-user"></i>
                            <span class="cont">@lang('Profile')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.twofactor') }}" class="{{ menuActive('user.twofactor') }}">
                            <i class="las la-shield-alt"></i>
                            <span class="cont">@lang('Two Factor')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.change.password') }}" class="{{ menuActive('user.change.password') }}">
                            <i class="las la-lock"></i>
                            <span class="cont">@lang('Change Password')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.logout') }}" class="{{ menuActive('user.logout') }}">
                            <i class="las la-sign-in-alt"></i>
                            <span class="cont">@lang('Logout')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>