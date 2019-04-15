<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Exposition;
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

class ExpositionController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showExpositionList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/exposition')->first();
        if($menu == null) abort(404);
        
        $exposition_list = Exposition::where('exposition.is_show',1)
                                ->orderBy('exposition_date','desc')
                                ->where('exposition_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.exposition.exposition-list',
            [
                'menu' => $menu,
                'exposition_list' => $exposition_list
            ]);
    }

    public function showExpositionById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/exposition')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $exposition = Exposition::where('exposition.is_show',1)
                    ->where('exposition_name_'.$this->lang,'!=','')
                    ->where('exposition_id',$id)
                    ->first();

        if($exposition == null) abort(404);

        $original_url = $exposition['exposition_url_'.$this->lang];

        if($original_url != '/exposition/'.$url) return redirect($original_url,301);


        return view('index.exposition.exposition-detail',
            [
                'exposition' => $exposition,
                'menu' => $menu
            ]);
    }

}
