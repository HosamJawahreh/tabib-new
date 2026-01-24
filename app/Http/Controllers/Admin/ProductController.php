<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Currency;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Subcategory;
use Yajra\DataTables\Facades\DataTables as Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PriceHelper;

class ProductController extends AdminBaseController
{
    //*** JSON Request
    public function datatables(Request $request)
    {
        // Optimized query with select only needed columns
        $query = Product::select(['id', 'name', 'slug', 'sku', 'price', 'status', 'type', 'product_type', 'user_id', 'photo', 'thumbnail'])
            ->where('type', 'Physical');

        // Apply filters
        if ($request->type == 'deactive') {
            $query->whereStatus(0);
        }

        // Search filter
        if ($request->has('search_query') && $request->search_query != '') {
            $search = $request->search_query;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Status filter - only apply if explicitly set
        if ($request->has('status') && $request->status !== '' && $request->status !== null) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Price filter
        if ($request->has('price') && $request->price != '') {
            $priceRange = $request->price;
            if ($priceRange == '0-10') {
                $query->whereBetween('price', [0, 10]);
            } elseif ($priceRange == '10-50') {
                $query->whereBetween('price', [10, 50]);
            } elseif ($priceRange == '50-100') {
                $query->whereBetween('price', [50, 100]);
            } elseif ($priceRange == '100+') {
                $query->where('price', '>', 100);
            }
        }

        $query->latest('id');

        //--- Integrating This Collection Into Datatables with Query Builder (optimized)
        return Datatables::eloquent($query)
            ->addColumn('sku', function (Product $data) {
                if ($data->type == 'Physical' && $data->sku) {
                    return '<div style="text-align: center;"><span style="font-weight: 600; color: #2d3748;">' . $data->sku . '</span></div>';
                }
                return '<div style="text-align: center;"><span style="color: #a0aec0;">-</span></div>';
            })
            ->addColumn('image', function (Product $data) {
                $photo = $data->thumbnail ? asset('assets/images/thumbnails/' . $data->thumbnail) : asset('assets/images/noimage.png');
                return '<div style="text-align: center;"><img src="' . $photo . '" alt="Product" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;"></div>';
            })
            ->editColumn('name', function (Product $data) {
                $name = mb_strlen($data->name, 'UTF-8') > 50 ? mb_substr($data->name, 0, 50, 'UTF-8') . '...' : $data->name;
                return '<div style="text-align: center;"><span style="font-weight: 500;">' . $name . '</span></div>';
            })
            ->editColumn('price', function (Product $data) {
                $price = $data->price * $this->curr->value;
                return '<div style="text-align: center;"><span style="font-weight: 600; color: #10b981;">' . PriceHelper::showAdminCurrencyPrice($price) . '</span></div>';
            })
            ->addColumn('order_count', function (Product $data) {
                // Calculate order count from cart JSON in orders table
                $orders = DB::table('orders')->select('cart')->get();
                $totalQty = 0;
                
                foreach ($orders as $order) {
                    $cart = json_decode($order->cart, true);
                    if (is_array($cart) && isset($cart['items'])) {
                        foreach ($cart['items'] as $item) {
                            if (isset($item['item']['id']) && $item['item']['id'] == $data->id) {
                                $totalQty += isset($item['qty']) ? $item['qty'] : 0;
                            }
                        }
                    }
                }
                
                return '<div style="text-align: center;"><span style="font-weight: 600; color: #667eea;">' . $totalQty . '</span></div>';
            })
            ->addColumn('status', function (Product $data) {
                $checked = $data->status == 1 ? 'checked' : '';
                $category = '';
                
                // Get categories from many-to-many relationship (category_product pivot table)
                $categories = $data->categories()->pluck('name')->toArray();
                
                if (!empty($categories)) {
                    $categoryNames = implode(', ', $categories);
                    $category = '<div style="margin-top: 8px;"><small style="color: #718096;"><i class="fas fa-tags"></i> ' . $categoryNames . '</small></div>';
                }
                
                return '<div style="text-align: center;">
                            <label class="switch">
                                <input type="checkbox" class="status-toggle" data-id="'.$data->id.'" '.$checked.'>
                                <span class="slider round"></span>
                            </label>
                            '.$category.'
                        </div>';
            })
            ->addColumn('edit', function (Product $data) {
                return '<div style="text-align: center;">
                    <a href="' . route('admin-prod-edit', $data->id) . '" class="btn btn-sm btn-primary" title="' . __("Edit") . '" style="padding: 6px 12px;">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>';
            })
            ->addColumn('delete', function (Product $data) {
                return '<div style="text-align: center;">
                    <a href="javascript:void(0)" data-href="' . route('admin-prod-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger delete" title="' . __("Delete") . '" style="padding: 6px 12px;">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['sku', 'image', 'name', 'price', 'order_count', 'status', 'edit', 'delete'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** JSON Request
    public function catalogdatatables()
    {
        $datas = Product::where('is_catalog', '=', 1)->orderBy('id', 'desc');

        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->editColumn('name', function (Product $data) {
                $name = mb_strlen($data->name, 'UTF-8') > 50 ? mb_substr($data->name, 0, 50, 'UTF-8') . '...' : $data->name;
                $id = '<small>' . __("ID") . ': <a href="' . route('front.product', $data->slug) . '" target="_blank">' . sprintf("%'.08d", $data->id) . '</a></small>';
                $id3 = $data->type == 'Physical' ? '<small class="ml-2"> ' . __("SKU") . ': <a href="' . route('front.product', $data->slug) . '" target="_blank">' . $data->sku . '</a>' : '';
                return $name . '<br>' . $id . $id3 . $data->checkVendor();
            })
            ->editColumn('price', function (Product $data) {
                $price = $data->price * $this->curr->value;
                return PriceHelper::showAdminCurrencyPrice($price);
            })
            ->editColumn('stock', function (Product $data) {
                $stck = (string) $data->stock;
                if ($stck == "0") {
                    return __("Out Of Stock");
                } elseif ($stck == null) {
                    return __("Unlimited");
                } else {
                    return $data->stock;
                }

            })
            ->addColumn('status', function (Product $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-prod-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-prod-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })
            ->addColumn('action', function (Product $data) {
                return '<div class="godropdown"><button class="go-dropdown-toggle">  ' . __("Actions") . '<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit', $data->id) . '"> <i class="fas fa-edit"></i> ' . __("Edit") . '</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="' . $data->id . '"><i class="fas fa-eye"></i> ' . __("View Gallery") . '</a><a data-href="' . route('admin-prod-feature', $data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> ' . __("Highlight") . '</a><a href="javascript:;" data-href="' . route('admin-prod-catalog', ['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal"><i class="fas fa-trash-alt"></i> ' . __("Remove Catalog") . '</a></div></div>';
            })
            ->rawColumns(['name', 'status', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function productscatalog()
    {
        return view('admin.product.catalog');
    }
    public function index()
    {

        return view('admin.product.index');
    }

    public function types()
    {
        return view('admin.product.types');
    }

    public function deactive()
    {
        return view('admin.product.deactive');
    }

    public function productsettings()
    {
        return view('admin.product.settings');
    }

    //*** GET Request
    public function create($slug)
    {
        $cats = Category::all();
        $sign = $this->curr;
        // Get English language (is_default = 1) for translations
        $languages = \App\Models\AdminLanguage::where('is_default', 1)->get();

        if ($slug == 'physical') {
            return view('admin.product.create.physical', compact('cats', 'sign', 'languages'));
        } else if ($slug == 'digital') {
            return view('admin.product.create.digital', compact('cats', 'sign', 'languages'));
        } else if (($slug == 'license')) {
            return view('admin.product.create.license', compact('cats', 'sign', 'languages'));
        } else if (($slug == 'listing')) {
            return view('admin.product.create.listing', compact('cats', 'sign', 'languages'));

        }
    }

    //*** GET Request
    public function status($id1, $id2)
    {
        $data = Product::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request - Check SKU Uniqueness
    public function checkSku(Request $request)
    {
        $sku = $request->input('sku');
        $productId = $request->input('product_id', null);
        
        $query = Product::where('sku', $sku);
        
        // If editing, exclude current product
        if ($productId) {
            $query->where('id', '!=', $productId);
        }
        
        $exists = $query->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? __('This SKU is already in use.') : __('SKU is available.')
        ]);
    }

    //*** POST Request
    public function uploadUpdate(Request $request, $id)
    {

        //--- Validation Section
        $rules = [
            'image' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Product::findOrFail($id);

        //--- Validation Section Ends
        $image = $request->image;
        list($type, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time() . Str::random(8) . '.webp';
        $path = 'assets/images/products/' . $image_name;
        
        // Create temporary file
        $tempPath = 'assets/images/products/temp_' . time() . '.png';
        file_put_contents($tempPath, $image);
        
        try {
            $img = Image::make($tempPath);
            
            // Resize to max 1200px and compress
            $img->resize(1200, 1200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $img->encode('webp', 75)->save($path);
            
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
        } catch (\Exception $e) {
            file_put_contents($path, $image);
            $image_name = str_replace('.webp', '.png', $image_name);
        }
        
        if ($data->photo != null) {
            if (file_exists(public_path() . '/assets/images/products/' . $data->photo)) {
                unlink(public_path() . '/assets/images/products/' . $data->photo);
            }
        }
        $input['photo'] = $image_name;
        $data->update($input);
        if ($data->thumbnail != null) {
            if (file_exists(public_path() . '/assets/images/thumbnails/' . $data->thumbnail)) {
                unlink(public_path() . '/assets/images/thumbnails/' . $data->thumbnail);
            }
        }

        $img = Image::make(public_path() . '/assets/images/products/' . $data->photo);
        $img->resize(285, 285, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $thumbnail = time() . Str::random(8) . '.webp';
        // Ultra-compress thumbnail at 60% quality for smallest file size
        $img->encode('webp', 60)->save(public_path() . '/assets/images/thumbnails/' . $thumbnail);
        $data->thumbnail = $thumbnail;
        $data->update();
        return response()->json(['status' => true, 'file_name' => $image_name]);
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'photo' => 'required',
            'file' => 'mimes:zip',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Product;
        $sign = $this->curr;
        $input = $request->all();

        // Handle checkbox fields - hidden fields send '0' or '1' as strings
        $input['status'] = $request->input('status', 0) == '1' ? 1 : 0;
        $input['featured'] = $request->input('featured', 0) == '1' ? 1 : 0;
        $input['hot'] = $request->input('hot', 0) == '1' ? 1 : 0;

        // Check File
        if ($file = $request->file('file')) {
            $name = time() . Str::random(8) . str_replace(' ', '', $file->getClientOriginalExtension());
            $file->move('assets/files', $name);
            $input['file'] = $name;
        }

        // Process and convert image to WebP with MAXIMUM compression
        $image = $request->photo;
        list($type, $image) = explode(';', $image);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time() . Str::random(8) . '.webp';
        $path = 'assets/images/products/' . $image_name;
        
        // Create temporary file from base64 to process with Intervention Image
        $tempPath = 'assets/images/products/temp_' . time() . '.png';
        file_put_contents($tempPath, $image);
        
        // Convert to WebP with AGGRESSIVE compression for smallest file size
        try {
            $img = Image::make($tempPath);
            
            // Resize to reasonable dimensions (max 1200px) to reduce file size dramatically
            $img->resize(1200, 1200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // Don't upscale small images
            });
            
            // Use quality 75 for WebP - provides excellent compression with minimal quality loss
            // WebP is much more efficient than JPEG, so 75% WebP looks like 90% JPEG
            $img->encode('webp', 75)->save($path);
            
            // Delete temporary file
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            
            $fileSize = filesize($path);
            Log::info('Product image converted to WebP: ' . $image_name . ' (' . round($fileSize / 1024, 2) . ' KB)');
        } catch (\Exception $e) {
            // Fallback to PNG if WebP conversion fails
            file_put_contents($path, $image);
            $image_name = str_replace('.webp', '.png', $image_name);
            $input['photo'] = $image_name;
            Log::error('WebP conversion failed, using PNG: ' . $e->getMessage());
        }
        
        $input['photo'] = $image_name;

        if ($request->type == "Physical" || $request->type == "Listing") {
            $rules = ['sku' => 'min:8|unique:products'];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }

            if ($request->product_condition_check == "") {
                $input['product_condition'] = 0;
            }

            if ($request->preordered_check == "") {
                $input['preordered'] = 0;
            }

            if ($request->minimum_qty_check == "") {
                $input['minimum_qty'] = null;
            }

            if ($request->shipping_time_check == "") {
                $input['ship'] = null;
            }

            if (empty($request->stock_check)) {
                $input['stock_check'] = 0;
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
                $input['color'] = null;
            } else {
                if (in_array(null, $request->size) || in_array(null, $request->size_qty) || in_array(null, $request->size_price)) {
                    $input['stock_check'] = 0;
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
                    $input['color'] = null;
                } else {
                    $input['stock_check'] = 1;
                    $input['color'] = implode(',', $request->color);
                    $input['size'] = implode(',', $request->size);
                    $input['size_qty'] = implode(',', $request->size_qty);
                    $size_prices = $request->size_price;
                    $s_price = array();
                    foreach ($size_prices as $key => $sPrice) {
                        $s_price[$key] = $sPrice / $sign->value;
                    }

                    $input['size_price'] = implode(',', $s_price);
                }
            }

            if (empty($request->color_check)) {
                $input['color_all'] = null;
            } else {
                $input['color_all'] = implode(',', $request->color_all);
            }

            if (empty($request->size_check)) {
                $input['size_all'] = null;
            } else {
                $input['size_all'] = implode(',', $request->size_all);
            }

            if (empty($request->whole_check)) {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            } else {
                if (in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount)) {
                    $input['whole_sell_qty'] = null;
                    $input['whole_sell_discount'] = null;
                } else {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

            if (empty($request->color_check)) {
                $input['color'] = null;
            } else {
                $input['color'] = implode(',', $request->color);
            }

            if ($request->mesasure_check == "") {
                $input['measure'] = null;
            }

        }

        if (empty($request->seo_check)) {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
        } else {
            if (!empty($request->meta_tag)) {
                $input['meta_tag'] = implode(',', $request->meta_tag);
            }
        }

        if ($request->type == "License") {

            if (in_array(null, $request->license) || in_array(null, $request->license_qty)) {
                $input['license'] = null;
                $input['license_qty'] = null;
            } else {
                $input['license'] = implode(',,', $request->license);
                $input['license_qty'] = implode(',', $request->license_qty);
            }

        }

        if (empty($request->features) || empty($request->colors) || in_array(null, $request->features ?? []) || in_array(null, $request->colors ?? [])) {
            $input['features'] = null;
            $input['colors'] = null;
        } else {
            $input['features'] = implode(',', str_replace(',', ' ', $request->features));
            $input['colors'] = implode(',', str_replace(',', ' ', $request->colors));
        }

        if (!empty($request->tags)) {
            $input['tags'] = implode(',', $request->tags);
        }

        $input['price'] = ($input['price'] / $sign->value);
        $input['previous_price'] = ($input['previous_price'] / $sign->value);

        $attrArr = [];
        if (!empty($request->category_id)) {
            $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
            if (!empty($catAttrs)) {
                foreach ($catAttrs as $key => $catAttr) {
                    $in_name = $catAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        if ($catAttr->details_status) {
                            $attrArr["$in_name"]["details_status"] = 1;
                        } else {
                            $attrArr["$in_name"]["details_status"] = 0;
                        }
                    }
                }
            }
        }

        if (!empty($request->subcategory_id)) {
            $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
            if (!empty($subAttrs)) {
                foreach ($subAttrs as $key => $subAttr) {
                    $in_name = $subAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        if ($subAttr->details_status) {
                            $attrArr["$in_name"]["details_status"] = 1;
                        } else {
                            $attrArr["$in_name"]["details_status"] = 0;
                        }
                    }
                }
            }
        }

        if (!empty($request->childcategory_id)) {
            $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
            if (!empty($childAttrs)) {
                foreach ($childAttrs as $key => $childAttr) {
                    $in_name = $childAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        if ($childAttr->details_status) {
                            $attrArr["$in_name"]["details_status"] = 1;
                        } else {
                            $attrArr["$in_name"]["details_status"] = 0;
                        }
                    }
                }
            }
        }

        if (empty($attrArr)) {
            $input['attributes'] = null;
        } else {
            $jsonAttr = json_encode($attrArr);
            $input['attributes'] = $jsonAttr;
        }

        // Save Data
        $data->fill($input)->save();

        // Sync Multiple Categories (if provided)
        if ($request->has('categories') && is_array($request->categories)) {
            $data->categories()->sync($request->categories);
        }

        // Save Product Translations (if provided)
        if ($request->has('translations') && is_array($request->translations)) {
            foreach ($request->translations as $langId => $translation) {
                if (!empty($translation['name']) || !empty($translation['description'])) {
                    $langCode = $translation['lang_code'] ?? '';

                    if (!empty($langCode)) {
                        // Use updateOrCreate to prevent duplicates
                        \App\Models\ProductTranslation::updateOrCreate(
                            [
                                'ec_products_id' => $data->id,
                                'lang_code' => $langCode,
                            ],
                            [
                                'name' => $translation['name'] ?? '',
                                'description' => $translation['description'] ?? '',
                                'content' => '' // You can add content field later if needed
                            ]
                        );
                    }
                }
            }
        }

        // Set SLug
        $prod = Product::find($data->id);
        if ($prod->type != 'Physical' || $request->type != "Listing") {
            $prod->slug = Str::slug($data->name, '-') . '-' . strtolower(Str::random(3) . $data->id . Str::random(3));
        } else {
            $prod->slug = Str::slug($data->name, '-') . '-' . strtolower($data->sku);
        }

        // Set Thumbnail - only if photo exists
        $photoPath = public_path() . '/assets/images/products/' . $prod->photo;
        if (file_exists($photoPath)) {
            // Create thumbnail with MAXIMUM compression
            try {
                // Ensure thumbnails directory exists
                if (!file_exists(public_path() . '/assets/images/thumbnails/')) {
                    mkdir(public_path() . '/assets/images/thumbnails/', 0755, true);
                }
                
                // Check if photo file exists
                if (file_exists($photoPath)) {
                    $img = Image::make($photoPath);
                    
                    // Ultra-compress thumbnails at 60% quality for smallest file size
                    // This matches our optimization strategy for fastest homepage loading
                    $img->resize(285, 285, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    
                    $thumbnail = time() . Str::random(8) . '.webp';
                    $thumbnailPath = public_path() . '/assets/images/thumbnails/' . $thumbnail;
                    
                    // Save as WebP with 60% quality for ultra-compression (smallest size)
                    $img->encode('webp', 60)->save($thumbnailPath);
                    $prod->thumbnail = $thumbnail;
                    
                    $fileSize = filesize($thumbnailPath);
                    Log::info('Thumbnail created (WebP): ' . $thumbnail . ' (' . round($fileSize / 1024, 2) . ' KB)');
                } else {
                    Log::error('Photo file does not exist for thumbnail creation: ' . $photoPath);
                    $prod->thumbnail = null;
                }
            } catch (\Exception $e) {
                // Log the error so we can see what went wrong
                Log::error('Thumbnail creation failed: ' . $e->getMessage() . ' - Photo path: ' . $photoPath);
                // Set thumbnail to null if creation fails
                $prod->thumbnail = null;
            }
        }
        $prod->update();

        // Add To Gallery If any
        $lastid = $data->id;
        if ($files = $request->file('gallery')) {
            foreach ($files as $key => $file) {
                if (in_array($key, $request->galval)) {
                    $gallery = new Gallery;
                    $name = time() . Str::random(8) . str_replace(' ', '', $file->getClientOriginalExtension());
                    $file->move('assets/images/galleries', $name);
                    $gallery['photo'] = $name;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                }
            }
        }
        //logic Section Ends

        //--- Redirect Section
        $msg = __("New Product Added Successfully.");
        return response()->json(['status' => true, 'msg' => $msg, 'redirect' => route('admin-prod-index')]);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function import()
    {

        $cats = Category::all();
        $sign = $this->curr;
        return view('admin.product.productcsv', compact('cats', 'sign'));
    }

    //*** POST Request
    public function importSubmit(Request $request)
    {
        // Remove PHP execution time limit for large imports
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $log = "";
        //--- Validation Section
        $rules = [
            'csvfile' => 'required|mimes:csv,txt',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $filename = '';
        if ($file = $request->file('csvfile')) {
            $filename = time() . '-' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/temp_files'), $filename);
        }

        $datas = "";

        $file = fopen(public_path('assets/temp_files/' . $filename), "r");

        // Remove UTF-8 BOM if present
        $bom = fread($file, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($file);
        }

        $i = 1;

        while (($line = fgetcsv($file)) !== false) {

            if ($i != 1) {

                //--- Validation Section Ends

                //--- Logic Section
                $data = new Product;
                $sign = Currency::where('is_default', '=', 1)->first();

                $input['type'] = 'Physical';

                // Make SKU unique if duplicate exists
                $originalSku = $line[0];
                $sku = $originalSku;
                $counter = 1;
                while (Product::where('sku', $sku)->exists()) {
                    $sku = $originalSku . '-' . $counter;
                    $counter++;
                }
                $input['sku'] = $sku;

                if ($sku != $originalSku) {
                    $log .= "<br>" . __('Row No') . ": " . $i . " - " . __('SKU modified from') . " " . $originalSku . " " . __('to') . " " . $sku . " " . __('(duplicate found)') . "<br>";
                }

                $input['category_id'] = null;
                $input['subcategory_id'] = null;
                $input['childcategory_id'] = null;

                // Parse categories - format is: "main_cat,sub_cat" in col[1], child_cat in col[2]
                $categories = [];

                // Split column 1 to get main category and subcategory (use explode for simplicity)
                $col1Parts = explode(',', $line[1]);
                $mainCategoryName = isset($col1Parts[0]) ? trim($col1Parts[0]) : '';
                $subCategoryName = isset($col1Parts[1]) ? trim($col1Parts[1]) : '';

                // Column 2 is the child category
                $childCategoryName = isset($line[2]) ? trim($line[2]) : '';

                // For multi-category support, collect all combinations
                $mainCategories = explode(',', $line[1]);
                $subCategories = count($mainCategories) > 1 ? array_slice($mainCategories, 1) : []; // Rest are subcategories
                $childCategories = !empty($line[2]) ? [$line[2]] : [];

                // Set primary category for backward compatibility
                if (!empty($mainCategoryName)) {
                    $mcat = Category::whereRaw('LOWER(name) = ?', [strtolower($mainCategoryName)]);
                    if ($mcat->exists()) {
                        $input['category_id'] = $mcat->first()->id;

                        if (!empty($subCategoryName)) {
                            $scat = Subcategory::whereRaw('LOWER(name) = ?', [strtolower($subCategoryName)]);
                            if ($scat->exists()) {
                                $input['subcategory_id'] = $scat->first()->id;
                            }
                        }

                        if (!empty($childCategoryName)) {
                            $chcat = Childcategory::whereRaw('LOWER(name) = ?', [strtolower($childCategoryName)]);
                            if ($chcat->exists()) {
                                $input['childcategory_id'] = $chcat->first()->id;
                            }
                        }

                        // Collect all category combinations for multi-category support
                        $categoryId = $input['category_id'];
                        $subcategoryId = $input['subcategory_id'];
                        $childcategoryId = $input['childcategory_id'];

                        $categories[] = [
                            'category_id' => $categoryId,
                            'subcategory_id' => $subcategoryId,
                            'childcategory_id' => $childcategoryId
                        ];
                    }
                }

                if ($input['category_id']) {
                    $input['photo'] = $line[5];
                    $input['name'] = $line[4];
                    $input['details'] = $line[6];
                    $input['color'] = $line[13];
                    $input['price'] = $line[7] != "" ? $line[7] : 0;
                    $input['previous_price'] = $line[8] != "" ? $line[8] : 0;
                    $input['stock'] = $line[9] != "" ? (int)$line[9] : null;
                    $input['size'] = $line[10];
                    $input['size_qty'] = $line[11];
                    $input['size_price'] = $line[12];
                    $input['youtube'] = $line[15];
                    $input['policy'] = $line[16];
                    $input['meta_tag'] = $line[17];
                    $input['meta_description'] = $line[18];
                    $input['tags'] = $line[14];
                    $input['product_type'] = (!empty($line[19]) && in_array(strtolower($line[19]), ['normal', 'affiliate'])) ? strtolower($line[19]) : 'normal';
                    $input['affiliate_link'] = $line[20];
                    $input['slug'] = Str::slug($input['name'], '-') . '-' . strtolower($input['sku']);

                    $image_url = $line[5];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $image_url);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_HEADER, true);
                    curl_setopt($ch, CURLOPT_NOBODY, true);

                    $content = curl_exec($ch);
                    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                    curl_close($ch);

                    $thumb_url = '';

                    if (strpos($contentType, 'image/') !== false) {
                        try {
                            // Download and convert to WebP with MAXIMUM compression
                            $imgData = @file_get_contents($line[5]);
                            if ($imgData !== false) {
                                $fimg = Image::make($imgData)->resize(1200, 1200, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });

                                // Save as WebP with 75% quality for best compression
                                $fphoto = time() . Str::random(8) . '.webp';
                                $fimg->encode('webp', 75)->save(base_path('public/assets/images/products/' . $fphoto));
                                $input['photo'] = $fphoto;

                                // Create thumbnail as WebP with 70% quality
                                $timg = Image::make($imgData)->resize(285, 285, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });
                                $thumbnail = time() . Str::random(8) . '_thumb.webp';
                                $timg->encode('webp', 70)->save(base_path('public/assets/images/thumbnails/' . $thumbnail));
                                $input['thumbnail'] = $thumbnail;

                                $log .= "<br>" . __('Row No') . ": " . $i . " - " . __('Image converted to WebP') . "<br>";
                            } else {
                                throw new \Exception('Failed to download image');
                            }
                        } catch (\Exception $e) {
                            // Use default noimage
                            $fimg = Image::make(base_path('public/assets/images/noimage.png'))->resize(1200, 1200, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                            $fphoto = time() . Str::random(8) . '.webp';
                            $fimg->encode('webp', 75)->save(base_path('public/assets/images/products/' . $fphoto));
                            $input['photo'] = $fphoto;

                            $timg = Image::make(base_path('public/assets/images/noimage.png'))->resize(285, 285);
                            $thumbnail = time() . Str::random(8) . '_thumb.webp';
                            $timg->encode('webp', 70)->save(base_path('public/assets/images/thumbnails/' . $thumbnail));
                            $input['thumbnail'] = $thumbnail;

                            $log .= "<br>" . __('Row No') . ": " . $i . " - " . __('Used default image (download failed)') . "<br>";
                        }
                    } else {
                        // Use default noimage for non-image content
                        $fimg = Image::make(base_path('public/assets/images/noimage.png'))->resize(1200, 1200, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        $fphoto = time() . Str::random(8) . '.webp';
                        $fimg->encode('webp', 75)->save(base_path('public/assets/images/products/' . $fphoto));
                        $input['photo'] = $fphoto;

                        $timg = Image::make(base_path('public/assets/images/noimage.png'))->resize(285, 285);
                        $thumbnail = time() . Str::random(8) . '_thumb.webp';
                        $timg->encode('webp', 70)->save(base_path('public/assets/images/thumbnails/' . $thumbnail));
                        $input['thumbnail'] = $thumbnail;
                    }

                    // Conert Price According to Currency
                    $input['price'] = ($input['price'] / $sign->value);
                    $input['previous_price'] = ($input['previous_price'] / $sign->value);

                    // Save Data
                    $data->fill($input)->save();

                    // Save multiple categories
                    if (!empty($categories) && count($categories) > 0) {
                        foreach ($categories as $cat) {
                            \App\Models\ProductCategory::create([
                                'product_id' => $data->id,
                                'category_id' => $cat['category_id'],
                                'subcategory_id' => $cat['subcategory_id'],
                                'childcategory_id' => $cat['childcategory_id']
                            ]);
                        }

                        if (count($categories) > 1) {
                            $log .= "<br>" . __('Row No') . ": " . $i . " - " . __('Product assigned to') . " " . count($categories) . " " . __('categories') . "<br>";
                        }
                    }

                } else {
                    $log .= "<br>" . __('Row No') . ": " . $i . " - " . __('No Category Found!') . "<br>";
                }
            }

            $i++;
        }
        fclose($file);

        //--- Redirect Section
        $msg = __('Bulk Product File Imported Successfully.') . $log;
        return response()->json($msg);
    }

    //*** GET Request
    public function edit($id)
    {
        $cats = Category::all();
        $data = Product::with('translations', 'galleries', 'categories')->findOrFail($id);
        $sign = $this->curr;
        // Get English language (is_default = 1) for translations, not Arabic
        $languages = \App\Models\AdminLanguage::where('is_default', 1)->get();

        if ($data->type == 'Digital') {
            return view('admin.product.edit.digital', compact('cats', 'data', 'sign', 'languages'));
        } elseif ($data->type == 'License') {
            return view('admin.product.edit.license', compact('cats', 'data', 'sign', 'languages'));
        } elseif ($data->type == 'Listing') {
            return view('admin.product.edit.listing', compact('cats', 'data', 'sign', 'languages'));
        } else {
            return view('admin.product.edit.physical', compact('cats', 'data', 'sign', 'languages'));
        }

    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        // return $request;
        //--- Validation Section
        $rules = [
            'file' => 'mimes:zip',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //-- Logic Section
        $data = Product::findOrFail($id);
        $sign = $this->curr;
        $input = $request->all();

        // Handle checkbox fields (unchecked checkboxes don't send values)
        $input['status'] = $request->has('status') ? 1 : 0;
        $input['featured'] = $request->has('featured') ? 1 : 0;
        $input['hot'] = $request->has('hot') ? 1 : 0;

        //Check Types
        if ($request->type_check == 1) {
            $input['link'] = null;
        } else {
            if ($data->file != null) {
                if (file_exists(public_path() . '/assets/files/' . $data->file)) {
                    unlink(public_path() . '/assets/files/' . $data->file);
                }
            }
            $input['file'] = null;
        }

        // Check Physical
        if ($data->type == "Physical" || $data->type == "Listing") {
            //--- Validation Section
            $rules = ['sku' => 'min:8|unique:products,sku,' . $id];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends

            // Check Condition
            if ($request->product_condition_check == "") {
                $input['product_condition'] = 0;
            }

            // Check Preorderd
            if ($request->preordered_check == "") {
                $input['preordered'] = 0;
            }

            // Check Minimum Qty
            if ($request->minimum_qty_check == "") {
                $input['minimum_qty'] = null;
            }

            // Check Shipping Time
            if ($request->shipping_time_check == "") {
                $input['ship'] = null;
            }

            // Check Size
            if (empty($request->stock_check)) {
                $input['stock_check'] = 0;
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
                $input['color'] = null;
            } else {
                if (empty($request->size) || empty($request->size_qty) || empty($request->size_price) ||
                    in_array(null, $request->size ?? []) || in_array(null, $request->size_qty ?? []) || in_array(null, $request->size_price ?? [])) {
                    $input['stock_check'] = 0;
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
                    $input['color'] = null;
                } else {
                    $input['stock_check'] = 1;
                    $input['color'] = implode(',', $request->color);
                    $input['size'] = implode(',', $request->size);
                    $input['size_qty'] = implode(',', $request->size_qty);
                    $size_prices = $request->size_price;
                    $s_price = array();
                    foreach ($size_prices as $key => $sPrice) {
                        $s_price[$key] = $sPrice / $sign->value;
                    }

                    $input['size_price'] = implode(',', $s_price);
                }
            }

            // Check Color
            if (empty($request->color_check)) {
                $input['color_all'] = null;
            } else {
                $input['color_all'] = implode(',', $request->color_all);
            }
            // Check Size
            if (empty($request->size_check)) {
                $input['size_all'] = null;
            } else {
                $input['size_all'] = implode(',', $request->size_all);
            }

            // Check Whole Sale
            if (empty($request->whole_check)) {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            } else {
                if (empty($request->whole_sell_qty) || empty($request->whole_sell_discount) ||
                    in_array(null, $request->whole_sell_qty ?? []) || in_array(null, $request->whole_sell_discount ?? [])) {
                    $input['whole_sell_qty'] = null;
                    $input['whole_sell_discount'] = null;
                } else {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

            // Check Measure
            if ($request->measure_check == "") {
                $input['measure'] = null;
            }
        }

        // Check Seo
        if (empty($request->seo_check)) {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
        } else {
            if (!empty($request->meta_tag)) {
                $input['meta_tag'] = implode(',', $request->meta_tag);
            }
        }

        // Check License
        if ($data->type == "License") {

            if (!empty($request->license) && !empty($request->license_qty) &&
                !in_array(null, $request->license ?? []) && !in_array(null, $request->license_qty ?? [])) {
                $input['license'] = implode(',,', $request->license);
                $input['license_qty'] = implode(',', $request->license_qty);
            } else {
                if (empty($request->license) || empty($request->license_qty) ||
                    in_array(null, $request->license ?? []) || in_array(null, $request->license_qty ?? [])) {
                    $input['license'] = null;
                    $input['license_qty'] = null;
                } else {
                    $license = explode(',,', $data->license);
                    $license_qty = explode(',', $data->license_qty);
                    $input['license'] = implode(',,', $license);
                    $input['license_qty'] = implode(',', $license_qty);
                }
            }

        }
        // Check Features
        if (!empty($request->features) && !empty($request->colors) && !in_array(null, $request->features) && !in_array(null, $request->colors)) {
            $input['features'] = implode(',', str_replace(',', ' ', $request->features));
            $input['colors'] = implode(',', str_replace(',', ' ', $request->colors));
        } else {
            if (empty($request->features) || empty($request->colors) || in_array(null, $request->features ?? []) || in_array(null, $request->colors ?? [])) {
                $input['features'] = null;
                $input['colors'] = null;
            } else {
                $features = explode(',', $data->features);
                $colors = explode(',', $data->colors);
                $input['features'] = implode(',', $features);
                $input['colors'] = implode(',', $colors);
            }
        }

        //Product Tags
        if (!empty($request->tags)) {
            $input['tags'] = implode(',', $request->tags);
        }
        if (empty($request->tags)) {
            $input['tags'] = null;
        }

        $input['price'] = $input['price'] / $sign->value;
        $input['previous_price'] = $input['previous_price'] / $sign->value;

        // store filtering attributes for physical product
        $attrArr = [];
        if (!empty($request->category_id)) {
            $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
            if (!empty($catAttrs)) {
                foreach ($catAttrs as $key => $catAttr) {
                    $in_name = $catAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        if ($catAttr->details_status) {
                            $attrArr["$in_name"]["details_status"] = 1;
                        } else {
                            $attrArr["$in_name"]["details_status"] = 0;
                        }
                    }
                }
            }
        }

        if (!empty($request->subcategory_id)) {
            $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
            if (!empty($subAttrs)) {
                foreach ($subAttrs as $key => $subAttr) {
                    $in_name = $subAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        if ($subAttr->details_status) {
                            $attrArr["$in_name"]["details_status"] = 1;
                        } else {
                            $attrArr["$in_name"]["details_status"] = 0;
                        }
                    }
                }
            }
        }
        if (!empty($request->childcategory_id)) {
            $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
            if (!empty($childAttrs)) {
                foreach ($childAttrs as $key => $childAttr) {
                    $in_name = $childAttr->input_name;
                    if ($request->has("$in_name")) {
                        $attrArr["$in_name"]["values"] = $request["$in_name"];
                        foreach ($request["$in_name" . "_price"] as $aprice) {
                            $ttt["$in_name" . "_price"][] = $aprice / $sign->value;
                        }
                        $attrArr["$in_name"]["prices"] = $ttt["$in_name" . "_price"];
                        if ($childAttr->details_status) {
                            $attrArr["$in_name"]["details_status"] = 1;
                        } else {
                            $attrArr["$in_name"]["details_status"] = 0;
                        }
                    }
                }
            }
        }

        if (empty($attrArr)) {
            $input['attributes'] = null;
        } else {
            $jsonAttr = json_encode($attrArr);
            $input['attributes'] = $jsonAttr;
        }

        $data->slug = Str::slug($data->name, '-') . '-' . strtolower($data->sku);

        $data->update($input);

        // Sync Multiple Categories (if provided)
        if ($request->has('categories') && is_array($request->categories)) {
            $data->categories()->sync($request->categories);
        }

        // Update Product Translations (if provided)
        if ($request->has('translations') && is_array($request->translations)) {
            foreach ($request->translations as $langId => $translation) {
                if (!empty($translation['name']) || !empty($translation['description'])) {
                    $langCode = $translation['lang_code'] ?? '';

                    if (!empty($langCode)) {
                        // Use updateOrCreate for composite key tables
                        \App\Models\ProductTranslation::updateOrCreate(
                            [
                                'ec_products_id' => $data->id,
                                'lang_code' => $langCode,
                            ],
                            [
                                'name' => $translation['name'] ?? '',
                                'description' => $translation['description'] ?? '',
                            ]
                        );
                    }
                }
            }
        }

        // Update Gallery Images (if provided)
        if ($files = $request->file('gallery')) {
            foreach ($files as $key => $file) {
                if (in_array($key, $request->galval ?? [])) {
                    $gallery = new Gallery;
                    $name = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $file->move('assets/images/galleries', $name);
                    $gallery['photo'] = $name;
                    $gallery['product_id'] = $data->id;
                    $gallery->save();
                }
            }
        }

        //-- Logic Section Ends

        //--- Redirect Section
        $msg = __("Product Updated Successfully.") . '<a href="' . route('admin-prod-index') . '">' . __("View Product Lists.") . '</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function feature($id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.highlight', compact('data'));
    }


    public function catalog($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->is_catalog = $id2;
        $data->update();
        if($id2 == 1) {
            $msg = "Product added to catalog successfully.";
        }
        else {
            $msg = "Product removed from catalog successfully.";
        }
        return response()->json($msg);
    }

    //*** POST Request
    public function featuresubmit(Request $request, $id)
    {
        //-- Logic Section
        $data = Product::findOrFail($id);
        $input = $request->all();
        if ($request->featured == "") {
            $input['featured'] = 0;
        }
        if ($request->hot == "") {
            $input['hot'] = 0;
        }
        if ($request->best == "") {
            $input['best'] = 0;
        }
        if ($request->top == "") {
            $input['top'] = 0;
        }
        if ($request->latest == "") {
            $input['latest'] = 0;
        }
        if ($request->big == "") {
            $input['big'] = 0;
        }
        if ($request->trending == "") {
            $input['trending'] = 0;
        }
        if ($request->sale == "") {
            $input['sale'] = 0;
        }
        if ($request->is_discount == "") {
            $input['is_discount'] = 0;
            $input['discount_date'] = null;
        } else {
            $input['discount_date'] = \Carbon\Carbon::parse($input['discount_date'])->format('Y-m-d');
        }

        $data->update($input);
        //-- Logic Section Ends

        //--- Redirect Section
        $msg = __('Highlight Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends

    }

    //*** GET Request
    public function destroy($id)
    {

        $data = Product::findOrFail($id);
        if ($data->galleries->count() > 0) {
            foreach ($data->galleries as $gal) {
                if (file_exists(public_path() . '/assets/images/galleries/' . $gal->photo)) {
                    unlink(public_path() . '/assets/images/galleries/' . $gal->photo);
                }
                $gal->delete();
            }
        }

        if ($data->reports->count() > 0) {
            foreach ($data->reports as $gal) {
                $gal->delete();
            }
        }

        if ($data->ratings->count() > 0) {
            foreach ($data->ratings as $gal) {
                $gal->delete();
            }
        }
        if ($data->wishlists->count() > 0) {
            foreach ($data->wishlists as $gal) {
                $gal->delete();
            }
        }
        if ($data->clicks->count() > 0) {
            foreach ($data->clicks as $gal) {
                $gal->delete();
            }
        }
        if ($data->comments->count() > 0) {
            foreach ($data->comments as $gal) {
                if ($gal->replies->count() > 0) {
                    foreach ($gal->replies as $key) {
                        $key->delete();
                    }
                }
                $gal->delete();
            }
        }

        if (!filter_var($data->photo, FILTER_VALIDATE_URL)) {
            if ($data->photo) {
                if (file_exists(public_path() . '/assets/images/products/' . $data->photo)) {
                    unlink(public_path() . '/assets/images/products/' . $data->photo);
                }
            }

        }

        if (file_exists(public_path() . '/assets/images/thumbnails/' . $data->thumbnail) && $data->thumbnail != "") {
            unlink(public_path() . '/assets/images/thumbnails/' . $data->thumbnail);
        }

        if ($data->file != null) {
            if (file_exists(public_path() . '/assets/files/' . $data->file)) {
                unlink(public_path() . '/assets/files/' . $data->file);
            }
        }
        $data->delete();
        //--- Redirect Section
        $msg = __('Product Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends

// PRODUCT DELETE ENDS
    }

    public function settingUpdate(Request $request)
    {
        //--- Logic Section
        $input = $request->all();
        $data = \App\Models\Generalsetting::findOrFail(1);

        if (!empty($request->product_page)) {
            $input['product_page'] = implode(',', $request->product_page);
        } else {
            $input['product_page'] = null;
        }

        if (!empty($request->wishlist_page)) {
            $input['wishlist_page'] = implode(',', $request->wishlist_page);
        } else {
            $input['wishlist_page'] = null;
        }

        cache()->forget('generalsettings');

        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    public function getAttributes(Request $request)
    {
        $model = '';
        if ($request->type == 'category') {
            $model = 'App\Models\Category';
        } elseif ($request->type == 'subcategory') {
            $model = 'App\Models\Subcategory';
        } elseif ($request->type == 'childcategory') {
            $model = 'App\Models\Childcategory';
        }

        $attributes = Attribute::where('attributable_id', $request->id)->where('attributable_type', $model)->get();
        $attrOptions = [];
        foreach ($attributes as $key => $attribute) {
            $options = AttributeOption::where('attribute_id', $attribute->id)->get();
            $attrOptions[] = ['attribute' => $attribute, 'options' => $options];
        }
        return response()->json($attrOptions);
    }
}
