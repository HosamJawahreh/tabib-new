 <!--==================== Header Section Start ====================-->
 <header class="ecommerce-header">
   <style>
     /* Stabilize scrollbar to avoid layout shift/jitter */
     html { scrollbar-gutter: stable both-edges; }
     html, body { overflow-x: hidden; overflow-y: scroll; scroll-behavior: auto; }

   /* AGGRESSIVE STICKY HEADER - FORCE APPLY */
   header.ecommerce-header,
   .ecommerce-header,
   header {
       position: -webkit-sticky !important;
       position: sticky !important;
       top: 0 !important;
       left: 0 !important;
       right: 0 !important;
       z-index: 9999 !important;
       background: #ffffff !important;
       background-color: #ffffff !important;
       box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1) !important;
       width: 100% !important;
       will-change: transform !important;
   }

   /* Ensure body and parent containers allow sticky positioning */
   body {
       position: relative !important;
       overflow-x: hidden !important;
   }

   #page_wrapper,
   .page_wrapper {
       overflow: visible !important;
       position: relative !important;
   }

   /* COMPLETE RTL Support for Arabic Language - FLIP ENTIRE LAYOUT */
   html[lang="ar"],
   html[lang="arabic"],
   html[lang="Arabic"],
   html[lang="العربية"],
   html[dir="rtl"],
   body[dir="rtl"],
   .rtl,
   html[lang="ar"] body,
   html[lang="ar"] #page_wrapper {
       direction: rtl !important;
   }

   /* Also check body class for RTL */
   body.rtl,
   body.ar,
   body.arabic {
       direction: rtl !important;
   }

   /* Header Row RTL - Logo to RIGHT, Icons to LEFT */
   html[lang="ar"] .main-nav-row,
   html[lang="arabic"] .main-nav-row,
   html[lang="Arabic"] .main-nav-row,
   html[lang="العربية"] .main-nav-row,
   html[dir="rtl"] .main-nav-row,
   body[dir="rtl"] .main-nav-row,
   body.rtl .main-nav-row,
   body.ar .main-nav-row,
   body.arabic .main-nav-row {
       direction: rtl !important;
       display: flex !important;
       flex-direction: row-reverse !important;
   }

   html[lang="ar"] .logo-col,
   html[lang="arabic"] .logo-col,
   html[lang="Arabic"] .logo-col,
   html[lang="العربية"] .logo-col,
   html[dir="rtl"] .logo-col,
   body[dir="rtl"] .logo-col,
   body.rtl .logo-col,
   body.ar .logo-col,
   body.arabic .logo-col {
       text-align: right !important;
       order: 3 !important;
   }

   html[lang="ar"] .search-col,
   html[lang="arabic"] .search-col,
   html[lang="Arabic"] .search-col,
   html[lang="العربية"] .search-col,
   html[dir="rtl"] .search-col,
   body[dir="rtl"] .search-col,
   body.rtl .search-col,
   body.ar .search-col,
   body.arabic .search-col {
       order: 2 !important;
   }

   html[lang="ar"] .icons-col,
   html[lang="arabic"] .icons-col,
   html[lang="Arabic"] .icons-col,
   html[lang="العربية"] .icons-col,
   html[dir="rtl"] .icons-col,
   body[dir="rtl"] .icons-col,
   body.rtl .icons-col,
   body.ar .icons-col,
   body.arabic .icons-col {
       order: 1 !important;
   }

   /* Icons align to LEFT in Arabic */
   html[lang="ar"] .col-icons,
   html[lang="arabic"] .col-icons,
   html[lang="Arabic"] .col-icons,
   html[lang="العربية"] .col-icons,
   html[dir="rtl"] .col-icons,
   body[dir="rtl"] .col-icons,
   body.rtl .col-icons,
   body.ar .col-icons {
       justify-content: flex-start !important;
   }

   /* Logo align to RIGHT in Arabic */
   html[lang="ar"] .navbar-brand,
   html[lang="arabic"] .navbar-brand,
   html[lang="Arabic"] .navbar-brand,
   html[lang="العربية"] .navbar-brand,
   html[dir="rtl"] .navbar-brand,
   body[dir="rtl"] .navbar-brand,
   body.rtl .navbar-brand,
   body.ar .navbar-brand {
       margin-left: auto !important;
       margin-right: 0 !important;
   }

   /* Search bar RTL */
   html[lang="ar"] .search-form,
   html[lang="arabic"] .search-form,
   html[lang="Arabic"] .search-form,
   html[lang="العربية"] .search-form,
   html[dir="rtl"] .search-form,
   body[dir="rtl"] .search-form,
   body.rtl .search-form,
   body.ar .search-form {
       direction: rtl !important;
   }

   html[lang="ar"] .search-field,
   html[lang="arabic"] .search-field,
   html[lang="Arabic"] .search-field,
   html[lang="العربية"] .search-field,
   html[dir="rtl"] .search-field,
   body[dir="rtl"] .search-field,
   body.rtl .search-field,
   body.ar .search-field {
       text-align: right !important;
       direction: rtl !important;
   }

   /* Flip search button in RTL */
   html[lang="ar"] .enhanced-search-form,
   html[lang="arabic"] .enhanced-search-form,
   html[dir="rtl"] .enhanced-search-form,
   body[dir="rtl"] .enhanced-search-form,
   body.rtl .enhanced-search-form,
   body.ar .enhanced-search-form {
       flex-direction: row-reverse !important;
       display: flex !important;
   }

   html[lang="ar"] .search-submit,
   html[lang="arabic"] .search-submit,
   html[dir="rtl"] .search-submit,
   body[dir="rtl"] .search-submit,
   body.rtl .search-submit,
   body.ar .search-submit {
       border-radius: 50px 0 0 50px !important;
       order: -1 !important;
   }

   html[lang="ar"] .search-field,
   html[lang="arabic"] .search-field,
   html[dir="rtl"] .search-field,
   body[dir="rtl"] .search-field,
   body.rtl .search-field,
   body.ar .search-field {
       border-radius: 0 50px 50px 0 !important;
   }
      /* Menu items RTL */
   html[lang="ar"] .navbar-nav,
   html[lang="ar"] .header-menu,
   html[lang="ar"] .nav,
   html[lang="ar"] ul.nav,
   html[lang="arabic"] .navbar-nav,
   html[lang="arabic"] .header-menu,
   html[lang="Arabic"] .navbar-nav,
   html[lang="العربية"] .navbar-nav,
   html[dir="rtl"] .navbar-nav,
   body[dir="rtl"] .navbar-nav,
   body.rtl .navbar-nav,
   body.ar .navbar-nav {
       direction: rtl !important;
       text-align: right !important;
   }

   html[lang="ar"] .navbar-nav > li,
   html[lang="ar"] .header-menu > li,
   html[lang="ar"] .nav > li,
   html[lang="arabic"] .navbar-nav > li,
   html[lang="Arabic"] .navbar-nav > li,
   html[lang="العربية"] .navbar-nav > li,
   html[dir="rtl"] .navbar-nav > li,
   body[dir="rtl"] .navbar-nav > li,
   body.rtl .navbar-nav > li,
   body.ar .navbar-nav > li {
       float: right !important;
   }

   html[lang="ar"] .dropdown-menu,
   html[lang="arabic"] .dropdown-menu,
   html[lang="Arabic"] .dropdown-menu,
   html[lang="العربية"] .dropdown-menu,
   html[dir="rtl"] .dropdown-menu,
   body[dir="rtl"] .dropdown-menu,
   body.rtl .dropdown-menu,
   body.ar .dropdown-menu {
       right: 0 !important;
       left: auto !important;
       text-align: right !important;
   }

   /* Mobile menu RTL */
   @media (max-width: 991px) {
       html[lang="ar"] .col-4,
       html[lang="arabic"] .col-4,
       html[lang="Arabic"] .col-4,
       html[lang="العربية"] .col-4,
       html[dir="rtl"] .col-4,
       body[dir="rtl"] .col-4,
       body.rtl .col-4,
       body.ar .col-4 {
           order: 3 !important;
       }
       html[lang="ar"] .col-8,
       html[lang="arabic"] .col-8,
       html[lang="Arabic"] .col-8,
       html[lang="العربية"] .col-8,
       html[dir="rtl"] .col-8,
       body[dir="rtl"] .col-8,
       body.rtl .col-8,
       body.ar .col-8 {
           order: 1 !important;
       }
   }

   /* Global Product Price Styling - Primary Green Color */
   .price ins,
   .product-price ins,
   .price-current,
   .product-price .price ins,
   ins {
       color: #7caa53 !important;
       font-weight: 600 !important;
       text-decoration: none !important;
   }

   /* DISABLE any fixed-top or alternate headers */
   /* Make header sticky on scroll */
   .ecommerce-header {
       position: fixed !important;
       top: 0 !important;
       left: 0 !important;
       right: 0 !important;
       z-index: 1000 !important;
       background: #fff !important;
       display: block !important;
       visibility: visible !important;
       opacity: 1 !important;
       overflow: visible !important;
       width: 100% !important;
       box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
   }

   /* Minimal padding to body - just enough for header */
   /* Note: index.blade.php also sets padding, this is a fallback */

   /* Prevent header row from scrolling */
   .main-nav-row,
   .container-fluid,
   .main-nav {
       overflow: visible !important;
   }

   /* Ensure body doesn't get horizontal scroll from cart */
   body {
       overflow-x: hidden !important;
   }

   html {
       overflow-x: hidden !important;
   }

   /* Logo Sizing - Bigger 150px height */
   img.nav-logo.header-logo-responsive,
   .navbar-brand img.nav-logo,
   .header-logo-responsive {
       height: 150px !important;
       width: auto !important;
       max-height: 150px !important;
       object-fit: contain !important;
   }
   @media (min-width: 768px) {
       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           height: 150px !important;
           width: auto !important;
           max-height: 150px !important;
       }
   }
   @media (min-width: 1200px) {
       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           height: 150px !important;
           width: auto !important;
           max-height: 150px !important;
       }
   }

   /* Small Desktop (992px - 1199px) - Show search bar with compact layout */
   @media (min-width: 992px) and (max-width: 1199px) {
       .search-col {
           display: block !important;
       }

       .enhanced-search-form {
           max-width: 100% !important;
       }

       .enhanced-search-form .search-field {
           font-size: 13px !important;
           padding: 8px 15px !important;
       }

       .enhanced-search-form .categori-container select {
           min-width: 90px !important;
           font-size: 12px !important;
           padding: 8px 25px 8px 10px !important;
       }

       .col-icons {
           gap: 6px !important;
           overflow: visible !important;
       }

       .icons-col {
           overflow: visible !important;
           padding-right: 18px !important;
       }

       .header-icon-enhanced {
           min-width: 40px;
           max-width: 40px;
           padding: 8px !important;
       }

       .cart-icon {
           padding: 8px !important;
       }

       .cart-icon i {
           font-size: 18px !important;
       }

       .header-cart-count {
           top: 2px !important;
           right: 2px !important;
       }

       .language-selector-modern select {
           font-size: 12px !important;
           width: 75px !important;
           max-width: 75px !important;
       }
   }

   /* Mobile Menu Improvements - Keep items in one line */
   @media (max-width: 991px) {
       .ecommerce-header {
           height: 70px !important; /* Increased height */
           padding: 8px 20px !important; /* Better padding */
           min-height: 70px !important;
       }

       .main-nav {
           width: 100% !important; /* Full width */
           padding: 0 !important;
       }

       .main-nav .container-fluid {
           width: 100% !important;
           max-width: 100% !important;
           padding: 0 15px !important;
       }

       .main-nav-row {
           height: 80px !important;
           min-height: 80px !important;
           display: flex !important;
           align-items: center !important;
           flex-wrap: nowrap !important;
           width: 100% !important;
       }

       /* REORDERING: Logo Left (1), Icons Center (2), Language Right (3) */
       .logo-col {
           order: 1 !important;
           flex: 0 0 auto !important;
           width: auto !important;
           text-align: left !important;
           display: flex !important;
           align-items: center !important;
           height: 100% !important;
       }

       .icons-col {
           order: 2 !important;
           flex: 1 1 auto !important;
           width: auto !important;
           display: flex !important;
           align-items: center !important;
           height: 100% !important;
       }

       .language-col {
           order: 3 !important;
           flex: 0 0 auto !important;
           width: auto !important;
           text-align: right !important;
           display: flex !important;
           align-items: center !important;
           height: 100% !important;
       }

       .phone-flag-col {
           display: flex !important;
           align-items: center !important;
           height: 100% !important;
       }

       /* Logo - BIGGER on mobile (60px + 20% = 72px) */
       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           height: 72px !important;
           width: auto !important;
           max-height: 72px !important;
       }

       .logo-col .navbar,
       .logo-col .navbar-brand {
           display: flex !important;
           align-items: center !important;
           height: 100% !important;
           margin: 0 !important;
       }

       .col-icons {
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
           height: 100% !important;
           gap: 10px !important;
           padding: 0 !important;
       }

       /* Force center alignment on mobile - override any desktop styles */
       .icons-col .col-icons {
           justify-content: center !important;
       }

       /* Ensure all header items are vertically centered with equal spacing */
       .header-icon-enhanced,
       .header-cart-1,
       .mobile-search-icon {
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
           margin: 0 !important;
           padding: 0 !important;
           position: relative !important;
       }

       .header-icon-enhanced a,
       .header-cart-1 a,
       .mobile-search-icon a,
       .header-cart-1 .cart,
       .mobile-search-icon > a {
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
           width: 100% !important;
           height: 100% !important;
           padding: 0 !important;
           margin: 0 !important;
       }

       .language-flag-selector {
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
           margin: 0 !important;
       }

       /* PROFESSIONAL MOBILE MENU - Compact but readable */
       .navbar-nav {
           gap: 3px !important;
       }

       .navbar-nav .nav-link {
           font-size: 13px !important;
           padding: 8px 12px !important;
       }

       .navbar-nav .nav-link i {
           font-size: 14px !important;
       }

       /* Hide icon text on smaller screens, keep icons */
       .navbar-nav .nav-link {
           gap: 5px !important;
       }

       .header-icon-enhanced {
           padding: 0 !important;
           margin: 0 !important;
           min-width: 48px !important;
           max-width: 48px !important;
           width: 48px !important;
           min-height: 48px !important;
           max-height: 48px !important;
           height: 48px !important;
           line-height: 48px !important;
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
       }

       .header-icon-enhanced i {
           font-size: 20px !important;
           line-height: 1 !important;
           margin: 0 !important;
       }

       .header-cart-1 {
           padding: 0 !important;
           margin: 0 !important;
           min-width: 48px !important;
           max-width: 48px !important;
           width: 48px !important;
           min-height: 48px !important;
           max-height: 48px !important;
           height: 48px !important;
           line-height: 48px !important;
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
       }

       .header-cart-1 .cart-icon,
       .header-cart-1 .cart {
           padding: 0 !important;
           margin: 0 !important;
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
       }

       .header-cart-1 .cart-icon i {
           font-size: 20px !important;
           line-height: 1 !important;
           margin: 0 !important;
       }

       .mobile-search-icon {
           padding: 0 !important;
           margin: 0 !important;
           min-width: 48px !important;
           max-width: 48px !important;
           width: 48px !important;
           min-height: 48px !important;
           max-height: 48px !important;
           height: 48px !important;
           line-height: 48px !important;
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
       }

       .mobile-search-icon .search-icon-wrapper,
       .mobile-search-icon i {
           margin: 0 !important;
           padding: 0 !important;
           font-size: 20px !important;
           line-height: 1 !important;
       }

       .header-cart-count {
           font-size: 9px !important;
           padding: 2px 5px !important;
           min-width: 18px;
           top: 0px !important;
           right: 0px !important;
       }

       .cart-icon {
           padding: 5px !important;
       }

       .enhanced-search-form {
           max-width: 100% !important;
           margin: 10px 0;
       }

       .header-phone-support,
       .header-phone-link {
           display: none !important;
       }

       /* Language Selector - Bigger and professional */
       .language-selector-modern {
           padding: 5px !important;
           max-width: 100px !important;
           margin-left: 10px !important;
       }

       .language-selector-modern select {
           font-size: 14px !important;
           padding: 8px !important;
           min-width: 95px !important;
           width: 95px !important;
           max-width: 95px !important;
           height: 42px !important;
       }

       /* Force icons container to stay centered */
       .col-icons {
           display: flex !important;
           flex-wrap: nowrap !important;
           gap: 8px !important;
           align-items: center !important;
           justify-content: center !important;
       }
           justify-content: flex-end !important;
           overflow: visible !important;
       }

       .icons-col {
           overflow: visible !important;
       }

       .col-icons > * {
           flex-shrink: 0 !important;
       }
   }

   @media (max-width: 576px) {
       /* Logo - Even BIGGER on small mobile (55px + 20% = 66px) */
       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           height: 66px !important;
           max-width: none !important;
           min-width: auto !important;
           width: auto !important;
           max-height: 66px !important;
       }

       /* EXTRA SMALL MOBILE - Ultra compact menu */
       .navbar-nav .nav-link {
           font-size: 12px !important;
           padding: 6px 10px !important;
       }

       .navbar-nav .nav-link i {
           font-size: 13px !important;
       }

       .navbar-nav {
           gap: 2px !important;
       }

       .header-icon-enhanced {
           padding: 4px !important;
           min-width: 36px;
           max-width: 36px;
       }

       .header-icon-enhanced i {
           font-size: 14px !important;
       }

       .col-icons {
           gap: 4px !important;
           flex-wrap: nowrap !important;
           overflow: visible !important;
       }

       .icons-col {
           overflow: visible !important;
           padding-right: 12px !important;
       }

       .cart-icon {
           padding: 5px !important;
       }

       .cart-icon i {
           font-size: 16px !important;
       }

       .language-selector-modern {
           max-width: 70px !important;
       }

       .language-selector-modern select {
           font-size: 11px !important;
           padding: 3px 4px !important;
           width: 65px !important;
           max-width: 65px !important;
       }

       .header-cart-count {
           font-size: 8px !important;
           padding: 2px 4px !important;
           top: 0px !important;
           right: 0px !important;
           min-width: 16px !important;
           height: 14px !important;
       }
   }

   /* Professional Modern Search Bar Design - 35% Smaller */
   .enhanced-search-form {
       border: 2px solid #e8ecef !important;
       border-radius: 50px !important;
       overflow: hidden;
       box-shadow: 0 2px 8px rgba(0,0,0,0.06);
       transition: all 0.3s ease;
       max-width: 390px !important; /* 35% smaller than 600px */
       width: 100% !important;
       margin: 0 auto;
       background: #ffffff !important;
       display: flex !important;
       align-items: center !important;
   }
   .enhanced-search-form:hover {
       border-color: #cbd5e0 !important;
       box-shadow: 0 4px 12px rgba(0,0,0,0.1);
   }
   .enhanced-search-form:focus-within {
       border-color: #4299e1 !important;
       box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1), 0 4px 12px rgba(0,0,0,0.1);
   }

   .enhanced-search-form .search-field {
       border: none !important;
       padding: 10px 20px !important;
       font-size: 14px !important;
       background: transparent !important;
       color: #2d3748 !important;
       flex: 1 !important;
   }
   .enhanced-search-form .search-field::placeholder {
       color: #a0aec0 !important;
       font-weight: 400;
   }
   .enhanced-search-form .search-field:focus {
       outline: none !important;
       box-shadow: none !important;
   }

   .enhanced-search-form .categori-container {
       border-left: 1px solid #e8ecef !important;
       border-right: 1px solid #e8ecef !important;
       padding: 0 !important;
   }
   .enhanced-search-form .categori-container select {
       border: none !important;
       padding: 10px 35px 10px 15px !important;
       background-color: #f7fafc !important;
       font-size: 13px !important;
       color: #4a5568 !important;
       cursor: pointer !important;
       min-width: 120px !important;
       font-weight: 500 !important;
       transition: background-color 0.2s ease;
   }
   .enhanced-search-form .categori-container select:hover {
       background-color: #edf2f7 !important;
   }
   .enhanced-search-form .categori-container select:focus {
       outline: none !important;
       background-color: #edf2f7 !important;
   }

   .enhanced-search-form .search-submit {
       background: linear-gradient(135deg, #7caa53 0%, #6a9447 100%) !important;
       border: none !important;
       padding: 10px 24px !important;
       border-radius: 0 50px 50px 0 !important;
       transition: all 0.3s ease;
       cursor: pointer !important;
       margin: 0 !important;
   }
   .enhanced-search-form .search-submit:hover {
       background: linear-gradient(135deg, #6a9447 0%, #5a7f3a 100%) !important;
       transform: scale(1.03);
   }
   .enhanced-search-form .search-submit i {
       font-size: 16px !important;
       color: #ffffff !important;
   }

   /* Modern Language Selector */
   .language-selector-modern {
       position: relative;
       min-width: 90px !important;
   }
   .language-selector-modern select {
       border: 1px solid #e8ecef !important;
       padding: 6px 28px 6px 10px !important;
       border-radius: 20px !important;
       font-size: 12px !important;
       background: #ffffff !important;
       color: #4a5568 !important;
       cursor: pointer;
       transition: all 0.3s ease;
       appearance: none;
       -webkit-appearance: none;
       -moz-appearance: none;
       background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 10 10'%3E%3Cpath fill='%234a5568' d='M5 7L1 3h8z'/%3E%3C/svg%3E") !important;
       background-repeat: no-repeat !important;
       background-position: right 8px center !important;
       background-size: 10px !important;
       font-weight: 500 !important;
   }
   .language-selector-modern select:hover {
       border-color: #cbd5e0 !important;
       box-shadow: 0 2px 6px rgba(0,0,0,0.06);
   }
   .language-selector-modern select:focus {
       outline: none !important;
       border-color: #4299e1 !important;
       box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
   }

   /* Flag-based Language Selector */
   .language-flag-selector {
       display: flex;
       align-items: center;
       justify-content: flex-end;
       padding: 0 !important;
   }

   .language-flag-selector .flag-link {
       display: inline-flex;
       align-items: center;
       justify-content: center;
       padding: 0;
       border-radius: 6px;
       transition: all 0.3s ease;
       background: transparent;
       border: none;
       box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
   }

   .language-flag-selector .flag-link:hover {
       transform: scale(1.05);
       box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
   }

   .language-flag-selector .flag-icon {
       width: 36px;
       height: 27px;
       object-fit: cover;
       border-radius: 6px;
       display: block;
       border: 1px solid rgba(0, 0, 0, 0.08);
   }

   /* Desktop - Slightly larger but still compact */
   @media (min-width: 992px) {
       .language-flag-selector .flag-icon {
           width: 40px;
           height: 30px;
           border-radius: 6px;
       }
   }

   /* Mobile - Smaller flags */
   @media (max-width: 991px) {
       .language-flag-selector .flag-icon {
           width: 32px;
           height: 24px;
           border-radius: 5px;
       }
   }

   /* Phone and Flag Column - Far Right Positioning */
   .phone-flag-col {
       padding-right: 20px !important;
       gap: 12px !important;
   }

   @media (max-width: 991px) {
       .phone-flag-col {
           padding-right: 10px !important;
           gap: 8px !important;
       }
   }

   /* Language and Phone Column - Desktop Layout */
   .language-phone-col {
       padding-left: 20px !important;
   }

   @media (max-width: 991px) {
       .language-phone-col {
           order: 3 !important;
           padding-left: 10px !important;
       }
   }

   /* Ensure proper alignment on desktop */
   @media (min-width: 992px) {
       .main-nav-row {
           justify-content: space-between;
       }

       .language-phone-col {
           order: 1 !important;
       }

       .logo-col {
           order: 2 !important;
       }

       .icons-col {
           order: 3 !important;
       }

       .col-icons {
           justify-content: flex-end !important;
       }
   }

   /* Icon styling - compact and modern */
   .header-icon-enhanced {
       position: relative;
       padding: 4px 6px;
       margin: 0 2px;
       transition: all 0.3s ease;
       border-radius: 8px;
       display: flex !important;
       align-items: center !important;
       justify-content: center !important;
   }
   .header-icon-enhanced:hover {
       background-color: #f7fafc;
       transform: translateY(-1px);
   }
   .header-icon-enhanced i {
       font-size: 18px !important;
       color: #4a5568 !important;
   }

   /* Cart icon container - ensure visibility and stability */
   .header-cart-1 {
       position: relative !important;
       display: flex !important;
       align-items: center !important;
       overflow: visible !important;
   }

   .header-cart-1 .cart {
       display: flex !important;
       align-items: center !important;
       text-decoration: none !important;
       position: relative !important;
   }

   /* Cart icon - always visible with proper spacing */
   .cart-icon {
       display: flex !important;
       align-items: center !important;
       justify-content: center !important;
       gap: 4px !important;
       position: relative !important;
       padding: 8px !important;
   }

   .cart-icon i {
       font-size: 20px !important;
       color: #4a5568 !important;
   }

   /* Cart count badge - visible positioning */
   .header-cart-count {
       visibility: visible !important;
       opacity: 1 !important;
       display: inline-flex !important;
       align-items: center !important;
       justify-content: center !important;
       background: #4299e1 !important;
       color: white !important;
       font-size: 10px !important;
       padding: 3px 6px !important;
       border-radius: 12px !important;
       font-weight: 700 !important;
       min-width: 20px !important;
       height: 18px !important;
       text-align: center !important;
       position: absolute !important;
       top: 2px !important;
       right: 2px !important;
       z-index: 10 !important;
   }

   .cart-wrap {
       display: none !important;
   }

   /* Ensure cart icon has enough space for badge */
   .header-cart-1 .cart-icon i {
       position: relative;
       z-index: 1;
   }

   /* Make sure parent containers don't clip the badge */
   .header-cart-1,
   .header-icon-enhanced,
   .col-icons,
   .icons-col {
       overflow: visible !important;
   }

   /* Add padding to icons column to prevent badge clipping */
   .icons-col {
       padding-right: 20px !important;
   }

   /* Make header icon enhanced have padding for badge space */
   .header-icon-enhanced {
       padding: 8px !important;
   }

   @media (max-width: 767px) {
       .icons-col {
           padding-right: 15px !important;
       }

       .header-icon-enhanced {
           padding: 6px !important;
       }

       .cart-icon {
           padding: 6px !important;
       }

       .cart-icon i {
           font-size: 18px !important;
       }

       .header-cart-count {
           font-size: 9px !important;
           padding: 2px 5px !important;
           min-width: 18px !important;
           height: 16px !important;
       }
   }

   /* Desktop and large screens - ensure proper spacing */
   @media (min-width: 1200px) {
       .icons-col {
           padding-right: 25px !important;
       }

       .col-icons {
           gap: 10px !important;
       }

       .header-icon-enhanced {
           padding: 10px !important;
       }

       .cart-icon {
           padding: 10px !important;
       }

       .cart-icon i {
           font-size: 22px !important;
       }

       .header-cart-count {
           top: 4px !important;
           right: 4px !important;
           font-size: 10px !important;
           padding: 3px 6px !important;
           min-width: 20px !important;
           height: 18px !important;
       }
   }
   }

   /* Account dropdown */
   .account-dropdown-mini {
       position: relative;
   }
   .account-dropdown-mini .my-account-popup {
       position: absolute;
       top: 100%;
       right: 0;
       margin-top: 8px;
       min-width: 160px;
       z-index: 1000;
   }

   /* Minimize main nav padding - compact header */
   .main-nav {
       padding-top: 8px !important;
       padding-bottom: 8px !important;
       overflow: visible !important;
       display: flex;
       align-items: center;
   }

   .main-nav-row {
       align-items: center !important;
       width: 100%;
   }

   /* Prevent header from causing page scroll */
   .ecommerce-header,
   header,
   .main-nav,
   .main-nav-row {
       overflow: visible !important;
   }

   /* Icons column should not cause overflow */
   .icons-col {
       overflow: visible !important;
   }

   .col-icons {
       overflow: visible !important;
   }

   .header-icon-enhanced,
   .header-cart-1 {
       overflow: visible !important;
       position: static !important;
   }

   /* Remove extra margins */
   .main-nav .row {
       margin: 0 !important;
       overflow: visible !important;
   }

   .main-nav .navbar {
       margin: 0 !important;
       padding: 0 !important;
   }

   /* Phone number styling - Compact, no border */
   .header-phone-link {
       font-size: 15px !important;
       font-weight: 600 !important;
       color: #4a5568 !important;
       text-decoration: none !important;
       padding: 6px 12px !important;
       border-radius: 6px !important;
       border: none !important;
       transition: all 0.3s ease !important;
       display: inline-block !important;
       background: transparent !important;
   }
   .header-phone-link:hover {
       background-color: #f0f8ea !important;
       color: #7caa53 !important;
       transform: translateY(-1px);
   }

   /* Right-aligned icons column - ensure items stay on the right */
   .icons-col .col-icons {
       display: flex;
       align-items: center;
       justify-content: center !important;
       gap: 10px;
       flex-wrap: nowrap;
   }

   /* Desktop layout - Logo far left, Icons center, Phone/Flag far right */
   @media (min-width: 992px) {
       .main-nav-row {
           display: flex;
           align-items: center;
           justify-content: space-between;
           flex-wrap: nowrap;
       }

       .logo-col {
           order: 1;
           flex: 0 0 auto;
           padding-left: 20px !important;
       }

       .icons-col {
           order: 2;
           flex: 0 0 auto;
           margin-left: auto;
           margin-right: auto;
       }

       .icons-col .col-icons {
           justify-content: center !important;
           gap: 15px;
       }

       .phone-flag-col {
           order: 3;
           flex: 0 0 auto;
           margin-left: auto !important;
           padding-right: 20px !important;
       }
   }

   /* Mobile layout - Vertically centered elements */
   @media (max-width: 991px) {
       .main-nav-row {
           display: flex;
           align-items: center !important;
           justify-content: space-between;
           min-height: 60px;
       }

       .logo-col {
           display: flex;
           align-items: center !important;
       }

       .logo-col .navbar {
           display: flex;
           align-items: center !important;
       }

       .icons-col {
           display: flex;
           align-items: center !important;
       }

       .icons-col .col-icons {
           justify-content: flex-end !important;
           align-items: center !important;
       }

       .phone-flag-col {
           display: flex;
           align-items: center !important;
       }

       /* Ensure all icon containers are vertically centered */
       .header-icon-enhanced,
       .header-cart-1,
       .language-flag-selector {
           display: flex;
           align-items: center !important;
           justify-content: center !important;
       }
   }

   /* HIDE BURGER MENU COMPLETELY - All screen sizes */
   .navbar-toggler {
       display: none !important;
       visibility: hidden !important;
   }

   /* PROFESSIONAL MENU ITEMS - Desktop & Mobile */
   .navbar-nav {
       display: flex !important;
       align-items: center !important;
       gap: 5px !important;
   }

   .navbar-nav .nav-item {
       position: relative !important;
   }

   .navbar-nav .nav-link {
       font-size: 15px !important;
       font-weight: 500 !important;
       padding: 12px 18px !important;
       color: #374151 !important;
       border-radius: 6px !important;
       transition: all 0.3s ease !important;
       display: flex !important;
       align-items: center !important;
       gap: 8px !important;
       white-space: nowrap !important;
   }

   .navbar-nav .nav-link i {
       font-size: 16px !important;
       color: #10b981 !important;
   }

   .navbar-nav .nav-link:hover,
   .navbar-nav .nav-item.active .nav-link {
       background: #f0fdf4 !important;
       color: #10b981 !important;
   }

   /* Dropdown arrow */
   .navbar-nav .dropdown-toggle::after {
       margin-left: 6px !important;
       font-size: 10px !important;
   }

   /* PROFESSIONAL MEGA DROPDOWN MENU */
   .navbar-nav .mega-dropdown-menu {
       min-width: 800px !important;
       padding: 20px !important;
       background: white !important;
       border-radius: 8px !important;
       box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1) !important;
       border: 1px solid #e5e7eb !important;
   }

   .navbar-nav .category-column {
       padding: 15px !important;
   }

   .navbar-nav .category-header {
       margin-bottom: 12px !important;
       padding-bottom: 10px !important;
       border-bottom: 2px solid #10b981 !important;
   }

   .navbar-nav .category-title {
       font-size: 16px !important;
       font-weight: 600 !important;
       color: #111827 !important;
       text-decoration: none !important;
       transition: color 0.2s ease !important;
   }

   .navbar-nav .category-title:hover {
       color: #10b981 !important;
   }

   .navbar-nav .subcategory-list {
       list-style: none !important;
       padding: 0 !important;
       margin: 0 !important;
   }

   .navbar-nav .subcategory-item {
       font-size: 14px !important;
       padding: 8px 12px !important;
       display: block !important;
       color: #6b7280 !important;
       text-decoration: none !important;
       border-radius: 6px !important;
       transition: all 0.2s ease !important;
   }

   .navbar-nav .subcategory-item:hover {
       background: #f0fdf4 !important;
       color: #10b981 !important;
       padding-left: 16px !important;
   }

   .navbar-nav .subcategory-item i {
       font-size: 12px !important;
       margin-right: 6px !important;
       color: #10b981 !important;
   }

   /* HIDE MENU ITEMS ON DESKTOP - Mobile Only */
   @media (min-width: 992px) {
       .navbar-collapse,
       .navbar-nav {
           display: none !important;
           visibility: hidden !important;
       }

       /* Remove all padding from desktop header */
       header.ecommerce-header {
           padding: 0 15px !important;
           margin: 0 !important;
       }

       .main-nav {
           padding: 0 !important;
           margin: 0 !important;
       }

       .main-nav-row {
           margin: 0 !important;
           padding: 0 !important;
       }

       .container-fluid {
           padding: 0 !important;
       }

       .logo-col,
       .search-col,
       .icons-col {
           padding-top: 5px !important;
           padding-bottom: 5px !important;
       }

       /* Bigger logo on desktop */
       .header-logo-responsive,
       .nav-logo {
           height: 100px !important;
           max-height: 100px !important;
           width: auto !important;
           display: block !important;
           margin: 0 !important;
           padding: 0 !important;
       }
   }

   /* Mobile: Minimal padding */
   @media (max-width: 991px) {
       header.ecommerce-header {
           padding: 0 8px !important;
           margin: 0 !important;
       }

       .main-nav {
           padding: 0 !important;
           margin: 0 !important;
       }

       .main-nav-row {
           margin: 0 !important;
           padding: 0 !important;
       }

       .container-fluid {
           padding: 0 !important;
       }

       .logo-col,
       .search-col,
       .icons-col {
           padding-top: 3px !important;
           padding-bottom: 3px !important;
       }

       .header-logo-responsive,
       .nav-logo {
           height: 38px !important;
           max-height: 38px !important;
           width: auto !important;
           display: block !important;
           margin: 0 !important;
           padding: 0 !important;
       }
   }

   /* Mobile styles */
   @media (max-width: 767px) {
       /* Hide desktop search bar on mobile */
       .search-col {
           display: none !important;
       }

       /* Mobile Search Icon Styling */
       .mobile-search-icon {
           padding: 8px !important;
           margin-right: 5px;
       }

       .mobile-search-icon .search-icon-wrapper {
           width: 40px;
           height: 40px;
           display: flex;
           align-items: center;
           justify-content: center;
           background: #10b981;
           border-radius: 50%;
           transition: all 0.3s ease;
       }

       .mobile-search-icon .search-icon-wrapper i {
           color: #fff !important;
           font-size: 18px !important;
       }

       .mobile-search-icon a:hover .search-icon-wrapper {
           transform: scale(1.1);
           box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
       }
   }

   /* Mobile Search Overlay - Professional Fullscreen Design */
   .mobile-search-overlay {
       position: fixed;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       background: rgba(0, 0, 0, 0.95);
       z-index: 99999;
       display: none;
       opacity: 0;
       transition: opacity 0.3s ease;
   }

   .mobile-search-overlay.active {
       display: block;
       opacity: 1;
   }

   .mobile-search-container {
       width: 100%;
       height: 100%;
       display: flex;
       flex-direction: column;
       background: #fff;
       animation: slideInFromTop 0.4s cubic-bezier(0.4, 0, 0.2, 1);
   }

   @keyframes slideInFromTop {
       from {
           transform: translateY(-100%);
       }
       to {
           transform: translateY(0);
       }
   }

   .mobile-search-header {
       padding: 20px;
       background: #1a1a1a;
       color: #fff;
       display: flex;
       align-items: center;
       justify-content: space-between;
       box-shadow: 0 2px 10px rgba(0,0,0,0.2);
   }

   .mobile-search-title {
       margin: 0;
       font-size: 20px;
       font-weight: 600;
       flex: 1;
       text-align: center;
       color: #fff;
   }

   .mobile-search-close {
       background: rgba(255, 255, 255, 0.15);
       border: none;
       width: 40px;
       height: 40px;
       border-radius: 50%;
       color: #fff;
       font-size: 20px;
       cursor: pointer;
       display: flex;
       align-items: center;
       justify-content: center;
       transition: all 0.3s ease;
   }

   .mobile-search-close:hover {
       background: rgba(255, 255, 255, 0.25);
       transform: rotate(90deg);
   }

   .mobile-search-body {
       flex: 1;
       padding: 20px;
       overflow-y: auto;
       background: #fff;
   }

   .mobile-search-form {
       margin-bottom: 20px;
   }

   .mobile-search-input-wrapper {
       position: relative;
       display: flex;
       align-items: center;
       background: #fff;
       border: 2px solid #e5e7eb;
       border-radius: 50px;
       box-shadow: 0 2px 8px rgba(0,0,0,0.08);
       padding: 5px;
       transition: all 0.3s ease;
   }

   .mobile-search-input-wrapper:focus-within {
       border-color: #10b981;
       box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
       transform: translateY(-2px);
   }

   .mobile-search-icon-input {
       color: #10b981;
       font-size: 20px;
       padding: 0 15px;
   }

   .mobile-search-input {
       flex: 1;
       border: none;
       outline: none;
       font-size: 16px;
       padding: 15px 10px;
       background: transparent;
       color: #1a1a1a;
   }

   .mobile-search-input::placeholder {
       color: #9ca3af;
   }

   .mobile-search-submit {
       background: #10b981;
       border: none;
       width: 50px;
       height: 50px;
       border-radius: 50%;
       color: #fff;
       font-size: 18px;
       cursor: pointer;
       display: flex;
       align-items: center;
       justify-content: center;
       transition: all 0.3s ease;
       box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
   }

   .mobile-search-submit:hover {
       background: #059669;
       transform: scale(1.05);
       box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
   }

   .mobile-search-suggestions {
       background: #fff;
       border-radius: 12px;
       padding: 0;
       box-shadow: 0 2px 10px rgba(0,0,0,0.05);
       max-height: calc(100vh - 250px);
       overflow-y: auto;
       display: none;
   }

   .mobile-search-suggestions.active {
       display: block;
   }

   .mobile-search-result-item {
       display: flex;
       align-items: center;
       padding: 12px 15px;
       border-bottom: 1px solid #f3f4f6;
       cursor: pointer;
       transition: all 0.2s ease;
       text-decoration: none;
       color: inherit;
   }

   .mobile-search-result-item:last-child {
       border-bottom: none;
   }

   .mobile-search-result-item:hover {
       background: #f9fafb;
       padding-left: 20px;
   }

   .mobile-search-result-image {
       width: 60px;
       height: 60px;
       object-fit: cover;
       border-radius: 8px;
       margin-right: 12px;
       background: #f3f4f6;
   }

   .mobile-search-result-info {
       flex: 1;
   }

   .mobile-search-result-name {
       font-size: 14px;
       font-weight: 600;
       color: #1a1a1a;
       margin: 0 0 4px 0;
       display: -webkit-box;
       -webkit-line-clamp: 2;
       -webkit-box-orient: vertical;
       overflow: hidden;
   }

   .mobile-search-result-price {
       font-size: 16px;
       font-weight: 700;
       color: #10b981;
       margin: 0;
   }

   .mobile-search-no-results {
       padding: 40px 20px;
       text-align: center;
       color: #9ca3af;
   }

   .mobile-search-no-results i {
       font-size: 48px;
       margin-bottom: 12px;
       opacity: 0.5;
   }

   .mobile-search-no-results p {
       margin: 0;
       font-size: 16px;
   }

   .mobile-search-loading {
       padding: 40px 20px;
       text-align: center;
       color: #10b981;
   }

   .mobile-search-loading i {
       font-size: 32px;
       animation: spin 1s linear infinite;
   }

   @keyframes spin {
       from { transform: rotate(0deg); }
       to { transform: rotate(360deg); }
   }

   .mobile-search-view-all {
       display: block;
       text-align: center;
       padding: 15px;
       background: #10b981;
       color: #fff;
       text-decoration: none;
       font-weight: 600;
       border-radius: 0 0 12px 12px;
       transition: all 0.3s ease;
   }

   .mobile-search-view-all:hover {
       background: #059669;
       color: #fff;
   }

   /* RTL Support for search results */
   [dir="rtl"] .mobile-search-result-image {
       margin-right: 0;
       margin-left: 12px;
   }

   [dir="rtl"] .mobile-search-result-item:hover {
       padding-left: 15px;
       padding-right: 20px;
   }

   /* RTL Support for Mobile Search */
   [dir="rtl"] .mobile-search-header {
       flex-direction: row-reverse;
   }

   [dir="rtl"] .mobile-search-input-wrapper {
       flex-direction: row-reverse;
   }

   [dir="rtl"] .mobile-search-icon-input {
       padding: 0 10px 0 15px;
   }   /* RTL Support - Still centered */
   [dir="rtl"] .header-cart-1 .cart-popup,
   [dir="rtl"] .has-cart-data .cart-popup,
   [dir="rtl"] .cart-popup {
       left: 50% !important;
       right: auto !important;
       margin-left: -190px !important;
       transform: translateY(-10px) !important;
   }

   [dir="rtl"] .header-cart-1:hover .cart-popup,
   [dir="rtl"] .has-cart-data:hover .cart-popup {
       transform: translateY(0) !important;
   }

   /* CRITICAL: Mobile Icon Centering - Updated 2026-01-17 - FORCE APPLY */
   @media screen and (max-width: 991px) {
       /* Force mobile header height */
       .ecommerce-header,
       header.ecommerce-header {
           height: 80px !important;
           min-height: 80px !important;
       }

       .main-nav-row {
           height: 80px !important;
           min-height: 80px !important;
       }

       /* FORCE CENTER ALIGNMENT FOR ICONS */
       .icons-col,
       div.icons-col,
       .order-2.icons-col {
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
           height: 100% !important;
       }

       .col-icons,
       .icons-col .col-icons,
       div.col-icons {
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
           height: 100% !important;
           gap: 12px !important;
           padding: 0 !important;
           margin: 0 !important;
       }

       /* FORCE EQUAL SIZING FOR ALL ICONS */
       .header-icon-enhanced,
       .header-cart-1,
       .mobile-search-icon,
       div.header-icon-enhanced,
       div.header-cart-1,
       div.mobile-search-icon {
           width: 48px !important;
           height: 48px !important;
           min-width: 48px !important;
           max-width: 48px !important;
           min-height: 48px !important;
           max-height: 48px !important;
           padding: 0 !important;
           margin: 0 !important;
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
           flex-shrink: 0 !important;
       }

       /* FORCE CENTER ALL NESTED ELEMENTS */
       .header-icon-enhanced a,
       .header-cart-1 a,
       .header-cart-1 .cart,
       .header-cart-1 .cart-icon,
       .mobile-search-icon a,
       .mobile-search-icon .search-icon-wrapper {
           display: flex !important;
           align-items: center !important;
           justify-content: center !important;
           width: 100% !important;
           height: 100% !important;
           padding: 0 !important;
           margin: 0 !important;
       }

       /* FORCE ICON SIZES */
       .header-icon-enhanced i,
       .header-cart-1 i,
       .header-cart-1 .cart-icon i,
       .mobile-search-icon i,
       .mobile-search-icon .search-icon-wrapper i {
           font-size: 22px !important;
           line-height: 1 !important;
           margin: 0 !important;
           padding: 0 !important;
       }
   }

   /* FINAL OVERRIDE - STICKY HEADER FORCE */
   header.ecommerce-header {
       position: -webkit-sticky !important;
       position: sticky !important;
       top: 0px !important;
       z-index: 9999 !important;
       background-color: #fff !important;
       box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1) !important;
   }

   /* Ensure parent containers don't prevent stickiness */
   body, #page_wrapper, .main-wrapper {
       overflow: visible !important;
       position: relative !important;
   }

   /* Desktop sticky header */
   @media (min-width: 992px) {
       header.ecommerce-header,
       .ecommerce-header {
           position: -webkit-sticky !important;
           position: sticky !important;
           top: 0 !important;
           z-index: 9999 !important;
       }

       /* DESKTOP: Make logo smaller - 100px instead of 150px */
       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           height: 100px !important;
           max-height: 100px !important;
           width: auto !important;
       }

       /* DESKTOP: Move language/phone to FAR RIGHT */
       .main-nav-row {
           display: flex !important;
           justify-content: space-between !important;
       }

       .logo-col {
           order: 1 !important;
           flex: 0 0 auto !important;
       }

       .search-col {
           order: 2 !important;
           flex: 1 1 auto !important;
       }

       .icons-col {
           order: 3 !important;
           flex: 0 0 auto !important;
       }

       .language-phone-col,
       .language-col {
           order: 4 !important;
           flex: 0 0 auto !important;
           margin-left: auto !important;
       }

       .phone-flag-col {
           display: flex !important;
           align-items: center !important;
           gap: 12px !important;
           margin-left: auto !important;
       }
   }

   /* Mobile sticky header */
   @media (max-width: 991px) {
       header.ecommerce-header,
       .ecommerce-header {
           position: -webkit-sticky !important;
           position: sticky !important;
           top: 0 !important;
           z-index: 9999 !important;
       }
   }

   </style>


@php
$categories = App\Models\Category::with('subs')->where('status',1)->get();
$pages = App\Models\Page::get();
@endphp
<div class="main-nav">
    <div class="container-fluid">
        <div class="row align-items-center main-nav-row">

            <!-- Logo Column - FAR LEFT -->
            <div class="col-lg-2 col-md-3 col-4 order-1 text-start logo-col">
                <nav class="navbar navbar-expand-lg nav-dark nav-primary-hover nav-line-active p-0">
                    <a class="navbar-brand" href="{{ route('front.index') }}">
                        <img class="nav-logo lazy header-logo-responsive" data-src="{{ asset('assets/images/'.$gs->logo) }}" src="{{ asset('assets/images/'.$gs->logo) }}" alt="Logo">
                    </a>
                    <!-- Burger menu for mobile -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="flaticon-menu-2 flat-small"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-md-5">
                            {{-- Home --}}
                            <li class="nav-item {{ request()->path() == '/' ? 'active':''}}">
                                <a class="nav-link" href="{{ route('front.index') }}">
                                    <i class="fas fa-home"></i> {{ __('Home') }}
                                </a>
                            </li>

                            {{-- Categories with Subcategories --}}
                            <li class="nav-item dropdown mega-dropdown">
                                <a class="nav-link dropdown-toggle" href="{{ route('front.category') }}">
                                    <i class="fas fa-th-large"></i> {{ __('Categories') }}
                                </a>
                                <ul class="dropdown-menu mega-dropdown-menu">
                                    <li class="mega-container">
                                        <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1">
                                            @foreach ($categories as $category)
                                            <div class="col category-column">
                                                <div class="category-header">
                                                    <a href="{{ route('front.category', $category->slug) }}" class="category-title">
                                                        {{ $category->name }}
                                                    </a>
                                                </div>
                                                @if($category->subs->count() > 0)
                                                <ul class="subcategory-list">
                                                    @foreach ($category->subs as $subcategory)
                                                    <li>
                                                        <a class="subcategory-item" href="{{route('front.category', [$category->slug, $subcategory->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">
                                                            <i class="fas fa-angle-right"></i> {{$subcategory->name}}
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </li>
                                </ul>
                            </li>

                            {{-- Contact --}}
                            <li class="nav-item {{ request()->path()=='contact' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('front.contact') }}">
                                    <i class="fas fa-envelope"></i> {{ __('Contact') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <!-- Icons Column - CENTER - Search, Cart, Account -->
            <div class="col-auto order-2 icons-col">
                <div class="d-flex align-items-center justify-content-center h-100 col-icons">

                    <!-- Mobile Search Icon -->
                    <div class="header-icon-enhanced mobile-search-icon d-md-none">
                        <a href="javascript:;" id="mobileSearchToggle" title="Search">
                            <div class="search-icon-wrapper">
                                <i class="flaticon-search flat-mini"></i>
                            </div>
                        </a>
                    </div>

                    <!-- Shopping Cart Icon -->
                    <div class="header-cart-1 header-icon-enhanced">
                        <a href="{{ route('front.cart') }}" class="cart" title="View Cart">
                            <div class="cart-icon"><i class="flaticon-shopping-cart flat-mini"></i> <span class="header-cart-count" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span></div>
                            <div class="cart-wrap">
                                <div class="cart-text">Cart</div>
                                <span class="header-cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
                            </div>
                        </a>
                    </div>

                    <!-- Account Icon - redirects based on login status -->
                    <div class="header-cart-1 header-icon-enhanced">
                        @if (Auth::check())
                            <a href="{{ route('user-dashboard') }}" class="cart" title="My Dashboard">
                                <div class="cart-icon"><i class="flaticon-user-3 flat-mini mx-auto"></i></div>
                            </a>
                        @else
                            <a href="{{ route('user.login') }}" class="cart" title="Login">
                                <div class="cart-icon"><i class="flaticon-user-3 flat-mini mx-auto"></i></div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Spacer Column - Takes remaining space to push phone/flag right -->
            <div class="col order-2 d-none d-lg-block"></div>

            <!-- Phone & Flag Column - FAR RIGHT -->
            @php
            $languges = App\Models\Language::all();
            $currentLang = Session::has('language') ? Session::get('language') : $languges->where('is_default','=',1)->first()->id;
            $currentLangCode = $languges->where('id', $currentLang)->first()->language ?? 'English';
            @endphp
            <div class="col-auto order-3 d-flex align-items-center justify-content-end gap-2 phone-flag-col">
                <!-- Phone Number - Desktop Only -->
                <div class="d-none d-lg-block">
                    <a href="tel:{{$ps->phone}}" class="header-phone-link">
                        {{$ps->phone}}
                    </a>
                </div>

                <!-- Language Flag Selector -->
                <div class="language-flag-selector">
                    @foreach($languges as $language)
                        @if(($language->language == 'Arabic' || $language->language == 'العربية' || $language->language == 'ar') && ($currentLangCode != 'Arabic' && $currentLangCode != 'العربية' && $currentLangCode != 'ar'))
                            <a href="{{route('front.language',$language->id)}}" class="flag-link" title="العربية">
                                <img src="https://flagcdn.com/w40/jo.png" alt="Jordan Flag" class="flag-icon">
                            </a>
                        @elseif(($language->language == 'English' || $language->language == 'en') && ($currentLangCode == 'Arabic' || $currentLangCode == 'العربية' || $currentLangCode == 'ar'))
                            <a href="{{route('front.language',$language->id)}}" class="flag-link" title="English">
                                <img src="https://flagcdn.com/w40/gb.png" alt="UK Flag" class="flag-icon">
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Search Overlay - Fullscreen Professional Design -->
<div class="mobile-search-overlay" id="mobileSearchOverlay">
    <div class="mobile-search-container">
        <div class="mobile-search-header">
            <button class="mobile-search-close" id="mobileSearchClose">
                <i class="fas fa-times"></i>
            </button>
            <h4 class="mobile-search-title">{{ __('Search Products') }}</h4>
        </div>
        <div class="mobile-search-body">
            <form id="mobileSearchForm" class="mobile-search-form" action="{{ route('front.category') }}" method="GET">
                @if (!empty(request()->input('sort')))
                <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                @endif
                @if (!empty(request()->input('minprice')))
                <input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
                @endif
                @if (!empty(request()->input('maxprice')))
                <input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
                @endif
                <div class="mobile-search-input-wrapper">
                    <i class="flaticon-search mobile-search-icon-input"></i>
                    <input
                        type="text"
                        id="mobile_prod_name"
                        class="mobile-search-input"
                        name="search"
                        placeholder="@if(app()->getLocale() == 'ar' || app()->getLocale() == 'arabic')ابحث عن المنتجات...@else{{ __('Search for products...') }}@endif"
                        value="{{ request()->input('search') }}"
                        dir="auto"
                        autocomplete="off"
                        required
                    >
                    <button type="submit" class="mobile-search-submit">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
            <div class="mobile-search-suggestions" id="mobileSearchSuggestions">
                <!-- Auto-complete suggestions will appear here -->
            </div>
        </div>
    </div>
</div>

</header>
<!--==================== Header Section End ====================-->

<script>
// RTL ONLY for Arabic language - Run after DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Get language from Laravel (set in html tag)
    var htmlLang = (document.documentElement.getAttribute('lang') || '').toLowerCase();

    console.log('🌐 Current Language:', htmlLang);

    // ONLY activate RTL if language is explicitly Arabic
    if (htmlLang === 'ar' || htmlLang === 'arabic' || htmlLang === 'العربية') {
        document.documentElement.setAttribute('dir', 'rtl');
        document.documentElement.style.direction = 'rtl';
        document.body.setAttribute('dir', 'rtl');
        document.body.style.direction = 'rtl';
        document.body.classList.add('rtl', 'ar', 'arabic');

        // Also set on page wrapper
        var wrapper = document.getElementById('page_wrapper');
        if (wrapper) {
            wrapper.setAttribute('dir', 'rtl');
            wrapper.style.direction = 'rtl';
        }

        console.log('✅ RTL ACTIVATED - Arabic Language');
    } else {
        // Explicitly set LTR for non-Arabic languages
        document.documentElement.setAttribute('dir', 'ltr');
        document.documentElement.style.direction = 'ltr';
        document.body.setAttribute('dir', 'ltr');
        document.body.style.direction = 'ltr';
        document.body.classList.remove('rtl', 'ar', 'arabic');

        var wrapper = document.getElementById('page_wrapper');
        if (wrapper) {
            wrapper.setAttribute('dir', 'ltr');
            wrapper.style.direction = 'ltr';
        }

        console.log('✅ LTR MODE - Language:', htmlLang);
    }

    // Mobile Search Overlay - Professional Implementation
    const mobileSearchToggle = document.getElementById('mobileSearchToggle');
    const mobileSearchOverlay = document.getElementById('mobileSearchOverlay');
    const mobileSearchClose = document.getElementById('mobileSearchClose');
    const mobileSearchInput = document.getElementById('mobile_prod_name');

    if (mobileSearchToggle && mobileSearchOverlay) {
        // Open mobile search
        mobileSearchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            mobileSearchOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';

            // Focus on input after animation
            setTimeout(function() {
                if (mobileSearchInput) {
                    mobileSearchInput.focus();
                }
            }, 400);
        });

        // Close mobile search
        if (mobileSearchClose) {
            mobileSearchClose.addEventListener('click', function() {
                mobileSearchOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }

        // Close on overlay background click
        mobileSearchOverlay.addEventListener('click', function(e) {
            if (e.target === mobileSearchOverlay) {
                mobileSearchOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileSearchOverlay.classList.contains('active')) {
                mobileSearchOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // AJAX Live Search Implementation
        if (mobileSearchInput) {
            let searchTimeout;
            const suggestionsContainer = document.getElementById('mobileSearchSuggestions');

            mobileSearchInput.addEventListener('input', function() {
                const query = this.value.trim();

                // Clear previous timeout
                clearTimeout(searchTimeout);

                // Clear results if query is too short
                if (query.length < 2) {
                    suggestionsContainer.innerHTML = '';
                    suggestionsContainer.classList.remove('active');
                    return;
                }

                // Show loading state
                suggestionsContainer.innerHTML = `
                    <div class="mobile-search-loading">
                        <i class="fas fa-spinner"></i>
                        <p>${query.length >= 2 ? '{{ __("Searching...") }}' : ''}</p>
                    </div>
                `;
                suggestionsContainer.classList.add('active');

                // Debounce search - wait 500ms after user stops typing
                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 500);
            });

            function performSearch(query) {
                fetch(`{{ route('front.category') }}?search=${encodeURIComponent(query)}&ajax=1`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    displayResults(data, query);
                })
                .catch(error => {
                    console.error('Search error:', error);
                    suggestionsContainer.innerHTML = `
                        <div class="mobile-search-no-results">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ __("Error loading results. Please try again.") }}</p>
                        </div>
                    `;
                });
            }

            function displayResults(data, query) {
                if (!data.products || data.products.length === 0) {
                    suggestionsContainer.innerHTML = `
                        <div class="mobile-search-no-results">
                            <i class="fas fa-search"></i>
                            <p>{{ __("No products found for") }} "<strong>${query}</strong>"</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                data.products.forEach(product => {
                    const imageUrl = product.photo ? `{{ asset('assets/images/products/') }}/${product.photo}` : `{{ asset('assets/images/noimage.png') }}`;
                    const productUrl = `${mainurl}/item/${product.slug}`;

                    html += `
                        <a href="${productUrl}" class="mobile-search-result-item">
                            <img src="${imageUrl}" alt="${product.name}" class="mobile-search-result-image">
                            <div class="mobile-search-result-info">
                                <h6 class="mobile-search-result-name">${product.name}</h6>
                                <p class="mobile-search-result-price">${product.price}</p>
                            </div>
                        </a>
                    `;
                });

                // Add "View All Results" button if there are more products
                if (data.total > data.products.length) {
                    html += `
                        <a href="{{ route('front.category') }}?search=${encodeURIComponent(query)}" class="mobile-search-view-all">
                            {{ __("View All") }} ${data.total} {{ __("Results") }}
                        </a>
                    `;
                }

                suggestionsContainer.innerHTML = html;
            }

            // Submit form on enter or button click
            const searchForm = document.getElementById('mobileSearchForm');
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    const query = mobileSearchInput.value.trim();
                    if (query.length < 2) {
                        e.preventDefault();
                        alert('{{ __("Please enter at least 2 characters to search") }}');
                    }
                });
            }
        }
    }

});

// Language Flag Switcher - Ensure it works on desktop and mobile
document.addEventListener('DOMContentLoaded', function() {
    const flagLinks = document.querySelectorAll('.language-flag-selector .flag-link');

    flagLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');

            // Add a small loading indicator (optional)
            this.style.opacity = '0.6';
            this.style.pointerEvents = 'none';

            // Navigate to the language switch URL
            window.location.href = url;
        });
    });
});
</script>

</header>
<!--==================== Header Section End ====================-->
