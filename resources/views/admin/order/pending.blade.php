@extends('layouts.admin')

@section('content')

<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('Pending Orders') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Orders') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-orders-all') }}?status=pending">{{ __('Pending Orders') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Order Filters -->
                        <div class="order-filters-container">
                            <div class="filter-header">
                                <div class="filter-title">
                                    <i class="fas fa-filter"></i>
                                    {{ __('Order Filters') }}
                                </div>
                            </div>

                            <div class="status-filters">
                                <a href="{{ route('admin-orders-all') }}" class="status-btn all">
                                    <i class="fas fa-list"></i>
                                    <span>{{ __('All Orders') }}</span>
                                    <span class="status-count">{{ \App\Models\Order::count() }}</span>
                                </a>

                                <a href="{{ route('admin-orders-all') }}?status=pending" class="status-btn pending active">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ __('Pending') }}</span>
                                    <span class="status-count">{{ \App\Models\Order::where('status', 'pending')->count() }}</span>
                                </a>

                                <a href="{{ route('admin-orders-all') }}?status=processing" class="status-btn processing">
                                    <i class="fas fa-spinner"></i>
                                    <span>{{ __('Processing') }}</span>
                                    <span class="status-count">{{ \App\Models\Order::where('status', 'processing')->count() }}</span>
                                </a>

                                <a href="{{ route('admin-orders-all') }}?status=completed" class="status-btn completed">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ __('Completed') }}</span>
                                    <span class="status-count">{{ \App\Models\Order::where('status', 'completed')->count() }}</span>
                                </a>

                                <a href="{{ route('admin-orders-all') }}?status=declined" class="status-btn declined">
                                    <i class="fas fa-times-circle"></i>
                                    <span>{{ __('Declined') }}</span>
                                    <span class="status-count">{{ \App\Models\Order::where('status', 'declined')->count() }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="product-area">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        @include('alerts.admin.form-success')
                                        <div class="table-responsive">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Customer Email') }}</th>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Total Qty') }}</th>
                                                            <th>{{ __('Total Cost') }}</th>
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
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

<style>
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

.status-btn.pending { border-color: #FF9800; color: #FF9800; }
.status-btn.pending.active { background: #FF9800; }

.status-btn.processing { border-color: #2196F3; color: #2196F3; }
.status-btn.processing.active { background: #2196F3; }

.status-btn.completed { border-color: #4CAF50; color: #4CAF50; }
.status-btn.completed.active { background: #4CAF50; }

.status-btn.declined { border-color: #F44336; color: #F44336; }
.status-btn.declined.active { background: #F44336; }

.status-btn.all { border-color: #9C27B0; color: #9C27B0; }
.status-btn.all.active { background: #9C27B0; }

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

{{-- DATA TABLE --}}

    <script type="text/javascript">

(function($) {
		"use strict";

        var table = $('#geniustable').DataTable({
               ordering: false,
               processing: true,
               serverSide: true,
               ajax: '{{ route('admin-order-datatables','pending') }}',
               columns: [
                        { data: 'customer_email', name: 'customer_email' },
                        { data: 'id', name: 'id' },
                        { data: 'totalQty', name: 'totalQty' },
                        { data: 'pay_amount', name: 'pay_amount' },
                        { data: 'action', searchable: false, orderable: false }
                     ],
               language : {
                    processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
                drawCallback : function( settings ) {
                        $('.select').niceSelect();
                }
            });


    })(jQuery);

    </script>

{{-- DATA TABLE --}}

@endsection
