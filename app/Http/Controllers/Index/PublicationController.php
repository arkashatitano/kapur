<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Mail\DemoEmail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Order;
use App\Models\PayboxResult;
use App\Models\Publication;
use App\Models\Product;
use App\Models\Rubric;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Auth;
use Cookie;

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

        $document_list = \App\Models\File::orderBy('file_id','asc')->where('publication_id',$publication->publication_id)->get();

        $is_payed = 0;

        if(isset($_COOKIE["publication_".$publication->publication_id.'_hash']) && isset($_COOKIE["publication_".$publication->publication_id.'_id'])){

            $_GET['hash'] = $_COOKIE["publication_".$publication->publication_id.'_hash'];
            $_GET['id'] = $_COOKIE["publication_".$publication->publication_id.'_id'];
        }

        if(isset($_GET['hash']) && isset($_GET['id'])){
            $order = Order::where('publication_id',$publication->publication_id)
                          ->where('order_id',$_GET['id'])
                          ->where('hash',$_GET['hash'])
                          ->where('is_pay',1)
                          ->first();

            if($order != null) {
                $is_payed = 1;
                setcookie("publication_".$publication->publication_id.'_hash',$_GET['hash'], time() + (86400 * 30), "/");
                setcookie("publication_".$publication->publication_id.'_id',$_GET['id'], time() + (86400 * 30), "/");
            }
        }

        return view('index.publication.publication-detail',
            [
                'publication' => $publication,
                'other_publication_list' => $other_publication_list,
                'document_list' => $document_list,
                'is_payed' => $is_payed,
                'menu' => $menu
            ]);
    }

    public function buyPublication(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'publication_id' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'city_name' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            $result['status'] = false;
            $result['error'] = 'Вам следует указать необходимые данные';
            return $result;
        }

        $publication = Publication::where('publication_id',$request->publication_id)->first();

        $contact = new Order();
        $contact->user_name = $request->user_name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->publication_id = $request->publication_id;
        $contact->city_name = $request->city_name;
        $contact->pay_type = 'онлайн оплата журнала';
        $contact->is_magazine = 0;
        $contact->is_show = 1;

        $contact->hash = md5(uniqid(time(), true));
        $contact->price = $publication->publication_price;
        $contact->save();

        $request->type = 'publication';
        $request->cost = $contact->price;
        $request->hash = $contact->hash;
        $request->id = $contact->order_id;
        $request->success_url = URL('/').$publication['publication_url_'.$this->lang].'?hash='.$contact->hash.'&id='.$contact->order_id;

        $paybox = new PayboxController();
        $result_payment = $paybox->payment($request);

        $result['status'] = true;
        $result['is_online'] = 1;
        $result['href'] = $result_payment;
        return response()->json($result);
    }

    public function confirmPublicationPay(Request $request,$hash,$id)
    {
        if($request->ok == 1){
            $email[0] = 'arman.abdiyev@gmail.com';

            $objDemo = new \stdClass();
            $result_email = Mail::to($email)->send(new DemoEmail($objDemo));
            dd($result_email);
        }

        $paybox_result = new PayboxResult();
        $paybox_result->paybox_result = $request;
        $paybox_result->order_id = $id;
        $paybox_result->save();


        if($id > 0) {
            if (isset($request->pg_result) || $request->pg_result == 1) {
                $order = Order::where('order_id',$id)
                    ->where('hash',$hash)
                    ->where('is_pay',0)
                    ->first();

                if($order == null) return;

                $order->is_pay = 1;
                $order->transaction_number = $request->pg_payment_id;
                $order->save();

                $publication = Publication::where('publication_id',$order->publication_id)->first();
                $email[0] = 'arman.abdiyev@gmail.com';

                $objDemo = new \stdClass();
                $objDemo->url = URL('/').$publication['publication_url_'.$this->lang].'?hash='.$order->hash.'&id='.$order->order_id;

                $result_email = Mail::to($email)->send(new DemoEmail($objDemo));
            }
        }
    }

}
