@extends('layouts.admin')

@section('content')
					<input type="hidden" id="headerdata" value="{{ __("PRODUCT") }}">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __("Products") }}</h4>
										<ul class="links">
											<li>
												<a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }} </a>
											</li>
											<li>
												<a href="javascript:;">{{ __("Products") }} </a>
											</li>
											<li>
												<a href="{{ route('admin-prod-index') }}">{{ __("All Products") }}</a>
											</li>
										</ul>
								</div>
							</div>
						</div>
						<div class="product-area">
							<div class="row">
								<div class="col-lg-12">
									<div class="mr-table allproduct">
                        					@include('alerts.admin.form-success')

										{{-- Simple Professional Filters Section --}}
										<div class="filters-container" style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin: 0 0 25px 0; border: 1px solid #e2e8f0;">
											<div class="row align-items-end">
												<div class="col-md-3 mb-3">
													<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 10px; display: block;">
														<i class="fas fa-search"></i> {{ __("Search Product") }}
													</label>
													<input type="text" id="search-product" class="form-control" placeholder="{{ __('Product name or SKU...') }}" style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 15px;">
												</div>
												<div class="col-md-2 mb-3">
													<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 10px; display: block;">
														<i class="fas fa-toggle-on"></i> {{ __("Status") }}
													</label>
													<select id="filter-status" class="form-control" style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 15px;">
														<option value="">{{ __("All Status") }}</option>
														<option value="1">{{ __("Active") }}</option>
														<option value="0">{{ __("Inactive") }}</option>
													</select>
												</div>
												<div class="col-md-3 mb-3">
													<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 10px; display: block;">
														<i class="fas fa-tags"></i> {{ __("Category") }}
													</label>
													<select id="filter-category" class="form-control" style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 15px;">
														<option value="">{{ __("All Categories") }}</option>
														@foreach(\App\Models\Category::where('status', 1)->orderBy('name')->get() as $cat)
															<option value="{{$cat->id}}">{{$cat->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col-md-2 mb-3">
													<label style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 10px; display: block;">
														<i class="fas fa-dollar-sign"></i> {{ __("Price Range") }}
													</label>
													<select id="filter-price" class="form-control" style="border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 15px;">
														<option value="">{{ __("All Prices") }}</option>
														<option value="0-10">0 - 10</option>
														<option value="10-50">10 - 50</option>
														<option value="50-100">50 - 100</option>
														<option value="100+">100+</option>
													</select>
												</div>
												<div class="col-md-2 mb-3">
													<button id="reset-filters" class="btn" style="width: 100%; border-radius: 6px; padding: 10px; font-weight: 600; border: 1px solid #e2e8f0; background: white; color: #2d3748;">
														<i class="fas fa-redo"></i> {{ __("Reset") }}
													</button>
												</div>
											</div>

											{{-- Filter Summary --}}
											<div id="filter-summary" class="mt-3" style="display: none;">
												<div style="background: #ffffff; border-radius: 6px; padding: 12px; border: 1px solid #e2e8f0;">
													<small style="color: #2d3748; font-weight: 600;">
														<i class="fas fa-filter"></i> {{ __("Active Filters:") }}
													</small>
													<div id="active-filters" style="display: inline-block; margin-left: 10px;"></div>
												</div>
											</div>
										</div>

										<div class="table-responsive">
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
									                        <th>{{ __("Image") }}</th>
									                        <th>{{ __("Name") }}</th>
									                        <th>{{ __("Price") }}</th>
									                        <th>{{ __("Status") }}</th>
									                        <th>{{ __("Options") }}</th>
														</tr>
													</thead>
												</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>



{{-- HIGHLIGHT MODAL --}}

										<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2" aria-hidden="true">


										<div class="modal-dialog highlight" role="document">
										<div class="modal-content">
												<div class="submit-loader">
														<img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
												</div>
											<div class="modal-header">
											<h5 class="modal-title"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">

											</div>
											<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
											</div>
										</div>
										</div>
</div>

{{-- HIGHLIGHT ENDS --}}

{{-- CATALOG MODAL --}}

<div class="modal fade" id="catalog-modal" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header d-block text-center">
		<h4 class="modal-title d-inline-block">{{ __("Update Status") }}</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
	</div>

      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center">{{ __("You are about to change the status of this Product.") }}</p>
            <p class="text-center">{{ __("Do you want to proceed?") }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __("Cancel") }}</button>
            <a class="btn btn-success btn-ok">{{ __("Proceed") }}</a>
      </div>

    </div>
  </div>
</div>

{{-- CATALOG MODAL ENDS --}}

{{-- DELETE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header d-block text-center">
		<h4 class="modal-title d-inline-block">{{ __("Confirm Delete") }}</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
	</div>

      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center">{{ __("You are about to delete this Product.") }}</p>
            <p class="text-center">{{ __("Do you want to proceed?") }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __("Cancel") }}</button>
            			<form action="" class="d-inline delete-form" method="POST">
				<input type="hidden" name="_method" value="delete" />
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
			</form>
      </div>

    </div>
  </div>
</div>

{{-- DELETE MODAL ENDS --}}

{{-- GALLERY MODAL --}}

		<div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">{{ __("Image Gallery") }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="top-area">
						<div class="row">
							<div class="col-sm-6 text-right">
								<div class="upload-img-btn">
									<form  method="POST" enctype="multipart/form-data" id="form-gallery">
										@csrf
									<input type="hidden" id="pid" name="product_id" value="">
									<input type="file" name="gallery[]" class="hidden" id="uploadgallery" accept="image/*" multiple>
											<label for="image-upload" id="prod_gallery"><i class="icofont-upload-alt"></i>{{ __("Upload File") }}</label>
									</form>
								</div>
							</div>
							<div class="col-sm-6">
								<a href="javascript:;" class="upload-done" data-dismiss="modal"> <i class="fas fa-check"></i> {{ __("Done") }}</a>
							</div>
							<div class="col-sm-12 text-center">( <small>{{ __("You can upload multiple Images.") }}</small> )</div>
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

{{-- GALLERY MODAL ENDS --}}

@endsection

@section('scripts')

{{-- DATA TABLE --}}

    <script type="text/javascript">

(function($) {
		"use strict";

		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               ajax: {
					url: '{{ route('admin-prod-datatables') }}?type=all',
					data: function (d) {
						d.search_query = $('#search-product').val();
						d.status = $('#filter-status').val();
						d.category = $('#filter-category').val();
						d.price = $('#filter-price').val();
					}
			   },
               columns: [
                        { data: 'image', name: 'photo', searchable: false, orderable: false },
                        { data: 'name', name: 'name' },
                        { data: 'price', name: 'price' },
                        { data: 'status', searchable: false, orderable: false},
            			{ data: 'action', searchable: false, orderable: false }
                     ],
               columnDefs: [
                   {
                       targets: 0,
                       width: '80px',
                       className: 'text-center'
                   }
               ],
                language : {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
				drawCallback : function( settings ) {
	    				$('.select').niceSelect();
				}
            });

		// Search filter
		$('#search-product').on('keyup', function() {
			table.draw();
			updateFilterSummary();
		});

		// Status filter
		$('#filter-status').on('change', function() {
			table.draw();
			updateFilterSummary();
		});

		// Category filter
		$('#filter-category').on('change', function() {
			table.draw();
			updateFilterSummary();
		});

		// Price filter
		$('#filter-price').on('change', function() {
			table.draw();
			updateFilterSummary();
		});

		// Reset filters
		$('#reset-filters').on('click', function() {
			$('#search-product').val('');
			$('#filter-status').val('');
			$('#filter-category').val('');
			$('#filter-price').val('');
			table.draw();
			updateFilterSummary();
		});

		// Update filter summary
		function updateFilterSummary() {
			var filters = [];
			var search = $('#search-product').val();
			var status = $('#filter-status').val();
			var category = $('#filter-category option:selected').text();
			var price = $('#filter-price option:selected').text();

			if (search) filters.push('<span class="badge" style="background: #2d3748; color: white; padding: 5px 10px; border-radius: 4px; margin-right: 5px;"><i class="fas fa-search"></i> ' + search + '</span>');
			if (status !== '') filters.push('<span class="badge" style="background: #2d3748; color: white; padding: 5px 10px; border-radius: 4px; margin-right: 5px;"><i class="fas fa-toggle-on"></i> ' + (status == '1' ? 'Active' : 'Inactive') + '</span>');
			if ($('#filter-category').val()) filters.push('<span class="badge" style="background: #2d3748; color: white; padding: 5px 10px; border-radius: 4px; margin-right: 5px;"><i class="fas fa-tags"></i> ' + category + '</span>');
			if ($('#filter-price').val()) filters.push('<span class="badge" style="background: #2d3748; color: white; padding: 5px 10px; border-radius: 4px; margin-right: 5px;"><i class="fas fa-dollar-sign"></i> ' + price + '</span>');

			if (filters.length > 0) {
				$('#active-filters').html(filters.join(''));
				$('#filter-summary').slideDown();
			} else {
				$('#filter-summary').slideUp();
			}
		}

		// Reset filters
		$('#reset-filters').on('click', function() {
			$('#search-product').val('');
			$('#filter-status').val('');
			$('#filter-category').val('');
			$('#filter-price').val('');
			table.draw();
		});

		// Toggle status directly in table
		$(document).on('change', '.status-toggle', function() {
			var checkbox = $(this);
			var productId = checkbox.data('id');
			var newStatus = checkbox.is(':checked') ? 1 : 0;

			$.ajax({
				url: '{{ route('admin-prod-status', ['id1' => '__ID__', 'id2' => '__STATUS__']) }}'.replace('__ID__', productId).replace('__STATUS__', newStatus),
				type: 'GET',
				success: function(response) {
					toastr.success('{{ __("Status updated successfully!") }}');
				},
				error: function() {
					toastr.error('{{ __("Failed to update status!") }}');
					checkbox.prop('checked', !checkbox.is(':checked'));
				}
			});
		});

      	$(function() {
        $(".btn-area").append('<div class="col-sm-4 table-contents">'+
        	'<a class="add-btn" href="{{route('admin-prod-create', 'physical')}}">'+
          '<i class="fas fa-plus"></i> <span class="remove-mobile">{{ __("Add Product") }}<span>'+
          '</a>'+
          '</div>');
      });

})(jQuery);

</script>

{{-- DATA TABLE ENDS--}}

{{-- Gallery Section Update--}}

<script type="text/javascript">

    $(function($) {
		"use strict";

    $(document).on("click", ".set-gallery" , function(){
        var pid = $(this).find('input[type=hidden]').val();
        $('#pid').val(pid);
        $('.selected-image .row').html('');
            $.ajax({
                    type: "GET",
                    url:"{{ route('admin-gallery-show') }}",
                    data:{id:pid},
                    success:function(data){
                      if(data[0] == 0)
                      {
	                    $('.selected-image .row').addClass('justify-content-center');
	      				$('.selected-image .row').html('<h3>{{ __("No Images Found.") }}</h3>');
     				  }
                      else {
	                    $('.selected-image .row').removeClass('justify-content-center');
	      				$('.selected-image .row h3').remove();
                          var arr = $.map(data[1], function(el) {
                          return el });

                          for(var k in arr)
                          {
        				$('.selected-image .row').append('<div class="col-sm-6">'+
                                        '<div class="img gallery-img">'+
                                            '<span class="remove-img"><i class="fas fa-times"></i>'+
                                            '<input type="hidden" value="'+arr[k]['id']+'">'+
                                            '</span>'+
                                            '<a href="'+'{{asset('assets/images/galleries').'/'}}'+arr[k]['photo']+'" target="_blank">'+
                                            '<img src="'+'{{asset('assets/images/galleries').'/'}}'+arr[k]['photo']+'" alt="gallery image">'+
                                            '</a>'+
                                        '</div>'+
                                  	'</div>');
                          }
                       }

                    }
                  });
      });


  $(document).on('click', '.remove-img' ,function() {
    var id = $(this).find('input[type=hidden]').val();
    $(this).parent().parent().remove();
	    $.ajax({
	        type: "GET",
	        url:"{{ route('admin-gallery-delete') }}",
	        data:{id:id}
	    });
  });

  $(document).on('click', '#prod_gallery' ,function() {
    $('#uploadgallery').click();
  });


  $("#uploadgallery").change(function(){
    $("#form-gallery").submit();
  });

  $(document).on('submit', '#form-gallery' ,function() {
		  $.ajax({
		   url:"{{ route('admin-gallery-store') }}",
		   method:"POST",
		   data:new FormData(this),
		   dataType:'JSON',
		   contentType: false,
		   cache: false,
		   processData: false,
		   success:function(data)
		   {
		    if(data != 0)
		    {
	                    $('.selected-image .row').removeClass('justify-content-center');
	      				$('.selected-image .row h3').remove();
		        var arr = $.map(data, function(el) {
		        return el });
		        for(var k in arr)
		           {
        				$('.selected-image .row').append('<div class="col-sm-6">'+
                                        '<div class="img gallery-img">'+
                                            '<span class="remove-img"><i class="fas fa-times"></i>'+
                                            '<input type="hidden" value="'+arr[k]['id']+'">'+
                                            '</span>'+
                                            '<a href="'+'{{asset('assets/images/galleries').'/'}}'+arr[k]['photo']+'" target="_blank">'+
                                            '<img src="'+'{{asset('assets/images/galleries').'/'}}'+arr[k]['photo']+'" alt="gallery image">'+
                                            '</a>'+
                                        '</div>'+
                                  	'</div>');
		            }
		    }

		    }

		  });
		  return false;

})(jQuery);

 });


</script>

{{-- Gallery Section Update Ends--}}

<style>
/* Toggle Switch Styling */
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
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
  background-color: #ccc;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
}

input:checked + .slider {
  background-color: #28a745;
}

input:focus + .slider {
  box-shadow: 0 0 1px #28a745;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

.slider.round {
  border-radius: 24px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

@endsection
