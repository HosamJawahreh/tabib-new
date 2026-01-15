<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use Datatables;
use Illuminate\Http\Request;

class SubscriberController extends AdminBaseController
{
    //*** JSON Request
    public function datatables()
    {
        $datas = Subscriber::oldest('id')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('sl', function (Subscriber $data) {
                $id = 1;
                return $id++;
            })
            ->addColumn('action', function (Subscriber $data) {
                return '<div class="action-list"><a href="javascript:;" data-href="' . route('admin-subs-delete', ['id' => $data->id]) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['sl', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.subscribers.index');
    }

    //*** GET Request
    public function download()
    {
        //  Code for generating csv file
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=subscribers.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Subscribers Emails'));
        $result = Subscriber::all();
        foreach ($result as $row) {
            fputcsv($output, $row->toArray());
        }
        fclose($output);
    }

    public function delete(Request $request, $id)
    {

        $data = Subscriber::findOrFail($id);
        $data->delete();
        return response()->json('Deleted Successfully.');
    }
}
