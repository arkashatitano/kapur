<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Expert;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Seminar;
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

class SeminarController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showSeminarList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/seminar')->first();
        if($menu == null) abort(404);
        
        $seminar_list = Seminar::where('seminar.is_show',1)
                                ->orderBy('seminar_date','desc')
                                ->where('seminar_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.seminar.seminar-list',
            [
                'menu' => $menu,
                'seminar_list' => $seminar_list
            ]);
    }

    public function showSeminarById(Request $request,$url)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/seminar')->first();
        if($menu == null) abort(404);

        $id = Helpers::getIdFromUrl($url);
       
        $seminar = Seminar::where('seminar.is_show',1)
                    ->where('seminar_name_'.$this->lang,'!=','')
                    ->where('seminar_id',$id)
                    ->first();

        if($seminar == null) abort(404);

        $original_url = $seminar['seminar_url_'.$this->lang];

        if($original_url != '/seminar/'.$url) return redirect($original_url,301);

        $expert = Expert::where('seminar_id',$seminar->seminar_id)->orderBy('sort_num','asc')->get();

        return view('index.seminar.seminar-detail',
            [
                'seminar' => $seminar,
                'menu' => $menu,
                'expert' => $expert
            ]);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'seminar_id' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'organization_name' => 'required',
            'position' => 'required',
            'work_phone' => 'required',
            'city_name' => 'required',
            'pay_type' => 'required',
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
        $contact->seminar_id = $request->seminar_id;
        $contact->organization_name = $request->organization_name;
        $contact->position = $request->position;
        $contact->work_phone = $request->work_phone;
        $contact->city_name = $request->city_name;
        $contact->pay_type = $request->pay_type;
        $contact->director_name = $request->director_name;
        $contact->company_info = $request->company_info;
        $contact->fax = $request->fax;
        $contact->is_show = 1;
        $contact->save();

        $result['status'] = true;
        $result['message'] = 'Успешно отправлено';

        return response()->json($result);
    }

}
