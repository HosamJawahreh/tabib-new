<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\PriceHelper;

class CategoryController extends AdminBaseController
{
    //*** JSON Request
    public function datatables()
    {
        $datas = Category::latest('id')->get();
        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->addColumn('status', function (Category $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-cat-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-cat-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })
            ->editColumn('is_featured', function (Category $data) {
                $class = $data->is_featured == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->is_featured == 1 ? 'selected' : '';
                $ns = $data->is_featured == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-cat-featured', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-cat-featured', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })
            ->addColumn('attributes', function (Category $data) {
                $buttons = '<div class="action-list"><a data-href="' . route('admin-attr-createForCategory', $data->id) . '" class="attribute" data-toggle="modal" data-target="#attribute"> <i class="fas fa-edit"></i>' . __("Create") . '</a>';
                if ($data->attributes()->count() > 0) {
                    $buttons .= '<a href="' . route('admin-attr-manage', $data->id) . '?type=category' . '" class="edit"> <i class="fas fa-edit"></i>' . __("Manage") . '</a>';
                }
                $buttons .= '</div>';

                return $buttons;
            })
            ->addColumn('action', function (Category $data) {
                return '<div class="action-list"><a data-href="' . route('admin-cat-edit', $data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('admin-cat-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['status', 'attributes', 'action','is_featured'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.category.index');
    }

    public function tree()
    {
        $categories = Category::where('is_featured', 1)
                             ->with(['subs.childs'])
                             ->orderBy('sort_order', 'asc')
                             ->orderBy('id', 'desc')
                             ->get();
        return view('admin.category.tree', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }
    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'slug' => 'nullable|unique:categories|regex:/^[a-zA-Z0-9\s-]+$/'
        ];
        $customs = [
            'name_ar.required' => __('Arabic name is required.'),
            'name_en.required' => __('English name is required.'),
            'slug.unique' => __('This slug has already been taken.'),
            'slug.regex' => __('Slug Must Not Have Any Special Characters.')
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        try {
            //--- Logic Section
            $input = $request->all();
            
            // Auto-generate slug if not provided
            if (empty($input['slug'])) {
                $slugSource = !empty($input['name_en']) ? $input['name_en'] : $input['name_ar'];
                $input['slug'] = $this->generateUniqueSlug($slugSource);
            }
            
            // Set the main 'name' field for backward compatibility (required by database)
            // Use English name if available, otherwise use Arabic name
            $input['name'] = !empty($request->name_en) ? $request->name_en : $request->name_ar;
            
            // Set default values if not provided
            if (!isset($input['status'])) {
                $input['status'] = 1; // Active by default
            }
            if (!isset($input['is_featured'])) {
                $input['is_featured'] = 1; // Featured by default for main categories
            }
            
            $data = new Category();
            
            // Handle optional photo upload
            if ($file = $request->file('photo')) {
                $name = PriceHelper::ImageCreateName($file);
                $file->move('assets/images/categories', $name);
                $input['photo'] = $name;
            } else {
                $input['photo'] = null;
            }
            
            // Handle optional image upload
            if ($file = $request->file('image')) {
                $name = PriceHelper::ImageCreateName($file);
                $file->move('assets/images/categories', $name);
                $input['image'] = $name;
            } else {
                $input['image'] = null;
            }

            $data->fill($input)->save();

            // Save translations
            if ($request->has('name_ar') || $request->has('name_en')) {
                $translations = [];
                if ($request->has('name_ar') && !empty($request->name_ar)) {
                    $translations['ar'] = $request->name_ar;
                }
                if ($request->has('name_en') && !empty($request->name_en)) {
                    $translations['en'] = $request->name_en;
                }
                if (!empty($translations)) {
                    $data->saveTranslations($translations);
                }
            }

            //--- Logic Section Ends

            //--- Redirect Section
            $msg = __('New Data Added Successfully.');
            return response()->json(['msg' => $msg, 'success' => true]);
            //--- Redirect Section Ends
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Category Store Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'errors' => ['error' => [$e->getMessage()]],
                'message' => 'Error creating category: ' . $e->getMessage()
            ], 500);
        }
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view('admin.category.edit', compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            
            'slug' => 'unique:categories,slug,' . $id . '|regex:/^[a-zA-Z0-9\s-]+$/',
            'image' => 'mimes:jpeg,jpg,png,svg'
        ];
        $customs = [
            
            'slug.unique' => __('This slug has already been taken.'),
            'slug.regex' => __('Slug Must Not Have Any Special Characters.'),
            'image.mimes' => __('Banner Image Type is Invalid.')
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $input = $request->all();
        $data = Category::findOrFail($id);
        if ($file = $request->file('photo')) {
            $name = PriceHelper::ImageCreateName($file);
            $file->move('assets/images/categories', $name);
            if ($data->photo != null) {
                if (file_exists(public_path() . '/assets/images/categories/' . $data->photo)) {
                    unlink(public_path() . '/assets/images/categories/' . $data->photo);
                }
            }
            $input['photo'] = $name;
        }
        if ($file = $request->file('image')) {
            $name = PriceHelper::ImageCreateName($file);
            $file->move('assets/images/categories', $name);
            $input['image'] = $name;
        }

        // Update the main 'name' field for backward compatibility (required by database)
        // Use English name if available, otherwise use Arabic name
        if ($request->has('name_ar') || $request->has('name_en')) {
            $input['name'] = !empty($request->name_en) ? $request->name_en : $request->name_ar;
        }

        $data->update($input);

        // Update translations
        if ($request->has('name_ar') || $request->has('name_en')) {
            $translations = [];
            if ($request->has('name_ar') && !empty($request->name_ar)) {
                $translations['ar'] = $request->name_ar;
            }
            if ($request->has('name_en') && !empty($request->name_en)) {
                $translations['en'] = $request->name_en;
            }
            if (!empty($translations)) {
                $data->saveTranslations($translations);
            }
        }

        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Status
    public function status($id1, $id2)
    {
        $data = Category::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Status
    public function featured($id1, $id2)
    {
        $data = Category::findOrFail($id1);
        $data->is_featured  = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }


    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Category::findOrFail($id);

        if ($data->attributes->count() > 0) {
            //--- Redirect Section
            $msg = __('Remove the Attributes first !');
            return response()->json($msg);
            //--- Redirect Section Ends
        }

        if ($data->subs->count() > 0) {
            //--- Redirect Section
            $msg = __('Remove the subcategories first !');
            return response()->json($msg);
            //--- Redirect Section Ends
        }
        if ($data->products->count() > 0) {
            //--- Redirect Section
            $msg = __('Remove the products first !');
            return response()->json($msg);
            //--- Redirect Section Ends
        }

     
        if (file_exists(public_path() . '/assets/images/categories/' . $data->image)) {
            unlink(public_path() . '/assets/images/categories/' . $data->image);
        }
        $data->delete();
        //--- Redirect Section
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    
    /**
     * Update category order via drag and drop
     */
    public function reorder(Request $request)
    {
        try {
            $orders = $request->input('orders', []);
            
            foreach ($orders as $order) {
                $type = $order['type'] ?? 'category';
                $id = $order['id'] ?? null;
                $sortOrder = $order['order'] ?? 0;
                $parentId = $order['parent_id'] ?? null;
                
                if (!$id) continue;
                
                if ($type === 'category') {
                    $item = Category::find($id);
                    if ($item) {
                        $item->sort_order = $sortOrder;
                        $item->save();
                    }
                } elseif ($type === 'subcategory') {
                    $item = \App\Models\Subcategory::find($id);
                    if ($item) {
                        $item->sort_order = $sortOrder;
                        if ($parentId !== null) {
                            $item->category_id = $parentId;
                        }
                        $item->save();
                    }
                } elseif ($type === 'childcategory') {
                    $item = \App\Models\Childcategory::find($id);
                    if ($item) {
                        $item->sort_order = $sortOrder;
                        if ($parentId !== null) {
                            $item->subcategory_id = $parentId;
                        }
                        $item->save();
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => __('Order updated successfully.')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Category Reorder Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('Error updating order: ') . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Generate a unique slug from the given text
     */
    private function generateUniqueSlug($text, $id = null)
    {
        // Generate base slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
        $slug = preg_replace('/-+/', '-', $slug); // Replace multiple dashes with single dash
        $slug = trim($slug, '-'); // Remove dashes from start and end
        
        // Check if slug exists
        $originalSlug = $slug;
        $counter = 1;
        
        while (true) {
            $query = Category::where('slug', $slug);
            if ($id) {
                $query->where('id', '!=', $id);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}
