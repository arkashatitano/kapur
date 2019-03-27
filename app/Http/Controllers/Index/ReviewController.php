<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Review;
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

class ReviewController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showReviewList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/review')->first();
        if($menu == null) abort(404);
        
        $review_list = Review::where('review.is_show',1)
                                ->orderBy('review_date','desc')
                                ->where('review_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.review.review-list',
            [
                'menu' => $menu,
                'review_list' => $review_list
            ]);
    }

    public function showReviewById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/review')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $review = Review::where('review.is_show',1)
                    ->where('review_name_'.$this->lang,'!=','')
                    ->where('review_id',$id)
                    ->first();

        if($review == null) abort(404);

        $original_url = $review['review_url_'.$this->lang];

        if($original_url != '/review/'.$url) return redirect($original_url,301);


        return view('index.review.review-detail',
            [
                'review' => $review,
                'menu' => $menu
            ]);
    }

}
