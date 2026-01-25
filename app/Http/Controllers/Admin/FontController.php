<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Font;
use Illuminate\Http\Request;
use Validator;
use Datatables;

class FontController extends AdminBaseController
{
    public function datatables(){
        $datas = Font::orderBy('is_default', 'desc')
                    ->orderBy('language', 'asc')
                    ->orderBy('font_family', 'asc')
                    ->get();
        return Datatables::of($datas)
                            ->addColumn('font_name', function(Font $data){
                                $star = $data->is_default == 1 ? '<i class="fas fa-star" style="color: #ffc107; margin-right: 5px;"></i>' : '';
                                return $star . '<strong>' . $data->font_family . '</strong>';
                            })
                            ->addColumn('language_badge', function(Font $data){
                                $badges = [
                                    'ar' => '<span class="badge badge-info">Arabic</span>',
                                    'en' => '<span class="badge badge-success">English</span>',
                                    'both' => '<span class="badge badge-primary">Both</span>'
                                ];
                                return $badges[$data->language] ?? '<span class="badge badge-secondary">N/A</span>';
                            })
                            ->addColumn('preview', function(Font $data){
                                $text = $data->language == 'ar' ? 'مرحبا بك' : ($data->language == 'en' ? 'Welcome' : 'Hello مرحبا');
                                return '<span style="font-family: \'' . $data->font_family . '\', sans-serif; font-size: 18px;">' . $text . '</span>';
                            })
                            ->addColumn('action',function(Font $data){
                                $languageLabel = [
                                    'ar' => 'Arabic',
                                    'en' => 'English', 
                                    'both' => 'Both Languages'
                                ];
                                $langText = $languageLabel[$data->language] ?? 'N/A';
                                
                                $default = $data->is_default == 1 
                                    ? '<a style="color: #28a745;"><i class="fa fa-check"></i> Default for ' . $langText . '</a>' 
                                    : '<a class="status" data-href="'.route('admin.fonts.status',$data->id).'">Set as Default</a>';
                                    
                                return '<div class="action-list"><a data-href="' . route('admin.fonts.edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>'.__("Edit").'</a><a href="javascript:;" data-href="' . route('admin.fonts.delete',['id' => $data->id]) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a>'.$default.'</div>';
                            })
                            ->rawColumns(['font_name', 'language_badge', 'preview', 'action'])
                            ->toJson();
    }

    public function index(){
        return view('admin.fonts.index');
    }

    public function create(){
        return view('admin.fonts.create');
    }

    public function store(Request $request){
        //--- Validation Section
        $rules = [
            'font_family' => 'required',
            'language' => 'required|in:en,ar,both'
                ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        $data = new Font();
        $input = $request->all();
        $input['font_value'] = preg_replace('/\s+/', '+',$request->font_family);
        $input['is_default'] = 0;
        $data->fill($input)->save();
        
        // Clear font cache
        cache()->forget('default_font');
        cache()->forget('bilingual_fonts');
        cache()->forget('default_font_en');
        cache()->forget('default_font_ar');
        cache()->forget('default_font_both');

        //--- Redirect Section     
        $msg = __('Data Added Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends  
    }

    public function update(Request $request,$id){
        //--- Validation Section
        $rules = [
            'font_family' => 'required',
            'language' => 'required|in:en,ar,both'
                ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        $data = Font::find($id);
        $input = $request->all();
        $input['font_value'] = preg_replace('/\s+/', '+',$request->font_family);
        $input['is_default'] = 0;
        $data->update($input);
        
        // Clear font cache
        cache()->forget('default_font');
        cache()->forget('bilingual_fonts');
        cache()->forget('default_font_en');
        cache()->forget('default_font_ar');
        cache()->forget('default_font_both');

        //--- Redirect Section     
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends  
    }

    public function edit($id){
        $data = Font::findOrFail($id);
        return view('admin.fonts.edit',compact('data'));
    }

    public function status($id){
        $font_update = Font::find($id);
        $font_update->is_default = 1;
        $font_update->update();

        // Only reset fonts of the SAME language
        // This allows one default per language (ar, en, both)
        $previous_fonts = Font::where('id', '!=', $id)
            ->where('language', $font_update->language)
            ->get();

        foreach($previous_fonts as $previous_font){
            $previous_font->is_default = 0;
            $previous_font->update();
        }
        
        // Clear all font caches
        cache()->forget('default_font');
        cache()->forget('bilingual_fonts');
        cache()->forget('default_font_en');
        cache()->forget('default_font_ar');
        cache()->forget('default_font_both');
        
        //--- Redirect Section     
        $msg = __('Data Updated Successfully. You can now set default for other languages.');
        return response()->json($msg);      
        //--- Redirect Section Ends  
   }

   //*** GET Request Delete
   public function destroy($id)
   {

       if($id == 1)
       {
       return response()->json(__("You don't have access to remove this font."));
       }
       $data = Font::findOrFail($id);
       if($data->is_default == 1)
       {
       return response()->json(__("You can not remove default font."));            
       }
       $data->delete();
       //--- Redirect Section     
       $msg = __('Data Deleted Successfully.');
       return response()->json($msg);      
       //--- Redirect Section Ends     
   }
}
