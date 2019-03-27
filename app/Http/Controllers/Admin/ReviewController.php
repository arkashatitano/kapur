<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Review;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'review');
        
    }

    public function index(Request $request)
    {
        $row = Review::orderBy('review.review_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(review.review_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('review.is_show',$request->active);
        else $row->where('review.is_show','1');

      
        if(isset($request->review_name) && $request->review_name != ''){
            $row->where(function($query) use ($request){
                $query->where('review_name_ru','like','%' .$request->review_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.review.review',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Review();
        $row->review_image = '/default.jpg';
        $row->review_date = date('d.m.Y H:i');

        return  view('admin.review.review-edit', [
            'title' => 'Добавить обзор',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'review_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.review.review-edit', [
                'title' => 'Добавить обзор',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $review = new Review();
        $review->review_name_ru = $request->review_name_ru;
        $review->review_text_ru = $request->review_text_ru;
        $review->review_meta_description_ru = $request->review_meta_description_ru;
        $review->review_meta_keywords_ru = $request->review_meta_keywords_ru;

        $review->review_name_kz = $request->review_name_kz;
        $review->review_text_kz = $request->review_text_kz;
        $review->review_meta_description_kz = $request->review_meta_description_kz;
        $review->review_meta_keywords_kz = $request->review_meta_keywords_kz;

        $review->review_name_en = $request->review_name_en;
        $review->review_text_en = $request->review_text_en;
        $review->review_meta_description_en = $request->review_meta_description_en;
        $review->review_meta_keywords_en = $request->review_meta_keywords_en;
        
        $review->review_image = $request->review_image;
        $review->review_pdf = $request->review_pdf;
        $review->user_id = Auth::user()->user_id;
        $review->is_show = 1;

        $timestamp = strtotime($request->review_date);
        $review->review_date = date("Y-m-d H:i", $timestamp);

        $review->save();

        $review->review_url_ru = '/review/'.$review->review_id.'-'.Helpers::getTranslatedSlugRu($review->review_name_ru);
        $review->review_url_kz = '/review/'.$review->review_id.'-'.Helpers::getTranslatedSlugRu($review->review_name_kz);
        $review->review_url_en = '/review/'.$review->review_id.'-'.Helpers::getTranslatedSlugRu($review->review_name_en);
        $review->save();
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'review';
        $action->action_text_ru = 'добавил(а) обзор "' .$review->review_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $review->review_id;
        $action->save();
        
        return redirect('/admin/review');
    }

    public function edit($id)
    {
        $row = Review::where('review_id',$id)
            ->select('*',
                DB::raw('DATE_FORMAT(review.review_date,"%d.%m.%Y %H:%i") as review_date'))
            ->first();

        return  view('admin.review.review-edit', [
            'title' => 'Редактировать данные обзора',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'review_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.review.review-edit', [
                'title' => 'Редактировать данные обзора',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $review = Review::find($id);

        $review->review_name_ru = $request->review_name_ru;
        $review->review_text_ru = $request->review_text_ru;
        $review->review_meta_description_ru = $request->review_meta_description_ru;
        $review->review_meta_keywords_ru = $request->review_meta_keywords_ru;

        $review->review_name_kz = $request->review_name_kz;
        $review->review_text_kz = $request->review_text_kz;
        $review->review_meta_description_kz = $request->review_meta_description_kz;
        $review->review_meta_keywords_kz = $request->review_meta_keywords_kz;

        $review->review_name_en = $request->review_name_en;
        $review->review_text_en = $request->review_text_en;
        $review->review_meta_description_en = $request->review_meta_description_en;
        $review->review_meta_keywords_en = $request->review_meta_keywords_en;

        $review->review_image = $request->review_image;
        $review->review_pdf = $request->review_pdf;

        $timestamp = strtotime($request->review_date);
        $review->review_date = date("Y-m-d H:i", $timestamp);

        $review->review_url_ru = '/review/'.$review->review_id.'-'.Helpers::getTranslatedSlugRu($review->review_name_ru);
        $review->review_url_kz = '/review/'.$review->review_id.'-'.Helpers::getTranslatedSlugRu($review->review_name_kz);
        $review->review_url_en = '/review/'.$review->review_id.'-'.Helpers::getTranslatedSlugRu($review->review_name_en);
        $review->save();
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'review';
        $action->action_text_ru = 'редактировал(а) данные обзора "' .$review->review_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $review->review_id;
        $action->save();
        
        return redirect('/admin/review');
    }

    public function destroy($id)
    {
        $review = Review::find($id);

        $old_name = $review->review_name_ru;

        $review->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'review';
        $action->action_text_ru = 'удалил(а) обзор "' .$review->review_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $review = Review::find($request->id);
        $review->is_show = $request->is_show;
        $review->save();

        $action = new Actions();
        $action->action_comment = 'review';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - обзор "' .$review->review_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - обзор "' .$review->review_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $review->review_id;
        $action->save();

    }

    public function getDocumentList(Request $request){
        $request->review_pdf = $request->image_url;
        return  view('admin.review.document-loop',[
            'row' => $request
        ]);
    }
}
