<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\File;
use App\Models\Seminar;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class SeminarController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'seminar');
        
    }

    public function index(Request $request)
    {
        $row = Seminar::orderBy('seminar.seminar_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(seminar.seminar_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('seminar.is_show',$request->active);
        else $row->where('seminar.is_show','1');

      
        if(isset($request->seminar_name) && $request->seminar_name != ''){
            $row->where(function($query) use ($request){
                $query->where('seminar_name_ru','like','%' .$request->seminar_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.seminar.seminar',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Seminar();
        $row->seminar_image = '/default.jpg';
        $row->seminar_date = date('d.m.Y H:i');

        return  view('admin.seminar.seminar-edit', [
            'title' => 'Добавить семинар',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'seminar_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.seminar.seminar-edit', [
                'title' => 'Добавить семинар',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $seminar = new Seminar();
        $seminar->seminar_name_ru = $request->seminar_name_ru;
        $seminar->seminar_desc_ru = $request->seminar_desc_ru;
        $seminar->seminar_text_ru = $request->seminar_text_ru;
        $seminar->seminar_meta_description_ru = $request->seminar_meta_description_ru;
        $seminar->seminar_meta_keywords_ru = $request->seminar_meta_keywords_ru;

        $seminar->seminar_name_kz = $request->seminar_name_kz;
        $seminar->seminar_desc_kz = $request->seminar_desc_kz;
        $seminar->seminar_text_kz = $request->seminar_text_kz;
        $seminar->seminar_meta_description_kz = $request->seminar_meta_description_kz;
        $seminar->seminar_meta_keywords_kz = $request->seminar_meta_keywords_kz;

        $seminar->seminar_name_en = $request->seminar_name_en;
        $seminar->seminar_desc_en = $request->seminar_desc_en;
        $seminar->seminar_text_en = $request->seminar_text_en;
        $seminar->seminar_meta_description_en = $request->seminar_meta_description_en;
        $seminar->seminar_meta_keywords_en = $request->seminar_meta_keywords_en;
        
        $seminar->seminar_image = $request->seminar_image;
        $seminar->user_id = Auth::user()->user_id;
        $seminar->is_show = 1;

        $timestamp = strtotime($request->seminar_date);
        $seminar->seminar_date = date("Y-m-d H:i", $timestamp);

        $seminar->save();

        $seminar->seminar_url_ru = '/seminar/'.$seminar->seminar_id.'-'.Helpers::getTranslatedSlugRu($seminar->seminar_name_ru);
        $seminar->seminar_url_kz = '/seminar/'.$seminar->seminar_id.'-'.Helpers::getTranslatedSlugRu($seminar->seminar_name_kz);
        $seminar->seminar_url_en = '/seminar/'.$seminar->seminar_id.'-'.Helpers::getTranslatedSlugRu($seminar->seminar_name_en);
        $seminar->save();

        File::where('seminar_id',$seminar->seminar_id)->delete();
        if(isset($request['file_url_input'])){
            foreach($request['file_url_input'] as $key => $item){
                $file = new File();
                $file->file_name_ru = $request['file_multiple_name_ru'][$key];
                $file->file_url = $request['file_url_input'][$key];
                $file->is_show = $request['file_multiple_is_show'][$key];
                $file->seminar_id = $seminar->seminar_id;
                $file->save();
            }
        }
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'seminar';
        $action->action_text_ru = 'добавил(а) семинар "' .$seminar->seminar_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $seminar->seminar_id;
        $action->save();
        
        return redirect('/admin/seminar');
    }

    public function edit($id)
    {
        $row = Seminar::where('seminar_id',$id)
            ->select('*',
                DB::raw('DATE_FORMAT(seminar.seminar_date,"%d.%m.%Y %H:%i") as seminar_date'))
            ->first();

        $document_list = File::where('seminar_id',$id)->orderBy('file_id','asc')->get();
        
        return  view('admin.seminar.seminar-edit', [
            'title' => 'Редактировать данные семинара',
            'row' => $row,
            'document_list' => $document_list
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'seminar_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $document_list = File::where('seminar_id',$id)->orderBy('file_id','asc')->get();
            
            return  view('admin.seminar.seminar-edit', [
                'title' => 'Редактировать данные семинара',
                'row' => (object) $request->all(),
                'error' => $error[0],
                'document_list' => $document_list
            ]);
        }

        $seminar = Seminar::find($id);

        $seminar->seminar_name_ru = $request->seminar_name_ru;
        $seminar->seminar_desc_ru = $request->seminar_desc_ru;
        $seminar->seminar_text_ru = $request->seminar_text_ru;
        $seminar->seminar_meta_description_ru = $request->seminar_meta_description_ru;
        $seminar->seminar_meta_keywords_ru = $request->seminar_meta_keywords_ru;

        $seminar->seminar_name_kz = $request->seminar_name_kz;
        $seminar->seminar_desc_kz = $request->seminar_desc_kz;
        $seminar->seminar_text_kz = $request->seminar_text_kz;
        $seminar->seminar_meta_description_kz = $request->seminar_meta_description_kz;
        $seminar->seminar_meta_keywords_kz = $request->seminar_meta_keywords_kz;

        $seminar->seminar_name_en = $request->seminar_name_en;
        $seminar->seminar_desc_en = $request->seminar_desc_en;
        $seminar->seminar_text_en = $request->seminar_text_en;
        $seminar->seminar_meta_description_en = $request->seminar_meta_description_en;
        $seminar->seminar_meta_keywords_en = $request->seminar_meta_keywords_en;

        $seminar->seminar_image = $request->seminar_image;

        $timestamp = strtotime($request->seminar_date);
        $seminar->seminar_date = date("Y-m-d H:i", $timestamp);

        $seminar->seminar_url_ru = '/seminar/'.$seminar->seminar_id.'-'.Helpers::getTranslatedSlugRu($seminar->seminar_name_ru);
        $seminar->seminar_url_kz = '/seminar/'.$seminar->seminar_id.'-'.Helpers::getTranslatedSlugRu($seminar->seminar_name_kz);
        $seminar->seminar_url_en = '/seminar/'.$seminar->seminar_id.'-'.Helpers::getTranslatedSlugRu($seminar->seminar_name_en);
        $seminar->save();

        File::where('seminar_id',$seminar->seminar_id)->delete();
        if(isset($request['file_url_input'])){
            foreach($request['file_url_input'] as $key => $item){
                $file = new File();
                $file->file_name_ru = $request['file_multiple_name_ru'][$key];
                $file->file_url = $request['file_url_input'][$key];
                $file->is_show = $request['file_multiple_is_show'][$key];
                $file->seminar_id = $seminar->seminar_id;
                $file->save();
            }
        }
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'seminar';
        $action->action_text_ru = 'редактировал(а) данные семинара "' .$seminar->seminar_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $seminar->seminar_id;
        $action->save();
        
        return redirect('/admin/seminar');
    }

    public function destroy($id)
    {
        $seminar = Seminar::find($id);

        $old_name = $seminar->seminar_name_ru;

        $seminar->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'seminar';
        $action->action_text_ru = 'удалил(а) семинар "' .$seminar->seminar_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $seminar = Seminar::find($request->id);
        $seminar->is_show = $request->is_show;
        $seminar->save();

        $action = new Actions();
        $action->action_comment = 'seminar';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - семинар "' .$seminar->seminar_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - семинар "' .$seminar->seminar_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $seminar->seminar_id;
        $action->save();

    }
}
