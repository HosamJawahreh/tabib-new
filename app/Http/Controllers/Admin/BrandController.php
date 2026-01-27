<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get();
        return view('admin.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'name_en' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'status' => 'required|in:0,1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()], 422);
        }

        try {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->name_en = $request->name_en;
            $brand->status = $request->status;
            $brand->sort_order = $request->sort_order ?? 0;

            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $imageName = time() . '_' . uniqid() . '.webp';

                    // Create directory if it doesn't exist - use base_path instead of public_path
                    $directory = base_path('public/assets/images/brands');
                    if (!file_exists($directory)) {
                        mkdir($directory, 0777, true);
                    }

                    // Convert to WebP with error handling
                    $img = Image::make($image->getRealPath());
                    $img->encode('webp', 90);
                    $savePath = $directory . '/' . $imageName;
                    $img->save($savePath);

                    // Verify file was created
                    if (!file_exists($savePath)) {
                        throw new \Exception('Image file was not created at: ' . $savePath);
                    }

                    $brand->image = $imageName;
                } catch (\Exception $e) {
                    Log::error('Image processing error: ' . $e->getMessage());
                    return response()->json([
                        'errors' => ['image' => ['Failed to process image: ' . $e->getMessage()]],
                        'message' => 'Failed to process image'
                    ], 500);
                }
            }

            $brand->save();

            return response()->json(['msg' => __('Brand created successfully!'), 'success' => true]);
        } catch (\Exception $e) {
            Log::error('Brand Store Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'errors' => ['error' => [$e->getMessage()]],
                'message' => 'Error creating brand: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'name_en' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'status' => 'required|in:0,1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        try {
            $brand = Brand::findOrFail($id);
            $brand->name = $request->name;
            $brand->name_en = $request->name_en;
            $brand->status = $request->status;
            $brand->sort_order = $request->sort_order ?? 0;

            if ($request->hasFile('image')) {
                try {
                    // Delete old image - use base_path instead of public_path
                    if ($brand->image && file_exists(base_path('public/assets/images/brands/' . $brand->image))) {
                        unlink(base_path('public/assets/images/brands/' . $brand->image));
                    }

                    $image = $request->file('image');
                    $imageName = time() . '_' . uniqid() . '.webp';

                    // Create directory if it doesn't exist
                    $directory = base_path('public/assets/images/brands');
                    if (!file_exists($directory)) {
                        mkdir($directory, 0777, true);
                    }

                    // Convert to WebP
                    $img = Image::make($image->getRealPath());
                    $img->encode('webp', 90);
                    $savePath = $directory . '/' . $imageName;
                    $img->save($savePath);

                    // Verify file was created
                    if (!file_exists($savePath)) {
                        throw new \Exception('Image file was not created at: ' . $savePath);
                    }

                    $brand->image = $imageName;
                } catch (\Exception $e) {
                    Log::error('Image update error: ' . $e->getMessage());
                    return response()->json([
                        'errors' => ['image' => ['Failed to process image: ' . $e->getMessage()]],
                        'message' => 'Failed to process image'
                    ], 500);
                }
            }

            $brand->save();

            return response()->json(['msg' => __('Brand updated successfully!'), 'success' => true]);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['error' => [$e->getMessage()]]], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Check if brand has products
            if ($brand->products()->count() > 0) {
                return response()->json(['msg' => __('Cannot delete brand with products. Please delete products first.')], 400);
            }

            // Delete image - use base_path instead of public_path
            if ($brand->image && file_exists(base_path('public/assets/images/brands/' . $brand->image))) {
                unlink(base_path('public/assets/images/brands/' . $brand->image));
            }

            $brand->delete();

            return response()->json(['msg' => __('Brand deleted successfully!')]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 500);
        }
    }

    public function status($id, $status)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->status = $status;
            $brand->save();

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
                Brand::where('id', $order['id'])->update(['sort_order' => $order['position']]);
            }

            return response()->json(['msg' => __('Order updated successfully!')]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 500);
        }
    }
}
