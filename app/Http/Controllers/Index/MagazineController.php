<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Magazine;
use App\Models\Order;
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


        return view('index.magazine.magazine-detail',
            [
                'magazine' => $magazine,
                'menu' => $menu
            ]);
    }

    public function buyByCash(Request $request){
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

        $result['status'] = true;
        $result['message'] = 'Успешно отправлено';

        return response()->json($result);
    }
}
