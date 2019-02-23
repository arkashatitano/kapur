<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Document;
use App\Models\Category;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'document');
        
    }

    public function index(Request $request)
    {
        $row = Document::orderBy('document.document_date','desc')
                       ->select('*',
                                 DB::raw('DATE_FORMAT(document.document_date,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('document.is_show',$request->active);
        else $row->where('document.is_show','1');

      
        if(isset($request->document_name) && $request->document_name != ''){
            $row->where(function($query) use ($request){
                $query->where('document_name_ru','like','%' .$request->document_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.document.document',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Document();
        $row->document_image = '/default.jpg';
        $row->document_date = date('d.m.Y H:i');

        return  view('admin.document.document-edit', [
            'title' => 'Добавить семинар',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       /* $validator = Validator::make($request->all(), [
            'document_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.document.document-edit', [
                'title' => 'Добавить семинар',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }*/

        $document = new Document();
        $document->document_name_ru = $request->document_name_ru;

        $document->document_name_kz = $request->document_name_kz;


        $document->document_name_en = $request->document_name_en;

        $document->document_pdf = $request->document_pdf;
        $document->document_pdf_size = $request->document_pdf_size?:0;
        $document->sort_num = $request->sort_num?:100;

        $document->user_id = Auth::user()->user_id;
        $document->is_show = 1;



        $document->save();

        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'document';
        $action->action_text_ru = 'добавил(а) семинар "' .$document->document_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $document->document_id;
        $action->save();
        
        return redirect('/admin/document');
    }

    public function edit($id)
    {
        $row = Document::find($id);

        return  view('admin.document.document-edit', [
            'title' => 'Редактировать данные семинара',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'document_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.document.document-edit', [
                'title' => 'Редактировать данные семинара',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $document = Document::find($id);

        $document->document_name_ru = $request->document_name_ru;

        $document->document_name_kz = $request->document_name_kz;


        $document->document_name_en = $request->document_name_en;

        $document->document_pdf = $request->document_pdf;
        $document->document_pdf_size = $request->document_pdf_size?:0;
        $document->sort_num = $request->sort_num?:100;
        $document->save();
        
        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'document';
        $action->action_text_ru = 'редактировал(а) данные семинара "' .$document->document_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $document->document_id;
        $action->save();
        
        return redirect('/admin/document');
    }

    public function destroy($id)
    {
        $document = Document::find($id);

        $old_name = $document->document_name_ru;

        $document->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'document';
        $action->action_text_ru = 'удалил(а) семинар "' .$document->document_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $document = Document::find($request->id);
        $document->is_show = $request->is_show;
        $document->save();

        $action = new Actions();
        $action->action_comment = 'document';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - семинар "' .$document->document_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - семинар "' .$document->document_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $document->document_id;
        $action->save();

    }

    public function getDocumentList(Request $request){
        $request->document_pdf = $request->image_url;
        return  view('admin.document.document-loop',[
            'row' => $request
        ]);
    }
}
