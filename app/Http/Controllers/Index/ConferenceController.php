<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Conference;
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

class ConferenceController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showConferenceList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/conference')->first();
        if($menu == null) abort(404);
        
        $conference_list = Conference::where('conference.is_show',1)
                                ->orderBy('conference_date','desc')
                                ->where('conference_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.conference.conference-list',
            [
                'menu' => $menu,
                'conference_list' => $conference_list
            ]);
    }

    public function showConferenceById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/conference')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $conference = Conference::where('conference.is_show',1)
                    ->where('conference_name_'.$this->lang,'!=','')
                    ->where('conference_id',$id)
                    ->first();

        if($conference == null) abort(404);

        $original_url = $conference['conference_url_'.$this->lang];

        if($original_url != '/conference/'.$url) return redirect($original_url,301);


        return view('index.conference.conference-detail',
            [
                'conference' => $conference,
                'menu' => $menu
            ]);
    }

}
