<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Arbitrator;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Magazine;
use App\Models\Member;
use App\Models\Menu;
use App\Models\News;
use App\Models\Order;
use App\Models\Page;


use App\Models\Partner;
use App\Models\Product;
use App\Models\Question;
use App\Models\Review;
use App\Models\Seminar;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Subscription;
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



class IndexController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = Helpers::getSessionLang();
    }

    
    public function index(Request $request)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/')->first();

        if($menu == null) abort(404);

        $partner_list = Partner::where('is_show',1)
                            ->orderBy('sort_num','asc')
                            ->take(20)
                            ->get();

        $member_list = Member::where('is_show',1)
                            ->orderBy('sort_num','asc')
                            ->take(20)
                            ->get();

        $slider_list = Slider::where('is_show',1)
                            ->orderBy('sort_num','asc')
                            ->take(10)
                            ->get();

        $seminar_list = Seminar::where('seminar.is_show',1)
                            ->orderBy('seminar_date','desc')
                            ->where('seminar_name_'.$this->lang,'!=','')
                            ->take(3)
                            ->get();

        $magazine_list = Magazine::where('is_show',1)
                            ->where('is_show_main',1)
                            ->orderBy('magazine_date','desc')
                            ->where('magazine_name_'.$this->lang,'!=','')
                            ->take(4)
                            ->get();

        return  view('index.index.index',
            [
                'row' => $request,
                'menu' => $menu,
                'partner_list' => $partner_list,
                'seminar_list' => $seminar_list,
                'magazine_list' => $magazine_list,
                'slider_list' => $slider_list,
                'member_list' => $member_list,
            ]);
    }



    public function showContact(Request $request)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/contact')->first();
        if($menu == null) abort(404);

        return  view('index.contact.contact',
            [
                'row' => $request,
                'menu' => $menu
            ]);
    }

    public function showSubscription(Request $request)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/subscription')->first();
        if($menu == null) abort(404);

        return  view('index.subscription.subscription',
            [
                'row' => $request,
                'menu' => $menu
            ]);
    }

    public function addRequest(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            $result['status'] = false;
            $result['error'] = 'Вам следует указать необходимые данные';
            return $result;
        }

        $contact = new Order();
        $contact->user_name = $request->user_name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->order_text = $request->comment;
        $contact->is_show = 1;
        $contact->save();

        $result['status'] = true;
        $result['message'] = 'Успешно отправлено';

        return response()->json($result);
    }

    public function addSubscription(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            $result['status'] = false;
            $result['error'] = 'Вам следует указать необходимые данные';
            return $result;
        }

        $contact = new Subscription();
        $contact->email = $request->email;
        $contact->user_name = $request->email;
        $contact->is_show = 1;
        $contact->save();

        $result['status'] = true;
        $result['message'] = 'Успешно подписались';

        return response()->json($result);
    }

    public function showSearch(Request $request)
    {
        $news_list = News::where('news.is_show',1)
            ->orderBy('news_date','desc')
            ->where('news_name_'.$this->lang,'!=','')
            ->where(function($query) use ($request){
                $query->where('news_name_'.$this->lang,'like','%' .$request->q .'%')
                      ->orWhere('news_desc_'.$this->lang,'like','%' .$request->q .'%')
                      ->orWhere('news_text_'.$this->lang,'like','%' .$request->q .'%');
            })
            ->take(10)
            ->get();

        $arbitrator_list = Arbitrator::where('is_show',1)
            ->orderBy('sort_num','asc')
            ->where('arbitrator_name_'.$this->lang,'!=','')
            ->where(function($query) use ($request){
                $query->where('arbitrator_name_'.$this->lang,'like','%' .$request->q .'%')
                    ->orWhere('arbitrator_desc_'.$this->lang,'like','%' .$request->q .'%')
                    ->orWhere('arbitrator_text_'.$this->lang,'like','%' .$request->q .'%');
            })
            ->take(10)
            ->get();

        $menu_list = \App\Models\Menu::where('is_show',1)
                    ->orderBy('sort_num','asc')
                    ->where(function($query) use ($request){
                        $query->where('menu_name_'.$this->lang,'like','%' .$request->q .'%')
                            ->orWhere('menu_text_'.$this->lang,'like','%' .$request->q .'%');
                    })
                    ->get();

        return  view('index.search.search',
            [
                'news_list' => $news_list,
                'menu_list' => $menu_list,
                'arbitrator_list' => $arbitrator_list
            ]);
    }
}
