<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Mail\MagazineEmail;
use App\Mail\OrderEmail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use Illuminate\Support\Facades\Mail;
use App\Models\Magazine;
use App\Models\Order;
use App\Models\PayboxResult;
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

class MagazineController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showMagazineList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/magazines')->first();
        if($menu == null) abort(404);
        
        $magazine_list = Magazine::where('magazine.is_show',1)
                                ->orderBy('magazine_date','desc')
                                ->where('magazine_name_'.$this->lang,'!=','')
                                ->paginate(8);
        
        return  view('index.magazine.magazine-list',
            [
                'menu' => $menu,
                'magazine_list' => $magazine_list
            ]);
    }

    public function showMagazineById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/magazines')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $magazine = Magazine::where('magazine.is_show',1)
                    ->where('magazine_name_'.$this->lang,'!=','')
                    ->where('magazine_id',$id)
                    ->first();

        if($magazine == null) abort(404);

        $original_url = $magazine['magazine_url_'.$this->lang];

        if($original_url != '/magazine/'.$url) return redirect($original_url,301);

        $document_list = \App\Models\File::where('is_show',1)->orderBy('file_id','asc')->where('magazine_id',$magazine->magazine_id)->get();

        return view('index.magazine.magazine-detail',
            [
                'magazine' => $magazine,
                'document_list' => $document_list,
                'menu' => $menu
            ]);
    }

    public function buyByCash(Request $request){
        $result['is_online'] = 0;

        if($request->pay_type == 'cash'){
            $validator = Validator::make($request->all(), [
                'user_name' => 'required',
                'magazine_id' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'organization_name' => 'required',
                'position' => 'required',
                'work_phone' => 'required',
                'city_name' => 'required'
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
            $contact->magazine_id = $request->magazine_id;
            $contact->organization_name = $request->organization_name;
            $contact->position = $request->position;
            $contact->work_phone = $request->work_phone;
            $contact->city_name = $request->city_name;
            $contact->director_name = $request->director_name;
            $contact->company_info = $request->company_info;
            $contact->fax = $request->fax;
            $contact->pay_type = 'наличными';
            $contact->is_show = 1;
            $contact->save();

            $magazine = Magazine::where('magazine_id',$request->magazine_id)->first();

            $contact->magazine_name_ru = $magazine->magazine_name_ru;

            $email = 'kbcsd@kap.kz';
            $result_email = Mail::to($email)->send(new OrderEmail($contact));

            $result['result_email'] = $result_email;
        }
        elseif($request->pay_type == 'online' || $request->pay_type == 'online_delivery'){
            $validator = Validator::make($request->all(), [
                'user_name' => 'required',
                'magazine_id' => 'required',
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

            $magazine = Magazine::where('magazine_id',$request->magazine_id)->first();

            $contact = new Order();
            $contact->user_name = $request->user_name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->magazine_id = $request->magazine_id;
            $contact->city_name = $request->city_name;
            $contact->pay_type = 'онлайн оплата';
            $contact->is_show = 1;

            $contact->hash = md5(uniqid(time(), true));

            if($request->pay_type == 'online_delivery'){
                $contact->price = $magazine->magazine_price + $magazine->magazine_price_delivery;
                $contact->comment = 'Доставка';
            }
            else {
                $contact->price = $magazine->magazine_price;
            }

            $contact->save();

            $request->type = 'magazine';
            $request->cost = $contact->price;
            $request->hash = $contact->hash;
            $request->id = $contact->order_id;
            $request->success_url = URL('/').$magazine['magazine_url_'.$this->lang].'?success=1';

            $paybox = new PayboxController();
            $result_payment = $paybox->payment($request);

            $result['status'] = true;
            $result['is_online'] = 1;
            $result['href'] = $result_payment;
            return response()->json($result);
        }

        $result['status'] = true;
        $result['message'] = 'Успешно отправлено';
        return response()->json($result);
    }

    public function confirmMagazinePay(Request $request,$hash,$id)
    {
        $paybox_result = new PayboxResult();
        $paybox_result->paybox_result = $request;
        $paybox_result->order_id = $id;
        $paybox_result->save();


        if($id > 0) {
            if (isset($request->pg_result) || $request->pg_result == 1) {
                $order = Order::where('order_id',$id)
                                ->where('hash',$hash)
                                ->first();

                if($order->is_pay == 1) return;
                
                $order->is_pay = 1;
                $order->transaction_number = $request->pg_payment_id;
                $order->save();

                $magazine = Magazine::where('magazine_id',$order->magazine_id)->first();
                $email[0] = $order->email;

                $objDemo = new \stdClass();
                $objDemo->user_name = $order['user_name'];
                $objDemo->magazine_name = $magazine['magazine_name_'.$this->lang];
                $objDemo->magazine_url = URL('/').$magazine['magazine_url_'.$this->lang].'?hash='.$order->hash.'&id='.$order->order_id;

                $objDemo->document_list = \App\Models\File::where('is_show',1)
                                                ->orderBy('file_id','asc')
                                                ->where('magazine_id',$magazine->magazine_id)
                                                ->get();

                $result_email = Mail::to($email)->send(new MagazineEmail($objDemo));

                $order->magazine_name_ru = $magazine->magazine_name_ru;

                $email = 'arman.abdiyev@gmail.com';
                $result_email = Mail::to($email)->send(new OrderEmail($order));
            }
        }
    }
}
