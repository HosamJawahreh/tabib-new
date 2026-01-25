@extends('layouts.load')

@section('content')
            <div class="content-area">
              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('alerts.admin.form-error')  
                        <form id="geniusformdata" action="{{route('admin.fonts.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                          {{csrf_field()}}

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Font Family') }} *</h4>
                                  <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="font_family" placeholder="{{ __('e.g., Cairo, Poppins, Roboto') }}" required="" value="{{$data->font_family}}">
                              <small class="form-text text-muted">{{ __('Enter the Google Font name exactly as it appears on Google Fonts') }}</small>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Language') }} *</h4>
                                  <p class="sub-heading">{{ __('(Select Font Language)') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <select class="input-field" name="language" required="">
                                <option value="">{{ __('Select Language') }}</option>
                                <option value="ar" {{ $data->language == 'ar' ? 'selected' : '' }}>{{ __('Arabic Only') }}</option>
                                <option value="en" {{ $data->language == 'en' ? 'selected' : '' }}>{{ __('English Only') }}</option>
                                <option value="both" {{ $data->language == 'both' ? 'selected' : '' }}>{{ __('Both Languages') }}</option>
                              </select>
                              <small class="form-text text-muted">
                                <strong>{{ __('Recommended Arabic Fonts:') }}</strong> Cairo, Tajawal, Almarai, Changa, Amiri<br>
                                <strong>{{ __('Recommended English Fonts:') }}</strong> Poppins, Roboto, Inter, Montserrat, Open Sans
                              </small>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection