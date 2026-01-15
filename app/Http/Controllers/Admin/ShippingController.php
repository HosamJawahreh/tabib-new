<?php

namespace App\Http\Controllers\Admin;

use App\{
    Models\Currency,
    Models\Shipping
};
use App\Helpers\PriceHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ShippingController extends AdminBaseController
{
    //*** JSON Request
    public function datatables()
    {
         $datas = Shipping::all();
         //--- Integrating This Collection Into Datatables
         return DataTables::of($datas)
                            ->editColumn('price', function(Shipping $data) {
                                $price = $data->price * $this->curr->value;
                                return PriceHelper::showAdminCurrencyPrice($price);
                            })
                            ->addColumn('action', function(Shipping $data) {
                                return '<div class="action-list"><a data-href="' . route('admin-shipping-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>'.__('Edit').'</a><a href="javascript:;" data-href="' . route('admin-shipping-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            })
                            ->rawColumns(['action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.shipping.index');
    }

    //*** GET Request
    public function create()
    {
        $sign = $this->curr;
        return view('admin.shipping.create',compact('sign'));
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'title' => 'required|unique:shippings',
            'subtitle' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ];
        $customs = [
            'title.required' => __('The title field is required.'),
            'title.unique' => __('This title has already been taken.'),
            'price.required' => __('The price field is required.'),
            'price.numeric' => __('The price must be a number.'),
        ];
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        try {
            $sign = $this->curr;
            if (!$sign || !isset($sign->value)) {
                Log::error('Currency sign not found in ShippingController store');
                return response()->json(['errors' => ['server' => 'Currency configuration error']], 422);
            }

            $data = new Shipping();
            $input = $request->only(['title', 'subtitle', 'price']);
            $signValue = (!empty($sign->value) && $sign->value != 0) ? $sign->value : 1;
            $input['price'] = ($input['price'] / $signValue);
            $data->fill($input)->save();
        } catch (\Exception $e) {
            Log::error('ShippingController store error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['errors' => ['server' => $e->getMessage()]], 422);
        }
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $sign = $this->curr;
        $data = Shipping::findOrFail($id);
        return view('admin.shipping.edit',compact('data','sign'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'title' => 'required|unique:shippings,title,'.$id,
            'subtitle' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ];
        $customs = [
            'title.required' => __('The title field is required.'),
            'title.unique' => __('This title has already been taken.'),
            'price.required' => __('The price field is required.'),
            'price.numeric' => __('The price must be a number.'),
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        try {
            $sign = $this->curr;
            if (!$sign || !isset($sign->value)) {
                Log::error('Currency sign not found in ShippingController update');
                return response()->json(['errors' => ['server' => 'Currency configuration error']], 422);
            }

            $data = Shipping::findOrFail($id);
            $input = $request->only(['title', 'subtitle', 'price']);
            $signValue = (!empty($sign->value) && $sign->value != 0) ? $sign->value : 1;
            $input['price'] = ($input['price'] / $signValue);
            $data->update($input);
        } catch (\Exception $e) {
            Log::error('ShippingController update error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['errors' => ['server' => $e->getMessage()]], 422);
        }
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Shipping::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
