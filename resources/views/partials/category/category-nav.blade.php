{{-- Category Navigation - Always Visible Main Categories --}}
<section class="category-navigation-section">
    <div class="container-fluid px-4">
        {{-- Main Categories Row - Always Visible - Reversed for RTL display --}}
        <div class="main-categories-row">
            @foreach($categories->reverse() as $category)
                <div class="main-category-item"
                     data-category-id="{{ $category->id }}"
                     data-has-subs="{{ $category->subs->count() > 0 ? '1' : '0' }}">
                    <span class="category-name">{{ $category->translated_name }}</span>
                    @if($category->subs->count() > 0)
                        <span class="badge-count">{{ $category->subs->count() }}</span>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Subcategories Row - Shows when main category with subs is clicked --}}
        <div class="subcategories-container" style="display: none;">
            @foreach($categories->reverse() as $category)
                @if($category->subs->count() > 0)
                    <div class="subcategories-row"
                         data-parent-category="{{ $category->id }}"
                         style="display: none;">
                        @foreach($category->subs->reverse() as $subcategory)
                            <div class="subcategory-item"
                                 data-subcategory-id="{{ $subcategory->id }}"
                                 data-parent-category="{{ $category->id }}"
                                 data-has-childs="{{ $subcategory->childs->count() > 0 ? '1' : '0' }}">
                                <span class="subcategory-name">{{ $subcategory->translated_name }}</span>
                                @if($subcategory->childs->count() > 0)
                                    <span class="badge-count-sm">{{ $subcategory->childs->count() }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Child Categories Row - Shows when subcategory with children is clicked --}}
        <div class="childcategories-container" style="display: none;">
            @foreach($categories->reverse() as $category)
                @foreach($category->subs->reverse() as $subcategory)
                    @if($subcategory->childs->count() > 0)
                        <div class="childcategories-row"
                             data-parent-subcategory="{{ $subcategory->id }}"
                             style="display: none;">
                            @foreach($subcategory->childs->reverse() as $childcategory)
                                <div class="childcategory-item"
                                     data-childcategory-id="{{ $childcategory->id }}"
                                     data-parent-subcategory="{{ $subcategory->id }}"
                                     data-parent-category="{{ $category->id }}">
                                    <span class="childcategory-name">{{ $childcategory->translated_name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
</section>

<style>
    /* Category Navigation Section */
    .category-navigation-section {
        background: #fff;
        padding: 10px 0;
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 20px;
    }

    /* Main Categories Row - Always Visible Horizontal - RTL (Right to Left) */
    .main-categories-row {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 5px;
        scrollbar-width: thin;
        scrollbar-color: #7caa53 #f0f0f0;
        margin-bottom: 5px;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
        /* Categories start from RIGHT */
        direction: rtl;
        justify-content: flex-start;
    }

    .main-categories-row::-webkit-scrollbar {
        height: 8px;
    }

    .main-categories-row::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 4px;
    }

    .main-categories-row::-webkit-scrollbar-thumb {
        background: #7caa53;
        border-radius: 4px;
    }

    .main-categories-row::-webkit-scrollbar-thumb:hover {
        background: #6a9447;
    }

    .main-category-item {
        display: inline-flex;
        align-items: center;
        gap: 0px;
        padding: 12px 24px;
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        color: #333;
        white-space: nowrap;
        transition: all 0.3s ease;
        user-select: none;
        flex-shrink: 0;
    }

    .main-category-item:hover {
        background: #f0f8ea;
        border-color: #7caa53;
        color: #7caa53;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(124, 170, 83, 0.2);
    }

    .main-category-item.active {
        background: #7caa53;
        color: #fff;
        border-color: #7caa53;
        box-shadow: 0 4px 12px rgba(124, 170, 83, 0.4);
        transform: translateY(-2px);
    }

    .badge-count {
        display: inline-block;
        background: rgba(124, 170, 83, 0.2);
        color: #7caa53;
        padding: 0px 4px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .main-category-item.active .badge-count {
        background: rgba(255, 255, 255, 0.3);
        color: #fff;
    }

    /* Subcategories Container */
    .subcategories-container {
        margin-bottom: 5px;
    }

    .subcategories-row {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 5px;
        scrollbar-width: thin;
        scrollbar-color: #7caa53 #f5f5f5;
        animation: slideDown 0.3s ease;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
        /* Subcategories also start from RIGHT */
        direction: rtl;
        justify-content: flex-start;
    }

    .subcategories-row::-webkit-scrollbar {
        height: 8px;
    }

    .subcategories-row::-webkit-scrollbar-track {
        background: #f5f5f5;
        border-radius: 4px;
    }

    .subcategories-row::-webkit-scrollbar-thumb {
        background: #7caa53;
        border-radius: 4px;
    }

    .subcategories-row::-webkit-scrollbar-thumb:hover {
        background: #6a9447;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .subcategory-item {
        display: inline-flex;
        align-items: center;
        gap: 0px;
        padding: 10px 20px;
        background: #fff;
        border: 2px solid #e0e0e0;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #555;
        white-space: nowrap;
        transition: all 0.3s ease;
        user-select: none;
        flex-shrink: 0;
    }

    .subcategory-item:hover {
        background: #f0f8ea;
        border-color: #7caa53;
        color: #7caa53;
        transform: translateY(-2px);
    }

    .subcategory-item.active {
        background: #7caa53;
        color: #fff;
        border-color: #7caa53;
        box-shadow: 0 2px 8px rgba(124, 170, 83, 0.3);
    }

    .badge-count-sm {
        display: inline-block;
        background: #e0e0e0;
        color: #555;
        padding: 0px 4px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 600;
    }

    .subcategory-item:hover .badge-count-sm,
    .subcategory-item.active .badge-count-sm {
        background: rgba(255, 255, 255, 0.3);
        color: #fff;
    }

    /* Child Categories Container */
    .childcategories-container {
        margin-bottom: 5px;
    }

    .childcategories-row {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 5px;
        scrollbar-width: thin;
        scrollbar-color: #d0e4c3 #f5f5f5;
        animation: slideDown 0.3s ease;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
        /* Child categories also start from RIGHT */
        direction: rtl;
        justify-content: flex-start;
    }

    .childcategories-row::-webkit-scrollbar {
        height: 8px;
    }

    .childcategories-row::-webkit-scrollbar-track {
        background: #f5f5f5;
        border-radius: 4px;
    }

    .childcategories-row::-webkit-scrollbar-thumb {
        background: #d0e4c3;
        border-radius: 4px;
    }

    .childcategories-row::-webkit-scrollbar-thumb:hover {
        background: #b8d4a8;
    }

    .childcategory-item {
        display: inline-block;
        padding: 8px 18px;
        background: #f8f9fa;
        border: 1px solid #d0e4c3;
        border-radius: 18px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        color: #666;
        white-space: nowrap;
        transition: all 0.3s ease;
        user-select: none;
        flex-shrink: 0;
    }

    .childcategory-item:hover {
        background: #e8f5e0;
        border-color: #7caa53;
        color: #7caa53;
        transform: translateY(-1px);
    }

    .childcategory-item.active {
        background: #7caa53;
        color: #fff;
        border-color: #7caa53;
        box-shadow: 0 1px 6px rgba(124, 170, 83, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        /* Reduce category section size on mobile */
        .category-navigation-section {
            padding: 5px 0;
            margin-bottom: 10px;
        }

        .main-categories-row {
            gap: 6px;
            padding: 3px;
            margin-bottom: 3px;
        }

        .main-category-item {
            font-size: 12px;
            padding: 8px 14px;
            border-radius: 20px;
        }

        .subcategories-row {
            gap: 6px;
            padding: 3px;
            margin-bottom: 3px;
        }

        .subcategory-item {
            font-size: 11px;
            padding: 6px 12px;
            border-radius: 16px;
        }

        .childcategories-row {
            gap: 5px;
            padding: 3px;
        }

        .childcategory-item {
            font-size: 10px;
            padding: 5px 10px;
            border-radius: 14px;
        }

        .badge-count {
            font-size: 9px;
            padding: 0px 3px;
        }

        .badge-count-sm {
            font-size: 8px;
            padding: 0px 3px;
        }
    }

    /* RTL Support */
    [dir="rtl"] .main-categories-row,
    [dir="rtl"] .subcategories-row,
    [dir="rtl"] .childcategories-row {
        direction: rtl;
    }
</style>
