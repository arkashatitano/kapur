<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Video;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'video');
        
    }

    public function index(Request $request)
    {
        $row = Video::orderBy('video.video_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(video.video_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('video.is_show',$request->active);
        else $row->where('video.is_show','1');

      
        if(isset($request->video_name) && $request->video_name != ''){
            $row->where(function($query) use ($request){
                $query->where('video_name_ru','like','%' .$request->video_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.video.video',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Video();
        $row->video_image = '/default.jpg';
        $row->video_date = date('d.m.Y H:i');

        return  view('admin.video.video-edit', [
            'title' => 'Добавить видео',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'video_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.video.video-edit', [
                'title' => 'Добавить видео',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $video = new Video();
        $video->video_name_ru = $request->video_name_ru;
        $video->tag_ru = $request->tag_ru;
        $video->video_text_ru = $request->video_text_ru;
        $video->video_meta_description_ru = $request->video_meta_description_ru;
        $video->video_meta_keywords_ru = $request->video_meta_keywords_ru;

        $video->video_name_kz = $request->video_name_kz;
        $video->tag_kz = $request->tag_kz;
        $video->video_text_kz = $request->video_text_kz;
        $video->video_meta_description_kz = $request->video_meta_description_kz;
        $video->video_meta_keywords_kz = $request->video_meta_keywords_kz;

        $video->video_name_en = $request->video_name_en;
        $video->tag_en = $request->tag_en;
        $video->video_text_en = $request->video_text_en;
        $video->video_meta_description_en = $request->video_meta_description_en;
        $video->video_meta_keywords_en = $request->video_meta_keywords_en;
        
        $video->video_image = $request->video_image;
        $video->video_url = $request->video_url;
        $video->user_id = Auth::user()->user_id;
        $video->is_show = 1;

        $timestamp = strtotime($request->video_date);
        $video->video_date = date("Y-m-d H:i", $timestamp);

        $video->save();

        $video->video_url_ru = '/video/'.$video->video_id.'-'.Helpers::getTranslatedSlugRu($video->video_name_ru);
        $video->video_url_kz = '/video/'.$video->video_id.'-'.Helpers::getTranslatedSlugRu($video->video_name_kz);
        $video->video_url_en = '/video/'.$video->video_id.'-'.Helpers::getTranslatedSlugRu($video->video_name_en);
        $video->save();
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'video';
        $action->action_text_ru = 'добавил(а) видео "' .$video->video_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $video->video_id;
        $action->save();
        
        return redirect('/admin/video');
    }

    public function edit($id)
    {
        $row = Video::find($id);

        return  view('admin.video.video-edit', [
            'title' => 'Редактировать данные видео',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'video_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.video.video-edit', [
                'title' => 'Редактировать данные видео',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $video = Video::find($id);

        $video->video_name_ru = $request->video_name_ru;
        $video->tag_ru = $request->tag_ru;
        $video->video_text_ru = $request->video_text_ru;
        $video->video_meta_description_ru = $request->video_meta_description_ru;
        $video->video_meta_keywords_ru = $request->video_meta_keywords_ru;

        $video->video_name_kz = $request->video_name_kz;
        $video->tag_kz = $request->tag_kz;
        $video->video_text_kz = $request->video_text_kz;
        $video->video_meta_description_kz = $request->video_meta_description_kz;
        $video->video_meta_keywords_kz = $request->video_meta_keywords_kz;

        $video->video_name_en = $request->video_name_en;
        $video->tag_en = $request->tag_en;
        $video->video_text_en = $request->video_text_en;
        $video->video_meta_description_en = $request->video_meta_description_en;
        $video->video_meta_keywords_en = $request->video_meta_keywords_en;

        $video->video_image = $request->video_image;
        $video->video_url = $request->video_url;

        $timestamp = strtotime($request->video_date);
        $video->video_date = date("Y-m-d H:i", $timestamp);

        $video->video_url_ru = '/video/'.$video->video_id.'-'.Helpers::getTranslatedSlugRu($video->video_name_ru);
        $video->video_url_kz = '/video/'.$video->video_id.'-'.Helpers::getTranslatedSlugRu($video->video_name_kz);
        $video->video_url_en = '/video/'.$video->video_id.'-'.Helpers::getTranslatedSlugRu($video->video_name_en);
        $video->save();
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'video';
        $action->action_text_ru = 'редактировал(а) данные видео "' .$video->video_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $video->video_id;
        $action->save();
        
        return redirect('/admin/video');
    }

    public function destroy($id)
    {
        $video = Video::find($id);

        $old_name = $video->video_name_ru;

        $video->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'video';
        $action->action_text_ru = 'удалил(а) видео "' .$video->video_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $video = Video::find($request->id);
        $video->is_show = $request->is_show;
        $video->save();

        $action = new Actions();
        $action->action_comment = 'video';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - видео "' .$video->video_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - видео "' .$video->video_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $video->video_id;
        $action->save();

    }
}
