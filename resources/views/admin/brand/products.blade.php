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
                        <div class="row" id="product-sortable">
                            @foreach($products as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 product-item" data-id="{{ $product->id }}">
                                <div class="card h-100 shadow-sm hover-shadow" style="border-radius: 12px; transition: all 0.3s ease;">
                                    {{-- Drag Handle --}}
                                    <div class="drag-handle text-center py-2" style="cursor: move; background: #f8f9fa; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                        <i class="fas fa-grip-horizontal text-muted"></i>
                                    </div>

                                    {{-- Product Image --}}
                                    <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background: #ffffff; padding: 15px;">
                                        @if($product->image)
                                        <img src="{{ asset('assets/images/brand-products/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                        <div class="text-center">
                                            <i class="fas fa-box-open" style="font-size: 60px; color: #dee2e6;"></i>
                                            <p class="text-muted small mt-2">{{ __('No Image') }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Card Body --}}
                                    <div class="card-body">
                                        <h5 class="card-title mb-2" style="font-weight: 600; font-size: 1rem;">{{ $product->name }}</h5>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge badge-success" style="font-size: 0.9rem; padding: 6px 12px;">
                                                ${{ number_format($product->price, 2) }}
                                            </span>
                                            <span class="badge {{ $product->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                {{ $product->status == 1 ? __('Active') : __('Inactive') }}
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted">{{ __('Sort Order') }}: <strong>{{ $product->sort_order }}</strong></small>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-sm btn-primary edit-product flex-fill mr-1"
                                                    data-id="{{ $product->id }}"
                                                    data-name="{{ $product->name }}"
                                                    data-name-en="{{ $product->name_en }}"
                                                    data-price="{{ $product->price }}"
                                                    data-status="{{ $product->status }}"
                                                    data-sort="{{ $product->sort_order }}"
                                                    data-image="{{ $product->image }}"
                                                    title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </button>

                                            <button class="btn btn-sm btn-{{ $product->status == 1 ? 'warning' : 'success' }} toggle-status mr-1"
                                                    data-id="{{ $product->id }}"
                                                    data-status="{{ $product->status == 1 ? 0 : 1 }}"
                                                    title="{{ $product->status == 1 ? __('Deactivate') : __('Activate') }}">
                                                <i class="fas fa-{{ $product->status == 1 ? 'eye-slash' : 'eye' }}"></i>
                                            </button>

                                            <button class="btn btn-sm btn-danger delete-product"
                                                    data-id="{{ $product->id }}"
                                                    title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
                        <label>{{ __('Product Name (Arabic)') }} *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Product Name (English)') }}</label>
                        <input type="text" class="form-control" name="name_en">
                        <small class="form-text text-muted">{{ __('Optional English name for bilingual support') }}</small>
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
                        <label>{{ __('Product Name (Arabic)') }} *</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Product Name (English)') }}</label>
                        <input type="text" class="form-control" name="name_en" id="edit_name_en">
                        <small class="form-text text-muted">{{ __('Optional English name for bilingual support') }}</small>
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
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.msg);
                } else {
                    alert(response.msg || 'Order updated successfully!');
                }
            },
            error: function(xhr) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('{{ __("Error updating order") }}');
                } else {
                    alert('Error updating order');
                }
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
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.msg);
                } else {
                    alert(response.msg || 'Product created successfully!');
                }
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                $('.gocover').hide();
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(value[0]);
                        } else {
                            alert('Error: ' + value[0]);
                        }
                    });
                } else {
                    var errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : '{{ __("An error occurred") }}';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert('Error: ' + errorMsg);
                    }
                }
            }
        });
    });

    // Open Edit Modal
    $(document).on('click', '.edit-product', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var nameEn = $(this).data('name-en');
        var price = $(this).data('price');
        var status = $(this).data('status');
        var sort = $(this).data('sort');
        var image = $(this).data('image');

        $('#edit_product_id').val(id);
        $('#edit_name').val(name);
        $('#edit_name_en').val(nameEn);
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
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.msg);
                } else {
                    alert(response.msg || 'Product updated successfully!');
                }
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                $('.gocover').hide();
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(value[0]);
                        } else {
                            alert('Error: ' + value[0]);
                        }
                    });
                } else {
                    var errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : '{{ __("An error occurred") }}';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert('Error: ' + errorMsg);
                    }
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
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.msg);
                } else {
                    alert(response.msg || 'Status updated successfully!');
                }
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('{{ __("An error occurred") }}');
                } else {
                    alert('An error occurred');
                }
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
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.msg);
                    } else {
                        alert(response.msg || 'Product deleted successfully!');
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    $('.gocover').hide();
                    var errorMsg = xhr.responseJSON && xhr.responseJSON.msg ? xhr.responseJSON.msg : '{{ __("An error occurred") }}';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert('Error: ' + errorMsg);
                    }
                }
            });
        }
    });
});
</script>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
}

.card {
    border: 1px solid #e3e6f0;
}

.product-item {
    transition: all 0.3s ease;
}

.drag-handle {
    transition: background 0.2s ease;
}

.drag-handle:hover {
    background: #e9ecef !important;
}

.card-title {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    min-height: 2.5rem;
}

@media (max-width: 768px) {
    .col-sm-12 {
        margin-bottom: 1rem;
    }
}
</style>

@endsection
