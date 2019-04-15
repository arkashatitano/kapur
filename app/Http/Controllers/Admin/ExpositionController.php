<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Exposition;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class ExpositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'exposition');
        
    }

    public function index(Request $request)
    {
        $row = Exposition::orderBy('exposition.exposition_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(exposition.exposition_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('exposition.is_show',$request->active);
        else $row->where('exposition.is_show','1');

      
        if(isset($request->exposition_name) && $request->exposition_name != ''){
            $row->where(function($query) use ($request){
                $query->where('exposition_name_ru','like','%' .$request->exposition_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.exposition.exposition',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Exposition();
        $row->exposition_image = '/default.jpg';
        $row->exposition_date = date('d.m.Y H:i');

        return  view('admin.exposition.exposition-edit', [
            'title' => 'Добавить проект',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'exposition_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.exposition.exposition-edit', [
                'title' => 'Добавить проект',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $exposition = new Exposition();
        $exposition->exposition_name_ru = $request->exposition_name_ru;
        $exposition->exposition_text_ru = $request->exposition_text_ru;
        $exposition->exposition_meta_description_ru = $request->exposition_meta_description_ru;
        $exposition->exposition_meta_keywords_ru = $request->exposition_meta_keywords_ru;

        $exposition->exposition_name_kz = $request->exposition_name_kz;
        $exposition->exposition_text_kz = $request->exposition_text_kz;
        $exposition->exposition_meta_description_kz = $request->exposition_meta_description_kz;
        $exposition->exposition_meta_keywords_kz = $request->exposition_meta_keywords_kz;

        $exposition->exposition_name_en = $request->exposition_name_en;
        $exposition->exposition_text_en = $request->exposition_text_en;
        $exposition->exposition_meta_description_en = $request->exposition_meta_description_en;
        $exposition->exposition_meta_keywords_en = $request->exposition_meta_keywords_en;
        
        $exposition->exposition_image = $request->exposition_image;
        $exposition->exposition_pdf = $request->exposition_pdf;
        $exposition->user_id = Auth::user()->user_id;
        $exposition->is_show = 1;

        $timestamp = strtotime($request->exposition_date);
        $exposition->exposition_date = date("Y-m-d H:i", $timestamp);

        $exposition->save();

        $exposition->exposition_url_ru = '/exposition/'.$exposition->exposition_id.'-'.Helpers::getTranslatedSlugRu($exposition->exposition_name_ru);
        $exposition->exposition_url_kz = '/exposition/'.$exposition->exposition_id.'-'.Helpers::getTranslatedSlugRu($exposition->exposition_name_kz);
        $exposition->exposition_url_en = '/exposition/'.$exposition->exposition_id.'-'.Helpers::getTranslatedSlugRu($exposition->exposition_name_en);
        $exposition->save();
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'exposition';
        $action->action_text_ru = 'добавил(а) проект "' .$exposition->exposition_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $exposition->exposition_id;
        $action->save();
        
        return redirect('/admin/exposition');
    }

    public function edit($id)
    {
        $row = Exposition::where('exposition_id',$id)
            ->select('*',
                DB::raw('DATE_FORMAT(exposition.exposition_date,"%d.%m.%Y %H:%i") as exposition_date'))
            ->first();

        return  view('admin.exposition.exposition-edit', [
            'title' => 'Редактировать данные проекта',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'exposition_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.exposition.exposition-edit', [
                'title' => 'Редактировать данные проекта',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $exposition = Exposition::find($id);

        $exposition->exposition_name_ru = $request->exposition_name_ru;
        $exposition->exposition_text_ru = $request->exposition_text_ru;
        $exposition->exposition_meta_description_ru = $request->exposition_meta_description_ru;
        $exposition->exposition_meta_keywords_ru = $request->exposition_meta_keywords_ru;

        $exposition->exposition_name_kz = $request->exposition_name_kz;
        $exposition->exposition_text_kz = $request->exposition_text_kz;
        $exposition->exposition_meta_description_kz = $request->exposition_meta_description_kz;
        $exposition->exposition_meta_keywords_kz = $request->exposition_meta_keywords_kz;

        $exposition->exposition_name_en = $request->exposition_name_en;
        $exposition->exposition_text_en = $request->exposition_text_en;
        $exposition->exposition_meta_description_en = $request->exposition_meta_description_en;
        $exposition->exposition_meta_keywords_en = $request->exposition_meta_keywords_en;

        $exposition->exposition_image = $request->exposition_image;
        $exposition->exposition_pdf = $request->exposition_pdf;

        $timestamp = strtotime($request->exposition_date);
        $exposition->exposition_date = date("Y-m-d H:i", $timestamp);

        $exposition->exposition_url_ru = '/exposition/'.$exposition->exposition_id.'-'.Helpers::getTranslatedSlugRu($exposition->exposition_name_ru);
        $exposition->exposition_url_kz = '/exposition/'.$exposition->exposition_id.'-'.Helpers::getTranslatedSlugRu($exposition->exposition_name_kz);
        $exposition->exposition_url_en = '/exposition/'.$exposition->exposition_id.'-'.Helpers::getTranslatedSlugRu($exposition->exposition_name_en);
        $exposition->save();
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'exposition';
        $action->action_text_ru = 'редактировал(а) данные проекта "' .$exposition->exposition_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $exposition->exposition_id;
        $action->save();
        
        return redirect('/admin/exposition');
    }

    public function destroy($id)
    {
        $exposition = Exposition::find($id);

        $old_name = $exposition->exposition_name_ru;

        $exposition->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'exposition';
        $action->action_text_ru = 'удалил(а) проект "' .$exposition->exposition_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $exposition = Exposition::find($request->id);
        $exposition->is_show = $request->is_show;
        $exposition->save();

        $action = new Actions();
        $action->action_comment = 'exposition';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - проект "' .$exposition->exposition_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - проект "' .$exposition->exposition_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $exposition->exposition_id;
        $action->save();

    }

    public function getDocumentList(Request $request){
        $request->exposition_pdf = $request->image_url;
        return  view('admin.exposition.document-loop',[
            'row' => $request
        ]);
    }
}
