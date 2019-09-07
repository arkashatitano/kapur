<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Conference;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class ConferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'conference');
        
    }

    public function index(Request $request)
    {
        $row = Conference::orderBy('conference.conference_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(conference.conference_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('conference.is_show',$request->active);
        else $row->where('conference.is_show','1');

      
        if(isset($request->conference_name) && $request->conference_name != ''){
            $row->where(function($query) use ($request){
                $query->where('conference_name_ru','like','%' .$request->conference_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.conference.conference',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Conference();
        $row->conference_image = '/default.jpg';
        $row->conference_date = date('d.m.Y H:i');

        return  view('admin.conference.conference-edit', [
            'title' => 'Добавить конференцию',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'conference_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.conference.conference-edit', [
                'title' => 'Добавить конференцию',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $conference = new Conference();
        $conference->conference_name_ru = $request->conference_name_ru;
        $conference->conference_text_ru = $request->conference_text_ru;
        $conference->conference_meta_description_ru = $request->conference_meta_description_ru;
        $conference->conference_meta_keywords_ru = $request->conference_meta_keywords_ru;

        $conference->conference_name_kz = $request->conference_name_kz;
        $conference->conference_text_kz = $request->conference_text_kz;
        $conference->conference_meta_description_kz = $request->conference_meta_description_kz;
        $conference->conference_meta_keywords_kz = $request->conference_meta_keywords_kz;

        $conference->conference_name_en = $request->conference_name_en;
        $conference->conference_text_en = $request->conference_text_en;
        $conference->conference_meta_description_en = $request->conference_meta_description_en;
        $conference->conference_meta_keywords_en = $request->conference_meta_keywords_en;
        
        $conference->conference_image = $request->conference_image;
        $conference->conference_pdf = $request->conference_pdf;
        $conference->text_color = $request->text_color;
        $conference->user_id = Auth::user()->user_id;
        $conference->is_show = 1;

        $timestamp = strtotime($request->conference_date);
        $conference->conference_date = date("Y-m-d H:i", $timestamp);

        $conference->save();

        $conference->conference_url_ru = '/conference/'.$conference->conference_id.'-'.Helpers::getTranslatedSlugRu($conference->conference_name_ru);
        $conference->conference_url_kz = '/conference/'.$conference->conference_id.'-'.Helpers::getTranslatedSlugRu($conference->conference_name_kz);
        $conference->conference_url_en = '/conference/'.$conference->conference_id.'-'.Helpers::getTranslatedSlugRu($conference->conference_name_en);
        $conference->save();
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'conference';
        $action->action_text_ru = 'добавил(а) конференцию "' .$conference->conference_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $conference->conference_id;
        $action->save();
        
        return redirect('/admin/conference');
    }

    public function edit($id)
    {
        $row = Conference::where('conference_id',$id)
            ->select('*',
                DB::raw('DATE_FORMAT(conference.conference_date,"%d.%m.%Y %H:%i") as conference_date'))
            ->first();

        return  view('admin.conference.conference-edit', [
            'title' => 'Редактировать данные конференции',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'conference_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.conference.conference-edit', [
                'title' => 'Редактировать данные конференции',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $conference = Conference::find($id);

        $conference->conference_name_ru = $request->conference_name_ru;
        $conference->conference_text_ru = $request->conference_text_ru;
        $conference->conference_meta_description_ru = $request->conference_meta_description_ru;
        $conference->conference_meta_keywords_ru = $request->conference_meta_keywords_ru;

        $conference->conference_name_kz = $request->conference_name_kz;
        $conference->conference_text_kz = $request->conference_text_kz;
        $conference->conference_meta_description_kz = $request->conference_meta_description_kz;
        $conference->conference_meta_keywords_kz = $request->conference_meta_keywords_kz;

        $conference->conference_name_en = $request->conference_name_en;
        $conference->conference_text_en = $request->conference_text_en;
        $conference->conference_meta_description_en = $request->conference_meta_description_en;
        $conference->conference_meta_keywords_en = $request->conference_meta_keywords_en;

        $conference->conference_image = $request->conference_image;
        $conference->conference_pdf = $request->conference_pdf;

        $timestamp = strtotime($request->conference_date);
        $conference->conference_date = date("Y-m-d H:i", $timestamp);
        $conference->text_color = $request->text_color;

        $conference->conference_url_ru = '/conference/'.$conference->conference_id.'-'.Helpers::getTranslatedSlugRu($conference->conference_name_ru);
        $conference->conference_url_kz = '/conference/'.$conference->conference_id.'-'.Helpers::getTranslatedSlugRu($conference->conference_name_kz);
        $conference->conference_url_en = '/conference/'.$conference->conference_id.'-'.Helpers::getTranslatedSlugRu($conference->conference_name_en);
        $conference->save();
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'conference';
        $action->action_text_ru = 'редактировал(а) данные конференции "' .$conference->conference_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $conference->conference_id;
        $action->save();
        
        return redirect('/admin/conference');
    }

    public function destroy($id)
    {
        $conference = Conference::find($id);

        $old_name = $conference->conference_name_ru;

        $conference->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'conference';
        $action->action_text_ru = 'удалил(а) конференцию "' .$conference->conference_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $conference = Conference::find($request->id);
        $conference->is_show = $request->is_show;
        $conference->save();

        $action = new Actions();
        $action->action_comment = 'conference';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - конференция "' .$conference->conference_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - конференция "' .$conference->conference_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $conference->conference_id;
        $action->save();

    }

    public function getDocumentList(Request $request){
        $request->conference_pdf = $request->image_url;
        return  view('admin.conference.document-loop',[
            'row' => $request
        ]);
    }
}
