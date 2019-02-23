<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\News;
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

class NewsController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showNewsList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/news')->first();
        if($menu == null) abort(404);
        
        $news_list = News::where('news.is_show',1)
                                ->orderBy('news_date','desc')
                                ->where('news_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.news.news-list',
            [
                'menu' => $menu,
                'news_list' => $news_list
            ]);
    }

    public function showNewsById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/news')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $news = News::where('news.is_show',1)
                    ->where('news_name_'.$this->lang,'!=','')
                    ->where('news_id',$id)
                    ->first();

        if($news == null) abort(404);

        $original_url = $news['news_url_'.$this->lang];

        if($original_url != '/news/'.$url) return redirect($original_url,301);

        $news['tag_'.$this->lang] = str_replace(', ',',',$news['tag_'.$this->lang]);
        $tags = explode(",", $news['tag_'.$this->lang]);

        if(!isset($tags[0])) $tags[0] = '##';
        if(!isset($tags[1])) $tags[1] = '##';
        if(!isset($tags[2])) $tags[2] = '##';

        $other_news_list = News::where('is_show',1)
                                ->where('news_name_'.$this->lang,'!=','')
                                ->where('news_id','!=',$news->news_id)
                                ->where(function($query) use ($tags){
                                  $query->where('tag_'.$this->lang,'like','%'.$tags[0].'%')
                                        ->orWhere('tag_'.$this->lang,'like','%'.$tags[1].'%')
                                        ->orWhere('tag_'.$this->lang,'like','%'.$tags[2].'%');
                                })
                                ->orderBy('news_date','desc')
                                ->take(3)
                                ->get();


        return view('index.news.news-detail',
            [
                'news' => $news,
                'other_news_list' => $other_news_list,
                'menu' => $menu
            ]);
    }

}
