<?php

namespace App\Http\Controllers\Admin;

use App\Models\Actions;
use App\Models\Comment;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers;
use Auth;
use View;
use DB;



class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        $row = Actions::leftJoin('users','users.user_id','=','actions.user_id')
            ->orderBy('actions.action_id','desc')
            ->select('*',
                DB::raw('DATE_FORMAT(actions.created_at,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->name) && $request->name != ''){
            $row->where(function($query) use ($request){
                $query->where('name','like','%' .$request->name .'%');
            });
        }

        if(isset($request->action_name) && $request->action_name != ''){
            $row->where(function($query) use ($request){
                $query->where('action_text_ru','like','%' .$request->action_name .'%');
            });
        }

        $row = $row->paginate(20);

        return  view('admin.index.index',
            [
                'menu' => 'home',
                'row' => $row,
                'request' => $request

            ]);
    }

    public function getUrl(Request $request){
        $result['result'] = \App\Http\Helpers::getTranslatedSlugRu($request->word);
        return response()->json($result);
    }

    public function getOrderCount(){
        $result['status'] = true;
        $result['comment_count'] = Comment::where('is_view','=','0')->count();
        $result['contact_count'] =  Contact::where('is_show','=','0')->count();
        return response()->json($result);
    }

    public function getDocumentList(Request $request){
        $document = array();
        $document[0]['file_url'] = $request->file_url;
        $document[0]['file_size'] = $request->file_size;
        $document[0]['file_name_ru'] = 'Загрузите файл';
        $document[0]['is_show'] = 1;

        return  view('admin.'.$request->model.'.document-loop',[
            'document_list' => $document
        ]);
    }
}
