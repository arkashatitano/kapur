<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\Page;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Cookie;



class PageController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        
    }

    
    public function showPage(Request $request,$url)
    {
        $menu = Menu::leftJoin('menu as parent','parent.menu_id','=','menu.parent_id')
                            ->where('menu.is_show',1)
                            ->where('menu.menu_redirect','')
                            ->where(function($query) use ($url){
                                $query->where('menu.menu_url_ru',$url)
                                    ->orWhere('menu.menu_url_kz',$url)
                                    ->orWhere('menu.menu_url_en',$url);
                            })
                            ->select('menu.*',
                                'parent.menu_name_'.$this->lang .' as parent_name',
                                'parent.menu_url_'.$this->lang .' as parent_url',
                                'parent.menu_redirect as parent_redirect',
                                DB::raw('(SELECT count(*) FROM menu as child
                                          WHERE child.parent_id = menu.menu_id and child.deleted_at is null and child.is_show = 1) as child_count')
                            )
                            ->first();

        if($menu == null) {
           abort(404);
        }

        if($menu->child_count > 0){
            $child = Menu::where('is_show',1)->where('parent_id',$menu->menu_id)->orderBy('sort_num','asc')->first();
            if($child->menu_redirect != ''){
                return redirect($child->menu_redirect);
            }
            else {
                return redirect($child['menu_url_'.$this->lang]);
            }
        }

        $document_list = \App\Models\File::where('is_show',1)->orderBy('file_id','asc')->where('menu_id',$menu->menu_id)->get();

        return  view('index.page.page-detail',
            [
                'row' => $request,
                'document_list' => $document_list,
                'menu' => $menu
            ]);
    }
}
