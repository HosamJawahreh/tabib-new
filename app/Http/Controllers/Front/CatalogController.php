<?php

namespace App\Http\Controllers\Front;

use App\{
  Models\Product,
  Models\Category,
  Models\Subcategory,
  Models\Childcategory,
  Models\Report
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CatalogController extends FrontBaseController
{

  // CATEGORIES SECTOPN

  public function categories()
  {

    return view('frontend.products');
  }

  // -------------------------------- CATEGORY SECTION ----------------------------------------

  public function category(Request $request, $slug = null, $slug1 = null, $slug2 = null, $slug3 = null)
  {

    if ($request->view_check) {
      session::put('view', $request->view_check);
    }

    //   dd(session::get('view'));

    $cat = null;
    $subcat = null;
    $childcat = null;
    $flash = null;
    $minprice = $request->min;
    $maxprice = $request->max;
    $sort = $request->sort;
    $search = $request->search;
    $pageby = $request->pageby;

    $minprice = ($minprice / $this->curr->value);
    $maxprice = ($maxprice / $this->curr->value);
    $type = $request->has('type') ?? '';


    if (!empty($slug)) {
      $cat = Category::where('slug', $slug)->firstOrFail();
      $data['cat'] = $cat;
    }

    if (!empty($slug1)) {
      $subcat = Subcategory::where('slug', $slug1)->firstOrFail();
      $data['subcat'] = $subcat;
    }
    if (!empty($slug2)) {
      $childcat = Childcategory::where('slug', $slug2)->firstOrFail();
      $data['childcat'] = $childcat;
    }

    $data['latest_products'] = Product::with('user')->whereStatus(1)->whereLatest(1)
    ->with(['user' => function ($query) {
      $query->select('id', 'is_vendor');
  }])

      ->withCount('ratings')
      ->withAvg('ratings', 'rating')
      ->get()
      ->chunk(4);;

    $prods = Product::when($cat, function ($query, $cat) {
      // Use whereHas to query the many-to-many relationship
      return $query->whereHas('categories', function($q) use ($cat) {
        $q->where('categories.id', $cat->id);
      });
    })
      ->when($subcat, function ($query, $subcat) {
        // Use whereHas to query the many-to-many relationship
        return $query->whereHas('categories', function($q) use ($subcat) {
          $q->where('categories.id', $subcat->id);
        });
      })
      ->when($type, function ($query, $type) {
        return $query->with('user')->whereStatus(1)->whereIsDiscount(1)
          ->where('discount_date', '>=', date('Y-m-d'))
          ->whereHas('user', function ($user) {
            $user->where('is_vendor', 2);
          });
      })
      ->when($childcat, function ($query, $childcat) {
        // Use whereHas to query the many-to-many relationship
        return $query->whereHas('categories', function($q) use ($childcat) {
          $q->where('categories.id', $childcat->id);
        });
      })
      ->when($search, function ($query, $search) {
        return $query->where('name', 'like', '%' . $search . '%')->orWhere('name', 'like', $search . '%');
      })
      ->when($minprice, function ($query, $minprice) {
        return $query->where('price', '>=', $minprice);
      })
      ->when($maxprice, function ($query, $maxprice) {
        return $query->where('price', '<=', $maxprice);
      })
      ->when($sort, function ($query, $sort) {
        if ($sort == 'date_desc') {
          return $query->latest('id');
        } elseif ($sort == 'date_asc') {
          return $query->oldest('id');
        } elseif ($sort == 'price_desc') {
          return $query->latest('price');
        } elseif ($sort == 'price_asc') {
          return $query->oldest('price');
        }
      })
      ->when(empty($sort), function ($query, $sort) {
        return $query->latest('id');
      })
      ->with('categories') // Load multi-categories relationship
      ->withCount('ratings')
      ->withAvg('ratings', 'rating');


    $prods = $prods->where(function ($query) use ($cat, $subcat, $childcat, $type, $request) {
      $flag = 0;
      if (!empty($cat)) {
        foreach ($cat->attributes as $key => $attribute) {
          $inname = $attribute->input_name;
          $chFilters = $request["$inname"];

          if (!empty($chFilters)) {
            $flag = 1;
            foreach ($chFilters as $key => $chFilter) {
              if ($key == 0) {
                $query->where('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
              } else {
                $query->orWhere('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
              }
            }
          }
        }
      }


      if (!empty($subcat)) {
        foreach ($subcat->attributes as $attribute) {
          $inname = $attribute->input_name;
          $chFilters = $request["$inname"];

          if (!empty($chFilters)) {
            $flag = 1;
            foreach ($chFilters as $key => $chFilter) {
              if ($key == 0 && $flag == 0) {
                $query->where('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
              } else {
                $query->orWhere('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
              }
            }
          }
        }
      }

      if (!empty($childcat)) {
        foreach ($childcat->attributes as $attribute) {
          $inname = $attribute->input_name;
          $chFilters = $request["$inname"];

          if (!empty($chFilters)) {
            $flag = 1;
            foreach ($chFilters as $key => $chFilter) {
              if ($key == 0 && $flag == 0) {
                $query->where('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
              } else {
                $query->orWhere('attributes', 'like', '%' . '"' . $chFilter . '"' . '%');
              }
            }
          }
        }
      }
    });

    $prods = $prods->where('status', 1)->get()

      ->map(function ($item) {
        $item->price = $item->vendorSizePrice();
        return $item;
      })->paginate(isset($pageby) ? $pageby : $this->gs->page_count);
    $data['prods'] = $prods;

    // Add footer blogs for footer section
    $data['footer_blogs'] = \App\Models\Blog::orderBy('created_at', 'desc')->limit(3)->get();

    //    dd($data['prods']);
    if ($request->ajax()) {
      // Check if it's a mobile search AJAX request
      if ($request->has('ajax') && $request->ajax == 1) {
        // Return JSON for mobile search
        $products = [];
        foreach ($prods as $product) {
          $products[] = [
            'id' => $product->id,
            'name' => $product->showName(),
            'slug' => $product->slug,
            'photo' => $product->photo,
            'price' => $product->showPrice(),
            'previous_price' => $product->showPreviousPrice(),
            'rating' => number_format($product->ratings_avg_rating ?? 0, 1),
            'rating_count' => $product->ratings_count ?? 0,
          ];
        }

        return response()->json([
          'products' => $products,
          'total' => $prods->total(),
          'per_page' => $prods->perPage(),
          'current_page' => $prods->currentPage(),
        ]);
      }

      // Regular AJAX request for category view
      $data['ajax_check'] = 1;
      return view('frontend.ajax.category', $data);
    }

    return view('frontend.products', $data);
  }


  public function getsubs(Request $request)
  {
    $category = Category::where('slug', $request->category)->firstOrFail();
    $subcategories = Subcategory::where('category_id', $category->id)->get();
    return $subcategories;
  }
  public function report(Request $request)
  {

    //--- Validation Section
    $rules = [
      'note' => 'max:400',
    ];
    $customs = [
      'note.max' => 'Note Must Be Less Than 400 Characters.',
    ];
    $validator = Validator::make($request->all(), $rules, $customs);
    if ($validator->fails()) {
      return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
    }
    //--- Validation Section Ends

    //--- Logic Section
    $data = new Report;
    $input = $request->all();
    $data->fill($input)->save();
    //--- Logic Section Ends

    //--- Redirect Section
    $msg = 'New Data Added Successfully.';
    return response()->json($msg);
    //--- Redirect Section Ends

  }
}
