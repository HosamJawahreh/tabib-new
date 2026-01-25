@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('alerts.admin.form-error')  
                      <form id="geniusformdata" action="{{route('admin-childcat-create')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Category') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="cat" required="">
                                  <option value="">{{ __('Select Category') }}</option>
                                    @foreach($cats as $cat)
                                      <option data-href="{{ route('admin-subcat-load',$cat->id) }}" value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Sub Category') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="subcat" name="subcategory_id" required="" disabled=""></select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Name') }} (Arabic) *</h4>
                                <p class="sub-heading">{{ __('Arabic Name') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" id="childcategory_name_ar" name="name_ar" placeholder="{{ __('Enter Arabic Name') }}" required="" value="" dir="rtl">
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
                            <input type="text" class="input-field" id="childcategory_name_en" name="name_en" placeholder="{{ __('Enter English Name') }}" value="">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Slug') }}</h4>
                                <p class="sub-heading">{{ __('(Auto-generated, optional)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" id="childcategory_slug" name="slug" placeholder="{{ __('Auto-generated from name') }}" value="">
                            <small class="text-muted">{{ __('Leave empty for automatic generation from English or Arabic name') }}</small>
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Create') }}</button>
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
$(document).ready(function() {
    // Auto-generate slug from name
    function generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }
    
    // Auto-generate slug when typing in name fields
    $('#childcategory_name_en, #childcategory_name_ar').on('keyup', function() {
        var enName = $('#childcategory_name_en').val();
        var arName = $('#childcategory_name_ar').val();
        var nameForSlug = enName.trim() !== '' ? enName : arName;
        
        if (nameForSlug.trim() !== '') {
            $('#childcategory_slug').val(generateSlug(nameForSlug));
        }
    });
});
</script>
@endsection