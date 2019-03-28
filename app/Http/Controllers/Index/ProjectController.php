<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Project;
use App\Models\Product;
use App\Models\Rubric;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Auth;

class ProjectController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showProjectList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/project')->first();
        if($menu == null) abort(404);
        
        $project_list = Project::where('project.is_show',1)
                                ->orderBy('project_date','desc')
                                ->where('project_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.project.project-list',
            [
                'menu' => $menu,
                'project_list' => $project_list
            ]);
    }

    public function showProjectById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/project')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $project = Project::where('project.is_show',1)
                    ->where('project_name_'.$this->lang,'!=','')
                    ->where('project_id',$id)
                    ->first();

        if($project == null) abort(404);

        $original_url = $project['project_url_'.$this->lang];

        if($original_url != '/project/'.$url) return redirect($original_url,301);


        return view('index.project.project-detail',
            [
                'project' => $project,
                'menu' => $menu
            ]);
    }

}
