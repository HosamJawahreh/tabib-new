@extends('layouts.admin')

@section('styles')

<style type="text/css">

.input-field {
    padding: 15px 20px;
}

/* Professional Order Filters */
.order-filters-container {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.filter-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.filter-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-title i {
    color: #4CAF50;
}

.status-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.status-btn {
    padding: 10px 20px;
    border-radius: 6px;
    border: 1px solid #ddd;
    background: #fff;
    color: #555;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.status-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    text-decoration: none;
}

.status-btn.active {
    color: #fff;
    border-color: transparent;
}

.status-btn i {
    font-size: 14px;
}

/* Simple Status Colors - Updated */
.status-btn.pending {
    border-color: #ff9800 !important;
    color: #ff9800 !important;
    background: #fff !important;
}
.status-btn.pending.active {
    background: #ff9800 !important;
    border-color: #ff9800 !important;
    color: #fff !important;
}

.status-btn.processing {
    border-color: #2196f3 !important;
    color: #2196f3 !important;
    background: #fff !important;
}
.status-btn.processing.active {
    background: #2196f3 !important;
    border-color: #2196f3 !important;
    color: #fff !important;
}

.status-btn.completed {
    border-color: #4caf50 !important;
    color: #4caf50 !important;
    background: #fff !important;
}
.status-btn.completed.active {
    background: #4caf50 !important;
    border-color: #4caf50 !important;
    color: #fff !important;
}

.status-btn.declined {
    border-color: #f44336 !important;
    color: #f44336 !important;
    background: #fff !important;
}
.status-btn.declined.active {
    background: #f44336 !important;
    border-color: #f44336 !important;
    color: #fff !important;
}

.status-btn.all {
    border-color: #607d8b !important;
    color: #607d8b !important;
    background: #fff !important;
}
.status-btn.all.active {
    background: #607d8b !important;
    border-color: #607d8b !important;
    color: #fff !important;
}

/* Status Badge Styles */
.badge {
    padding: 5px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
}

.badge-warning {
    background: #ff9800;
    color: #fff;
}

.badge-info {
    background: #2196f3;
    color: #fff;
}

.badge-success {
    background: #4caf50;
    color: #fff;
}

.badge-danger {
    background: #f44336;
    color: #fff;
}

.badge-secondary {
    background: #78909c;
    color: #fff;
}

.status-count {
    background: rgba(0, 0, 0, 0.1);
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 600;
}

.status-btn.active .status-count {
    background: rgba(255, 255, 255, 0.3);
}

.quick-actions {
    display: flex;
    gap: 10px;
}

.quick-action-btn {
    padding: 10px 18px;
    border-radius: 6px;
    background: #4CAF50;
    border: none;
    color: #fff;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.quick-action-btn:hover {
    background: #45a049;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
    text-decoration: none;
}

/* Inline Action Buttons */
.action-btns-inline {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    color: #fff;
}

.btn-action i {
    font-size: 14px;
}

/* Simple Action Button Colors */
.btn-view {
    background: #2196F3;
}

.btn-view:hover {
    background: #1976D2;
}

.btn-track {
    background: #FF9800;
}

.btn-track:hover {
    background: #F57C00;
}

.btn-delivery {
    background: #4CAF50;
}

.btn-delivery:hover {
    background: #388E3C;
}

.btn-email {
    background: #9C27B0;
}

.btn-email:hover {
    background: #7B1FA2;
}

@media (max-width: 768px) {
    .filter-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .status-filters {
        width: 100%;
    }

    .status-btn {
        flex: 1 1 calc(50% - 5px);
        justify-content: center;
        font-size: 13px;
    }

    .quick-actions {
        width: 100%;
    }

    .quick-action-btn {
        flex: 1;
    }

    .action-btns-inline {
        gap: 5px;
    }

    .btn-action {
        width: 28px;
        height: 28px;
    }

    .btn-action i {
        font-size: 12px;
    }
}

</style>

@endsection

@section('content')

<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        @php
                                            $statusText = 'All Orders';
                                            $currentStatus = request()->get('status', 'all');
                                            if($currentStatus == 'pending') $statusText = 'New Orders';
                                            elseif($currentStatus == 'processing') $statusText = 'Processing Orders';
                                            elseif($currentStatus == 'completed') $statusText = 'Completed Orders';
                                            elseif($currentStatus == 'declined') $statusText = 'Declined Orders';
                                            else $statusText = 'All Orders';
                                        @endphp
                                        <h4 class="heading">{{ __($statusText) }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Orders') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-orders-all') }}">{{ __($statusText) }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Order Filters -->
                        <div class="order-filters-container">
                            <div class="filter-header">
                                <h3 class="filter-title">
                                    <i class="fas fa-filter"></i>
                                    {{ __('Filter Orders') }}
                                </h3>
                            </div>

                            <div class="status-filters">
                                @php
                                    $currentStatus = request()->get('status', 'all');
                                    $allOrders = \App\Models\Order::count();
                                    $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
                                    $processingOrders = \App\Models\Order::where('status', 'processing')->count();
                                    $completedOrders = \App\Models\Order::where('status', 'completed')->count();
                                    $declinedOrders = \App\Models\Order::where('status', 'declined')->count();
                                @endphp

                                <a href="javascript:;" data-status="pending"
                                   class="status-btn pending filter-status-btn {{ $currentStatus == 'pending' ? 'active' : '' }}">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ __('New Orders') }}</span>
                                    <span class="status-count">{{ $pendingOrders }}</span>
                                </a>

                                <a href="javascript:;" data-status="processing"
                                   class="status-btn processing filter-status-btn {{ $currentStatus == 'processing' ? 'active' : '' }}">
                                    <i class="fas fa-sync-alt"></i>
                                    <span>{{ __('Processing') }}</span>
                                    <span class="status-count">{{ $processingOrders }}</span>
                                </a>

                                <a href="javascript:;" data-status="completed"
                                   class="status-btn completed filter-status-btn {{ $currentStatus == 'completed' ? 'active' : '' }}">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ __('Completed') }}</span>
                                    <span class="status-count">{{ $completedOrders }}</span>
                                </a>

                                <a href="javascript:;" data-status="declined"
                                   class="status-btn declined filter-status-btn {{ $currentStatus == 'declined' ? 'active' : '' }}">
                                    <i class="fas fa-times-circle"></i>
                                    <span>{{ __('Declined') }}</span>
                                    <span class="status-count">{{ $declinedOrders }}</span>
                                </a>

                                <a href="javascript:;" data-status="all"
                                   class="status-btn all filter-status-btn {{ $currentStatus == 'all' || !in_array($currentStatus, ['pending', 'processing', 'completed', 'declined']) ? 'active' : '' }}">
                                    <i class="fas fa-list"></i>
                                    <span>{{ __('All Orders') }}</span>
                                    <span class="status-count">{{ $allOrders }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="product-area">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        @include('alerts.admin.form-success')
                                        @include('alerts.form-success')
                                        <div class="table-responsive">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Customer Name') }}</th>
                                                            <th>{{ __('Phone Number') }}</th>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Shipping') }}</th>
                                                            <th>{{ __('Shipping Cost') }}</th>
                                                            <th>{{ __('Total Qty') }}</th>
                                                            <th>{{ __('Total Cost') }}</th>
                                                            <th>{{ __('Status') }}</th>
                                                            <th>{{ __('Options') }}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

{{-- ORDER MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="submit-loader">
            <img src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
        </div>
        <div class="modal-header d-block text-center">
            <h4 class="modal-title d-inline-block">{{ __('Delete Order') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <p class="text-center">{{ __("You are about to delete this order permanently.") }}</p>
            <p class="text-center">{{ __('Do you want to proceed?') }}</p>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            <form id="delete-order-form" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirm-delete1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="submit-loader">
            <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
        </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{ __('Update Status') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">{{ __("You are about to update the order's Status.") }}</p>
        <p class="text-center">{{ __('Do you want to proceed?') }}</p>
        <input type="hidden" id="t-add" value="{{ route('admin-order-track-add') }}">
        <input type="hidden" id="t-id" value="">
        <input type="hidden" id="t-title" value="">
        <textarea class="input-field" placeholder="{{__('Enter Your Tracking Note (Optional)')}}" id="t-txt"></textarea>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-success btn-ok order-btn">{{ __('Proceed') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- ORDER MODAL ENDS --}}



{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __('Send Email') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-form">
                                <form id="emailreply">
                                    {{csrf_field()}}
                                    <ul>
                                        <li>
                                            <input type="email" class="input-field eml-val" id="eml" name="to" placeholder="{{ __('Email') }} *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ __('Subject') }} *" required="">
                                        </li>
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }} *" required=""></textarea>
                                        </li>
                                    </ul>
                                    <button class="submit-btn" id="emlsub" type="submit">{{ __('Send Email') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}

{{-- ADD / EDIT MODAL --}}

                <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered" role="document">
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
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                            </div>
                        </div>
                    </div>

                </div>

{{-- ADD / EDIT MODAL ENDS --}}

@endsection

@section('scripts')

{{-- DATA TABLE --}}

    <script type="text/javascript">

(function($) {
		"use strict";

        // Get current status from URL
        var urlParams = new URLSearchParams(window.location.search);
        var currentStatus = urlParams.get('status') || 'all';

        // Set active button on page load based on URL
        $('.filter-status-btn').removeClass('active');
        $('.filter-status-btn[data-status="' + currentStatus + '"]').addClass('active');

        var table = $('#geniustable').DataTable({
               ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{ route('admin-order-datatables','') }}/' + currentStatus,
               columns: [
                        { data: 'customer_name', name: 'customer_name' },
                        { data: 'customer_phone', name: 'customer_phone' },
                        { data: 'id', name: 'id' },
                        { data: 'shipping_method', name: 'shipping_method', searchable: false, orderable: false },
                        { data: 'shipping_cost', name: 'shipping_cost', searchable: false, orderable: false },
                        { data: 'totalQty', name: 'totalQty' },
                        { data: 'pay_amount', name: 'pay_amount' },
                        { data: 'status', name: 'status', searchable: false, orderable: false },
                        { data: 'action', searchable: false, orderable: false }
                     ],
               language : {
                    processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
                drawCallback : function( settings ) {
                        $('.select').niceSelect();
                }
            });

        // Filter button click handler - reload table without page refresh
        $('.filter-status-btn').on('click', function(e) {
            e.preventDefault();

            var status = $(this).data('status');

            // Remove active class from all buttons
            $('.filter-status-btn').removeClass('active');

            // Add active class to clicked button
            $(this).addClass('active');

            // Keep URL as /orders without query parameters
            var newUrl = '{{ route('admin-orders-all') }}';
            window.history.pushState({}, '', newUrl);

            // Update DataTable ajax URL and reload
            table.ajax.url('{{ route('admin-order-datatables','') }}/' + status).load();

            // Update page title
            var statusTitles = {
                'pending': '{{ __('New Orders') }}',
                'processing': '{{ __('Processing Orders') }}',
                'completed': '{{ __('Completed Orders') }}',
                'declined': '{{ __('Declined Orders') }}',
                'all': '{{ __('All Orders') }}'
            };

            $('.heading').text(statusTitles[status] || '{{ __('New Orders') }}');
        });

        // Order Status Change Handler in table (using event delegation for dynamic content)
        $('#geniustable').on('change', '.order-status-select', function() {
            var orderId = $(this).data('order-id');
            var newStatus = $(this).val();
            var selectElement = $(this);
            var oldValue = selectElement.find('option[selected]').val();

            if(confirm('Are you sure you want to change the order status?')) {
                $.ajax({
                    url: '{{ url('admin/order') }}/' + orderId + '/status/' + newStatus,
                    type: 'GET',
                    success: function(response) {
                        // Show success message
                        alert('Order status updated successfully!');

                        // Mark new selected option
                        selectElement.find('option').removeAttr('selected');
                        selectElement.find('option[value="'+newStatus+'"]').attr('selected', 'selected');

                        // Reload table to update counts if needed
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        alert('Error updating order status. Please try again.');
                        // Revert to old value
                        selectElement.val(oldValue);
                    }
                });
            } else {
                // User cancelled, revert to old value
                selectElement.val(oldValue);
            }
        });

        // Delete Order Handler (using event delegation for dynamic content)
        $('#geniustable').on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).data('href');
            $('#delete-order-form').attr('action', deleteUrl);
        });

        // Delete form submission
        $('#delete-order-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: form.serialize(),
                success: function(response) {
                    $('#confirm-delete').modal('hide');
                    alert('Order deleted successfully!');
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    alert('Error deleting order. Please try again.');
                }
            });
        });

    })(jQuery);

    </script>

{{-- DATA TABLE --}}

@endsection
