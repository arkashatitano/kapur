<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Video;
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

class VideoController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showVideoList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/video')->first();
        if($menu == null) abort(404);
        
        $video_list = Video::where('video.is_show',1)
                                ->orderBy('video_date','desc')
                                ->where('video_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.video.video-list',
            [
                'menu' => $menu,
                'video_list' => $video_list
            ]);
    }

    public function showVideoById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/video')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $video = Video::where('video.is_show',1)
                    ->where('video_name_'.$this->lang,'!=','')
                    ->where('video_id',$id)
                    ->first();

        if($video == null) abort(404);

        $original_url = $video['video_url_'.$this->lang];

        if($original_url != '/video/'.$url) return redirect($original_url,301);

        $video['tag_'.$this->lang] = str_replace(', ',',',$video['tag_'.$this->lang]);
        $tags = explode(",", $video['tag_'.$this->lang]);

        if(!isset($tags[0])) $tags[0] = '##';
        if(!isset($tags[1])) $tags[1] = '##';
        if(!isset($tags[2])) $tags[2] = '##';

        $other_video_list = Video::where('is_show',1)
                                ->where('video_name_'.$this->lang,'!=','')
                                ->where('video_id','!=',$video->video_id)
                                ->where(function($query) use ($tags){
                                  $query->where('tag_'.$this->lang,'like','%'.$tags[0].'%')
                                        ->orWhere('tag_'.$this->lang,'like','%'.$tags[1].'%')
                                        ->orWhere('tag_'.$this->lang,'like','%'.$tags[2].'%');
                                })
                                ->orderBy('video_date','desc')
                                ->take(3)
                                ->get();


        return view('index.video.video-detail',
            [
                'video' => $video,
                'other_video_list' => $other_video_list,
                'menu' => $menu
            ]);
    }

}
