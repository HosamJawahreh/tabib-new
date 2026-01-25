    <li class="menu-item">
        <a href="{{ route('admin-orders-all') }}" class="menu-link wave-effect">
            <span class="icon-wrapper">
                <i class="fas fa-shopping-cart"></i>
            </span>
            <span class="menu-text">{{ __('Orders') }}</span>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('admin-prod-index') }}" class="menu-link wave-effect">
            <span class="icon-wrapper">
                <i class="icofont-cart"></i>
            </span>
            <span class="menu-text">{{ __('Products') }}</span>
        </a>
    </li>

    <li class="menu-item {{ request()->is('admin/category/tree') ? 'active' : '' }}">
        <a href="{{ route('admin-cat-tree') }}" class="menu-link wave-effect">
            <span class="icon-wrapper">
                <i class="fas fa-sitemap"></i>
            </span>
            <span class="menu-text">{{ __('Categories') }}</span>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('admin-staff-index') }}" class="menu-link wave-effect">
            <span class="icon-wrapper">
                <i class="fas fa-user-secret"></i>
            </span>
            <span class="menu-text">{{ __('Manage Staffs') }}</span>
        </a>
    </li>

    <li class="menu-item">
        <a href="{{ route('admin-role-index') }}" class="menu-link wave-effect">
            <span class="icon-wrapper">
                <i class="fas fa-user-tag"></i>
            </span>
            <span class="menu-text">{{ __('Manage Roles') }}</span>
        </a>
    </li>

    <li class="menu-item">
        <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <span class="icon-wrapper">
                <i class="fas fa-cogs"></i>
            </span>
            <span class="menu-text">{{ __('General Settings') }}</span>
        </a>
        <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
            <!-- Sliders -->
            <li>
                <a href="{{ route('admin-sl-index') }}"><i class="fas fa-sliders-h"></i> {{ __('Sliders') }}</a>
            </li>

            <li><a href="{{ route('admin-gs-logo') }}"><i class="fas fa-image"></i> {{ __('Logo') }}</a></li>
            {{-- <li><a href="{{ route('admin-gs-fav') }}"><i class="fas fa-star"></i> {{ __('Favicon') }}</a></li> --}}
            {{-- <li><a href="{{ route('admin-gs-load') }}"><i class="fas fa-spinner"></i> {{ __('Loader') }}</a></li> --}}
            <li><a href="{{ route('admin-shipping-index') }}"><i class="fas fa-shipping-fast"></i> {{ __('Shipping Methods') }}</a></li>
            {{-- <li><a href="{{ route('admin-package-index') }}"><i class="fas fa-box"></i> {{ __('Packagings') }}</a></li> --}}
            {{-- <li><a href="{{ route('admin-pick-index') }}"><i class="fas fa-map-marker-alt"></i> {{ __('Pickup Locations') }}</a></li> --}}
            <li><a href="{{ route('admin-gs-contents') }}"><i class="fas fa-file-alt"></i> {{ __('Website Contents') }}</a></li>
            {{-- <li><a href="{{ route('admin-gs-affilate') }}"><i class="fas fa-link"></i> {{__('Affiliate Program')}}</a></li> --}}
            {{-- <li><a href="{{ route('admin-gs-popup') }}"><i class="fas fa-window-restore"></i> {{ __('Popup Banner') }}</a></li> --}}
            <li><a href="{{ route('admin-gs-bread') }}"><i class="fas fa-stream"></i> {{ __('Breadcrumb Banner') }}</a></li>
            <li><a href="{{ route('admin-gs-error-banner') }}"><i class="fas fa-exclamation-triangle"></i> {{ __('Error Banner') }}</a></li>
            {{-- <li><a href="{{ route('admin-gs-maintenance') }}"><i class="fas fa-tools"></i> {{ __('Website Maintenance') }}</a></li> --}}

            <!-- Total Earning -->
            {{-- <li>
                <a href="#income" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-hand-holding-usd"></i> {{ __('Total Earning') }}
                </a>
                <ul class="collapse list-unstyled" id="income" data-parent="#general">
                    <li><a href="{{route('admin-tax-calculate-income')}}"><span>{{ __('Tax Calculate') }}</span></a></li>
                    <li><a href="{{route('admin-subscription-income')}}"><span>{{ __('Subscription Earning') }}</span></a></li>
                    <li><a href="{{route('admin-withdraw-income')}}"><span>{{ __('Withdraw Earning') }}</span></a></li>
                    <li><a href="{{route('admin-commission-income')}}"><span>{{ __('Commission Earning') }}</span></a></li>
                </ul>
            </li> --}}

            <!-- Customers -->
            <li>
                <a href="#customers" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="icofont-user"></i> {{ __('Customers') }}
                </a>
                <ul class="collapse list-unstyled" id="customers" data-parent="#general">
                    <li><a href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a></li>
                    {{-- <li><a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a></li> --}}
                    <li><a href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a></li>
                </ul>
            </li>

            <!-- Messages -->
            {{-- <li>
                <a href="#messages" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-envelope"></i> {{ __('Messages') }}
                </a>
                <ul class="collapse list-unstyled" id="messages" data-parent="#general">
                    <li><a href="{{ route('admin-message-index') }}"><span>{{ __('Tickets') }}</span></a></li>
                    <li><a href="{{ route('admin-message-dispute') }}"><span>{{ __('Disputes') }}</span></a></li>
                </ul>
            </li> --}}

            <!-- Blog -->
            {{-- <li>
                <a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-fw fa-newspaper"></i> {{ __('Blog') }}
                </a>
                <ul class="collapse list-unstyled" id="blog" data-parent="#general">
                    <li><a href="{{ route('admin-cblog-index') }}"><span>{{ __('Categories') }}</span></a></li>
                    <li><a href="{{ route('admin-blog-index') }}"><span>{{ __('Posts') }}</span></a></li>
                    <li><a href="{{ route('admin-gs-blog-settings') }}"><span>{{ __('Blog Settings') }}</span></a></li>
                </ul>
            </li> --}}

            <!-- Font Option -->
            <li>
                <a href="{{ route('admin.fonts.index') }}"><i class="fa fa-font"></i> {{ __('Font Option') }}</a>
            </li>

            <!-- Email Settings -->
            <li>
                <a href="#emails" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-at"></i> {{ __('Email Settings') }}
                </a>
                <ul class="collapse list-unstyled" id="emails" data-parent="#general">
                    <li><a href="{{route('admin-mail-index')}}"><span>{{ __('Email Template') }}</span></a></li>
                    <li><a href="{{route('admin-mail-config')}}"><span>{{ __('Email Configurations') }}</span></a></li>
                    <li><a href="{{route('admin-group-show')}}"><span>{{ __('Group Email') }}</span></a></li>
                </ul>
            </li>

            <!-- Social Settings -->
            <li>
                <a href="#socials" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-paper-plane"></i> {{ __('Social Settings') }}
                </a>
                <ul class="collapse list-unstyled" id="socials" data-parent="#general">
                    <li><a href="{{route('admin-sociallink-index')}}"><span>{{ __('Social Links') }}</span></a></li>
                    <li><a href="{{route('admin-social-facebook')}}"><span>{{ __('Facebook Login') }}</span></a></li>
                    <li><a href="{{route('admin-social-google')}}"><span>{{ __('Google Login') }}</span></a></li>
                </ul>
            </li>

            <!-- Language Settings -->
            <li>
                <a href="#langs" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-language"></i> {{ __('Language Settings') }}
                </a>
                <ul class="collapse list-unstyled" id="langs" data-parent="#general">
                    <li><a href="{{route('admin-lang-index')}}"><span>{{ __('Website Language') }}</span></a></li>
                    <li><a href="{{route('admin-tlang-index')}}"><span>{{ __('Admin Panel Language') }}</span></a></li>
                </ul>
            </li>

            <!-- SEO Tools -->
            <li>
                <a href="#seoTools" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-wrench"></i> {{ __('SEO Tools') }}
                </a>
                <ul class="collapse list-unstyled" id="seoTools" data-parent="#general">
                    <li><a href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a></li>
                    <li><a href="{{ route('admin-seotool-analytics') }}"><span>{{ __('Google Analytics') }}</span></a></li>
                    <li><a href="{{ route('admin-seotool-keywords') }}"><span>{{ __('Website Meta Keywords') }}</span></a></li>
                </ul>
            </li>
        </ul>
    </li>

    <li class="menu-item">
        <a href="{{ route('admin-cache-clear') }}" class="menu-link wave-effect">
            <span class="icon-wrapper">
                <i class="fas fa-sync"></i>
            </span>
            <span class="menu-text">{{ __('Clear Cache') }}</span>
        </a>
    </li>
