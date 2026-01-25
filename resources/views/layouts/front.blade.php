<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="GeniusCart-New - Multivendor Ecommerce system">
    <meta name="author" content="GeniusOcean">

    @if (isset($page->meta_tag) && isset($page->meta_description))
        <meta name="keywords" content="{{ $page->meta_tag }}">
        <meta name="description" content="{{ $page->meta_description }}">
        <title>{{ $gs->title }}</title>
    @elseif(isset($blog->meta_tag) && isset($blog->meta_description))
        <meta property="og:title" content="{{ $blog->title }}" />
        <meta property="og:description"
            content="{{ $blog->meta_description != null ? $blog->meta_description : strip_tags($blog->meta_description) }}" />
        <meta property="og:image" content="{{ asset('assets/images/blogs/' . $blog->photo) }}" />
        <meta name="keywords" content="{{ $blog->meta_tag }}">
        <meta name="description" content="{{ $blog->meta_description }}">
        <title>{{ $gs->title }}</title>
    @elseif(isset($productt))
        <meta name="keywords" content="{{ !empty($productt->meta_tag) ? implode(',', $productt->meta_tag) : '' }}">
        <meta name="description"
            content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}">
        <meta property="og:title" content="{{ $productt->name }}" />
        <meta property="og:description"
            content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}" />
        <meta property="og:image" content="{{ asset('assets/images/thumbnails/' . $productt->thumbnail) }}" />
        <meta name="author" content="GeniusOcean">
        <title>{{ substr($productt->name, 0, 11) . '-' }}{{ $gs->title }}</title>
    @else
        <meta property="og:title" content="{{ $gs->title }}" />
        <meta property="og:image" content="{{ asset('assets/images/' . $gs->logo) }}" />
        <meta name="keywords" content="{{ $seo->meta_keys }}">
        <meta name="author" content="GeniusOcean">
        <title>{{ $gs->title }}</title>
    @endif

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/' . $gs->favicon) }}" />
    
    <!-- Professional Bilingual Font System -->
    @php
        $bilingualFonts = \App\Models\Font::getBilingualFonts();
        $arabicFont = $bilingualFonts['arabic'];
        $englishFont = $bilingualFonts['english'];
    @endphp
    
    <!-- Google Fonts - Arabic Font -->
    @if ($arabicFont && $arabicFont->font_value)
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family={{ $arabicFont->font_value }}:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @endif
    
    <!-- Google Fonts - English Font -->
    @if ($englishFont && $englishFont->font_value)
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family={{ $englishFont->font_value }}:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @endif

    <link rel="stylesheet"href="{{ asset('assets/front/css/styles.php?color=' . str_replace('#', '', $gs->colors) . '&header_color=' . $gs->header_color) }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/plugin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/webfonts/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/template.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/product-card-custom.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/product-card-responsive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/cart-sidebar-responsive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive-fixes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/header-responsive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/slider-header-fix.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/footer-spacing-fix.css') }}?v={{ time() }}">

    <!-- RTL/LTR Support with Professional Arabic Font -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/rtl-ltr-arabic-font.css') }}?v={{ time() }}">

    <!-- Global Arabic RTL Support for All Pages -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/arabic-rtl-global.css') }}?v={{ time() }}">
    
    <!-- Professional Bilingual Font System -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/bilingual-fonts.css') }}?v={{ time() }}">

    <!-- Product Image & Scrollbar Fixes -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/product-image-scrollbar-fix.css') }}?v={{ time() }}">

    <link rel="stylesheet" href="{{ asset('assets/front/css/category/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">
    
    <!-- Dynamic Font Variables -->
    <style>
        :root {
            --arabic-font-family: '{{ $arabicFont->font_family ?? "Cairo" }}', sans-serif;
            --english-font-family: '{{ $englishFont->font_family ?? "Poppins" }}', sans-serif;
            --arabic-font-weight: 400;
            --english-font-weight: 400;
        }
        
        /* Apply fonts based on language */
        html[lang="ar"] body,
        html[lang="ar"] * {
            font-family: var(--arabic-font-family) !important;
        }
        
        html[lang="en"] body,
        html[lang="en"] * {
            font-family: var(--english-font-family) !important;
        }
        
        /* Mixed content - detect language per element */
        *[lang="ar"] {
            font-family: var(--arabic-font-family) !important;
        }
        
        *[lang="en"] {
            font-family: var(--english-font-family) !important;
        }
    </style>
    
    @if ($default_font->font_family)
        <link rel="stylesheet" id="colorr"
            href="{{ asset('assets/front/css/font.php?font_familly=' . $default_font->font_family) }}">
    @else
        <link rel="stylesheet" id="colorr"
            href="{{ asset('assets/front/css/font.php?font_familly=' . 'Open Sans') }}">
    @endif

    @if (!empty($seo->google_analytics))
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $seo->google_analytics }}');
        </script>
    @endif
    @if (!empty($seo->facebook_pixel))
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $seo->facebook_pixel }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $seo->facebook_pixel }}&ev=PageView&noscript=1" />
        </noscript>
    @endif


    {{-- Scrollbar Fix CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/scrollbar-fix.css') }}">

    {{-- Mobile Responsive Fix CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/mobile-fix.css') }}">

    {{-- Mobile Search Icon Force Styling --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/mobile-search-icon-force.css') }}?v={{ time() }}">

    {{-- Desktop Search Professional Design --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/desktop-search-professional.css') }}?v={{ time() }}">

    {{-- NUCLEAR OVERRIDE - Mobile Search Icon - MUST BE LAST --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/search-icon-nuclear-override.css') }}?v={{ time() }}">

    {{-- Desktop Search Nuclear Fix - Force Functionality --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/desktop-search-nuclear-fix.css') }}?v={{ time() }}">

    {{-- SEARCH Z-INDEX AND POSITIONING FIX - Fixes navbar blocking input & positioning --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/search-zindex-positioning-fix.css') }}?v={{ time() }}">

    {{-- DESKTOP FLAG & SEARCH POSITIONING FORCE - Triple flag size, center search, flag to right --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/desktop-flag-search-positioning-force.css') }}?v={{ time() }}">

    {{-- DESKTOP HEADER COMPLETE FIX - Ensures cart icon visibility and proper z-index --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/desktop-header-complete-fix.css') }}?v={{ time() }}">

    {{-- CART BADGE CENTER FIX - Centers number and adds spacing --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/cart-badge-center-fix.css') }}?v={{ time() }}">

    {{-- SLIDER SIZE FORCE - Desktop +25%, Mobile -35% - ABSOLUTE LAST --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/slider-size-force.css') }}?v={{ time() }}">

    {{-- MOBILE FLAG SIZE FORCE - Increase flag on mobile - VERY LAST --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/mobile-flag-size-force.css') }}?v={{ time() }}">

    @yield('css')
</head>

<body>

    <div id="page_wrapper" class="bg-white">
        <div class="loader">
            <div class="spinner"></div>
        </div>

        @yield('content')
    </div>
    <script>
        var mainurl = "{{ url('/') }}";
        var gs = {!! json_encode(
            DB::table('generalsettings')->where('id', '=', 1)->first(['is_loader', 'decimal_separator', 'thousand_separator', 'is_cookie', 'is_talkto', 'talkto']),
        ) !!};
        var ps_category = {{ $ps->category }};

        var lang = {
            'days': '{{ __('Days') }}',
            'hrs': '{{ __('Hrs') }}',
            'min': '{{ __('Min') }}',
            'sec': '{{ __('Sec') }}',
            'cart_already': '{{ __('Already Added To Card.') }}',
            'cart_out': '{{ __('Out Of Stock') }}',
            'cart_success': '{{ __('Successfully Added To Cart.') }}',
            'cart_empty': '{{ __('Cart is empty.') }}',
            'coupon_found': '{{ __('Coupon Found.') }}',
            'no_coupon': '{{ __('No Coupon Found.') }}',
            'already_coupon': '{{ __('Coupon Already Applied.') }}',
            'enter_coupon': '{{ __('Enter Coupon First') }}',
            'minimum_qty_error': '{{ __('Minimum Quantity is:') }}',
            'affiliate_link_copy': '{{ __('Affiliate Link Copied Successfully') }}'
        };
    </script>
    <!-- Include Scripts -->
    <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
    <!-- jQuery CDN Fallback -->
    <script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>')</script>
    <script src="{{ asset('assets/front/js/jquery-ui.min.js') }}"></script>
    <script>window.jQuery.ui || document.write('<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"><\/script>')</script>

    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/plugin.js') }}"></script>
    <script src="{{ asset('assets/front/js/waypoint.js') }}"></script>
    <script src="{{ asset('assets/front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/wow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.plugin.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.countdown.js') }}"></script>
    @yield('zoom')
    <script src="{{ asset('assets/front/js/paraxify.js') }}"></script>


    <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/custom.js') }}"></script>
    <script src="{{ asset('assets/front/js/main.js') }}?v={{ \Illuminate\Support\Facades\File::exists(public_path('assets/front/js/main.js')) ? filemtime(public_path('assets/front/js/main.js')) : time() }}"></script>
    <script src="{{ asset('assets/front/js/product-card-custom.js') }}?v={{ \Illuminate\Support\Facades\File::exists(public_path('assets/front/js/product-card-custom.js')) ? filemtime(public_path('assets/front/js/product-card-custom.js')) : time() }}"></script>
    <script src="{{ asset('assets/front/js/cart-sidebar-responsive.js') }}"></script>
    <script src="{{ asset('assets/front/js/header-responsive.js') }}?v={{ time() }}"></script>
    
    <!-- Professional Bilingual Font System -->
    <script src="{{ asset('assets/front/js/bilingual-fonts.js') }}?v={{ time() }}"></script>
    
    <!-- Professional Facebook Pixel E-commerce Tracking -->
    @if (!empty($seo->facebook_pixel))
    <script src="{{ asset('assets/front/js/facebook-pixel-ecommerce.js') }}?v={{ time() }}"></script>
    @endif

    <script>
        lazy();

        function lazy() {
            $(".lazy").Lazy({
                scrollDirection: 'vertical',
                effect: "fadeIn",
                effectTime: 1000,
                threshold: 0,
                visibleOnly: false,
                onError: function(element) {
                    console.log('error loading ' + element.data('src'));
                }
            });
        }
    </script>





    @php
        echo Toastr::message();
    @endphp
    @yield('script')
</body>

</html>
