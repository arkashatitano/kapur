<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Publication;
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

class PublicationController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showPublicationList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/articles')->first();
        if($menu == null) abort(404);

        $publication_list = Publication::where('publication.is_show',1)
            ->orderBy('publication_date','desc')
            ->where('publication_name_'.$this->lang,'!=','');

        if($request->category > 0){
            $publication_list->where('category_id',$request->category);
        }

        $publication_list = $publication_list->paginate(10);

        $category_list = Category::where('is_show',1)->orderBy('sort_num','asc')->get();

        return  view('index.publication.publication-list',
            [
                'menu' => $menu,
                'publication_list' => $publication_list,
                'category_list' => $category_list
            ]);
    }

    public function showPublicationById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/articles')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);

        $publication = Publication::where('publication.is_show',1)
            ->where('publication_name_'.$this->lang,'!=','')
            ->where('publication_id',$id)
            ->first();

        if($publication == null) abort(404);

        $original_url = $publication['publication_url_'.$this->lang];

        if($original_url != '/article/'.$url) return redirect($original_url,301);

        $publication['tag_'.$this->lang] = str_replace(', ',',',$publication['tag_'.$this->lang]);
        $tags = explode(",", $publication['tag_'.$this->lang]);

        if(!isset($tags[0])) $tags[0] = '##';
        if(!isset($tags[1])) $tags[1] = '##';
        if(!isset($tags[2])) $tags[2] = '##';

        $other_publication_list = Publication::where('is_show',1)
            ->where('publication_name_'.$this->lang,'!=','')
            ->where('publication_id','!=',$publication->publication_id)
            ->where(function($query) use ($tags){
                $query->where('tag_'.$this->lang,'like','%'.$tags[0].'%')
                    ->orWhere('tag_'.$this->lang,'like','%'.$tags[1].'%')
                    ->orWhere('tag_'.$this->lang,'like','%'.$tags[2].'%');
            })
            ->orderBy('publication_date','desc')
            ->take(3)
            ->get();


        return view('index.publication.publication-detail',
            [
                'publication' => $publication,
                'other_publication_list' => $other_publication_list,
                'menu' => $menu
            ]);
    }

}
