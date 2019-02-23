<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'certificate');
    }

    public function index(Request $request)
    {
        $row = Certificate::select('*');

        if(isset($request->active))
            $row->where('certificate.is_show',$request->active);
        else $row->where('certificate.is_show','1');


        if(isset($request->certificate_name) && $request->certificate_name != ''){
            $row->where(function($query) use ($request){
                $query->where('certificate_name_ru','like','%' .$request->certificate_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.certificate.certificate',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Certificate();
        $row->certificate_image = '/default.jpg';

        return  view('admin.certificate.certificate-edit', [
            'title' => 'Добавить свидетельство ',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'certificate_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.certificate.certificate-edit', [
                'title' => 'Добавить свидетельство ',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $certificate = new Certificate();
        $certificate->certificate_name_ru = $request->certificate_name_ru;
        $certificate->certificate_name_en = $request->certificate_name_en;
        $certificate->certificate_name_kz = $request->certificate_name_kz;
        $certificate->certificate_image = $request->certificate_image;
        $certificate->sort_num = $request->sort_num?$request->sort_num:100;
        $certificate->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'certificate';
        $action->action_text_ru = 'добавил(а) свидетельство  "' .$certificate->certificate_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $certificate->certificate_id;
        $action->save();

        return redirect('/admin/certificate');
    }

    public function edit($id)
    {
        $row = Certificate::find($id);

        return  view('admin.certificate.certificate-edit', [
            'title' => 'Редактировать данные свидетельство ',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'certificate_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.certificate.certificate-edit', [
                'title' => 'Редактировать данные свидетельство ',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $certificate = Certificate::find($id);
        $certificate->certificate_name_ru = $request->certificate_name_ru;
        $certificate->certificate_name_en = $request->certificate_name_en;
        $certificate->certificate_name_kz = $request->certificate_name_kz;
        $certificate->certificate_image = $request->certificate_image;
        $certificate->sort_num = $request->sort_num?$request->sort_num:100;
        $certificate->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'certificate';
        $action->action_text_ru = 'редактировал(а) данные свидетельство  "' .$certificate->certificate_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $certificate->certificate_id;
        $action->save();

        return redirect('/admin/certificate');
    }

    public function destroy($id)
    {
        $certificate = Certificate::find($id);

        $old_name = $certificate->certificate_name_ru;

        $certificate->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'certificate';
        $action->action_text_ru = 'удалил(а) свидетельство  "' .$certificate->certificate_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $certificate = Certificate::find($request->id);
        $certificate->is_show = $request->is_show;
        $certificate->save();

        $action = new Actions();
        $action->action_comment = 'certificate';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - свидетельство  "' .$certificate->certificate_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - свидетельство  "' .$certificate->certificate_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $certificate->certificate_id;
        $action->save();

    }

}
