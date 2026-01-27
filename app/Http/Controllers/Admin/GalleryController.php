<?php

namespace App\Http\Controllers\Admin;

use App\{
    Http\Controllers\Controller,
    Models\Gallery,
    Models\Product
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class GalleryController extends Controller
{

    public function show()
    {
        $data[0] = 0;
        $id = $_GET['id'];
        $prod = Product::findOrFail($id);
        if(count($prod->galleries))
        {
            $data[0] = 1;
            $data[1] = $prod->galleries;
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = null;
        $lastid = $request->product_id;
        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                $val = $file->getClientOriginalExtension();
                if($val == 'jpeg'|| $val == 'jpg'|| $val == 'png'|| $val == 'svg' || $val == 'webp')
                  {
                    $gallery = new Gallery;

                    // Convert gallery images to WebP with 75% quality for product details
                    $img = Image::make($file->getRealPath());

                    // Resize to max 1200px for product detail view
                    $img->resize(1200, 1200, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    // Save as WebP with 75% quality (matches product main photo quality)
                    $thumbnail = time() . Str::random(8) . '.webp';
                    $img->encode('webp', 75)->save(public_path() . '/assets/images/galleries/' . $thumbnail);

                    $gallery['photo'] = $thumbnail;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                    $data[] = $gallery;
                  }
            }
        }
        return response()->json($data);
    }

    public function destroy()
    {

        $id = $_GET['id'];
        $gal = Gallery::findOrFail($id);
            if (file_exists(public_path().'/assets/images/galleries/'.$gal->photo)) {
                unlink(public_path().'/assets/images/galleries/'.$gal->photo);
            }
        $gal->delete();

    }

}
