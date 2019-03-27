<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'gallery');
        
    }

    public function index(Request $request)
    {
        $row = Gallery::orderBy('gallery.gallery_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(gallery.gallery_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('gallery.is_show',$request->active);
        else $row->where('gallery.is_show','1');

      
        if(isset($request->gallery_name) && $request->gallery_name != ''){
            $row->where(function($query) use ($request){
                $query->where('gallery_name_ru','like','%' .$request->gallery_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.gallery.gallery',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Gallery();
        $row->gallery_image = '/default.jpg';
        $row->gallery_date = date('d.m.Y H:i');

        return  view('admin.gallery.gallery-edit', [
            'title' => 'Добавить галерею',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'gallery_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.gallery.gallery-edit', [
                'title' => 'Добавить галерею',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $gallery = new Gallery();
        $gallery->gallery_name_ru = $request->gallery_name_ru;
        $gallery->gallery_desc_ru = $request->gallery_desc_ru;
        $gallery->gallery_text_ru = $request->gallery_text_ru;
        $gallery->gallery_meta_description_ru = $request->gallery_meta_description_ru;
        $gallery->gallery_meta_keywords_ru = $request->gallery_meta_keywords_ru;

        $gallery->gallery_name_kz = $request->gallery_name_kz;
        $gallery->gallery_desc_kz = $request->gallery_desc_kz;
        $gallery->gallery_text_kz = $request->gallery_text_kz;
        $gallery->gallery_meta_description_kz = $request->gallery_meta_description_kz;
        $gallery->gallery_meta_keywords_kz = $request->gallery_meta_keywords_kz;

        $gallery->gallery_name_en = $request->gallery_name_en;
        $gallery->gallery_desc_en = $request->gallery_desc_en;
        $gallery->gallery_text_en = $request->gallery_text_en;
        $gallery->gallery_meta_description_en = $request->gallery_meta_description_en;
        $gallery->gallery_meta_keywords_en = $request->gallery_meta_keywords_en;
        
        $gallery->gallery_image = $request->gallery_image;
      
        $gallery->user_id = Auth::user()->user_id;
        $gallery->is_show = 1;

        $timestamp = strtotime($request->gallery_date);
        $gallery->gallery_date = date("Y-m-d H:i", $timestamp);

        $gallery->save();

        $gallery->gallery_url_ru = '/gallery/'.$gallery->gallery_id.'-'.Helpers::getTranslatedSlugRu($gallery->gallery_name_ru);
        $gallery->gallery_url_kz = '/gallery/'.$gallery->gallery_id.'-'.Helpers::getTranslatedSlugRu($gallery->gallery_name_kz);
        $gallery->gallery_url_en = '/gallery/'.$gallery->gallery_id.'-'.Helpers::getTranslatedSlugRu($gallery->gallery_name_en);
        $gallery->save();

        $image_delete = \App\Models\Image::where('gallery_id',$gallery->gallery_id)->delete();

        if(isset($request->image_list)){
            foreach($request->image_list as $key => $item){
                $image = new \App\Models\Image();
                $image->image_url = $item;
                $image->gallery_id = $gallery->gallery_id;
                $image->save();
            }
        }

        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'gallery';
        $action->action_text_ru = 'добавил(а) галерею "' .$gallery->gallery_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $gallery->gallery_id;
        $action->save();
        
        return redirect('/admin/gallery');
    }

    public function edit($id)
    {
        $row = Gallery::where('gallery_id',$id)
            ->select('*',
                DB::raw('DATE_FORMAT(gallery.gallery_date,"%d.%m.%Y %H:%i") as gallery_date'))
            ->first();

        $images = \App\Models\Image::where('gallery_id',$id)->get();

        return  view('admin.gallery.gallery-edit', [
            'title' => 'Редактировать данные галерея',
            'row' => $row,
            'image' => $images
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'gallery_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            $images = \App\Models\Image::where('gallery_id',$id)->get();

            return  view('admin.gallery.gallery-edit', [
                'title' => 'Редактировать данные галерея',
                'row' => (object) $request->all(),
                'error' => $error[0],
                'image' => $images
            ]);
        }

        $gallery = Gallery::find($id);

        $gallery->gallery_name_ru = $request->gallery_name_ru;
        $gallery->gallery_desc_ru = $request->gallery_desc_ru;
        $gallery->gallery_text_ru = $request->gallery_text_ru;
        $gallery->gallery_meta_description_ru = $request->gallery_meta_description_ru;
        $gallery->gallery_meta_keywords_ru = $request->gallery_meta_keywords_ru;

        $gallery->gallery_name_kz = $request->gallery_name_kz;
        $gallery->gallery_desc_kz = $request->gallery_desc_kz;
        $gallery->gallery_text_kz = $request->gallery_text_kz;
        $gallery->gallery_meta_description_kz = $request->gallery_meta_description_kz;
        $gallery->gallery_meta_keywords_kz = $request->gallery_meta_keywords_kz;

        $gallery->gallery_name_en = $request->gallery_name_en;
        $gallery->gallery_desc_en = $request->gallery_desc_en;
        $gallery->gallery_text_en = $request->gallery_text_en;
        $gallery->gallery_meta_description_en = $request->gallery_meta_description_en;
        $gallery->gallery_meta_keywords_en = $request->gallery_meta_keywords_en;

        $gallery->gallery_image = $request->gallery_image;
        
        $timestamp = strtotime($request->gallery_date);
        $gallery->gallery_date = date("Y-m-d H:i", $timestamp);

        $gallery->gallery_url_ru = '/gallery/'.$gallery->gallery_id.'-'.Helpers::getTranslatedSlugRu($gallery->gallery_name_ru);
        $gallery->gallery_url_kz = '/gallery/'.$gallery->gallery_id.'-'.Helpers::getTranslatedSlugRu($gallery->gallery_name_kz);
        $gallery->gallery_url_en = '/gallery/'.$gallery->gallery_id.'-'.Helpers::getTranslatedSlugRu($gallery->gallery_name_en);
        $gallery->save();

        $image_delete = \App\Models\Image::where('gallery_id',$gallery->gallery_id)->delete();

        if(isset($request->image_list)){
            foreach($request->image_list as $key => $item){
                $image = new \App\Models\Image();
                $image->image_url = $item;
                $image->gallery_id = $gallery->gallery_id;
                $image->save();
            }
        }


        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'gallery';
        $action->action_text_ru = 'редактировал(а) данные галерея "' .$gallery->gallery_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $gallery->gallery_id;
        $action->save();
        
        return redirect('/admin/gallery');
    }

    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        $old_name = $gallery->gallery_name_ru;

        $gallery->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'gallery';
        $action->action_text_ru = 'удалил(а) галерею "' .$gallery->gallery_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $gallery = Gallery::find($request->id);
        $gallery->is_show = $request->is_show;
        $gallery->save();

        $action = new Actions();
        $action->action_comment = 'gallery';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - галерея "' .$gallery->gallery_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - галерея "' .$gallery->gallery_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $gallery->gallery_id;
        $action->save();

    }

    public function getImageList(Request $request){
        $image[0]['image_url'] = $request->image_url;
        return  view('admin.gallery.image-loop',[
            'image' => $image
        ]);
    }
}
