    <li class="menu-item">
        <a href="{{ route('admin-orders-all') }}" class="menu-link wave-effect">
            <span class="icon-wrapper">
                <i class="fas fa-shopping-cart"></i>
            </span>
            <span class="menu-text">{{ __('Orders') }}</span>
        </a>
    </li>

    <li class="menu-item">
        <a href="#menu5" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <span class="icon-wrapper">
                <i class="fas fa-sitemap"></i>
            </span>
            <span class="menu-text">{{ __('Manage Categories') }}</span>
        </a>
        <ul class="collapse list-unstyled
        @if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category')
          show
        @elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory')
          show
        @elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory')
          show
        @endif" id="menu5" data-parent="#accordion" >
            <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category') active @endif">
                <a href="{{ route('admin-cat-index') }}"><span>{{ __('Main Category') }}</span></a>
            </li>
            <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory') active @endif">
                <a href="{{ route('admin-subcat-index') }}"><span>{{ __('Sub Category') }}</span></a>
            </li>
            <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory') active @endif">
                <a href="{{ route('admin-childcat-index') }}"><span>{{ __('Child Category') }}</span></a>
            </li>
        </ul>
    </li>

    <li class="menu-item">
        <a href="{{ route('admin-prod-index') }}" class="menu-link wave-effect">
            <span class="icon-wrapper">
                <i class="icofont-cart"></i>
            </span>
            <span class="menu-text">{{ __('Products') }}</span>
        </a>
    </li>

    <!-- General Settings - Main Menu (moved everything here, removed Site Settings wrapper) -->
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

            <!-- Logo -->
            <li>
                <a href="{{ route('admin-gs-logo') }}"><i class="fas fa-image"></i> {{ __('Logo') }}</a>
            </li>

            <!-- Shipping Methods -->
            <li>
                <a href="{{ route('admin-shipping-index') }}"><i class="fas fa-shipping-fast"></i> {{ __('Shipping Methods') }}</a>
            </li>

            <!-- Website Contents -->
            <li>
                <a href="{{ route('admin-gs-contents') }}"><i class="fas fa-file-alt"></i> {{ __('Website Contents') }}</a>
            </li>

            <!-- Breadcrumb Banner -->
            <li>
                <a href="{{ route('admin-gs-bread') }}"><i class="fas fa-stream"></i> {{ __('Breadcrumb Banner') }}</a>
            </li>

            <!-- Error Banner -->
            <li>
                <a href="{{ route('admin-gs-error-banner') }}"><i class="fas fa-exclamation-triangle"></i> {{ __('Error Banner') }}</a>
            </li>

            <!-- Customers -->
            <li>
                <a href="#customers" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                    <i class="icofont-user"></i> {{ __('Customers') }}
                </a>
                <ul class="collapse list-unstyled" id="customers" data-parent="#general">
                    <li><a href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a></li>
                    <li><a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a></li>
                    <li><a href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a></li>
                </ul>
            </li>

            <!-- Manage Staffs -->
            <li>
                <a href="{{ route('admin-staff-index') }}"><i class="fas fa-user-secret"></i> {{ __('Manage Staffs') }}</a>
            </li>

            <!-- Manage Roles -->
            <li>
                <a href="{{ route('admin-role-index') }}"><i class="fas fa-user-tag"></i> {{ __('Manage Roles') }}</a>
            </li>

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
                    <i class="fas fa-wrench"></i> {{ __('SEO Tools') }}</a>
                <ul class="collapse list-unstyled" id="seoTools" data-parent="#general">
                    <li><a href="{{route('admin-prod-popular',['id'=>'views'])}}"><span>{{ __('Popular Products') }}</span></a></li>
                    <li><a href="{{route('admin-seotool-analytics')}}"><span>{{ __('Google Analytics') }}</span></a></li>
                    <li><a href="{{route('admin-seotool-keywords')}}"><span>{{ __('Website Meta Keywords') }}</span></a></li>
                </ul>
            </li>
        </ul>
    </li>
                </a>
                <ul class="collapse list-unstyled" id="seoTools" data-parent="#siteSettings">
                    <li><a href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a></li>
                    <li><a href="{{ route('admin-seotool-analytics') }}"><span>{{ __('Google Analytics') }}</span></a></li>
                    <li><a href="{{ route('admin-seotool-keywords') }}"><span>{{ __('Website Meta Keywords') }}</span></a></li>
                </ul>
            </li>

            <!-- Clear Cache -->
            <li>
                <a href="{{ route('admin-cache-clear') }}"><i class="fas fa-sync"></i> {{ __('Clear Cache') }}</a>
            </li>

        </ul>
    </li>
