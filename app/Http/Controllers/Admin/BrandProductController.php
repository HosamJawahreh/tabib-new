<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class BrandProductController extends Controller
{
    public function index($brand_id)
    {
        $brand = Brand::findOrFail($brand_id);
        $products = BrandProduct::where('brand_id', $brand_id)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();
        
        return view('admin.brand.products', compact('brand', 'products'));
    }

    public function store(Request $request)
    {
        $rules = [
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'status' => 'required|in:0,1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        try {
            $product = new BrandProduct();
            $product->brand_id = $request->brand_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->status = $request->status;
            $product->sort_order = $request->sort_order ?? 0;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.webp';
                
                // Convert to WebP
                $img = Image::make($image->getRealPath());
                $img->encode('webp', 90);
                $img->save(public_path('assets/images/brand-products/' . $imageName));
                
                $product->image = $imageName;
            }

            $product->save();

            return response()->json(['msg' => __('Product created successfully!'), 'success' => true]);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['error' => [$e->getMessage()]]], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'status' => 'required|in:0,1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        try {
            $product = BrandProduct::findOrFail($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->status = $request->status;
            $product->sort_order = $request->sort_order ?? 0;

            if ($request->hasFile('image')) {
                // Delete old image
                if ($product->image && file_exists(public_path('assets/images/brand-products/' . $product->image))) {
                    unlink(public_path('assets/images/brand-products/' . $product->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.webp';
                
                // Convert to WebP
                $img = Image::make($image->getRealPath());
                $img->encode('webp', 90);
                $img->save(public_path('assets/images/brand-products/' . $imageName));
                
                $product->image = $imageName;
            }

            $product->save();

            return response()->json(['msg' => __('Product updated successfully!'), 'success' => true]);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['error' => [$e->getMessage()]]], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = BrandProduct::findOrFail($id);

            // Delete image
            if ($product->image && file_exists(public_path('assets/images/brand-products/' . $product->image))) {
                unlink(public_path('assets/images/brand-products/' . $product->image));
            }

            $product->delete();

            return response()->json(['msg' => __('Product deleted successfully!')]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 500);
        }
    }

    public function status($id, $status)
    {
        try {
            $product = BrandProduct::findOrFail($id);
            $product->status = $status;
            $product->save();

            return response()->json(['msg' => __('Status updated successfully!')]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        try {
            $orders = $request->order;
            foreach ($orders as $order) {
                BrandProduct::where('id', $order['id'])->update(['sort_order' => $order['position']]);
            }

            return response()->json(['msg' => __('Order updated successfully!')]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 500);
        }
    }
}
