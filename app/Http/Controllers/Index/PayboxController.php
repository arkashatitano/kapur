<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Arbitrator;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\News;
use App\Models\Order;
use App\Models\Page;


use App\Models\Product;
use App\Models\Question;
use App\Models\Review;
use App\Models\Service;
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
use Auth;
use Mockery\CountValidator\Exception;


class PayboxController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = Helpers::getSessionLang();
    }


    public function payment(Request $request)
    {
        try {
            $href = "";

            $rand_str = "z";
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < 10; $i++) {
                $rand_str .= $characters[rand(0, strlen($characters) - 1)];
            }

            include_once("PG_Signature.php");
            $MERCHANT_SECRET_KEY = "Tx16wGYi1ZfjlhM6";

            $arrReq = array();

            $url = URL('/');
            $url = str_replace('http://','https://',$url);

            $arrReq['pg_merchant_id'] = 514936;// Идентификатор магазина
            $arrReq['pg_order_id']    = $request->id;		// Идентификатор заказа в системе магазина
            $arrReq['pg_amount']      = $request->cost;		// Сумма заказа
            $arrReq['pg_user_phone'] = Helpers::changePhoneFormatWithoutSeven($request->phone);
            $arrReq['pg_user_email'] = $request->email;
            $arrReq['pg_result_url']      = $url.  "/paybox-result/".$request->type."/".$request->hash."/".$request->id;
            $arrReq['pg_success_url']      = $request->success_url;
            $arrReq['pg_failure_url']      = URL('/'). "?error-paybox=1";


            if(isset($request->type) && $request->type == 'magazine'){
                $arrReq['pg_description'] = "Покупка журнала на kap.kz"; // Описание заказа (показывается в Платёжной системе)
            }
            else {
                $arrReq['pg_description'] = "Покупка статьи на kap.kz"; // Описание заказа (показывается в Платёжной системе)
            }

            $arrReq['pg_salt'] = $rand_str;
            $arrReq['pg_request_method'] = "POST";
      //      $arrReq['pg_payment_system'] = "TEST";

            //$arrReq['pg_testing_mode'] = '1';
            $arrReq['pg_success_url_method'] = 'AUTOPOST';
            $arrReq['pg_payment_route'] = 'frame';

            $arrReq['pg_sig'] = \PG_Signature::make('payment.php', $arrReq, $MERCHANT_SECRET_KEY);

            $file = "log.txt";
            $current = file_get_contents($file);
            $current .= $arrReq['pg_merchant_id'] . "\n";
            $current .= $arrReq['pg_order_id'] . "\n";
            $current .= $arrReq['pg_amount'] . "\n";
            $current .= $arrReq['pg_user_phone'] . "\n";
            $current .= $arrReq['pg_user_email'] . "\n";
            $current .= $arrReq['pg_result_url'] . "\n";
            $current .= $arrReq['pg_success_url'] . "\n";
            $current .= $arrReq['pg_failure_url'] . "\n";
            $current .= $arrReq['pg_description'] . "\n";
            $current .= $arrReq['pg_salt'] . "\n";
            $current .= $arrReq['pg_request_method'] . "\n";
            $current .= $arrReq['pg_success_url_method'] . "\n";
            $current .= $arrReq['pg_payment_route'] . "\n";
            //$current .= $arrReq['pg_testing_mode'] . "\n";
            $current .= $arrReq['pg_sig'] . "\n";
          //  $current .= $arrReq['pg_payment_system'] . "\n";

            $query = http_build_query($arrReq);
            $current .= $query . "\n";
            file_put_contents($file, $current);

            $href = $query;
            $result = "https://www.paybox.kz/payment.php?".$href;
            return $result;
        }
        catch(Exception $ex){
            return false;
        }

    }
}
