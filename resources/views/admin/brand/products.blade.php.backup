@extends('layouts.admin')

@section('content')

<input type="hidden" id="headerdata" value="{{ __('BRAND PRODUCTS') }}">

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ $brand->name }} - {{ __('Products') }}</h4>
                <ul class="links">
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin-brand-index') }}">{{ __('Brands') }}</a></li>
                    <li><a href="javascript:;">{{ __('Products') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="add-product-content1">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-description">
                    <div class="body-area">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <a href="{{ route('admin-brand-index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> {{ __('Back to Brands') }}
                            </a>
                            <button class="addProductSubmit-btn" data-toggle="modal" data-target="#addProductModal">
                                <i class="fas fa-plus"></i> {{ __('Add New Product') }}
                            </button>
                        </div>

                        <div class="gocover" style="background: url({{ asset('assets/images/xloading.gif') }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                        
                        @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="products-table">
                                <thead>
                                    <tr>
                                        <th width="50"><i class="fas fa-grip-vertical"></i></th>
                                        <th width="100">{{ __('Image') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th width="120">{{ __('Price') }}</th>
                                        <th width="100">{{ __('Status') }}</th>
                                        <th width="100">{{ __('Order') }}</th>
                                        <th width="150">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="product-sortable">
                                    @foreach($products as $product)
                                    <tr class="product-item" data-id="{{ $product->id }}">
                                        <td class="drag-handle" style="cursor: move;">
                                            <i class="fas fa-grip-vertical"></i>
                                        </td>
                                        <td>
                                            @if($product->image)
                                            <img src="{{ asset('assets/images/brand-products/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 style="width: 60px; height: 60px; object-fit: contain; border-radius: 5px; border: 1px solid #dee2e6;">
                                            @else
                                            <div style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                            @endif
                                        </td>
                                        <td><strong>{{ $product->name }}</strong></td>
                                        <td><span class="badge badge-success">${{ number_format($product->price, 2) }}</span></td>
                                        <td>
                                            <span class="badge {{ $product->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                {{ $product->status == 1 ? __('Active') : __('Inactive') }}
                                            </span>
                                        </td>
                                        <td>{{ $product->sort_order }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-primary edit-product" 
                                                        data-id="{{ $product->id }}"
                                                        data-name="{{ $product->name }}"
                                                        data-price="{{ $product->price }}"
                                                        data-status="{{ $product->status }}"
                                                        data-sort="{{ $product->sort_order }}"
                                                        data-image="{{ $product->image }}"
                                                        title="{{ __('Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <button class="btn btn-{{ $product->status == 1 ? 'warning' : 'success' }} toggle-status" 
                                                        data-id="{{ $product->id }}"
                                                        data-status="{{ $product->status == 1 ? 0 : 1 }}"
                                                        title="{{ $product->status == 1 ? __('Deactivate') : __('Activate') }}">
                                                    <i class="fas fa-{{ $product->status == 1 ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                
                                                <button class="btn btn-danger delete-product" 
                                                        data-id="{{ $product->id }}"
                                                        title="{{ __('Delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open" style="font-size: 60px; color: #dee2e6;"></i>
                            <h5 class="mt-3">{{ __('No Products Found') }}</h5>
                            <p class="text-muted">{{ __('Click "Add New Product" to create your first product') }}</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Product Modal --}}
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> {{ __('Add New Product') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addProductForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="brand_id" value="{{ $brand->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Product Name') }} *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Price') }} *</label>
                        <input type="number" class="form-control" name="price" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Product Image') }}</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="form-text text-muted">{{ __('Recommended size: 500x500px. Will be converted to WebP format.') }}</small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Sort Order') }}</label>
                        <input type="number" class="form-control" name="sort_order" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Status') }} *</label>
                        <select class="form-control" name="status" required>
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save Product') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Product Modal --}}
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> {{ __('Edit Product') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editProductForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" id="edit_product_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Product Name') }} *</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Price') }} *</label>
                        <input type="number" class="form-control" name="price" id="edit_price" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Current Image') }}</label>
                        <div id="current_product_image_preview" class="mb-2"></div>
                        <label>{{ __('Change Image') }}</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="form-text text-muted">{{ __('Leave empty to keep current image') }}</small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Sort Order') }}</label>
                        <input type="number" class="form-control" name="sort_order" id="edit_sort_order" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Status') }} *</label>
                        <select class="form-control" name="status" id="edit_status" required>
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Update Product') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
$(document).ready(function() {
    
    // Initialize Sortable for drag and drop
    var el = document.getElementById('product-sortable');
    if (el) {
        var sortable = Sortable.create(el, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function (evt) {
                updateProductOrder();
            }
        });
    }

    // Update product order
    function updateProductOrder() {
        var order = [];
        $('#product-sortable .product-item').each(function(index) {
            order.push({
                id: $(this).data('id'),
                position: index
            });
        });

        $.ajax({
            url: '{{ route("admin-brand-product-update-order") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order: order
            },
            success: function(response) {
                toastr.success(response.msg);
            },
            error: function(xhr) {
                toastr.error('{{ __("Error updating order") }}');
            }
        });
    }

    // Add Product Form Submit
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        $('.gocover').show();

        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("admin-brand-product-store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.gocover').hide();
                $('#addProductModal').modal('hide');
                $('#addProductForm')[0].reset();
                toastr.success(response.msg);
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                $('.gocover').hide();
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('{{ __("An error occurred") }}');
                }
            }
        });
    });

    // Open Edit Modal
    $(document).on('click', '.edit-product', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        var status = $(this).data('status');
        var sort = $(this).data('sort');
        var image = $(this).data('image');

        $('#edit_product_id').val(id);
        $('#edit_name').val(name);
        $('#edit_price').val(price);
        $('#edit_status').val(status);
        $('#edit_sort_order').val(sort);

        if (image) {
            $('#current_product_image_preview').html('<img src="{{ asset("assets/images/brand-products/") }}/' + image + '" style="max-width: 200px; height: auto;">');
        } else {
            $('#current_product_image_preview').html('<p class="text-muted">{{ __("No image") }}</p>');
        }

        $('#editProductModal').modal('show');
    });

    // Edit Product Form Submit
    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();
        $('.gocover').show();

        var formData = new FormData(this);
        var productId = $('#edit_product_id').val();

        $.ajax({
            url: '{{ url("admin/brand-product/update") }}/' + productId,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.gocover').hide();
                $('#editProductModal').modal('hide');
                toastr.success(response.msg);
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                $('.gocover').hide();
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('{{ __("An error occurred") }}');
                }
            }
        });
    });

    // Toggle Status
    $(document).on('click', '.toggle-status', function() {
        var productId = $(this).data('id');
        var status = $(this).data('status');

        $.ajax({
            url: '{{ url("admin/brand-product/status") }}/' + productId + '/' + status,
            method: 'GET',
            success: function(response) {
                toastr.success(response.msg);
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                toastr.error('{{ __("An error occurred") }}');
            }
        });
    });

    // Delete Product
    $(document).on('click', '.delete-product', function() {
        var productId = $(this).data('id');

        if (confirm('{{ __("Are you sure you want to delete this product?") }}')) {
            $('.gocover').show();

            $.ajax({
                url: '{{ url("admin/brand-product/delete") }}/' + productId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('.gocover').hide();
                    toastr.success(response.msg);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    $('.gocover').hide();
                    toastr.error(xhr.responseJSON.msg || '{{ __("An error occurred") }}');
                }
            });
        }
    });
});
</script>

@endsection
