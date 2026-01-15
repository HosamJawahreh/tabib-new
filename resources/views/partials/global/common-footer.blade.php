@php
$categories = App\Models\Category::with('subs')->where('status',1)->get();
$pages = App\Models\Page::get();
@endphp

<style>
/* Professional One-Line Footer with Copyright */
.professional-footer {
    background: #2d3748;
    color: #e2e8f0;
    padding: 20px 0;
    border-top: 3px solid #10b981;
}

.footer-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.footer-left-section {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 25px;
}

.footer-contact-info {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 25px;
    font-size: 0.9rem;
}

.footer-contact-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #e2e8f0;
}

.footer-contact-item i {
    color: #10b981;
    font-size: 1rem;
}

.footer-copyright {
    color: #cbd5e0;
    font-size: 0.85rem;
    margin: 0;
    padding-left: 25px;
    border-left: 2px solid rgba(16, 185, 129, 0.3);
}

.footer-social-icons {
    display: flex;
    align-items: center;
    gap: 12px;
}

.footer-social-icons a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.footer-social-icons a:hover {
    background: #10b981;
    color: white;
    transform: translateY(-3px);
}

@media (max-width: 991px) {
    .footer-content {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }

    .footer-left-section {
        flex-direction: column;
        width: 100%;
        gap: 15px;
    }

    .footer-contact-info {
        flex-direction: column;
        gap: 12px;
        width: 100%;
    }

    .footer-copyright {
        padding-left: 0;
        border-left: none;
        padding-top: 15px;
        border-top: 2px solid rgba(16, 185, 129, 0.3);
        width: 100%;
    }

    .footer-social-icons {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .professional-footer {
        padding: 15px 0;
    }

    .footer-contact-item {
        font-size: 0.85rem;
    }

    .footer-copyright {
        font-size: 0.8rem;
    }

    .footer-social-icons a {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
    }
}
</style>

<!--==================== Professional One-Line Footer with Copyright ====================-->
<footer class="professional-footer">
    <div class="container">
        <div class="footer-content">
            <!-- Left Section: Contact Info + Copyright -->
            <div class="footer-left-section">
                <div class="footer-contact-info">
                    @if($ps->phone != null)
                    <div class="footer-contact-item">
                        <i class="icofont-phone"></i>
                        <span>{{ $ps->phone }}</span>
                    </div>
                    @endif

                    @if($ps->email != null)
                    <div class="footer-contact-item">
                        <i class="icofont-email"></i>
                        <span>{{ $ps->email }}</span>
                    </div>
                    @endif

                    @if($ps->street != null)
                    <div class="footer-contact-item">
                        <i class="icofont-location-pin"></i>
                        <span>{{ $ps->street }}</span>
                    </div>
                    @endif
                </div>

                <!-- Copyright in Same Line -->
                <div class="footer-copyright">
                    {{ $gs->copyright }}
                </div>
            </div>

            <!-- Social Media Icons on Right -->
            <div class="footer-social-icons">
                @foreach(DB::table('social_links')->where('user_id',0)->where('status',1)->get() as $link)
                    <a href="{{ $link->link }}" target="_blank" title="{{ $link->icon }}">
                        <i class="{{ $link->icon }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
<!--==================== Footer End ====================-->

@if(isset($visited))

@if($gs->is_cookie == 1)
    <div class="cookie-bar-wrap show">
        <div class="container d-flex justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="row justify-content-center">
                    <div class="cookie-bar">
                        <div class="cookie-bar-text">
                            {{ __('The website uses cookies to ensure you get the best experience on our website.') }}
                        </div>
                        <div class="cookie-bar-action">
                            <button class="btn btn-primary btn-accept">
                             {{ __('GOT IT!') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endif

<!--==================== Copyright Section End ====================-->

<!-- Scroll to top -->
<a href="#" class="scroller text-white" id="scroll"><i class="fa fa-angle-up"></i></a>
