@extends('layouts.admin') 

@section('content')  

					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __("Subscribers") }}</h4>
										<ul class="links">
											<li>
												<a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }} </a>
											</li>
											<li>
												<a href="{{ route('admin-subs-index') }}">{{ __("Subscribers") }}</a>
											</li>
										</ul>
								</div>
							</div>
						</div>
						<div class="product-area">
							<div class="row">
								<div class="col-lg-12">
									<div class="mr-table allproduct">
                        @include('alerts.admin.form-both')  
										<div class="table-responsive">
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
									                        <th>{{ __("#Sl") }}</th>
									                        <th>{{ __("Email") }}</th>
									                        <th>{{ __("Action") }}</th>
														</tr>
													</thead>
												</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

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
								  <p class="text-center">{{ __("You are about to delete this Category. Everything under this category will be deleted.") }}</p>
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

@endsection    



@section('scripts')

    <script type="text/javascript">

(function($) {
		"use strict";

		$('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{ route('admin-subs-datatables') }}',
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'email', name: 'email' },
                        { data: 'action', name: 'action' , searchable: false, orderable: false }
                     ],
                language : {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                }
            });								
					
      	$(function() {
        $(".btn-area").append('<div class="col-sm-4 table-contents">'+
        	'<a class="add-btn" href="{{route('admin-subs-download')}}">'+
          '<i class="fa fa-download"></i> {{ __("Download") }}'+
          '</a>'+
          '</div>');
      });	

})(jQuery);

    </script>
@endsection   