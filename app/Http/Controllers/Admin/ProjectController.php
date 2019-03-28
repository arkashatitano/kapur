<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Project;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'project');
        
    }

    public function index(Request $request)
    {
        $row = Project::orderBy('project.project_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(project.project_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('project.is_show',$request->active);
        else $row->where('project.is_show','1');

      
        if(isset($request->project_name) && $request->project_name != ''){
            $row->where(function($query) use ($request){
                $query->where('project_name_ru','like','%' .$request->project_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.project.project',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Project();
        $row->project_image = '/default.jpg';
        $row->project_date = date('d.m.Y H:i');

        return  view('admin.project.project-edit', [
            'title' => 'Добавить проект',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'project_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.project.project-edit', [
                'title' => 'Добавить проект',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $project = new Project();
        $project->project_name_ru = $request->project_name_ru;
        $project->project_text_ru = $request->project_text_ru;
        $project->project_meta_description_ru = $request->project_meta_description_ru;
        $project->project_meta_keywords_ru = $request->project_meta_keywords_ru;

        $project->project_name_kz = $request->project_name_kz;
        $project->project_text_kz = $request->project_text_kz;
        $project->project_meta_description_kz = $request->project_meta_description_kz;
        $project->project_meta_keywords_kz = $request->project_meta_keywords_kz;

        $project->project_name_en = $request->project_name_en;
        $project->project_text_en = $request->project_text_en;
        $project->project_meta_description_en = $request->project_meta_description_en;
        $project->project_meta_keywords_en = $request->project_meta_keywords_en;
        
        $project->project_image = $request->project_image;
        $project->project_pdf = $request->project_pdf;
        $project->user_id = Auth::user()->user_id;
        $project->is_show = 1;

        $timestamp = strtotime($request->project_date);
        $project->project_date = date("Y-m-d H:i", $timestamp);

        $project->save();

        $project->project_url_ru = '/project/'.$project->project_id.'-'.Helpers::getTranslatedSlugRu($project->project_name_ru);
        $project->project_url_kz = '/project/'.$project->project_id.'-'.Helpers::getTranslatedSlugRu($project->project_name_kz);
        $project->project_url_en = '/project/'.$project->project_id.'-'.Helpers::getTranslatedSlugRu($project->project_name_en);
        $project->save();
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'project';
        $action->action_text_ru = 'добавил(а) проект "' .$project->project_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $project->project_id;
        $action->save();
        
        return redirect('/admin/project');
    }

    public function edit($id)
    {
        $row = Project::where('project_id',$id)
            ->select('*',
                DB::raw('DATE_FORMAT(project.project_date,"%d.%m.%Y %H:%i") as project_date'))
            ->first();

        return  view('admin.project.project-edit', [
            'title' => 'Редактировать данные проекта',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'project_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.project.project-edit', [
                'title' => 'Редактировать данные проекта',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $project = Project::find($id);

        $project->project_name_ru = $request->project_name_ru;
        $project->project_text_ru = $request->project_text_ru;
        $project->project_meta_description_ru = $request->project_meta_description_ru;
        $project->project_meta_keywords_ru = $request->project_meta_keywords_ru;

        $project->project_name_kz = $request->project_name_kz;
        $project->project_text_kz = $request->project_text_kz;
        $project->project_meta_description_kz = $request->project_meta_description_kz;
        $project->project_meta_keywords_kz = $request->project_meta_keywords_kz;

        $project->project_name_en = $request->project_name_en;
        $project->project_text_en = $request->project_text_en;
        $project->project_meta_description_en = $request->project_meta_description_en;
        $project->project_meta_keywords_en = $request->project_meta_keywords_en;

        $project->project_image = $request->project_image;
        $project->project_pdf = $request->project_pdf;

        $timestamp = strtotime($request->project_date);
        $project->project_date = date("Y-m-d H:i", $timestamp);

        $project->project_url_ru = '/project/'.$project->project_id.'-'.Helpers::getTranslatedSlugRu($project->project_name_ru);
        $project->project_url_kz = '/project/'.$project->project_id.'-'.Helpers::getTranslatedSlugRu($project->project_name_kz);
        $project->project_url_en = '/project/'.$project->project_id.'-'.Helpers::getTranslatedSlugRu($project->project_name_en);
        $project->save();
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'project';
        $action->action_text_ru = 'редактировал(а) данные проекта "' .$project->project_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $project->project_id;
        $action->save();
        
        return redirect('/admin/project');
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        $old_name = $project->project_name_ru;

        $project->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'project';
        $action->action_text_ru = 'удалил(а) проект "' .$project->project_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $project = Project::find($request->id);
        $project->is_show = $request->is_show;
        $project->save();

        $action = new Actions();
        $action->action_comment = 'project';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - проект "' .$project->project_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - проект "' .$project->project_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $project->project_id;
        $action->save();

    }

    public function getDocumentList(Request $request){
        $request->project_pdf = $request->image_url;
        return  view('admin.project.document-loop',[
            'row' => $request
        ]);
    }
}
