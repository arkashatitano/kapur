<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Magazine;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class MagazineController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'magazine');
        
    }

    public function index(Request $request)
    {
        $row = Magazine::orderBy('magazine.magazine_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(magazine.magazine_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('magazine.is_show',$request->active);
        else $row->where('magazine.is_show','1');

      
        if(isset($request->magazine_name) && $request->magazine_name != ''){
            $row->where(function($query) use ($request){
                $query->where('magazine_name_ru','like','%' .$request->magazine_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.magazine.magazine',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Magazine();
        $row->magazine_image = '/default.jpg';
        $row->magazine_date = date('d.m.Y H:i');

        return  view('admin.magazine.magazine-edit', [
            'title' => 'Добавить семинар',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'magazine_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.magazine.magazine-edit', [
                'title' => 'Добавить семинар',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $magazine = new Magazine();
        $magazine->magazine_name_ru = $request->magazine_name_ru;
        $magazine->magazine_desc_ru = $request->magazine_desc_ru;
        $magazine->magazine_text_ru = $request->magazine_text_ru;
        $magazine->magazine_meta_description_ru = $request->magazine_meta_description_ru;
        $magazine->magazine_meta_keywords_ru = $request->magazine_meta_keywords_ru;

        $magazine->magazine_name_kz = $request->magazine_name_kz;
        $magazine->magazine_desc_kz = $request->magazine_desc_kz;
        $magazine->magazine_text_kz = $request->magazine_text_kz;
        $magazine->magazine_meta_description_kz = $request->magazine_meta_description_kz;
        $magazine->magazine_meta_keywords_kz = $request->magazine_meta_keywords_kz;

        $magazine->magazine_name_en = $request->magazine_name_en;
        $magazine->magazine_desc_en = $request->magazine_desc_en;
        $magazine->magazine_text_en = $request->magazine_text_en;
        $magazine->magazine_meta_description_en = $request->magazine_meta_description_en;
        $magazine->magazine_meta_keywords_en = $request->magazine_meta_keywords_en;
        
        $magazine->magazine_image = $request->magazine_image;
        $magazine->magazine_number = $request->magazine_number;
        $magazine->magazine_pdf = $request->magazine_pdf;
        $magazine->magazine_price = $request->magazine_price?:0;
        $magazine->is_show_main = $request->is_show_main;
        $magazine->user_id = Auth::user()->user_id;
        $magazine->is_show = 1;

        $timestamp = strtotime($request->magazine_date);
        $magazine->magazine_date = date("Y-m-d H:i", $timestamp);

        $magazine->save();

        $magazine->magazine_url_ru = '/magazine/'.$magazine->magazine_id.'-'.Helpers::getTranslatedSlugRu($magazine->magazine_name_ru);
        $magazine->magazine_url_kz = '/magazine/'.$magazine->magazine_id.'-'.Helpers::getTranslatedSlugRu($magazine->magazine_name_kz);
        $magazine->magazine_url_en = '/magazine/'.$magazine->magazine_id.'-'.Helpers::getTranslatedSlugRu($magazine->magazine_name_en);
        $magazine->save();
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'magazine';
        $action->action_text_ru = 'добавил(а) семинар "' .$magazine->magazine_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $magazine->magazine_id;
        $action->save();
        
        return redirect('/admin/magazine');
    }

    public function edit($id)
    {
        $row = Magazine::find($id);

        return  view('admin.magazine.magazine-edit', [
            'title' => 'Редактировать данные семинара',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'magazine_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.magazine.magazine-edit', [
                'title' => 'Редактировать данные семинара',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $magazine = Magazine::find($id);

        $magazine->magazine_name_ru = $request->magazine_name_ru;
        $magazine->magazine_desc_ru = $request->magazine_desc_ru;
        $magazine->magazine_text_ru = $request->magazine_text_ru;
        $magazine->magazine_meta_description_ru = $request->magazine_meta_description_ru;
        $magazine->magazine_meta_keywords_ru = $request->magazine_meta_keywords_ru;

        $magazine->magazine_name_kz = $request->magazine_name_kz;
        $magazine->magazine_desc_kz = $request->magazine_desc_kz;
        $magazine->magazine_text_kz = $request->magazine_text_kz;
        $magazine->magazine_meta_description_kz = $request->magazine_meta_description_kz;
        $magazine->magazine_meta_keywords_kz = $request->magazine_meta_keywords_kz;

        $magazine->magazine_name_en = $request->magazine_name_en;
        $magazine->magazine_desc_en = $request->magazine_desc_en;
        $magazine->magazine_text_en = $request->magazine_text_en;
        $magazine->magazine_meta_description_en = $request->magazine_meta_description_en;
        $magazine->magazine_meta_keywords_en = $request->magazine_meta_keywords_en;

        $magazine->magazine_image = $request->magazine_image;
        $magazine->magazine_number = $request->magazine_number;
        $magazine->magazine_pdf = $request->magazine_pdf;
        $magazine->magazine_price = $request->magazine_price?:0;
        $magazine->is_show_main = $request->is_show_main;

        $timestamp = strtotime($request->magazine_date);
        $magazine->magazine_date = date("Y-m-d H:i", $timestamp);

        $magazine->magazine_url_ru = '/magazine/'.$magazine->magazine_id.'-'.Helpers::getTranslatedSlugRu($magazine->magazine_name_ru);
        $magazine->magazine_url_kz = '/magazine/'.$magazine->magazine_id.'-'.Helpers::getTranslatedSlugRu($magazine->magazine_name_kz);
        $magazine->magazine_url_en = '/magazine/'.$magazine->magazine_id.'-'.Helpers::getTranslatedSlugRu($magazine->magazine_name_en);
        $magazine->save();
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'magazine';
        $action->action_text_ru = 'редактировал(а) данные семинара "' .$magazine->magazine_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $magazine->magazine_id;
        $action->save();
        
        return redirect('/admin/magazine');
    }

    public function destroy($id)
    {
        $magazine = Magazine::find($id);

        $old_name = $magazine->magazine_name_ru;

        $magazine->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'magazine';
        $action->action_text_ru = 'удалил(а) семинар "' .$magazine->magazine_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $magazine = Magazine::find($request->id);
        $magazine->is_show = $request->is_show;
        $magazine->save();

        $action = new Actions();
        $action->action_comment = 'magazine';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - семинар "' .$magazine->magazine_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - семинар "' .$magazine->magazine_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $magazine->magazine_id;
        $action->save();

    }

    public function getDocumentList(Request $request){
        $request->magazine_pdf = $request->image_url;
        return  view('admin.magazine.document-loop',[
            'row' => $request
        ]);
    }
}
