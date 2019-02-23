<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'slider');
    }

    public function index(Request $request)
    {
        $row = Slider::select('*');

        if(isset($request->active))
            $row->where('slider.is_show',$request->active);
        else $row->where('slider.is_show','1');


        if(isset($request->slider_name) && $request->slider_name != ''){
            $row->where(function($query) use ($request){
                $query->where('slider_name_ru','like','%' .$request->slider_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.slider.slider',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Slider();
        $row->slider_image = '/default.jpg';

        return  view('admin.slider.slider-edit', [
            'title' => 'Добавить фото',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slider_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.slider.slider-edit', [
                'title' => 'Добавить фото',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $slider = new Slider();
        $slider->slider_name_ru = $request->slider_name_ru;
        $slider->slider_name_en = $request->slider_name_en;
        $slider->slider_name_kz = $request->slider_name_kz;
        $slider->slider_text_ru = $request->slider_text_ru;
        $slider->slider_text_en = $request->slider_text_en;
        $slider->slider_text_kz = $request->slider_text_kz;
        $slider->slider_redirect = $request->slider_redirect;
        $slider->slider_image = $request->slider_image;
        $slider->sort_num = $request->sort_num?$request->sort_num:100;
        $slider->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'slider';
        $action->action_text_ru = 'добавил(а) фото "' .$slider->slider_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $slider->slider_id;
        $action->save();

        return redirect('/admin/slider');
    }

    public function edit($id)
    {
        $row = Slider::find($id);

        return  view('admin.slider.slider-edit', [
            'title' => 'Редактировать данные фото',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'slider_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.slider.slider-edit', [
                'title' => 'Редактировать данные фото',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $slider = Slider::find($id);
        $slider->slider_name_ru = $request->slider_name_ru;
        $slider->slider_name_en = $request->slider_name_en;
        $slider->slider_name_kz = $request->slider_name_kz;
        $slider->slider_text_ru = $request->slider_text_ru;
        $slider->slider_text_en = $request->slider_text_en;
        $slider->slider_text_kz = $request->slider_text_kz;
        $slider->slider_redirect = $request->slider_redirect;
        $slider->slider_image = $request->slider_image;
        $slider->sort_num = $request->sort_num?$request->sort_num:100;
        $slider->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'slider';
        $action->action_text_ru = 'редактировал(а) данные фото "' .$slider->slider_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $slider->slider_id;
        $action->save();

        return redirect('/admin/slider');
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);

        $old_name = $slider->slider_name_ru;

        $slider->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'slider';
        $action->action_text_ru = 'удалил(а) фото "' .$slider->slider_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $slider = Slider::find($request->id);
        $slider->is_show = $request->is_show;
        $slider->save();

        $action = new Actions();
        $action->action_comment = 'slider';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - партнер "' .$slider->slider_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - партнер "' .$slider->slider_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $slider->slider_id;
        $action->save();

    }

}
