<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\File;
use App\Models\Publication;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class PublicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'publication');

        $categories = Category::where('is_show',1)->orderBy('sort_num','asc')->get();
        View::share('categories', $categories);
        
    }

    public function index(Request $request)
    {
        $row = Publication::orderBy('publication.publication_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(publication.publication_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('publication.is_show',$request->active);
        else $row->where('publication.is_show','1');

      
        if(isset($request->publication_name) && $request->publication_name != ''){
            $row->where(function($query) use ($request){
                $query->where('publication_name_ru','like','%' .$request->publication_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.publication.publication',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Publication();
        $row->publication_image = '/default.jpg';
        $row->publication_date = date('d.m.Y H:i');
        $row->publication_price = 0;

        return  view('admin.publication.publication-edit', [
            'title' => 'Добавить статью',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'publication_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.publication.publication-edit', [
                'title' => 'Добавить статью',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $publication = new Publication();
        $publication->publication_name_ru = $request->publication_name_ru;
        $publication->tag_ru = $request->tag_ru;
        $publication->publication_text_ru = $request->publication_text_ru;
        $publication->publication_meta_description_ru = $request->publication_meta_description_ru;
        $publication->publication_meta_keywords_ru = $request->publication_meta_keywords_ru;

        $publication->publication_name_kz = $request->publication_name_kz;
        $publication->tag_kz = $request->tag_kz;
        $publication->publication_text_kz = $request->publication_text_kz;
        $publication->publication_meta_description_kz = $request->publication_meta_description_kz;
        $publication->publication_meta_keywords_kz = $request->publication_meta_keywords_kz;

        $publication->publication_name_en = $request->publication_name_en;
        $publication->tag_en = $request->tag_en;
        $publication->publication_text_en = $request->publication_text_en;
        $publication->publication_meta_description_en = $request->publication_meta_description_en;
        $publication->publication_meta_keywords_en = $request->publication_meta_keywords_en;
        
        $publication->publication_image = $request->publication_image;
        $publication->publication_price = $request->publication_price?:0;
        $publication->category_id = $request->category_id;
        $publication->user_id = Auth::user()->user_id;
        $publication->is_show = 1;

        $timestamp = strtotime($request->publication_date);
        $publication->publication_date = date("Y-m-d H:i", $timestamp);
        $publication->text_color = $request->text_color;
        $publication->save();

        $publication->publication_url_ru = '/article/'.$publication->publication_id.'-'.Helpers::getTranslatedSlugRu($publication->publication_name_ru);
        $publication->publication_url_kz = '/article/'.$publication->publication_id.'-'.Helpers::getTranslatedSlugRu($publication->publication_name_kz);
        $publication->publication_url_en = '/article/'.$publication->publication_id.'-'.Helpers::getTranslatedSlugRu($publication->publication_name_en);
        $publication->save();

        File::where('publication_id',$publication->publication_id)->delete();
        if(isset($request['file_url_input'])){
            foreach($request['file_url_input'] as $key => $item){
                $file = new File();
                $file->file_name_ru = $request['file_multiple_name_ru'][$key];
                $file->file_url = $request['file_url_input'][$key];
                $file->is_show = $request['file_multiple_is_show'][$key];
                $file->publication_id = $publication->publication_id;
                $file->save();
            }
        }

        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'publication';
        $action->action_text_ru = 'добавил(а) статьи "' .$publication->publication_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $publication->publication_id;
        $action->save();
        
        return redirect('/admin/publication');
    }

    public function edit($id)
    {
        $row = Publication::where('publication_id',$id)
            ->select('*',
                DB::raw('DATE_FORMAT(publication.publication_date,"%d.%m.%Y %H:%i") as publication_date'))
            ->first();

        $document_list = File::where('publication_id',$id)->orderBy('file_id','asc')->get();

        return  view('admin.publication.publication-edit', [
            'title' => 'Редактировать данные статьи',
            'row' => $row,
            'document_list' => $document_list
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'publication_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $document_list = File::where('publication_id',$id)->orderBy('file_id','asc')->get();

            return  view('admin.publication.publication-edit', [
                'title' => 'Редактировать данные статьи',
                'row' => (object) $request->all(),
                'document_list' => $document_list,
                'error' => $error[0]
            ]);
        }

        $publication = Publication::find($id);

        $publication->publication_name_ru = $request->publication_name_ru;
        $publication->tag_ru = $request->tag_ru;
        $publication->publication_text_ru = $request->publication_text_ru;
        $publication->publication_meta_description_ru = $request->publication_meta_description_ru;
        $publication->publication_meta_keywords_ru = $request->publication_meta_keywords_ru;

        $publication->publication_name_kz = $request->publication_name_kz;
        $publication->tag_kz = $request->tag_kz;
        $publication->publication_text_kz = $request->publication_text_kz;
        $publication->publication_meta_description_kz = $request->publication_meta_description_kz;
        $publication->publication_meta_keywords_kz = $request->publication_meta_keywords_kz;

        $publication->publication_name_en = $request->publication_name_en;
        $publication->tag_en = $request->tag_en;
        $publication->publication_text_en = $request->publication_text_en;
        $publication->publication_meta_description_en = $request->publication_meta_description_en;
        $publication->publication_meta_keywords_en = $request->publication_meta_keywords_en;

        $publication->publication_image = $request->publication_image;
        $publication->publication_price = $request->publication_price?:0;
        $publication->category_id = $request->category_id;
        
        $timestamp = strtotime($request->publication_date);
        $publication->publication_date = date("Y-m-d H:i", $timestamp);
        $publication->text_color = $request->text_color;
        $publication->publication_url_ru = '/article/'.$publication->publication_id.'-'.Helpers::getTranslatedSlugRu($publication->publication_name_ru);
        $publication->publication_url_kz = '/article/'.$publication->publication_id.'-'.Helpers::getTranslatedSlugRu($publication->publication_name_kz);
        $publication->publication_url_en = '/article/'.$publication->publication_id.'-'.Helpers::getTranslatedSlugRu($publication->publication_name_en);
        $publication->save();

        File::where('publication_id',$publication->publication_id)->delete();
        if(isset($request['file_url_input'])){
            foreach($request['file_url_input'] as $key => $item){
                $file = new File();
                $file->file_name_ru = $request['file_multiple_name_ru'][$key];
                $file->file_url = $request['file_url_input'][$key];
                $file->is_show = $request['file_multiple_is_show'][$key];
                $file->publication_id = $publication->publication_id;
                $file->save();
            }
        }

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'publication';
        $action->action_text_ru = 'редактировал(а) данные статьи "' .$publication->publication_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $publication->publication_id;
        $action->save();
        
        return redirect('/admin/publication');
    }

    public function destroy($id)
    {
        $publication = Publication::find($id);

        $old_name = $publication->publication_name_ru;

        $publication->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'publication';
        $action->action_text_ru = 'удалил(а) статьи "' .$publication->publication_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $publication = Publication::find($request->id);
        $publication->is_show = $request->is_show;
        $publication->save();

        $action = new Actions();
        $action->action_comment = 'publication';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - статьи "' .$publication->publication_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - статьи "' .$publication->publication_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $publication->publication_id;
        $action->save();

    }
}
