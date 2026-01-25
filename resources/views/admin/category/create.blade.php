@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('alerts.admin.form-error')
                        <form id="geniusformdata" action="{{route('admin-cat-store')}}" method="POST" enctype="multipart/form-data">
                          {{csrf_field()}}

                          {{-- Hidden field for parent_id (0 = main category, >0 = subcategory/child) --}}
                          <input type="hidden" name="parent_id" value="{{ $parent_id ?? 0 }}">
                          <input type="hidden" name="is_featured" value="{{ isset($parent_id) && $parent_id > 0 ? '0' : '1' }}">

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Name') }} (Arabic) *</h4>
                                  <p class="sub-heading">{{ __('Arabic Name') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="name_ar" placeholder="{{ __('Enter Arabic Name') }}" required="" value="" dir="rtl">
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Name') }} (English)</h4>
                                  <p class="sub-heading">{{ __('English Name') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="name_en" placeholder="{{ __('Enter English Name') }}" value="">
                            </div>
                          </div>

                          <input type="hidden" name="name" id="hidden_name">

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Slug') }} *</h4>
                                  <p class="sub-heading">{{ __('In English') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="slug" placeholder="{{ __('Enter Slug') }}" value="">
                            </div>
                          </div>

                            <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                  <h4 class="heading">{{ __('Set Image') }} *</h4>
                                </div>
                              </div>
                              <div class="col-lg-7">
                                <div class="img-upload ">
                                  <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/admin/images/upload.png') }});">
                                    <label for="image-upload" class="img-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                    <input type="file" name="image" class="img-upload">
                                  </div>
                                  <p class="text">{{__('Prefered Size: (1230x267) or Square Sized Image')}}</p>
                                </div>
                              </div>
                            </div>



                          <br>
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">

                              </div>
                            </div>
                            <div class="col-lg-7">
                              <button class="addProductSubmit-btn" type="submit">{{ __('Create Category') }}</button>
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

@section('scripts')
<script>
// Sync Arabic name to hidden name field for backward compatibility
$('input[name="name_ar"]').on('input', function() {
    $('#hidden_name').val($(this).val());
});

// Auto-generate slug from Arabic name
$('input[name="name_ar"]').on('input', function() {
    var slug = $(this).val()
        .toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\u0600-\u06FF\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
    $('input[name="slug"]').val('cat-' + Date.now());
});
</script>
@endsection
