<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Seminar;
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

class SeminarController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showSeminarList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/seminar')->first();
        if($menu == null) abort(404);
        
        $seminar_list = Seminar::where('seminar.is_show',1)
                                ->orderBy('seminar_date','desc')
                                ->where('seminar_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.seminar.seminar-list',
            [
                'menu' => $menu,
                'seminar_list' => $seminar_list
            ]);
    }

    public function showSeminarById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/seminar')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $seminar = Seminar::where('seminar.is_show',1)
                    ->where('seminar_name_'.$this->lang,'!=','')
                    ->where('seminar_id',$id)
                    ->first();

        if($seminar == null) abort(404);

        $original_url = $seminar['seminar_url_'.$this->lang];

        if($original_url != '/seminar/'.$url) return redirect($original_url,301);


        return view('index.seminar.seminar-detail',
            [
                'seminar' => $seminar,
                'menu' => $menu
            ]);
    }

}
