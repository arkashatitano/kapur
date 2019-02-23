<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Certificate;
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

class CertificateController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showCertificateList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/certificate')->first();
        if($menu == null) abort(404);
        
        $certificate_list = Certificate::where('certificate.is_show',1)
                                ->orderBy('sort_num','asc')
                                ->where('certificate_name_'.$this->lang,'!=','')
                                ->paginate(10);
        
        return  view('index.certificate.certificate-list',
            [
                'menu' => $menu,
                'certificate_list' => $certificate_list
            ]);
    }



}
