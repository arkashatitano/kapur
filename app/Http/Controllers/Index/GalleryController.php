<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Menu;
use App\Models\Gallery;
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

class GalleryController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showGalleryList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/gallery')->first();
        if($menu == null) abort(404);
        
        $gallery_list = Gallery::where('gallery.is_show',1)
                                ->orderBy('gallery_date','desc')
                                ->where('gallery_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.gallery.gallery-list',
            [
                'menu' => $menu,
                'gallery_list' => $gallery_list
            ]);
    }

    public function showGalleryById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/gallery')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $gallery = Gallery::where('gallery.is_show',1)
                    ->where('gallery_name_'.$this->lang,'!=','')
                    ->where('gallery_id',$id)
                    ->first();

        if($gallery == null) abort(404);

        $original_url = $gallery['gallery_url_'.$this->lang];

        if($original_url != '/gallery/'.$url) return redirect($original_url,301);

        $image_list = Image::where('gallery_id',$gallery->gallery_id)->orderBy('image_id','asc')->get();

        return view('index.gallery.gallery-detail',
            [
                'gallery' => $gallery,
                'menu' => $menu,
                'image_list' => $image_list
            ]);
    }

}
