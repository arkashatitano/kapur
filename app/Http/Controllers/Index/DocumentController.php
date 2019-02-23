<?php

namespace App\Http\Controllers\Index;

use App\Http\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Document;
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

class DocumentController extends Controller
{
    public $lang = 'ru';

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    public function showDocumentList(Request $request,$url = null)
    {
        $menu = Menu::where('is_show',1)->where('menu_redirect','/documents')->first();
        if($menu == null) abort(404);
        
        $document_list = Document::where('document.is_show',1)
                                ->orderBy('sort_num','asc')
                                ->where('document_name_'.$this->lang,'!=','')
                                ->paginate(20);
        
        return  view('index.document.document-list',
            [
                'menu' => $menu,
                'document_list' => $document_list
            ]);
    }



}
