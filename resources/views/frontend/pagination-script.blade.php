<script>
// Pagination with Vanilla JS Fallback
(function() {
    'use strict';

    const useVanillaJS = typeof jQuery === 'undefined';

    if (useVanillaJS) {
        console.warn('⚠️ jQuery not loaded! Using vanilla JavaScript');
        initVanilla();
    } else {
        console.log('✅ jQuery loaded');
        initjQuery();
    }

    function initVanilla() {
        let isLoading = false;
        let currentPage = 2;
        let hasMorePages = {{ $products->hasMorePages() ? 'true' : 'false' }};

        console.log('🚀 Vanilla pagination ready');

        function loadMore() {
            if (isLoading || !hasMorePages) return;

            isLoading = true;
            document.getElementById('products-loading').classList.remove('d-none');

            fetch('{{ route("front.products.load") }}?page=' + currentPage, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.html) {
                    document.getElementById('products-grid').insertAdjacentHTML('beforeend', data.html);
                    hasMorePages = data.has_more;
                    currentPage = data.next_page || (currentPage + 1);
                    if (!hasMorePages) document.getElementById('products-end-message').classList.remove('d-none');
                }
                document.getElementById('products-loading').classList.add('d-none');
                isLoading = false;
            })
            .catch(e => {
                console.error(e);
                document.getElementById('products-loading').classList.add('d-none');
                isLoading = false;
            });
        }

        window.addEventListener('scroll', function() {
            const st = window.pageYOffset;
            const wh = window.innerHeight;
            const dh = document.documentElement.scrollHeight;

            document.getElementById('scrollToTop').style.display = st > 300 ? 'flex' : 'none';

            if (dh - (st + wh) < 500 && st > 100) loadMore();
        });

        document.getElementById('scrollToTop').addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        setTimeout(() => {
            if (document.documentElement.scrollHeight <= window.innerHeight + 100 && hasMorePages) {
                loadMore();
            }
        }, 1500);
    }

    function initjQuery() {
        jQuery(document).ready(function($) {
            let isLoading = false;
            let currentPage = 2;
            let hasMorePages = {{ $products->hasMorePages() ? 'true' : 'false' }};

            console.log('🚀 jQuery pagination ready');

            function loadMore() {
                if (isLoading || !hasMorePages) return;

                isLoading = true;
                $('#products-loading').removeClass('d-none');

                $.ajax({
                    url: '{{ route("front.products.load") }}',
                    data: { page: currentPage },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(r) {
                        if (r.html) {
                            $('#products-grid').append(r.html);
                            hasMorePages = r.has_more;
                            currentPage = r.next_page || (currentPage + 1);
                            if (!hasMorePages) $('#products-end-message').removeClass('d-none');
                        }
                        $('#products-loading').addClass('d-none');
                        isLoading = false;
                    },
                    error: function() {
                        $('#products-loading').addClass('d-none');
                        isLoading = false;
                    }
                });
            }

            $(window).on('scroll', function() {
                const st = $(window).scrollTop();
                const wh = $(window).height();
                const dh = $(document).height();

                $('#scrollToTop').toggle(st > 300);

                if (dh - (st + wh) < 500 && st > 100) loadMore();
            });

            $('#scrollToTop').on('click', () => $('html,body').animate({ scrollTop: 0 }, 600));

            setTimeout(() => {
                if ($(document).height() <= $(window).height() + 100 && hasMorePages) loadMore();
            }, 1500);

            window.testPagination = loadMore;
        });
    }
})();
</script>
