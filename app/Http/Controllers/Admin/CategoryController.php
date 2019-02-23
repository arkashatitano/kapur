<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'category');
    }

    public function index(Request $request)
    {
        $row = Category::select('*');

        if(isset($request->active))
            $row->where('category.is_show',$request->active);
        else $row->where('category.is_show','1');


        if(isset($request->category_name) && $request->category_name != ''){
            $row->where(function($query) use ($request){
                $query->where('category_name_ru','like','%' .$request->category_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.category.category',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Category();
        $row->category_image = '/default.jpg';

        return  view('admin.category.category-edit', [
            'title' => 'Добавить категорию',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.category.category-edit', [
                'title' => 'Добавить категорию',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $category = new Category();
        $category->category_name_ru = $request->category_name_ru;
        $category->category_name_en = $request->category_name_en;
        $category->category_name_kz = $request->category_name_kz;
        $category->sort_num = $request->sort_num?$request->sort_num:100;
        $category->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'category';
        $action->action_text_ru = 'добавил(а) категорию "' .$category->category_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $category->category_id;
        $action->save();

        return redirect('/admin/category');
    }

    public function edit($id)
    {
        $row = Category::find($id);

        return  view('admin.category.category-edit', [
            'title' => 'Редактировать данные категории',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'category_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.category.category-edit', [
                'title' => 'Редактировать данные категории',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $category = Category::find($id);
        $category->category_name_ru = $request->category_name_ru;
        $category->category_name_en = $request->category_name_en;
        $category->category_name_kz = $request->category_name_kz;
        $category->sort_num = $request->sort_num?$request->sort_num:100;
        $category->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'category';
        $action->action_text_ru = 'редактировал(а) данные категории "' .$category->category_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $category->category_id;
        $action->save();

        return redirect('/admin/category');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $old_name = $category->category_name_ru;

        $category->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'category';
        $action->action_text_ru = 'удалил(а) категорию "' .$category->category_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $category = Category::find($request->id);
        $category->is_show = $request->is_show;
        $category->save();

        $action = new Actions();
        $action->action_comment = 'category';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - категория "' .$category->category_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - категория "' .$category->category_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $category->category_id;
        $action->save();

    }

}
