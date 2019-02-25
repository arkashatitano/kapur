<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Expert;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class ExpertController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'expert');
        
    }

    public function index(Request $request)
    {
        $row = Expert::orderBy('expert.sort_num','asc');

        if(isset($request->active))
            $row->where('expert.is_show',$request->active);
        else $row->where('expert.is_show','1');

      
        if(isset($request->expert_name) && $request->expert_name != ''){
            $row->where(function($query) use ($request){
                $query->where('expert_name_ru','like','%' .$request->expert_name .'%');
            });
        }

        if($request->seminar_id > 0){
            $row->where('seminar_id',$request->seminar_id);
        }

        $row = $row->paginate(20);

        return  view('admin.expert.expert',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Expert();
        
        return  view('admin.expert.expert-edit', [
            'title' => 'Добавить эксперта',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'expert_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.expert.expert-edit', [
                'title' => 'Добавить эксперта',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $expert = new Expert();
        $expert->expert_name_ru = $request->expert_name_ru;
        $expert->expert_text_ru = $request->expert_text_ru;
        
        $expert->expert_name_kz = $request->expert_name_kz;
        $expert->expert_text_kz = $request->expert_text_kz;
       
        $expert->expert_name_en = $request->expert_name_en;
        $expert->expert_text_en = $request->expert_text_en;
        
        $expert->expert_image = $request->expert_image;
        $expert->seminar_id = $request->seminar_id;
        $expert->sort_num = $request->sort_num?:100;
    
        $expert->is_show = 1;
        
        $expert->save();
        $expert->save();
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'expert';
        $action->action_text_ru = 'добавил(а) эксперта "' .$expert->expert_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $expert->expert_id;
        $action->save();
        
        return redirect('/admin/expert?seminar_id='.$request->seminar_id);
    }

    public function edit($id)
    {
        $row = Expert::find($id);

        return  view('admin.expert.expert-edit', [
            'title' => 'Редактировать данные эксперта',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'expert_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.expert.expert-edit', [
                'title' => 'Редактировать данные эксперта',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $expert = Expert::find($id);

        $expert->expert_name_ru = $request->expert_name_ru;
        $expert->expert_text_ru = $request->expert_text_ru;

        $expert->expert_name_kz = $request->expert_name_kz;
        $expert->expert_text_kz = $request->expert_text_kz;

        $expert->expert_name_en = $request->expert_name_en;
        $expert->expert_text_en = $request->expert_text_en;

        $expert->expert_image = $request->expert_image;
        $expert->seminar_id = $request->seminar_id;
        $expert->sort_num = $request->sort_num?:100;
        
        $expert->save();
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'expert';
        $action->action_text_ru = 'редактировал(а) данные эксперта "' .$expert->expert_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $expert->expert_id;
        $action->save();

        return redirect('/admin/expert?seminar_id='.$request->seminar_id);
    }

    public function destroy($id)
    {
        $expert = Expert::find($id);

        $old_name = $expert->expert_name_ru;

        $expert->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'expert';
        $action->action_text_ru = 'удалил(а) эксперта "' .$expert->expert_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $expert = Expert::find($request->id);
        $expert->is_show = $request->is_show;
        $expert->save();

        $action = new Actions();
        $action->action_comment = 'expert';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - эксперт "' .$expert->expert_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - эксперт "' .$expert->expert_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $expert->expert_id;
        $action->save();

    }
}
