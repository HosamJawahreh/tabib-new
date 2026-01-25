@extends('layouts.admin')

@section('styles')
<style>
    .category-tree-container {
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .tree-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .tree-header h4 {
        margin: 0;
        color: #333;
        font-size: 24px;
        font-weight: 600;
    }

    .add-category-btn {
        background: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .add-category-btn:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40,167,69,0.3);
    }

    .category-tree {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    @media (min-width: 992px) {
        .category-tree {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .category-item {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .category-item:hover {
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .category-item.has-expanded-subs {
        grid-column: 1 / -1; /* Take full width when expanded */
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .category-header:hover {
        background: rgba(0,0,0,0.02);
    }

    .category-header.has-children {
        cursor: pointer;
    }

    .category-header.no-children {
        cursor: default;
    }

    .category-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .category-details {
        flex: 1;
    }

    .category-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .category-meta {
        display: flex;
        gap: 15px;
        font-size: 13px;
        color: #666;
    }

    .category-badge {
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .category-actions {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
        font-weight: 500;
    }

    .btn-edit {
        background: #007bff;
        color: white;
    }

    .btn-edit:hover {
        background: #0056b3;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .btn-add-sub {
        background: #17a2b8;
        color: white;
    }

    .btn-add-sub:hover {
        background: #138496;
    }

    .subcategory-list {
        padding: 10px 20px 20px 20px;
        display: none;
        width: 100%;
    }

    .subcategory-list.show {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }

    @media (min-width: 768px) {
        .subcategory-list.show {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .subcategory-item {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 12px 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: stretch;
    }

    .subcategory-item > div:first-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .subcategory-item.has-expanded-childs {
        grid-column: 1 / -1; /* Take full width when child categories are expanded */
    }

    .child-list {
        padding: 10px 0 0 0;
        margin-top: 10px;
        display: none;
        width: 100%;
    }

    .child-list.show {
        display: grid;
        grid-template-columns: 1fr;
        gap: 8px;
    }

    @media (min-width: 768px) {
        .child-list.show {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .child-item {
        background: #f1f3f5;
        border-left: 3px solid #007bff;
        padding: 10px 15px;
        border-radius: 3px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .toggle-icon {
        font-size: 18px;
        transition: transform 0.3s;
        margin-right: 10px;
        color: #6c757d;
    }

    .toggle-icon.rotate {
        transform: rotate(90deg);
        color: #007bff;
    }

    .collapsed-hint {
        font-size: 12px;
        color: #6c757d;
        font-style: italic;
        margin-left: 5px;
    }

    .level-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .level-main {
        background: #28a745;
    }

    .level-sub {
        background: #17a2b8;
    }

    .level-child {
        background: #ffc107;
    }

    .product-count {
        background: #e9ecef;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        color: #495057;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 8px;
    }

    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 8px 8px 0 0;
    }

    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 4px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .bilingual-inputs {
        display: flex;
        gap: 15px;
    }

    .bilingual-inputs .form-group {
        flex: 1;
    }

    .language-label {
        display: inline-block;
        padding: 2px 8px;
        background: #007bff;
        color: white;
        border-radius: 3px;
        font-size: 11px;
        margin-left: 5px;
    }

    .language-label.ar {
        background: #28a745;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 64px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .search-filter-bar {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        align-items: center;
    }

    .search-box {
        flex: 1;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #ced4da;
        border-radius: 6px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .filter-btn {
        padding: 10px 20px;
        border: 1px solid #ced4da;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-btn:hover {
        background: #f8f9fa;
    }

    .filter-btn.active {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }
</style>
@endsection

@section('content')
<input type="hidden" id="headerdata" value="{{ __('CATEGORY MANAGEMENT') }}">
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Category Management Tree') }}</h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('admin-cat-tree') }}">{{ __('Categories') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="product-area">
        <div class="row">
            <div class="col-lg-12">
                <div class="category-tree-container">
                    @include('alerts.admin.form-success')

                    <div class="tree-header">
                        <h4>
                            <i class="fas fa-sitemap"></i> {{ __('Featured Categories') }}
                        </h4>
                        <div style="display: flex; gap: 10px;">
                            <button class="add-category-btn" data-toggle="modal" data-target="#addCategoryModal">
                                <i class="fas fa-plus"></i> {{ __('Add New Category') }}
                            </button>
                        </div>
                    </div>

                    <!-- Search and Filter Bar -->
                    <div class="search-filter-bar">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="categorySearch" placeholder="{{ __('Search categories...') }}">
                        </div>
                        <button class="filter-btn active" data-filter="all">
                            <i class="fas fa-list"></i> {{ __('All') }}
                        </button>
                        <button class="filter-btn" data-filter="active">
                            <i class="fas fa-check-circle"></i> {{ __('Active') }}
                        </button>
                        <button class="filter-btn" data-filter="inactive">
                            <i class="fas fa-times-circle"></i> {{ __('Inactive') }}
                        </button>
                        <button class="filter-btn" data-filter="featured">
                            <i class="fas fa-star"></i> {{ __('Featured') }}
                        </button>
                    </div>

                    <!-- Category Tree -->
                    <ul class="category-tree" id="categoryTreeList">
                        @forelse($categories as $category)
                        <li class="category-item" data-category-id="{{ $category->id }}" data-status="{{ $category->status }}" data-featured="{{ $category->is_featured }}">
                            <div class="category-header {{ $category->subs->count() > 0 ? 'has-children' : 'no-children' }}" data-category-toggle="{{ $category->id }}" data-has-subs="{{ $category->subs->count() > 0 ? '1' : '0' }}">
                                <div class="category-info">
                                    @if($category->subs->count() > 0)
                                    <i class="fas fa-chevron-right toggle-icon" id="toggle-{{ $category->id }}"></i>
                                    @else
                                    <span style="width: 18px;"></span>
                                    @endif
                                    
                                    <div class="category-details">
                                        <div class="category-name">
                                            <span class="level-indicator level-main"></span>
                                            {{ $category->name }}
                                        </div>
                                        <div class="category-meta">
                                            <span><i class="fas fa-language"></i> AR: {{ $category->name_ar ?? '-' }}</span>
                                            <span><i class="fas fa-language"></i> EN: {{ $category->name_en ?? '-' }}</span>
                                            <span class="product-count">
                                                <i class="fas fa-box"></i> {{ $category->products->count() }} {{ __('products') }}
                                            </span>
                                            @if($category->subs->count() > 0)
                                            <span class="product-count">
                                                <i class="fas fa-layer-group"></i> {{ $category->subs->count() }} {{ __('subcategories') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="category-actions">
                                    <span class="category-badge {{ $category->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $category->status == 1 ? __('Active') : __('Inactive') }}
                                    </span>
                                    @if($category->is_featured == 1)
                                    <span class="category-badge badge-info">
                                        <i class="fas fa-star"></i> {{ __('Featured') }}
                                    </span>
                                    @endif
                                    <button class="action-btn btn-edit" data-action="edit-category" data-id="{{ $category->id }}" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn btn-add-sub" data-action="add-subcategory" data-id="{{ $category->id }}" title="{{ __('Add Subcategory') }}">
                                        <i class="fas fa-plus"></i> Sub
                                    </button>
                                    @if($category->products->count() == 0 && $category->subs->count() == 0)
                                    <button class="action-btn btn-delete" data-action="delete-category" data-id="{{ $category->id }}" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>

                            @if($category->subs->count() > 0)
                            <div class="subcategory-list" id="subcategory-{{ $category->id }}">
                                @foreach($category->subs as $subcategory)
                                <div class="subcategory-item">
                                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                        <div class="category-info" style="flex: 1;">
                                            @if($subcategory->childs->count() > 0)
                                            <i class="fas fa-chevron-right toggle-icon" id="toggle-sub-{{ $subcategory->id }}" data-subcategory-toggle="{{ $subcategory->id }}"></i>
                                            @else
                                            <span style="width: 18px; display: inline-block;"></span>
                                            @endif
                                            
                                            <div class="category-details">
                                                <div class="category-name">
                                                    <span class="level-indicator level-sub"></span>
                                                    {{ $subcategory->name }}
                                                </div>
                                                <div class="category-meta">
                                                    <span><i class="fas fa-language"></i> AR: {{ $subcategory->name_ar ?? '-' }}</span>
                                                    <span><i class="fas fa-language"></i> EN: {{ $subcategory->name_en ?? '-' }}</span>
                                                    <span class="product-count">
                                                        <i class="fas fa-box"></i> {{ $subcategory->products->count() }} {{ __('products') }}
                                                    </span>
                                                    @if($subcategory->childs->count() > 0)
                                                    <span class="product-count">
                                                        <i class="fas fa-layer-group"></i> {{ $subcategory->childs->count() }} {{ __('child categories') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="category-actions">
                                            <span class="category-badge {{ $subcategory->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                {{ $subcategory->status == 1 ? __('Active') : __('Inactive') }}
                                            </span>
                                            <button class="action-btn btn-edit" data-action="edit-subcategory" data-id="{{ $subcategory->id }}" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn btn-add-sub" data-action="add-child" data-id="{{ $subcategory->id }}" data-category-id="{{ $category->id }}" title="{{ __('Add Child') }}">
                                                <i class="fas fa-plus"></i> Child
                                            </button>
                                            @if($subcategory->products->count() == 0 && $subcategory->childs->count() == 0)
                                            <button class="action-btn btn-delete" data-action="delete-subcategory" data-id="{{ $subcategory->id }}" title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($subcategory->childs->count() > 0)
                                <div class="child-list" id="child-{{ $subcategory->id }}" style="display: none;">
                                    @foreach($subcategory->childs as $child)
                                    <div class="child-item">
                                        <div class="category-info">
                                            <div class="category-details">
                                                <div class="category-name">
                                                    <span class="level-indicator level-child"></span>
                                                    {{ $child->name }}
                                                </div>
                                                <div class="category-meta">
                                                    <span><i class="fas fa-language"></i> AR: {{ $child->name_ar ?? '-' }}</span>
                                                    <span><i class="fas fa-language"></i> EN: {{ $child->name_en ?? '-' }}</span>
                                                    <span class="product-count">
                                                        <i class="fas fa-box"></i> {{ $child->products->count() }} {{ __('products') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="category-actions">
                                            <span class="category-badge {{ $child->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                {{ $child->status == 1 ? __('Active') : __('Inactive') }}
                                            </span>
                                            <button class="action-btn btn-edit" data-action="edit-child" data-id="{{ $child->id }}" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($child->products->count() == 0)
                                            <button class="action-btn btn-delete" data-action="delete-child" data-id="{{ $child->id }}" title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @endif
                        </li>
                        @empty
                        <li class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <h5>{{ __('No Categories Found') }}</h5>
                            <p>{{ __('Start by adding your first category') }}</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i> {{ __('Add New Category') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addCategoryForm" action="{{ route('admin-cat-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="bilingual-inputs">
                        <div class="form-group">
                            <label>
                                {{ __('Name') }} <span class="language-label ar">AR</span> *
                            </label>
                            <input type="text" class="form-control" id="add_name_ar" name="name_ar" required dir="rtl" placeholder="{{ __('Enter Arabic Name') }}">
                        </div>
                        <div class="form-group">
                            <label>
                                {{ __('Name') }} <span class="language-label">EN</span> *
                            </label>
                            <input type="text" class="form-control" id="add_name_en" name="name_en" required placeholder="{{ __('Enter English Name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Slug') }} <span class="text-muted">({{ __('Optional') }})</span></label>
                        <input type="text" class="form-control" id="add_slug" name="slug" placeholder="{{ __('auto-generated from name') }}">
                        <small class="form-text text-muted">{{ __('Auto-generated from English name (or Arabic if English is empty). Leave empty for automatic generation.') }}</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Status') }}</label>
                                <select class="form-control" name="status">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Featured') }}</label>
                                <select class="form-control" name="is_featured">
                                    <option value="1" selected>{{ __('Yes') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> {{ __('Create Category') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal (will be loaded dynamically) --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="submit-loader">
                <img src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
            </div>
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to delete this category?') }}</p>
                <p class="text-danger">{{ __('This action cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Create a simple notification function if toastr is not available
if (typeof toastr === 'undefined') {
    window.toastr = {
        success: function(msg) {
            alert('Success: ' + msg);
        },
        error: function(msg) {
            alert('Error: ' + msg);
        }
    };
}

$(document).ready(function() {
    console.log('Category tree script loaded!');
    console.log('jQuery version:', $.fn.jquery);
    console.log('Bootstrap modal plugin available:', typeof $.fn.modal);
    console.log('Testing modal on #editModal:', $('#editModal').length);
    
    // Event delegation for all category actions
    
    // Category toggle
    $(document).on('click', '[data-category-toggle]', function(e) {
        var id = $(this).data('category-toggle');
        var hasSubs = $(this).data('has-subs');
        console.log('Category toggle clicked:', id, hasSubs);
        if (hasSubs) {
            toggleCategory(id);
        }
    });
    
    // Subcategory toggle
    $(document).on('click', '[data-subcategory-toggle]', function(e) {
        e.stopPropagation();
        var id = $(this).data('subcategory-toggle');
        console.log('Subcategory toggle clicked:', id);
        toggleSubcategory(id);
    });
    
    // Category actions
    $(document).on('click', '[data-action="edit-category"]', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        console.log('Edit category clicked:', id);
        editCategory(id);
    });
    
    $(document).on('click', '[data-action="add-subcategory"]', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        addSubcategory(id);
    });
    
    $(document).on('click', '[data-action="delete-category"]', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        deleteCategory(id);
    });
    
    // Subcategory actions
    $(document).on('click', '[data-action="edit-subcategory"]', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        editSubcategory(id);
    });
    
    $(document).on('click', '[data-action="add-child"]', function(e) {
        e.stopPropagation();
        var subcategoryId = $(this).data('id');
        var categoryId = $(this).data('category-id');
        addChildcategory(subcategoryId, categoryId);
    });
    
    $(document).on('click', '[data-action="delete-subcategory"]', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        deleteSubcategory(id);
    });
    
    // Child category actions
    $(document).on('click', '[data-action="edit-child"]', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        editChildcategory(id);
    });
    
    $(document).on('click', '[data-action="delete-child"]', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        deleteChildcategory(id);
    });
    
    // Comprehensive modal cleanup after modal closes
    $(document).on('hidden.bs.modal', '.modal', function () {
        var $modal = $(this);
        
        // Remove all backdrops
        $('.modal-backdrop').remove();
        
        // Clean up body classes and styles
        $('body').removeClass('modal-open').css({'padding-right': '', 'overflow': ''});
        
        // Remove Bootstrap's modal data to prevent state issues
        $modal.removeData('bs.modal');
        
        // Clear the modal body content if it's the editModal
        if ($modal.attr('id') === 'editModal') {
            $modal.find('.modal-body').empty();
            $modal.find('.modal-title').empty();
        }
    });
    
    // Handle data-dismiss="modal" clicks manually since Bootstrap modal plugin may not work
    $(document).on('click', '[data-dismiss="modal"]', function() {
        var $modal = $(this).closest('.modal');
        hideModal($modal);
    });
    
    // Auto-generate slug from category name
    function generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }
    
    // Add category form - auto-generate slug
    $('#add_name_en, #add_name_ar').on('keyup', function() {
        var enName = $('#add_name_en').val();
        var arName = $('#add_name_ar').val();
        
        // Prefer English name for slug, fallback to Arabic
        var nameForSlug = enName.trim() !== '' ? enName : arName;
        
        if (nameForSlug.trim() !== '') {
            $('#add_slug').val(generateSlug(nameForSlug));
        }
    });

    // Handle add category form
    $('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submitted');
        
        var formData = new FormData(this);
        
        // Log form data for debugging
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        // Slug is optional - backend will auto-generate if empty
        // But if user types in name fields, we auto-fill it for preview
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                console.log('AJAX request starting...');
            },
            success: function(response) {
                console.log('Success response:', response);
                hideModal($('#addCategoryModal'));
                
                var successMsg = response.msg || response.message || response || 'Category created successfully!';
                
                if (typeof toastr !== 'undefined') {
                    toastr.success(successMsg);
                } else {
                    alert('Success: ' + successMsg);
                }
                // Reset form
                $('#addCategoryForm')[0].reset();
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                console.error('Error creating category:', xhr);
                console.error('Response status:', xhr.status);
                console.error('Response text:', xhr.responseText);
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var errorMsg = Array.isArray(value) ? value[0] : value;
                        if (typeof toastr !== 'undefined') {
                            toastr.error(errorMsg);
                        } else {
                            alert('Error: ' + errorMsg);
                        }
                    });
                } else {
                    var errorMsg = xhr.responseJSON ? (xhr.responseJSON.message || 'An error occurred') : 'An error occurred';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert('Error: ' + errorMsg);
                    }
                }
            }
        });
    });

    // Search functionality
    $('#categorySearch').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.category-item').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Filter functionality
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        var filter = $(this).data('filter');
        
        $('.category-item').each(function() {
            var status = $(this).data('status');
            var featured = $(this).data('featured');
            
            if (filter === 'all') {
                $(this).show();
            } else if (filter === 'active' && status == 1) {
                $(this).show();
            } else if (filter === 'inactive' && status == 0) {
                $(this).show();
            } else if (filter === 'featured' && featured == 1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

// Attach form handler to dynamically loaded forms
function attachFormHandler() {
    // Remove any existing handlers first
    $('#editModal').find('form').off('submit');
    
    // Handle form submission in the modal
    $('#editModal').find('form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        var submitBtn = form.find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method') || 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            },
            success: function(response) {
                var $modal = $('#editModal');
                
                // Properly hide and clean up the modal
                hideModal($modal);
                
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.msg || response || 'Success!');
                } else {
                    alert('Success: ' + (response.msg || response || 'Operation completed'));
                }
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(value[0]);
                        } else {
                            alert('Error: ' + value[0]);
                        }
                    });
                } else {
                    var errorMsg = xhr.responseJSON ? (xhr.responseJSON.message || 'An error occurred') : 'An error occurred';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert('Error: ' + errorMsg);
                    }
                }
            }
        });
    });
}

// Toggle category expansion - Simple inline expansion
function toggleCategory(id) {
    var subcategoryList = $('#subcategory-' + id);
    var toggleIcon = $('#toggle-' + id);
    var categoryItem = $('[data-category-id="' + id + '"]');
    
    // Toggle the subcategory list
    subcategoryList.toggleClass('show');
    toggleIcon.toggleClass('rotate');
    
    // Add/remove class to expand to full width
    if (subcategoryList.hasClass('show')) {
        categoryItem.addClass('has-expanded-subs');
    } else {
        categoryItem.removeClass('has-expanded-subs');
        // Also close all child categories
        subcategoryList.find('.child-list').hide();
        subcategoryList.find('.toggle-icon').removeClass('rotate');
    }
}

// Toggle subcategory expansion
function toggleSubcategory(id) {
    var childList = $('#child-' + id);
    var toggleIcon = $('#toggle-sub-' + id);
    var subcategoryItem = toggleIcon.closest('.subcategory-item');
    
    childList.toggleClass('show').toggle();
    toggleIcon.toggleClass('rotate');
    
    // Add/remove class to expand to full width
    if (childList.hasClass('show')) {
        subcategoryItem.addClass('has-expanded-childs');
    } else {
        subcategoryItem.removeClass('has-expanded-childs');
    }
}

// Helper function to show modal (without Bootstrap .modal() method)
function showModal($modal) {
    // Remove any existing backdrops
    $('.modal-backdrop').remove();
    
    // Create backdrop
    var $backdrop = $('<div class="modal-backdrop fade show"></div>');
    $('body').append($backdrop);
    
    // Show modal
    $modal.addClass('show').css('display', 'block');
    $('body').addClass('modal-open');
    
    // Set aria and role
    $modal.attr('aria-hidden', 'false');
}

// Helper function to hide modal (without Bootstrap .modal() method)
function hideModal($modal) {
    $modal.removeClass('show').css('display', 'none');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css({'padding-right': '', 'overflow': ''});
    $modal.attr('aria-hidden', 'true');
}

// Edit category
function editCategory(id) {
    console.log('editCategory function called with id:', id);
    var $modal = $('#editModal');
    console.log('Modal element found:', $modal.length);
    
    // Ensure modal is completely hidden and cleaned before showing
    hideModal($modal);
    
    console.log('Modal cleaned up, preparing to show');
    
    // Set up the modal content
    $modal.find('.modal-body').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
    $modal.find('.modal-title').html('<i class="fas fa-edit"></i> {{ __("Edit Category") }}');
    
    // Small delay to ensure cleanup is complete
    setTimeout(function() {
        console.log('Showing modal now');
        showModal($modal);
    }, 100);
    
    $.ajax({
        url: '{{ url("admin/category/edit") }}/' + id,
        method: 'GET',
        success: function(response) {
            $modal.find('.modal-body').html(response);
            attachFormHandler();
        },
        error: function(xhr) {
            $modal.find('.modal-body').html('<div class="alert alert-danger">Error loading form</div>');
        }
    });
}

// Edit subcategory
function editSubcategory(id) {
    var $modal = $('#editModal');
    
    // Ensure modal is completely hidden and cleaned before showing
    hideModal($modal);
    
    // Set up the modal content
    $modal.find('.modal-body').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
    $modal.find('.modal-title').html('<i class="fas fa-edit"></i> {{ __("Edit Subcategory") }}');
    
    // Small delay to ensure cleanup is complete
    setTimeout(function() {
        showModal($modal);
    }, 100);
    
    $.ajax({
        url: '{{ url("admin/subcategory/edit") }}/' + id,
        method: 'GET',
        success: function(response) {
            $modal.find('.modal-body').html(response);
            attachFormHandler();
        },
        error: function(xhr) {
            $modal.find('.modal-body').html('<div class="alert alert-danger">Error loading form</div>');
        }
    });
}

// Edit childcategory
function editChildcategory(id) {
    var $modal = $('#editModal');
    
    // Ensure modal is completely hidden and cleaned before showing
    hideModal($modal);
    
    // Set up the modal content
    $modal.find('.modal-body').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
    $modal.find('.modal-title').html('<i class="fas fa-edit"></i> {{ __("Edit Child Category") }}');
    
    // Small delay to ensure cleanup is complete
    setTimeout(function() {
        showModal($modal);
    }, 100);
    
    $.ajax({
        url: '{{ url("admin/childcategory/edit") }}/' + id,
        method: 'GET',
        success: function(response) {
            $modal.find('.modal-body').html(response);
            attachFormHandler();
        },
        error: function(xhr) {
            $modal.find('.modal-body').html('<div class="alert alert-danger">Error loading form</div>');
        }
    });
}

// Add subcategory
function addSubcategory(categoryId) {
    var $modal = $('#editModal');
    
    // Ensure modal is completely hidden and cleaned before showing
    hideModal($modal);
    
    // Set up the modal content
    $modal.find('.modal-body').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
    $modal.find('.modal-title').html('<i class="fas fa-plus"></i> {{ __("Add Subcategory") }}');
    
    // Small delay to ensure cleanup is complete
    setTimeout(function() {
        showModal($modal);
    }, 100);
    
    $.ajax({
        url: '{{ url("admin/subcategory/create") }}?category_id=' + categoryId,
        method: 'GET',
        success: function(response) {
            $modal.find('.modal-body').html(response);
            
            // Pre-select the category in the dropdown
            setTimeout(function() {
                $modal.find('select[name="category_id"]').val(categoryId);
            }, 100);
            
            attachFormHandler();
        },
        error: function(xhr) {
            $modal.find('.modal-body').html('<div class="alert alert-danger">Error loading form</div>');
        }
    });
}

// Add childcategory
function addChildcategory(subcategoryId, categoryId) {
    var $modal = $('#editModal');
    
    // Ensure modal is completely hidden and cleaned before showing
    hideModal($modal);
    
    // Set up the modal content
    $modal.find('.modal-body').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
    $modal.find('.modal-title').html('<i class="fas fa-plus"></i> {{ __("Add Child Category") }}');
    
    // Small delay to ensure cleanup is complete
    setTimeout(function() {
        showModal($modal);
    }, 100);
    
    $.ajax({
        url: '{{ url("admin/childcategory/create") }}?subcategory_id=' + subcategoryId,
        method: 'GET',
        success: function(response) {
            $modal.find('.modal-body').html(response);
            
            // Pre-select the category and trigger subcategory load
            setTimeout(function() {
                var $catSelect = $modal.find('select#cat');
                var $subcatSelect = $modal.find('select#subcat');
                
                // Set category value
                $catSelect.val(categoryId);
                
                // Trigger change to load subcategories
                var selectedOption = $catSelect.find('option[value="' + categoryId + '"]');
                if (selectedOption.length) {
                    var loadUrl = selectedOption.data('href');
                    if (loadUrl) {
                        $.get(loadUrl, function(data) {
                            $subcatSelect.html(data);
                            $subcatSelect.prop('disabled', false);
                            // Set subcategory value after loading
                            $subcatSelect.val(subcategoryId);
                        });
                    }
                }
            }, 100);
            
            attachFormHandler();
        },
        error: function(xhr) {
            $modal.find('.modal-body').html('<div class="alert alert-danger">Error loading form</div>');
        }
    });
}

// Delete category
function deleteCategory(id) {
    var $modal = $('#confirmDeleteModal');
    
    // Ensure modal is completely hidden and cleaned before showing
    hideModal($modal);
    
    // Set the delete form action
    $modal.find('.delete-form').attr('action', '{{ url("admin/category/delete") }}/' + id);
    
    // Small delay to ensure cleanup is complete
    setTimeout(function() {
        showModal($modal);
    }, 100);
}

// Delete subcategory
function deleteSubcategory(id) {
    var $modal = $('#confirmDeleteModal');
    
    // Ensure modal is completely hidden and cleaned before showing
    hideModal($modal);
    
    // Set the delete form action
    $modal.find('.delete-form').attr('action', '{{ url("admin/subcategory/delete") }}/' + id);
    
    // Small delay to ensure cleanup is complete
    setTimeout(function() {
        showModal($modal);
    }, 100);
}

// Delete childcategory
function deleteChildcategory(id) {
    var $modal = $('#confirmDeleteModal');
    
    // Ensure modal is completely hidden and cleaned before showing
    hideModal($modal);
    
    // Set the delete form action
    $modal.find('.delete-form').attr('action', '{{ url("admin/childcategory/delete") }}/' + id);
    
    // Small delay to ensure cleanup is complete
    setTimeout(function() {
        showModal($modal);
    }, 100);
}

// Handle delete form submission
$('.delete-form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            hideModal($('#confirmDeleteModal'));
            toastr.success(response);
            setTimeout(function() {
                location.reload();
            }, 1500);
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON);
        }
    });
});
</script>
@endsection
