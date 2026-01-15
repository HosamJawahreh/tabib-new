@extends('layouts.admin')

@section('content')

<div class="content-area">
  <div class="mr-breadcrumb">
    <div class="row">

      <div class="col-lg-12">
        <h4 class="heading">{{ __('Home Page Customization') }}</h4>
        <ul class="links">
          <li>
            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
          </li>
          <li>
            <a href="javascript:;">{{ __('Home Page Settings') }}</a>
          </li>
          <li>
            <a href="{{ route('admin-ps-customize') }}">{{ __('Home Page Customization') }}</a>
          </li>
        </ul>
      </div>

    </div>
  </div>

  <div class="add-product-content1">
    <div class="row">
      <div class="col-lg-12">
        <div class="product-description">
          <div class="social-links-area">
            <div class="gocover"
              style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
            </div>
            <form id="geniusform" action="{{ route('admin-ps-homeupdate') }}" method="POST"
              enctype="multipart/form-data">
              @csrf

              @include('alerts.admin.form-both')

              <div class="row justify-content-center">

                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="slider">{{ __('Slider') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="slider" value="1" {{ $data->slider == 1 ? "checked" : ""}}>
                    <span class="slider round"></span>
                  </label>
                </div>

                <div class="col-lg-2"></div>

                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="top_banner">{{ __('Top Banner Section') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="top_banner" value="1" {{ $data->top_banner == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>

              </div>

              <div class="row justify-content-center">

                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="arrival_section">{{ __('Arrival Section') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="arrival_section" value="1" {{ $data->arrival_section == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>

                <div class="col-lg-2"></div>

                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="top_big_trending">{{ __('Top Rated, Big Save & Trending') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="top_big_trending" value="1" {{ $data->top_big_trending == 1 ? "checked" : ""}}>
                    <span class="slider round"></span>
                  </label>
                </div>

              </div>


              <div class="row justify-content-center">

                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="category">{{ __('Featured Products') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="category" value="1" {{ $data->category == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>

                <div class="col-lg-2"></div>
                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="large_banner">{{ __('Large Banner') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="large_banner" value="1" {{ $data->large_banner == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>

              </div>

              <div class="row justify-content-center">

             
                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="best_selling">{{ __('Best Selling Products') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="best_selling" value="1" {{ $data->best_selling == 1 ? "checked" : ""}}>
                    <span class="slider round"></span>
                  </label>
                </div>

                <div class="col-lg-2"></div>

                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="bottom_banner">{{ __('Bottom Banner Section') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="bottom_banner" value="1" {{ $data->bottom_banner == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>

              </div>

              <div class="row justify-content-center">

                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="partner">{{ __('Partners Section') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="partner" value="1" {{ $data->partner == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>

                <div class="col-lg-2"></div>

                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="blog">{{ __('Blogs Section') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="blog" value="1" {{ $data->blog == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>

              </div>

              <div class="row justify-content-center">
                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="our_services">{{ __('services Section') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="our_services" value="1" {{ $data->our_services == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-4 d-flex justify-content-between">
                  <label class="control-label" for="newsletter">{{ __('Newsletter') }} *</label>
                  <label class="switch">
                    <input type="checkbox" name="newsletter" value="1" {{ $data->newsletter == 1 ? "checked" : "" }}>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>

              <div class="row">
                <div class="col-12 text-center">
                  <button type="submit" class="submit-btn">{{ __('Submit') }}</button>
                </div>
              </div>

            </form>

            </div>

              <br>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
