@extends('layouts.admin')
@section('styles')

<link href="{{asset('assets/admin/css/product.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css/jquery.Jcrop.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css/Jcrop-style.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/admin/css/product-form-custom.css')}}" rel="stylesheet"/>

@endsection
@section('content')

@php
// Safety check: Ensure $data is a valid Product object
if (!isset($data) || !is_object($data)) {
    abort(404, 'Product not found or invalid data');
}
@endphp

		<div class="content-area">
			<div class="mr-breadcrumb">
				<div class="row">
					<div class="col-lg-12">
							<h4 class="heading">{{ __('Edit Physical Product') }} <a class="add-btn" href="{{ route('admin-prod-index') }}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
							<ul class="links">
								<li>
									<a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
								</li>
							<li>
								<a href="javascript:;">{{ __('Products') }} </a>
							</li>
							<li>
								<a href="{{ route('admin-prod-index') }}">{{ __('All Products') }}</a>
								</li>
								<li>
									<a href="javascript:;">{{ __('Edit Product') }}</a>
								</li>
							</ul>
					</div>
				</div>
			</div>
			<form id="geniusform" action="{{route('admin-prod-update', $data->id)}}" method="POST" enctype="multipart/form-data">
				{{csrf_field()}}
				@include('alerts.admin.form-both')

				{{-- STICKY TOP ACTION BAR --}}
				<div style="position: sticky; top: 0; z-index: 1000; background: white; border-bottom: 2px solid #e2e8f0; padding: 15px 30px; margin: -15px -15px 20px -15px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
					<div class="row align-items-center">
						<div class="col-md-4">
							<h5 style="margin: 0; color: #2d3748; font-weight: 600;">
								<i class="fas fa-edit"></i> {{ __('Edit Product') }}
							</h5>
							<small style="color: #718096;">{{ $data->name }}</small>
						</div>
						<div class="col-md-8 text-right">
							<div class="d-inline-flex align-items-center" style="gap: 15px;">
								{{-- Product Status Toggle --}}
								<div class="d-inline-flex align-items-center">
									<label style="margin: 0; font-weight: 600; color: #2d3748; margin-right: 8px; font-size: 13px;">{{ __('Status') }}:</label>
									<label class="switch switch-sm" style="margin: 0;">
										<input type="checkbox" id="status-toggle-top" name="status" value="1" {{ $data->status == 1 ? 'checked' : '' }}>
										<span class="slider round"></span>
									</label>
									<span id="status-text-top" style="margin-left: 8px; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; {{ $data->status == 1 ? 'background-color: #d4edda; color: #155724;' : 'background-color: #f8d7da; color: #721c24;' }}">
										{{ $data->status == 1 ? __('Active') : __('Inactive') }}
									</span>
								</div>

								{{-- Featured Toggle --}}
								<div class="d-inline-flex align-items-center">
									<label style="margin: 0; font-weight: 600; color: #2d3748; margin-right: 8px; font-size: 13px;">
										<i class="fas fa-star" style="color: #f59e0b;"></i> {{ __('Featured') }}:
									</label>
									<label class="switch switch-sm" style="margin: 0;">
										<input type="checkbox" id="featured-toggle-top" name="featured" value="1" {{ $data->featured == 1 ? 'checked' : '' }}>
										<span class="slider round" style="background-color: {{ $data->featured == 1 ? '#fbbf24' : '#cbd5e0' }};"></span>
									</label>
								</div>

								{{-- Hot Toggle --}}
								<div class="d-inline-flex align-items-center">
									<label style="margin: 0; font-weight: 600; color: #2d3748; margin-right: 8px; font-size: 13px;">
										<i class="fas fa-fire" style="color: #ef4444;"></i> {{ __('Hot') }}:
									</label>
									<label class="switch switch-sm" style="margin: 0;">
										<input type="checkbox" id="hot-toggle-top" name="hot" value="1" {{ $data->hot == 1 ? 'checked' : '' }}>
										<span class="slider round" style="background-color: {{ $data->hot == 1 ? '#3b82f6' : '#cbd5e0' }};"></span>
									</label>
								</div>

								{{-- Save Button --}}
								<button class="btn" type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 25px; font-size: 13px; font-weight: 600; border: none; border-radius: 6px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
									<i class="fas fa-save" style="margin-right: 6px;"></i>
									{{ __('Save') }}
								</button>
							</div>
						</div>
					</div>
				</div>

				<style>
					/* Switch Styles */
					.switch {
						position: relative;
						display: inline-block;
						width: 60px;
						height: 34px;
					}
					.switch-sm {
						width: 48px;
						height: 26px;
					}
					.switch input {
						opacity: 0;
						width: 0;
						height: 0;
					}
					.slider {
						position: absolute;
						cursor: pointer;
						top: 0;
						left: 0;
						right: 0;
						bottom: 0;
						background-color: #cbd5e0;
						transition: .4s;
					}
					.slider:before {
						position: absolute;
						content: "";
						height: 26px;
						width: 26px;
						left: 4px;
						bottom: 4px;
						background-color: white;
						transition: .4s;
					}
					.switch-sm .slider:before {
						height: 20px;
						width: 20px;
						left: 3px;
						bottom: 3px;
					}
					input:checked + .slider {
						background-color: #10b981;
					}
					input:checked + .slider:before {
						transform: translateX(26px);
					}
					.switch-sm input:checked + .slider:before {
						transform: translateX(22px);
					}
					.slider.round {
						border-radius: 34px;
					}
					.slider.round:before {
						border-radius: 50%;
					}
				</style>

				<div class="row">
					<div class="col-lg-12">
						<div class="add-product-content">
							<div class="row">
								<div class="col-lg-12">
									<div class="product-description">
										<div class="body-area" style="padding: 30px;">
											<div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

											{{-- PRICING SECTION (MOVED TO TOP) --}}
											<div class="row">
												<div class="col-lg-12 mb-3">
													<h4 class="heading" style="color: #2d3748; font-size: 16px; border-bottom: 2px solid #4299e1; padding-bottom: 8px; margin-bottom: 15px;">
														<i class="fas fa-tag"></i> {{ __('Product Identification & Pricing') }}
													</h4>
												</div>

												{{-- Product SKU --}}
												<div class="col-lg-4">
													<div class="form-group">
														<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 8px;">
															{{ __('Product SKU') }} *
														</label>
														<input type="text" class="input-field" placeholder="{{ __('Enter Product SKU') }}" name="sku" required="" value="{{ $data->sku }}" dir="auto" style="border: 2px solid #e2e8f0; border-radius: 6px; padding: 12px; font-size: 14px;">
													</div>
												</div>

												{{-- Current Price --}}
												<div class="col-lg-4">
													<div class="form-group">
														<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 8px;">
															{{ __('Current Price') }} * <small style="color: #718096;">({{$sign->name}})</small>
														</label>
														<input name="price" type="number" class="input-field" placeholder="{{ __('Enter Price') }}" step="0.01" min="0" required="" value="{{ round($data->price * $sign->value, 2) }}" dir="auto" style="border: 2px solid #e2e8f0; border-radius: 6px; padding: 12px; font-size: 14px;">
													</div>
												</div>

												{{-- Discount Price --}}
												<div class="col-lg-4">
													<div class="form-group">
														<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 8px;">
															{{ __('Discount Price') }} <small style="color: #718096;">({{ __('Optional') }})</small>
														</label>
														<input name="previous_price" step="0.01" min="0" type="number" class="input-field" placeholder="{{ __('Enter Discount Price') }}" value="{{ round($data->previous_price * $sign->value, 2) }}" dir="auto" style="border: 2px solid #e2e8f0; border-radius: 6px; padding: 12px; font-size: 14px;">
													</div>
												</div>
											</div>

											{{-- PRODUCT NAME SECTION (2 COLUMNS: ARABIC & ENGLISH) --}}
											<div class="row">
												<div class="col-lg-12 mb-3">
													<h4 class="heading" style="color: #2d3748; font-size: 16px; border-bottom: 2px solid #4299e1; padding-bottom: 8px; margin-bottom: 15px;">
														<i class="fas fa-box"></i> {{ __('Product Information') }}
													</h4>
												</div>

												{{-- Arabic Name (from products table) --}}
												<div class="col-lg-6">
													<div class="form-group">
														<label style="font-weight: 600; color: #2d3748; font-size: 14px; display: flex; align-items: center; margin-bottom: 8px;">
															<img src="{{ asset('assets/images/ar.png') }}"
																 alt="Arabic"
																 style="width: 24px; height: 18px; margin-right: 10px; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
																 onerror="this.style.display='none'">
															{{ __('Product Name (Arabic)') }} *
														</label>
														<input type="text"
															   class="input-field"
															   placeholder="أدخل اسم المنتج بالعربية"
															   name="name"
															   required=""
															   value="{{ $data->name }}"
															   style="border: 2px solid #e2e8f0; border-radius: 6px; padding: 12px; font-size: 14px; direction: rtl; text-align: right;">
													</div>
												</div>

												{{-- English Name (from product_translations table) --}}
												@if(isset($languages) && count($languages) > 0)
													@foreach($languages as $language)
														@php
														// English language (ID 1) maps to en_US in translations table
															$langCode = 'en_US';
															$translation = $data->translations->where('lang_code', $langCode)->first();
														@endphp
														<div class="col-lg-6">
															<div class="form-group">
																<label style="font-weight: 600; color: #2d3748; font-size: 14px; display: flex; align-items: center; margin-bottom: 8px;">
																	<img src="{{ asset('assets/images/uk.png') }}"
																		 alt="English"
																		 style="width: 24px; height: 18px; margin-right: 10px; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
																		 onerror="this.style.display='none'">
																	{{ __('Product Name (English)') }} *
																</label>
																<input type="text"
																	   class="input-field"
																	   name="translations[{{$language->id}}][name]"
																	   placeholder="Enter product name in English"
																	   value="{{ $translation ? $translation->name : '' }}"
																	   style="border: 2px solid #e2e8f0; border-radius: 6px; padding: 12px; font-size: 14px;">
																<input type="hidden" name="translations[{{$language->id}}][lang_code]" value="{{$langCode}}">
															</div>
														</div>
													@endforeach
												@endif
											</div>

											{{-- CATEGORIES SECTION --}}
											<div class="row">
												<div class="col-lg-12 mb-3 mt-4">
													<h4 class="heading" style="color: #2d3748; font-size: 16px; border-bottom: 2px solid #ed8936; padding-bottom: 8px; margin-bottom: 15px;">
														<i class="fas fa-folder-tree"></i> {{ __('Product Categories') }}
													</h4>
													<small style="color: #718096; display: block; margin-bottom: 10px;">{{ __('Select from main categories and their subcategories') }}</small>
												</div>
												<div class="col-lg-12">
													<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 10px; display: block;">
														{{ __('Select Categories') }} * <small style="color: #718096;">({{ __('Select one or more') }})</small>
													</label>
													<div class="category-tree-container" style="border: 2px solid #e2e8f0; border-radius: 8px; padding: 20px; max-height: 400px; overflow-y: auto; background: #f9fafb;">
														@foreach($cats as $cat)
															<div class="category-item parent-category" style="margin-bottom: 10px;">
																<label style="display: flex; align-items: center; cursor: pointer; padding: 10px; background: white; border-radius: 6px; margin-bottom: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.2s;">
																	<input type="checkbox" name="categories[]" value="{{ $cat->id }}" class="category-checkbox parent-checkbox" data-category-id="{{ $cat->id }}"
																		{{ in_array($cat->id, $selectedCategoryIds) ? 'checked' : '' }}
																		style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
																	<i class="fas fa-folder" style="margin-right: 10px; color: #ed8936; font-size: 16px;"></i>
																	<span style="font-weight: 600; font-size: 14px; color: #2d3748;">{{ $cat->name }}</span>
																	@if($cat->children->count() > 0)
																		<i class="fas fa-chevron-down toggle-icon" style="margin-left: auto; color: #718096; font-size: 12px;"></i>
																	@endif
																</label>

																@if($cat->children->count() > 0)
																	<div class="subcategories" style="margin-left: 25px; display: none;">
																		@foreach($cat->children as $sub)
																			<div class="category-item sub-category" style="margin-bottom: 8px;">
																				<label style="display: flex; align-items: center; cursor: pointer; padding: 6px 10px; background: #f7fafc; border-radius: 4px; margin-bottom: 4px;">
																					<input type="checkbox" name="categories[]" value="{{ $sub->id }}" class="category-checkbox sub-checkbox" data-parent-id="{{ $cat->id }}" data-category-id="{{ $sub->id }}"
																						{{ in_array($sub->id, $selectedCategoryIds) ? 'checked' : '' }}
																						style="margin-right: 10px; width: 16px; height: 16px; cursor: pointer;">
																					<i class="fas fa-folder-open" style="margin-right: 8px; color: #3182ce; font-size: 13px;"></i>
																					<span style="font-weight: 500; font-size: 13px; color: #4a5568;">{{ $sub->name }}</span>
																					@if($sub->children->count() > 0)
																						<i class="fas fa-chevron-down toggle-icon" style="margin-left: auto; color: #718096; font-size: 11px;"></i>
																					@endif
																				</label>

																				@if($sub->children->count() > 0)
																					<div class="childcategories" style="margin-left: 20px; display: none;">
																						@foreach($sub->children as $child)
																							<div class="category-item child-category" style="margin-bottom: 5px;">
																								<label style="display: flex; align-items: center; cursor: pointer; padding: 5px 10px; background: #edf2f7; border-radius: 4px;">
																									<input type="checkbox" name="categories[]" value="{{ $child->id }}" class="category-checkbox child-checkbox" data-parent-id="{{ $sub->id }}" data-category-id="{{ $child->id }}"
																										{{ in_array($child->id, $selectedCategoryIds) ? 'checked' : '' }}
																										style="margin-right: 10px; width: 14px; height: 14px; cursor: pointer;">
																									<i class="fas fa-tag" style="margin-right: 8px; color: #2b6cb0; font-size: 12px;"></i>
																									<span style="font-weight: 400; font-size: 12px; color: #4a5568;">{{ $child->name }}</span>
																								</label>
																							</div>
																						@endforeach
																					</div>
																				@endif
																			</div>
																		@endforeach
																	</div>
																@endif
															</div>
														@endforeach
													</div>
													<div id="selected-categories-display" style="margin-top: 10px; padding: 10px; background: #e6f7ff; border-radius: 4px; display: none;">
														<strong style="color: #2d3748; font-size: 13px;">Selected Categories:</strong>
														<div id="selected-categories-list" style="margin-top: 5px;"></div>
													</div>
													<input type="hidden" name="category_id" id="main-category-id" value="">
													<input type="hidden" name="subcategory_id" id="sub-category-id" value="">
													<input type="hidden" name="childcategory_id" id="child-category-id" value="">
												</div>
											</div>

											{{-- Hidden old selectors for backward compatibility --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">
														<h4 class="heading">{{ __('Category') }}*</h4>
													</div>
												</div>
												<div class="col-lg-12">
													<select id="cat" name="category_id_old" disabled="">
														<option value="">{{ __('Select Category') }}</option>
														@foreach($cats as $cat)
															<option data-href="{{ route('admin-subcat-load',$cat->id) }}" value="{{ $cat->id }}">{{$cat->name}}</option>
														@endforeach
													</select>
												</div>
											</div>

											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">
														<h4 class="heading">{{ __('Sub Category') }}*</h4>
													</div>
												</div>
												<div class="col-lg-12">
													<select id="subcat" name="subcategory_id_old" disabled="">
															<option value="">{{ __('Select Sub Category') }}</option>
													</select>
												</div>
											</div>

											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">
														<h4 class="heading">{{ __('Child Category') }}*</h4>
													</div>
												</div>
												<div class="col-lg-12">
													<select id="childcat" name="childcategory_id_old" disabled="">
															<option value="">{{ __('Select Child Category') }}</option>
													</select>
												</div>
											</div>


											<div id="catAttributes"></div>
											<div id="subcatAttributes"></div>
											<div id="childcatAttributes"></div>

											{{-- IMAGES SECTION --}}
											<div class="row">
												<div class="col-lg-12 mb-3 mt-4">
													<h4 class="heading" style="color: #2d3748; font-size: 16px; border-bottom: 2px solid #9f7aea; padding-bottom: 8px; margin-bottom: 15px;">
														<i class="fas fa-images"></i> {{ __('Product Images') }}
													</h4>
												</div>

												{{-- Feature Image --}}
												<div class="col-lg-6">
													<div class="left-area">
														<h4 class="heading">{{ __('Feature Image') }} *</h4>
													</div>
													<div class="panel panel-body">
														<div class="span4 cropme text-center" id="landscape"
															style="width: 100%; height: 285px; border: 1px dashed #ddd; background: #f1f1f1; overflow: hidden; display: flex; align-items: center; justify-content: center;">
															@if($data->photo)
																<img src="{{ $data->photo ? asset('assets/images/products/'.$data->photo) : asset('assets/images/noimage.png') }}"
																	 id="feature-img-preview"
																	 alt="Feature Image"
																	 style="max-width: 100%; max-height: 100%; object-fit: contain;">
															@else
																<a href="javascript:;" id="crop-image" class="mybtn1" style="">
																	<i class="icofont-upload-alt"></i> {{ __('Upload Image Here') }}
																</a>
															@endif
														</div>
													</div>
												</div>

												{{-- Product Gallery --}}
												<div class="col-lg-6">
													<div class="left-area">
														<h4 class="heading">{{ __('Product Gallery Images') }} *</h4>
													</div>
													<div class="panel panel-body" style="min-height: 285px; border: 1px dashed #ddd; background: #f1f1f1; padding: 15px;">
														@if($data->galleries && $data->galleries->count() > 0)
															<div class="row">
																@foreach($data->galleries as $gallery)
																	<div class="col-sm-6 mb-3">
																		<div class="img gallery-img" style="position: relative;">
																			<span class="remove-img" style="position: absolute; top: 5px; right: 5px; background: #e53e3e; color: white; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10;">
																				<i class="fas fa-times"></i>
																				<input type="hidden" value="{{ $gallery->id }}">
																			</span>
																			<a href="{{ asset('assets/images/galleries/'.$gallery->photo) }}" target="_blank">
																				<img src="{{ asset('assets/images/galleries/'.$gallery->photo) }}"
																					 alt="gallery image"
																					 style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
																			</a>
																		</div>
																	</div>
																@endforeach
															</div>
														@endif
														<div style="text-align: center; margin-top: 10px;">
															<a href="#" class="set-gallery btn btn-primary" data-toggle="modal" data-target="#setgallery" style="padding: 12px 30px; font-size: 14px; font-weight: 600;">
																<i class="icofont-plus"></i> {{ __('Add More Images') }}
															</a>
														</div>
													</div>
												</div>
											</div>
											<input type="hidden" id="feature_photo" name="photo" value="{{ $data->photo }}">
											<input type="file" name="gallery[]" class="hidden" id="uploadgallery" accept="image/*" multiple>

											{{-- PRODUCT DESCRIPTION SECTION (2 COLUMNS: ARABIC & ENGLISH) --}}
											<div class="row">
												<div class="col-lg-12 mb-3 mt-4">
													<h4 class="heading" style="color: #2d3748; font-size: 16px; border-bottom: 2px solid #38b2ac; padding-bottom: 8px; margin-bottom: 15px;">
														<i class="fas fa-file-alt"></i> {{ __('Product Description') }}
													</h4>
												</div>

												{{-- Arabic Description (from products table) --}}
												<div class="col-lg-6">
													<label style="font-weight: 600; color: #2d3748; font-size: 14px; display: flex; align-items: center; margin-bottom: 10px;">
														<img src="{{ asset('assets/images/ar.png') }}"
															 alt="Arabic"
															 style="width: 24px; height: 18px; margin-right: 10px; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
															 onerror="this.style.display='none'">
														{{ __('Description (Arabic)') }} *
													</label>
													<div class="text-editor">
														<textarea class="nic-edit-p"
																  name="details"
																  placeholder="أدخل وصف المنتج بالعربية"
																  style="min-height: 250px; direction: rtl; text-align: right;">{{ $data->details }}</textarea>
													</div>
												</div>

												{{-- English Description (from product_translations table) --}}
												@if(isset($languages) && count($languages) > 0)
													@foreach($languages as $language)
														@php
															// English language (ID 1) maps to en_US in translations table
															$langCode = 'en_US';
															$translation = $data->translations->where('lang_code', $langCode)->first();
														@endphp
														<div class="col-lg-6">
															<label style="font-weight: 600; color: #2d3748; font-size: 14px; display: flex; align-items: center; margin-bottom: 10px;">
																<img src="{{ asset('assets/images/uk.png') }}"
																	 alt="English"
																	 style="width: 24px; height: 18px; margin-right: 10px; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
																	 onerror="this.style.display='none'">
																{{ __('Description (English)') }} *
															</label>
															<div class="text-editor">
																<textarea class="nic-edit-p"
																		  name="translations[{{$language->id}}][description]"
																		  placeholder="Enter product description in English"
																		  style="min-height: 250px;">{{ $translation ? $translation->description : '' }}</textarea>
															</div>
														</div>
													@endforeach
												@endif
											</div>


											{{-- HIDDEN: Product Condition Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input class="checkclick1" name="product_condition_check" type="checkbox" id="product_condition_check" value="1">
															<label for="product_condition_check">{{ __('Allow Product Condition') }}</label>
														</li>
													</ul>
												</div>
											</div>

											<div class="showbox d-none">
												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
																<h4 class="heading">{{ __('Product Condition') }}*</h4>
														</div>
													</div>
													<div class="col-lg-12">
															<select name="product_condition">
																<option value="2">{{ __('New') }}</option>
																<option value="1">{{ __('Used') }}</option>
															</select>
													</div>
												</div>
											</div>

											{{-- HIDDEN: Preorder Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input class="checkclick1" name="preordered_check" type="checkbox" id="preorderedCheck" value="1">
															<label for="preorderedCheck">{{ __('Allow Product Preorder') }}</label>
														</li>
													</ul>
												</div>
											</div>


											<div class="showbox d-none">
												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
																<h4 class="heading">{{ __('Product Preorder') }}*</h4>
														</div>
													</div>
													<div class="col-lg-12">
															<select name="preordered">
																<option value="1">{{ __('Sale') }}</option>
																<option value="2">{{ __('Preordered') }}</option>
															</select>
													</div>
												</div>
											</div>

											{{-- HIDDEN: Minimum Qty Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input class="checkclick1" name="minimum_qty_check" type="checkbox" id="check111" value="1">
															<label for="check111">{{ __('Allow Minimum Order Qty') }}</label>
														</li>
													</ul>
												</div>
											</div>


											<div class="showbox d-none">
												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
															<h4 class="heading">{{ __('Product Minimum Order Qty') }}* </h4>
														</div>
													</div>
													<div class="col-lg-12">
														<input type="number" class="input-field" min="1"
															placeholder="{{ __('Minimum Order Qty') }}" name="minimum_qty">
													</div>
												</div>

											</div>

											{{-- HIDDEN: Shipping Time Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input class="checkclick1" name="shipping_time_check" type="checkbox" id="check1" value="1">
															<label for="check1">{{ __('Allow Estimated Shipping Time') }}</label>
														</li>
													</ul>
												</div>
											</div>



											<div class="showbox d-none">
												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
															<h4 class="heading">{{ __('Product Estimated Shipping Time') }}* </h4>
														</div>
													</div>
													<div class="col-lg-12">
														<input type="text" class="input-field" placeholder="{{ __('Estimated Shipping Time') }}" name="ship" value="{{ $data->ship }}" value="{{ $data->ship }}">
													</div>
												</div>
											</div>

											{{-- HIDDEN: Product Colors Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input class="checkclickc" name="color_check" type="checkbox" id="check3" value="1">
															<label for="check3">{{ __('Allow Product Colors') }}</label>
														</li>
													</ul>
												</div>
											</div>

											<div class="showbox">

												<div class="row">
														<div  class="col-lg-12">
															<div class="left-area">
																<h4 class="heading">
																	{{ __('Product Colors') }}*
																</h4>
																<p class="sub-heading">
																	{{ __('(Choose Your Favorite Colors)') }}
																</p>
															</div>
														</div>
														<div  class="col-lg-12">
															<div class="select-input-color" id="color-section">
																<div class="color-area">
																	<span class="remove color-remove"><i class="fas fa-times"></i></span>
																	<div class="input-group colorpicker-component cp">
																		<input type="text" name="color_all[]" class="input-field cp tcolor"/>
																		<span class="input-group-addon"><i></i></span>
																	</div>
																	</div>
															</div>
														<a href="javascript:;" id="color-btn" class="add-more mt-4 mb-3"><i class="fas fa-plus"></i>{{ __('Add More Color') }} </a>
													</div>
												</div>

											</div>

											{{-- HIDDEN: Product Sizes Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input class="checkclicks" name="size_check" type="checkbox" id="tcheck" value="1">
															<label for="tcheck">{{ __('Allow Product Sizes') }}</label>
														</li>
													</ul>
												</div>
											</div>

											<div class="showbox d-none">
												<div class="row">
														<div  class="col-lg-4">
															<div class="left-area">
																<h4 class="heading">
																	{{ __('Product Size') }}*
																</h4>
																<p class="sub-heading">
																	{{ __('(eg. S,M,L,XL,XXL,3XL,4XL)') }}
																</p>
															</div>
														</div>
														<div  class="col-lg-12">
																<div class="select-input-tsize" id="tsize-section">
																	<div class="tsize-area">
																		<span class="remove tsize-remove"><i class="fas fa-times"></i></span>
																		<input  type="text" name="size_all[]" class="input-field tsize" placeholder="{{ __('Enter Product Size') }}"  >

																		</div>
																</div>
															<a href="javascript:;" id="tsize-btn" class="add-more mt-4 mb-3"><i class="fas fa-plus"></i>{{ __('Add More Size') }} </a>
														</div>
												</div>

											</div>

											{{-- HIDDEN: Product Wholesale Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input class="checkclick1" name="whole_check" type="checkbox" id="whole_check" value="1">
															<label for="whole_check">{{ __('Allow Product Whole Sell') }}</label>
														</li>
													</ul>
												</div>
											</div>

											<div class="showbox d-none">
												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">

														</div>
													</div>
													<div class="col-lg-12">
														<div class="featured-keyword-area">
															<div class="feature-tag-top-filds" id="whole-section">
																<div class="feature-area">
																	<span class="remove whole-remove"><i class="fas fa-times"></i></span>
																	<div class="row">
																		<div class="col-lg-6">
																		<input type="number" name="whole_sell_qty[]" value="{{ is_array($data->whole_sell_qty) ? implode(',', $data->whole_sell_qty) : $data->whole_sell_qty }}" class="input-field" placeholder="{{ __('Enter Quantity') }}" min="0">
																		</div>

																		<div class="col-lg-6">
																		<input type="number" name="whole_sell_discount[]" value="{{ is_array($data->whole_sell_discount) ? implode(',', $data->whole_sell_discount) : $data->whole_sell_discount }}" class="input-field" placeholder="{{ __('Enter Discount Percentage') }}" min="0" />
																		</div>
																	</div>
																</div>
															</div>

															<a href="javascript:;" id="whole-btn" class="add-fild-btn"><i class="icofont-plus"></i> {{ __('Add More Field') }}</a>
														</div>
													</div>
												</div>
											</div>

											{{-- HIDDEN: Product Measurement Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input class="checkclick1" name="measure_check" type="checkbox" id="measure_check" value="1">
															<label for="measure_check">{{ __('Allow Product Measurement') }}</label>
														</li>
													</ul>
												</div>
											</div>


											<div class="showbox d-none">
												<div class="row">
													<div class="col-lg-6">
														<div class="left-area">
															<h4 class="heading">{{ __('Product Measurement') }}*</h4>
														</div>
													</div>
													<div class="col-lg-12">
														<select id="product_measure">
															<option value="">{{ __('None') }}</option>
															<option value="Gram">{{ __('Gram') }}</option>
															<option value="Kilogram">{{ __('Kilogram') }}</option>
															<option value="Litre">{{ __('Litre') }}</option>
															<option value="Pound">{{ __('Pound') }}</option>
															<option value="Custom">{{ __('Custom') }}</option>
														</select>
													</div>
													{{-- <div class="col-lg-1"></div> --}}
													<div class="col-lg-12 hidden" id="measure">
														<input name="measure" value="{{ $data->measure }}" type="text" id="measurement" class="input-field" placeholder="{{ __('Enter Unit') }}">
													</div>
												</div>
											</div>

											{{-- HIDDEN: Manage Stock Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">

													</div>
												</div>
												<div class="col-lg-12">
													<ul class="list">
														<li>
															<input name="stock_check" class="stock-check" type="checkbox" id="size-check" value="1">
															<label for="size-check" class="stock-text">{{ __('Manage Stock') }}</label>
														</li>
													</ul>
												</div>
											</div>


											<div class="showbox" id="size-display">
												<div class="row">
														<div  class="col-lg-12">
														</div>
														<div  class="col-lg-12">
															<div class="product-size-details" id="size-section">
																<div class="size-area">
																	<span class="remove size-remove"><i class="fas fa-times"></i></span>
																	<div  class="row">
																		<div class="col-md-3 col-sm-6">
																			<label>
																				{{ __('Size Name') }} :
																				<span>
																					{{ __('(eg. S,M,L,XL,3XL,4XL)') }}
																				</span>
																			</label>
																			<select name="size[]" value="{{ is_array($data->size) ? implode(',', $data->size) : $data->size }}" class="input-field size-name"></select>
																		</div>
																		<div class="col-md-3 col-sm-6">
																			<label>
																				{{ __('Size Qty') }} :
																				<span>
																					{{ __('(Quantity of this size)') }}
																				</span>
																			</label>
																			<input type="number" name="size_qty[]" class="input-field" placeholder="{{ __('Size Qty') }}" value="1" min="1">
																		</div>
																		<div class="col-md-3 col-sm-6">
																			<label>
																				{{ __('Size Price') }} :
																				<span>
																					{{ __('(Added with base price)') }}
																				</span>
																			</label>
																			<input type="number" name="size_price[]" class="input-field" placeholder="{{ __('Size Price') }}" value="0" min="0">
																		</div>
																		<div class="col-md-3 col-sm-6">
																			<label>
																				{{ __('Size Color') }} :
																				<span>
																					{{ __('(Select color of this size)') }}
																				</span>
																			</label>
																			<select name="color[]" value="{{ is_array($data->color) ? implode(',', $data->color) : $data->color }}" class="input-field color-name"></select>
																		</div>

																	</div>
																</div>
															</div>

															<a href="javascript:;" id="size-btn" class="add-more"><i class="fas fa-plus"></i>{{ __('Add More') }} </a>
														</div>
												</div>
											</div>

											{{-- HIDDEN: Product Stock Section --}}
											<div class="row d-none" id="default_stock">
												<div class="col-lg-12">
													<div class="left-area">
														<h4 class="heading">{{ __('Product Stock') }}*</h4>
														<p class="sub-heading">{{ __('(Leave Empty will Show Always Available)') }}</p>
													</div>
												</div>
												<div class="col-lg-12">
													<input name="stock" value="{{ $data->stock }}"  type="number" class="input-field" placeholder="e.g 20" value="" min="0">
												</div>
											</div>

											{{-- Product Description moved above with translations --}}

											{{-- HIDDEN: Product Buy/Return Policy Section --}}
											<div class="row d-none">
												<div class="col-lg-12">
													<div class="left-area">
														<h4 class="heading">
															{{ __('Product Buy/Return Policy') }}*
														</h4>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="text-editor">
														<textarea class="nic-edit-p" name="policy"></textarea>
													</div>
												</div>
											</div>

											{{-- SEO SECTION --}}
											<div class="row">
												<div class="col-lg-12 mb-3 mt-4">
													<div class="checkbox-wrapper" style="background: #f7fafc; padding: 15px; border-radius: 8px; border: 2px solid #e2e8f0;">
														<input type="checkbox" name="seo_check" value="1" class="checkclick" id="allowProductSEO" checked>
														<label for="allowProductSEO" style="font-weight: 600; color: #2d3748; font-size: 15px; margin-left: 10px;">
															<i class="fas fa-search"></i> {{ __('Enable Product SEO') }}
														</label>
													</div>
												</div>
											</div>

											<div class="showbox">
												<div class="row">
													<div class="col-lg-12 mb-3">
														<h4 class="heading" style="color: #2d3748; font-size: 16px; border-bottom: 2px solid #667eea; padding-bottom: 8px; margin-bottom: 15px;">
															<i class="fas fa-tags"></i> {{ __('SEO Settings') }}
														</h4>
													</div>

													{{-- Meta Tags --}}
													<div class="col-lg-6">
														<div class="form-group">
															<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 10px; display: block;">
																{{ __('Meta Tags') }}
																<small style="color: #718096;">({{ __('Press Enter after each tag') }})</small>
															</label>
															<ul id="metatags" class="myTags" style="border: 2px solid #e2e8f0; border-radius: 6px; padding: 10px; background: white; min-height: 60px;"></ul>
														</div>
													</div>

													{{-- Meta Description --}}
													<div class="col-lg-6">
														<div class="form-group">
															<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 10px; display: block;">
																{{ __('Meta Description') }}
															</label>
															<textarea class="input-field"
																	  name="meta_description"
																	  rows="4"
																	  placeholder="{{ __('Enter meta description') }}"
																	  style="border: 2px solid #e2e8f0; border-radius: 6px; padding: 12px; font-size: 14px; resize: vertical;">{{ $data->meta_description }}</textarea>
														</div>
													</div>
												</div>
											</div>

											<script>
												document.addEventListener('DOMContentLoaded', function() {
													// Status toggle
													const toggleTop = document.getElementById('status-toggle-top');
													if (toggleTop) {
														toggleTop.addEventListener('change', function() {
															const statusTextTop = document.getElementById('status-text-top');
															if (this.checked) {
																statusTextTop.textContent = '{{ __("Active") }}';
																statusTextTop.style.backgroundColor = '#d4edda';
																statusTextTop.style.color = '#155724';
															} else {
																statusTextTop.textContent = '{{ __("Inactive") }}';
																statusTextTop.style.backgroundColor = '#f8d7da';
																statusTextTop.style.color = '#721c24';
															}
														});
													}

													// Featured toggle color change
													const featuredToggle = document.getElementById('featured-toggle-top');
													if (featuredToggle) {
														featuredToggle.addEventListener('change', function() {
															const slider = this.nextElementSibling;
															slider.style.backgroundColor = this.checked ? '#fbbf24' : '#cbd5e0';
														});
													}

													// Hot toggle color change
													const hotToggle = document.getElementById('hot-toggle-top');
													if (hotToggle) {
														hotToggle.addEventListener('change', function() {
															const slider = this.nextElementSibling;
															slider.style.backgroundColor = this.checked ? '#3b82f6' : '#cbd5e0';
														});
													}
												});
											</script>

											<input type="hidden" name="type" value="Physical">

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
					{{-- Sidebar removed - all content moved to main area above --}}
				</div>
			</form>
		</div>

		<div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Image Gallery') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="top-area">
						<div class="row">
							<div class="col-sm-6 text-right">
								<div class="upload-img-btn">
											<label for="image-upload" id="prod_gallery"><i class="icofont-upload-alt"></i>{{ __('Upload File') }}</label>
								</div>
							</div>
							<div class="col-sm-6">
								<a href="javascript:;" class="upload-done" data-dismiss="modal"> <i class="fas fa-check"></i> {{ __('Done') }}</a>
							</div>
							<div class="col-sm-12 text-center">( <small>{{ __('You can upload multiple Images.') }}</small> )</div>
						</div>
					</div>
					<div class="gallery-images">
						<div class="selected-image">
							<div class="row">


							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>

@endsection

@section('scripts')

		<script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
		<script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>

<script type="text/javascript">

(function($) {
		"use strict";

// ============================================
// Multi-Category Tree Selector
// ============================================
$(document).ready(function() {
	// Toggle subcategories/child categories
	$('.category-item label').on('click', function(e) {
		if ($(e.target).is('input[type="checkbox"]')) {
			return; // Let checkbox handle itself
		}

		e.preventDefault();
		const $label = $(this);
		const $subcategories = $label.next('.subcategories, .childcategories');
		const $icon = $label.find('.toggle-icon');

		if ($subcategories.length) {
			$subcategories.slideToggle(300);
			$icon.toggleClass('fa-chevron-down fa-chevron-up');
		}
	});

	// Handle checkbox selection
	$('.category-checkbox').on('change', function() {
		updateSelectedCategories();
		updateHiddenFields();
	});

	// Update selected categories display
	function updateSelectedCategories() {
		const selected = [];
		$('.category-checkbox:checked').each(function() {
			const $label = $(this).closest('label');
			const categoryName = $label.find('span').text().trim();
			const categoryId = $(this).val();
			selected.push({id: categoryId, name: categoryName});
		});

		if (selected.length > 0) {
			let html = '';
			selected.forEach(function(cat) {
				html += '<span style="display: inline-block; background: #4299e1; color: white; padding: 4px 12px; border-radius: 15px; margin: 3px; font-size: 12px;">' +
					'<i class="fas fa-tag" style="margin-right: 5px;"></i>' + cat.name +
					'</span>';
			});
			$('#selected-categories-list').html(html);
			$('#selected-categories-display').slideDown();
		} else {
			$('#selected-categories-display').slideUp();
		}
	}

	// Update hidden fields for backward compatibility
	function updateHiddenFields() {
		const firstChecked = $('.category-checkbox:checked').first();
		if (firstChecked.length) {
			const categoryId = firstChecked.val();
			const hasParent = firstChecked.data('parent-id');

			if (firstChecked.hasClass('parent-checkbox')) {
				// Parent category selected
				$('#main-category-id').val(categoryId);
				$('#sub-category-id').val('');
				$('#child-category-id').val('');
			} else if (firstChecked.hasClass('sub-checkbox')) {
				// Sub category selected
				$('#main-category-id').val(hasParent);
				$('#sub-category-id').val(categoryId);
				$('#child-category-id').val('');
			} else if (firstChecked.hasClass('child-checkbox')) {
				// Child category selected
				const subCategoryId = hasParent;
				// Find parent category from the subcategory
				const $subCheckbox = $('.sub-checkbox[data-category-id="' + subCategoryId + '"]');
				const mainCategoryId = $subCheckbox.data('parent-id');

				$('#main-category-id').val(mainCategoryId);
				$('#sub-category-id').val(subCategoryId);
				$('#child-category-id').val(categoryId);
			}
		} else {
			$('#main-category-id').val('');
			$('#sub-category-id').val('');
			$('#child-category-id').val('');
		}

		// Debug log to verify values
		console.log('Category IDs updated:', {
			main: $('#main-category-id').val(),
			sub: $('#sub-category-id').val(),
			child: $('#child-category-id').val()
		});
	}

	// Expand all button (optional - can add to UI)
	window.expandAllCategories = function() {
		$('.subcategories, .childcategories').slideDown(300);
		$('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
	};

	window.collapseAllCategories = function() {
		$('.subcategories, .childcategories').slideUp(300);
		$('.toggle-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
	};

	// Initial update
	updateSelectedCategories();
});

// Gallery Section Insert

  $(document).on('click', '.remove-img' ,function() {
    var id = $(this).find('input[type=hidden]').val();
    $('#galval'+id).remove();
    $(this).parent().parent().remove();

    // Send AJAX request to delete from database
    $.ajax({
        type: "GET",
        url:"{{ route('admin-gallery-delete') }}",
        data:{id:id},
        success:function(data) {
            console.log('Gallery image deleted successfully');
        },
        error:function(error) {
            console.error('Error deleting gallery image:', error);
        }
    });
  });

  $(document).on('click', '#prod_gallery' ,function() {
    $('#uploadgallery').click();
     $('.selected-image .row').html('');
    $('#geniusform').find('.removegal').val(0);
  });


  $("#uploadgallery").change(function(){
     var total_file=document.getElementById("uploadgallery").files.length;
     for(var i=0;i<total_file;i++)
     {
      $('.selected-image .row').append('<div class="col-sm-6">'+
                                        '<div class="img gallery-img">'+
                                            '<span class="remove-img"><i class="fas fa-times"></i>'+
                                            '<input type="hidden" value="'+i+'">'+
                                            '</span>'+
                                            '<a href="'+URL.createObjectURL(event.target.files[i])+'" target="_blank">'+
                                            '<img src="'+URL.createObjectURL(event.target.files[i])+'" alt="gallery image">'+
                                            '</a>'+
                                        '</div>'+
                                  '</div> '
                                      );
      $('#geniusform').append('<input type="hidden" name="galval[]" id="galval'+i+'" class="removegal" value="'+i+'">')
     }

  });

// Gallery Section Insert Ends

// Form Submission Validation
$('#geniusform').on('submit', function(e) {
	const selectedCategories = $('.category-checkbox:checked').length;

	if (selectedCategories === 0) {
		e.preventDefault();
		alert('{{ __("Please select at least one category!") }}');
		$('html, body').animate({
			scrollTop: $('.category-tree-container').offset().top - 100
		}, 500);
		return false;
	}
	return true;
});

})(jQuery);

</script>

<script type="text/javascript">

(function($) {
		"use strict";

$('.cropme').simpleCropper();

})(jQuery);


$(document).on('click','#size-check',function(){
	if($(this).is(':checked')){
		$('#default_stock').addClass('d-none')
	}else{
		$('#default_stock').removeClass('d-none');
	}
})

// Initialize meta tags with existing data
$(document).ready(function() {
	@if($data->meta_tag)
		@php
			$metaTags = is_array($data->meta_tag) ? $data->meta_tag : explode(',', $data->meta_tag);
		@endphp
		@foreach($metaTags as $tag)
			$("#metatags").tagit("createTag", "{{ trim($tag) }}");
		@endforeach
	@endif

	// Pre-select existing categories
	var selectedCategories = [
		@if(isset($selectedCategoryIds) && is_array($selectedCategoryIds))
			@foreach($selectedCategoryIds as $catId)
				{{ $catId }},
			@endforeach
		@endif
	];

	// Check the categories and expand their parent containers
	selectedCategories.forEach(function(catId) {
		if (catId) {
			var $checkbox = $('.category-checkbox[value="' + catId + '"]');
			$checkbox.prop('checked', true);

			// Expand ALL parent containers (subcategories and childcategories)
			$checkbox.parents('.subcategories, .childcategories').show();

			// Also expand the subcategories/childcategories of this category if it has any
			$checkbox.closest('label').next('.subcategories, .childcategories').show();

			// Update toggle icons
			$checkbox.closest('label').find('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
			$checkbox.parents('.subcategories, .childcategories').prev('label').find('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
		}
	});

	// Update the selected categories display
	updateSelectedCategories();
});
</script>


@include('partials.admin.product.product-scripts')
@endsection
