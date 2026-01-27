@extends('layouts.admin')

@section('content')

<input type="hidden" id="headerdata" value="{{ __('BRANDS') }}">

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Brand Management') }}</h4>
                <ul class="links">
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li><a href="javascript:;">{{ __('Brands') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="add-product-content1">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-description">
                    <div class="body-area">

                        {{-- Add Brand Button --}}
                        <div class="mb-4">
                            <button class="addProductSubmit-btn" data-toggle="modal" data-target="#addBrandModal">
                                <i class="fas fa-plus"></i> {{ __('Add New Brand') }}
                            </button>
                        </div>

                        {{-- Brands List --}}
                        <div class="gocover" style="background: url({{ asset('assets/images/xloading.gif') }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                        <div id="brand-list-container">
                            @if($brands->count() > 0)
                            <div class="row" id="brand-sortable">
                                @foreach($brands as $brand)
                                <div class="col-md-4 col-sm-6 mb-4 brand-item" data-id="{{ $brand->id }}">
                                    <div class="card shadow-sm h-100" style="border-radius: 10px; overflow: hidden;">
                                        {{-- Brand Image --}}
                                        <div class="brand-image-wrapper" style="height: 200px; background: #f8f9fa; position: relative; overflow: hidden;">
                                            @if($brand->image)
                                            <img src="{{ asset('assets/images/brands/' . $brand->image) }}"
                                                 alt="{{ $brand->name }}"
                                                 style="width: 100%; height: 100%; object-fit: contain; padding: 20px;">
                                            @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <i class="fas fa-image" style="font-size: 50px; color: #dee2e6;"></i>
                                            </div>
                                            @endif

                                            {{-- Drag Handle --}}
                                            <div class="drag-handle" style="position: absolute; top: 10px; left: 10px; cursor: move; background: rgba(0,0,0,0.5); color: white; padding: 5px 10px; border-radius: 5px;">
                                                <i class="fas fa-grip-vertical"></i>
                                            </div>

                                            {{-- Status Badge --}}
                                            <div style="position: absolute; top: 10px; right: 10px;">
                                                <span class="badge {{ $brand->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $brand->status == 1 ? __('Active') : __('Inactive') }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Brand Details --}}
                                        <div class="card-body">
                                            <h5 class="card-title mb-3" style="font-weight: 600; color: #2d3748;">
                                                {{ $brand->name }}
                                            </h5>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-box"></i> {{ $brand->products->count() }} {{ __('Products') }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="fas fa-sort"></i> {{ __('Order') }}: {{ $brand->sort_order }}
                                                </small>
                                            </div>

                                            {{-- Action Buttons --}}
                                            <div class="btn-group btn-group-sm w-100" role="group">
                                                <a href="{{ route('admin-brand-products', $brand->id) }}"
                                                   class="btn btn-info" title="{{ __('Manage Products') }}">
                                                    <i class="fas fa-boxes"></i> {{ __('Products') }}
                                                </a>

                                                <button class="btn btn-primary edit-brand"
                                                        data-id="{{ $brand->id }}"
                                                        data-name="{{ $brand->name }}"
                                                        data-name-en="{{ $brand->name_en }}"
                                                        data-status="{{ $brand->status }}"
                                                        data-sort="{{ $brand->sort_order }}"
                                                        data-image="{{ $brand->image }}"
                                                        title="{{ __('Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button class="btn btn-{{ $brand->status == 1 ? 'warning' : 'success' }} toggle-status"
                                                        data-id="{{ $brand->id }}"
                                                        data-status="{{ $brand->status == 1 ? 0 : 1 }}"
                                                        title="{{ $brand->status == 1 ? __('Deactivate') : __('Activate') }}">
                                                    <i class="fas fa-{{ $brand->status == 1 ? 'eye-slash' : 'eye' }}"></i>
                                                </button>

                                                @if($brand->products->count() == 0)
                                                <button class="btn btn-danger delete-brand"
                                                        data-id="{{ $brand->id }}"
                                                        title="{{ __('Delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fas fa-copyright" style="font-size: 60px; color: #dee2e6;"></i>
                                <h5 class="mt-3">{{ __('No Brands Found') }}</h5>
                                <p class="text-muted">{{ __('Click "Add New Brand" to create your first brand') }}</p>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Brand Modal --}}
<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> {{ __('Add New Brand') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addBrandForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Brand Name (Arabic)') }} *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Brand Name (English)') }}</label>
                        <input type="text" class="form-control" name="name_en">
                        <small class="form-text text-muted">{{ __('Optional English name for bilingual support') }}</small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Brand Image') }}</label>
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
                    <button type="submit" class="btn btn-primary">{{ __('Save Brand') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Brand Modal --}}
<div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> {{ __('Edit Brand') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editBrandForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="brand_id" id="edit_brand_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Brand Name (Arabic)') }} *</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Brand Name (English)') }}</label>
                        <input type="text" class="form-control" name="name_en" id="edit_name_en">
                        <small class="form-text text-muted">{{ __('Optional English name for bilingual support') }}</small>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Current Image') }}</label>
                        <div id="current_image_preview" class="mb-2"></div>
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
                    <button type="submit" class="btn btn-primary">{{ __('Update Brand') }}</button>
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
    var el = document.getElementById('brand-sortable');
    if (el) {
        var sortable = Sortable.create(el, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function (evt) {
                updateBrandOrder();
            }
        });
    }

    // Update brand order
    function updateBrandOrder() {
        var order = [];
        $('#brand-sortable .brand-item').each(function(index) {
            order.push({
                id: $(this).data('id'),
                position: index
            });
        });

        $.ajax({
            url: '{{ route("admin-brand-update-order") }}',
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

    // Add Brand Form Submit
    $('#addBrandForm').on('submit', function(e) {
        e.preventDefault();
        $('.gocover').show();

        var formData = new FormData(this);

        // Debug: Log form data
        console.log('Submitting brand form...');
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ': ' + pair[1]);
        }

        $.ajax({
            url: '{{ route("admin-brand-store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Success response:', response);
                $('.gocover').hide();
                $('#addBrandModal').modal('hide');
                $('#addBrandForm')[0].reset();
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.msg);
                } else {
                    alert(response.msg || 'Brand created successfully!');
                }
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                console.error('Error response:', xhr);
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseJSON);
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
    $(document).on('click', '.edit-brand', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var nameEn = $(this).data('name-en');
        var status = $(this).data('status');
        var sort = $(this).data('sort');
        var image = $(this).data('image');

        $('#edit_brand_id').val(id);
        $('#edit_name').val(name);
        $('#edit_name_en').val(nameEn);
        $('#edit_status').val(status);
        $('#edit_sort_order').val(sort);

        if (image) {
            $('#current_image_preview').html('<img src="{{ asset("assets/images/brands/") }}/' + image + '" style="max-width: 200px; height: auto;">');
        } else {
            $('#current_image_preview').html('<p class="text-muted">{{ __("No image") }}</p>');
        }

        $('#editBrandModal').modal('show');
    });

    // Edit Brand Form Submit
    $('#editBrandForm').on('submit', function(e) {
        e.preventDefault();
        $('.gocover').show();

        var formData = new FormData(this);
        var brandId = $('#edit_brand_id').val();

        $.ajax({
            url: '{{ url("admin/brand/update") }}/' + brandId,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.gocover').hide();
                $('#editBrandModal').modal('hide');
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.msg);
                } else {
                    alert(response.msg || 'Brand updated successfully!');
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
        var brandId = $(this).data('id');
        var status = $(this).data('status');

        $.ajax({
            url: '{{ url("admin/brand/status") }}/' + brandId + '/' + status,
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

    // Delete Brand
    $(document).on('click', '.delete-brand', function() {
        var brandId = $(this).data('id');

        if (confirm('{{ __("Are you sure you want to delete this brand?") }}')) {
            $('.gocover').show();

            $.ajax({
                url: '{{ url("admin/brand/delete") }}/' + brandId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('.gocover').hide();
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.msg);
                    } else {
                        alert(response.msg || 'Brand deleted successfully!');
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

@endsection
