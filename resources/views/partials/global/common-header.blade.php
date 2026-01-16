 <!--==================== Header Section Start ====================-->
 <header class="ecommerce-header">
   <style>
     /* Stabilize scrollbar to avoid layout shift/jitter */
     html { scrollbar-gutter: stable both-edges; }
     html, body { overflow-x: hidden; overflow-y: scroll; scroll-behavior: auto; }

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
   .fixed-top,
   header.fixed-top,
   .header.fixed-top,
   .nav-sticky,
   .menu-sticky {
       display: none !important;
       visibility: hidden !important;
       opacity: 0 !important;
       height: 0 !important;
       overflow: hidden !important;
   }

   /* Keep OUR header static (not sticky) */
   .ecommerce-header {
       position: relative !important;
       z-index: 999 !important;
       background: #fff !important;
       display: block !important;
       visibility: visible !important;
       opacity: 1 !important;
       overflow: visible !important;
   }

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

   /* Logo Sizing - Compact 40px height */
   img.nav-logo.header-logo-responsive,
   .navbar-brand img.nav-logo,
   .header-logo-responsive {
       height: 100px !important;
       width: auto !important;
       max-height: 100px !important;
       object-fit: contain !important;
   }
   @media (min-width: 768px) {
       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           height: 100px !important;
           width: auto !important;
           max-height: 100px !important;
       }
   }
   @media (min-width: 1200px) {
       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           height: 100px !important;
           width: auto !important;
           max-height: 100px !important;
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
           height: 48px !important;
           padding: 4px 15px !important;
       }

       .main-nav, .main-nav-row {
           height: 48px !important;
       }

       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           height: 38px !important;
           width: auto !important;
           max-height: 38px !important;
       }

       .header-icon-enhanced {
           padding: 4px !important;
           min-width: 36px;
           max-width: 36px;
           height: 36px;
       }

       .header-icon-enhanced i {
           font-size: 15px !important;
       }

       .header-cart-count {
           font-size: 8px !important;
           padding: 2px 4px !important;
           min-width: 16px;
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

       .header-phone-support {
           display: none !important;
       }

       .language-selector-modern {
           padding: 5px !important;
           max-width: 85px !important;
       }

       .language-selector-modern select {
           font-size: 12px !important;
           padding: 4px 6px !important;
           min-width: auto !important;
           width: 75px !important;
           max-width: 75px !important;
       }

       /* Force icons container to stay in one line */
       .col-icons {
           display: flex !important;
           flex-wrap: nowrap !important;
           gap: 6px !important;
           align-items: center !important;
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
       img.nav-logo.header-logo-responsive,
       .navbar-brand img.nav-logo,
       .header-logo-responsive {
           max-width: 50px !important;
           min-width: 50px !important;
           width: 50px !important;
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

   /* Cart icon container - ensure visibility */
   .header-cart-1 {
       position: static !important;
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

   /* Phone number styling */
   .header-phone-link {
       font-size: 16px !important;
       font-weight: 600 !important;
       color: #4a5568 !important;
       text-decoration: none !important;
       padding: 8px 15px !important;
       border-radius: 8px !important;
       border: 2px solid #e8ecef !important;
       transition: all 0.3s ease !important;
       display: inline-block !important;
   }
   .header-phone-link:hover {
       background-color: #7caa53 !important;
       color: #fff !important;
       border-color: #7caa53 !important;
       transform: translateY(-2px);
       box-shadow: 0 4px 8px rgba(124, 170, 83, 0.3);
   }

   /* HIDE MENU ITEMS ON DESKTOP - Mobile Only */
   @media (min-width: 992px) {
       .navbar-collapse,
       .navbar-nav,
       .navbar-toggler {
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
   </style>


@php
$categories = App\Models\Category::with('subs')->where('status',1)->get();
$pages = App\Models\Page::get();
@endphp
<div class="main-nav">
    <div class="container-fluid">
        <div class="row align-items-center main-nav-row">
            <div class="col-lg-2 col-md-3 col-4 text-start logo-col">
                <nav class="navbar navbar-expand-lg nav-dark nav-primary-hover nav-line-active p-0">
                    <a class="navbar-brand" href="{{ route('front.index') }}">
                        <img class="nav-logo lazy header-logo-responsive" data-src="{{ asset('assets/images/'.$gs->logo) }}" src="{{ asset('assets/images/'.$gs->logo) }}" alt="Logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="flaticon-menu-2 flat-small text-primary"></i>
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
            <div class="col-lg-7 col-md-6 d-none d-md-block order-md-2 order-3 search-col">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="product-search-one w-100 global-search touch-screen-view">
                        <form id="searchForm" class="search-form form-inline enhanced-search-form" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">

                            @if (!empty(request()->input('sort')))
                            <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                            @endif
                            @if (!empty(request()->input('minprice')))
                            <input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
                            @endif
                            @if (!empty(request()->input('maxprice')))
                            <input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
                            @endif
                            <input type="text" id="prod_name" class="col form-control search-field" name="search" placeholder="@if(app()->getLocale() == 'ar' || app()->getLocale() == 'arabic')ابحث عن المنتجات...@else{{ __('Search products...') }}@endif" value="{{ request()->input('search') }}" dir="auto" style="text-align: start;">
                            <button type="submit" name="submit" class="search-submit"><i class="flaticon-search flat-mini text-white"></i></button>

                        </form>
                    </div>
                    <div class="autocomplete">
                        <div id="myInputautocomplete-list" class="autocomplete-items"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-8 order-md-3 order-2 icons-col">
                <div class="d-flex align-items-center justify-content-end h-100 col-icons">

                    <!-- Wishlist Icon - REMOVED as requested -->

                    <!-- Shopping Cart Icon -->
                    <div class="header-cart-1 header-icon-enhanced">
                        <a href="{{ route('front.cart') }}" class="cart has-cart-data" title="View Cart">
                            <div class="cart-icon"><i class="flaticon-shopping-cart flat-mini"></i> <span class="header-cart-count" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span></div>
                            <div class="cart-wrap">
                                <div class="cart-text">Cart</div>
                                <span class="header-cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
                            </div>
                        </a>
                        @include('load.cart')
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

                    @php
                    $languges = App\Models\Language::all();
                    @endphp
                    <!-- Language Selector - Modern Design -->
                    <div class="header-icon-enhanced language-selector-modern">
                        <select name="language" class="language selectors nice">
                        @foreach($languges as $language)
                        <option value="{{route('front.language',$language->id)}}" {{ Session::has('language') ? ( Session::get('language') == $language->id ? 'selected' : '' ) : ($languges->where('is_default','=',1)->first()->id == $language->id ? 'selected' : '') }}>
                        {{$language->language}}
                        </option>
                        @endforeach
                        </select>
                    </div>

                    <!-- Support Number - Clickable Phone -->
                    <div class="d-none d-lg-flex align-items-center ms-2">
                        <a href="tel:{{$ps->phone}}" class="header-phone-link" style="font-size: 16px; font-weight: 600; color: #4a5568; text-decoration: none; padding: 8px 15px; border-radius: 8px; transition: all 0.3s ease; border: 2px solid #e8ecef;">
                            {{$ps->phone}}
                        </a>
                    </div>
                </div>
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
});
</script>

</header>
<!--==================== Header Section End ====================-->
