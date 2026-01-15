
@extends('layouts.front')
@section('css')

@endsection
@section('content')
@include('partials.global.common-header')


@include('partials.global.subscription-popup')


@if($ps->slider == 1)
    <div class="position-relative">
        <span class="nextBtn"></span>
        <span class="prevBtn"></span>
        <section class="home-slider owl-theme owl-carousel">
            @foreach($sliders as $data)
            <div class="banner-slide-item" style="background: url('{{asset('assets/images/sliders/'.$data->photo)}}') no-repeat center center / cover ;">
                <div class="container">
                    <div class="banner-wrapper-item text-{{ $data->position }}">
                        <div class="banner-content text-dark ">
                            <h5 class="subtitle text-dark slide-h5">{{$data->subtitle_text}}</h5>

                            <h2 class="title text-dark slide-h5">{{$data->title_text}}</h2>

                            <p class="slide-h5">{{$data->details_text}}</p>

                            <a href="{{$data->link}}" class="cmn--btn ">{{ __('SHOP NOW') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </section>
    </div>
@endif



@if ($ps->top_banner == 1)
    <!--==================== Shop By Categories Section Start ====================-->
<div class="full-row pb-0">
    <div class="container">
            <div class="col-lg-12 col-md-6">
                <div class="row">
                    @foreach (DB::table('banners')->whereType('TopSmall')->get() as $banner)
                    <div class="col-md-4">
                        <div class="banner-wrapper hover-img-zoom banner-one custom-class-113">
                            <div class="banner-image overflow-hidden transation"><img src="{{asset('assets/images/banners/'.$banner->photo)}}" alt="Banner Image"></div>
                            <div class="banner-content position-absolute">
                                <span class="d-block font-500 font-small text-uppercase mb-2">{{$banner->title}}</span>
                                <h4><a href="{{$banner->link}}" class="text-decoration-none">{{$banner->text}}</a></h4>
                                <a href="{{$banner->link}}" class="btn-link-down-line mt-20 text-uppercase">{{__('Shop Now')}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        
    </div>
</div>
<!--==================== Shop By Categories Section End ====================-->
@endif



@if($ps->arrival_section == 1)
       <!--==================== Best Month Offer Section Start ====================-->
    <div class="full-row px-sm-5">
        <div class="container-fluid">
            <div class="row justify-content-center wow fadeInUp animated" data-wow-delay="200ms" data-wow-duration="1000ms">
                <div class="col-xxl-5 col-xl-7 col-lg-9">
                    <div class="text-center mb-40">
                        <h2 class="text-center font-500 mb-4">{{__('Best Month Offer')}}</h2>
                        <span class="sub-title">{{__('Erat pellentesque curabitur euismod dui etiam pellentesque rhoncus fermentum tristique lobortis lectus magnis. Consequat porta turpis maecenas')}}</span>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-xxl-6 col-md-12">
                    <div class="banner-wrapper hover-img-zoom banner-one custom-class-122 bg-light">
                        <div class="banner-image overflow-hidden transation"><img src="{{asset('assets/images/arrival/'.$arrivals[0]['photo'])}}" alt="Banner Image"></div>
                        <div class="banner-content y-center position-absolute">
                            <div class="middle-content">
                                <span class="up-to-sale">{{$arrivals[0]['up_sale']}}</span>
                                <h3><a href="{{$arrivals[0]['url']}}" class="text-dark text-decoration-none">{{$arrivals[0]['title']}}</a></h3>
                                <a href="{{$arrivals[0]['url']}}" class="category">{{$arrivals[0]['header']}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="banner-wrapper hover-img-zoom banner-one custom-class-123">
                        <div class="banner-image overflow-hidden transation"><img src="{{asset('assets/images/arrival/'.$arrivals[1]['photo'])}}" alt="Banner Image"></div>
                        <div class="banner-content position-absolute">
                            <div class="middle-content">
                                <span class="up-to-sale">{{$arrivals[1]['up_sale']}}</span>
                                <h3><a href="{{$arrivals[1]['url']}}" class="text-dark text-decoration-none">{{$arrivals[1]['title']}}</a></h3>
                                <a href="{{$arrivals[1]['url']}}" class="category">{{$arrivals[1]['header']}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="banner-wrapper hover-img-zoom banner-one custom-class-124 bg-light">
                        <div class="banner-image overflow-hidden transation"><img src="{{asset('assets/images/arrival/'.$arrivals[2]['photo'])}}" alt="Banner Image"></div>
                        <div class="banner-content position-absolute">
                            <span class="up-to-sale">{{$arrivals[2]['up_sale']}}</span>
                            <h3><a href="{{$arrivals[2]['url']}}" class="text-dark text-decoration-none">{{$arrivals[2]['title']}}</a></h3>
                            <a href="{{$arrivals[2]['url']}}" class="category">{{$arrivals[2]['header']}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==================== Best Month Offer Section End ====================-->
@endif


<div id="extraData">
    <div class="text-center">
        <img  src="{{asset('assets/images/'.$gs->loader)}}">
    </div>
</div>



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
<!-- Scroll to top -->
<a href="#" class="scroller text-white" id="scroll"><i class="fa fa-angle-up"></i></a>
<!-- End Scroll To top -->

@endsection
@section('script')
	<script>
		let checkTrur = 0;
		$(window).on('scroll', function(){

		if(checkTrur == 0){
			$('#extraData').load('{{route('front.extraIndex')}}');
			checkTrur = 1;
		}
		});
        var owl = $('.home-slider').owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        items: 1,
        autoplay: true,
        margin: 0,
        animateIn: 'fadeInDown',
        animateOut: 'fadeOutUp',
        mouseDrag: false,
    })
    $('.nextBtn').click(function() {
        owl.trigger('next.owl.carousel', [300]);
    })
    $('.prevBtn').click(function() {
        owl.trigger('prev.owl.carousel', [300]);
    })
	</script>
@endsection
