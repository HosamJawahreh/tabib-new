
 @if($ps->top_big_trending==1)
 <!--==================== Top Collection Section Start ====================-->
 <div class="full-row bg-white">
     <div class="container">
         <div class="row">
             <div class="col">
                 <div class="top-collection-tab nav-tab-active-secondary">
                     <ul class="nav nav-pills list-color-general justify-content-center mb-5">
                         <li class="nav-item">
                             <a class="nav-link active" data-bs-toggle="pill" href="#pills-new-arrival-two">{{ __('New Arrival') }}</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" data-bs-toggle="pill" href="#pills-Trending-two">{{ __('Trending') }}</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" data-bs-toggle="pill" href="#pills-best-selling-two">{{ __('Best Selling') }}</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" data-bs-toggle="pill" href="#pills-featured-two">{{ __('Popular') }}</a>
                         </li>
                     </ul>
                     <div class="tab-content">
                         <div class="tab-pane fade show active" id="pills-new-arrival-two">
                             <div class="products product-style-1">
                                 <div class="row g-4 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 e-title-general e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">

                                     @foreach($latest_products as $prod)
                                     <div class="col">
                                         @include('partials.product.home-product')
                                     </div>
                                     @endforeach
                                 </div>
                             </div>
                         </div>
                         <div class="tab-pane fade" id="pills-Trending-two">
                             <div class="products product-style-1">
                                 <div class="row g-4 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 e-title-general e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">
                                     @foreach($trending_products as $prod)
                                     <div class="col">
                                         @include('partials.product.home-product')
                                     </div>
                                     @endforeach

                                 </div>
                             </div>
                         </div>
                         <div class="tab-pane fade" id="pills-best-selling-two">
                             <div class="products product-style-1">
                                 <div class="row g-4 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 e-title-general e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">
                                     @foreach($sale_products as $prod)
                                     <div class="col">
                                         @include('partials.product.home-product')
                                     </div>
                                     @endforeach

                                 </div>
                             </div>
                         </div>
                         <div class="tab-pane fade" id="pills-featured-two">
                             <div class="products product-style-1">
                                 <div class="row g-4 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 e-title-general e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">
                                     @foreach($popular_products as $prod)
                                     <div class="col">
                                         @include('partials.product.home-product')
                                     </div>
                                     @endforeach
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!--==================== Top Collection Section End ====================-->
@endif
 
 
 
 @if($ps->category==1)
 <div class="full-row">
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-lg-5">
                 <span class="text-secondary pb-2 d-table tagline mx-auto text-uppercase text-center">{{ __('Featured Products') }}</span>
                 <h2 class="main-title mb-4 text-center text-secondary">{{ __('Our Featured Products') }}</h2>
             </div>
         </div>
         <div class="products product-style-1">
            <div class="row g-4 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 e-title-general e-title-hover-primary e-image-bg-light e-hover-image-zoom e-info-center">

                @foreach($popular_products as $prod)
                <div class="col">
                    @include('partials.product.home-product')
                </div>
                @endforeach
            </div>
        </div>
     </div>
 </div>
 <!--==================== Top Products Section End ====================-->
 @endif
 
 @if ($ps->large_banner == 1)
   <!--==================== Special Offer Section Start ====================-->
   <div class="full-row" style="background: url({{asset('assets/images/'.$ps->big_save_banner1)}}) no-repeat center / cover;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="p-50 text-white bg-primary">
                    <div class="text-uppercase text-white font-500">{{$ps->big_save_banner_subtitle}}</div>
                    <h1 class="text-white my-4">{{$ps->big_save_banner_title}}</h1>
                    <div class="font-medium w-75">
                        <p>{{$ps->big_save_banner_text}}</p>
                    </div>
                    <a href="{{$ps->big_save_banner_link}}" class="btn btn-dark mt-4">{{__('Learn More')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--==================== Special Offer Section End ====================-->
 @endif



@if($ps->best_selling==1)
<!--==================== Best Selling Products Section Start ====================-->
<div class="full-row pb-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-head d-flex justify-content-between align-items-center pb-20">
                    <h3 class="font-700 text-secondary mb-0 down-line">{{__('Best Selling Products')}}</h3>
                    <a href="{{route('front.category')}}" class="btn-link-down-line text-uppercase font-small">{{__('View all products')}}</a>
                </div>
            </div>
        </div>
        <div class="row g-3 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-1 product-list e-hover-image-zoom e-btn-set-two">
            @foreach($best_products as $prod)
            @include('partials.product.best-product')
            @endforeach
        </div>
    </div>
</div>
<!--==================== Best Selling Products Section End ====================-->
@endif



@if ($ps->bottom_banner == 1)
    <!--==================== Banner Section Start ====================-->
    <div class="full-row p-0 my-5 d-none d-sm-block">
        <div class="container">
            <div class="row row-cols-lg-2 row-cols-1 g-3">
                @foreach (DB::table('banners')->whereType('BottomSmall')->get() as $bottomBanner)
                    <div class="col">
                        <div class="banner-wrapper hover-img-zoom banner-one custom-class-112">
                            <div class="banner-image overflow-hidden transation"><img src="{{asset('assets/images/banners/'.$bottomBanner->photo)}}" alt="Banner Image"></div>
                            <div class="banner-content position-absolute">
                                <h4><a href="{{$bottomBanner->link}}" class="text-dark font-700 text-decoration-none">{{$bottomBanner->title}}</a></h4>
                                <div class="font-fifteen">
                                    <p>{{$bottomBanner->text}}</p>
                                </div>
                                <a href="{{$bottomBanner->link}}" class="btn-link-down-line mt-20 text-uppercase">{{__('Shop Now')}}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
<!--==================== Banner Section End ====================-->
@endif


<!--==================== Service Section Start ====================-->
@if ($ps->partner==1)
<div class="full-row bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">

                <h2 class="main-title mb-4 text-center text-secondary">{{ $gs->partner_title }}</h2>
                <span class="mb-30 sub-title text-general font-medium ordenery-font font-400 text-center">{{ $gs->partner_text }}</span>
            </div>
        </div>
        <div class="row g-3">
            @foreach (DB::table('partners')->get() as $data)
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="simple-service">
                    <img class="lazy" data-src="{{ asset('assets/images/partner/'.$data->photo) }}" alt="">

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endif






 <!--==================== Our Blog Section Start ====================-->
@if($ps->blog==1)
    <div class="full-row pt-0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">

                        <h2 class="main-title mb-4 text-center text-secondary">{{ __('Latest Post') }}</h2>
                        <span class="mb-30 sub-title text-general font-medium ordenery-font font-400 text-center">{{ __('Cillum eu id enim aliquip aute ullamco anim. Culpa deserunt nostrud excepteur voluptate velit ipsum esse enim.') }}</span>
                    </div>
                </div>
                <div class="row row-cols-lg-2 row-cols-1">
                    @foreach ($blogs as $blog)
                    <div class="col">
                        <div class="thumb-latest-blog text-center transation hover-img-zoom mb-3">
                            <div class="post-image overflow-hidden">
                                <a href="{{ route('front.blogshow',$blog->slug) }}">
                                    <img class="lazy" data-src="{{ asset('assets/images/blogs/'.$blog->photo) }}" alt="Image not found!">
                                </a>

                            </div>
                            <div class="post-content">
                                <h3><a href="{{ route('front.blogshow',$blog->slug) }}" class="transation text-dark hover-text-primary d-table my-10 mx-sm-auto">{{ mb_strlen($blog->title,'UTF-8') > 200 ? mb_substr($blog->title,0,200,'UTF-8')."...":$blog->title }}</a></h3>
                                <div class="post-meta font-small text-uppercase list-color-general my-3">
                                    <p class="post-date">{{ date('d M, Y',strtotime($blog->created_at)) }}</p>
                                </div>
                                <a href="{{ route('front.blogshow',$blog->slug) }}" class="btn-link-left-line">{{ __('Read More') }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!--==================== Our Blog Section End ====================-->
@endif



@if ($ps->our_services == 1)
     <!--==================== Service Section Start ====================-->
 <div class="full-row bg-light my-4">
    <div class="container">
        <div class="row row-cols-xl-4 row-cols-sm-2 row-cols-1 gy-4 gy-xl-0">
           
            @foreach (DB::table('services')->get() as $service)
            <div class="col">
                <div class="simple-service px-3 md-my-10 d-flex align-items-center">
                    <div class="box-80px rounded-pill position-relative bg-white">
                   <img class="flat-medium text-secondary xy-center position-absolute" src="{{asset('assets/images/services/'.$service->photo)}}" alt="">
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-1 font-500"><a href="service.html" class="text-dark hover-text-primary transation-this">{{$service->title}}</a></h5>
                        <div class="font-small text-secondary">
                            <span>{{$service->details}}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--==================== Service Section End ====================-->
@endif


@includeIf('partials.global.common-footer')

<script src="{{ asset('assets/front/js/extraindex.js') }}"></script>

<script>
    $(".lazy").Lazy();
</script>

