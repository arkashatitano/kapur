<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'partner');
    }

    public function index(Request $request)
    {
        $row = Partner::select('*');

        if(isset($request->active))
            $row->where('partner.is_show',$request->active);
        else $row->where('partner.is_show','1');


        if(isset($request->partner_name) && $request->partner_name != ''){
            $row->where(function($query) use ($request){
                $query->where('partner_name_ru','like','%' .$request->partner_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.partner.partner',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Partner();
        $row->partner_image = '/default.jpg';

        return  view('admin.partner.partner-edit', [
            'title' => 'Добавить партнера',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partner_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.partner.partner-edit', [
                'title' => 'Добавить партнера',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $partner = new Partner();
        $partner->partner_name_ru = $request->partner_name_ru;
        $partner->partner_name_en = $request->partner_name_en;
        $partner->partner_name_kz = $request->partner_name_kz;
        $partner->partner_redirect = $request->partner_redirect;
        $partner->partner_image = $request->partner_image;
        $partner->sort_num = $request->sort_num?$request->sort_num:100;
        $partner->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'partner';
        $action->action_text_ru = 'добавил(а) партнера "' .$partner->partner_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $partner->partner_id;
        $action->save();

        return redirect('/admin/partner');
    }

    public function edit($id)
    {
        $row = Partner::find($id);

        return  view('admin.partner.partner-edit', [
            'title' => 'Редактировать данные партнера',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'partner_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.partner.partner-edit', [
                'title' => 'Редактировать данные партнера',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $partner = Partner::find($id);
        $partner->partner_name_ru = $request->partner_name_ru;
        $partner->partner_name_en = $request->partner_name_en;
        $partner->partner_name_kz = $request->partner_name_kz;
        $partner->partner_redirect = $request->partner_redirect;
        $partner->partner_image = $request->partner_image;
        $partner->sort_num = $request->sort_num?$request->sort_num:100;
        $partner->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'partner';
        $action->action_text_ru = 'редактировал(а) данные партнера "' .$partner->partner_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $partner->partner_id;
        $action->save();

        return redirect('/admin/partner');
    }

    public function destroy($id)
    {
        $partner = Partner::find($id);

        $old_name = $partner->partner_name_ru;

        $partner->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'partner';
        $action->action_text_ru = 'удалил(а) партнера "' .$partner->partner_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $partner = Partner::find($request->id);
        $partner->is_show = $request->is_show;
        $partner->save();

        $action = new Actions();
        $action->action_comment = 'partner';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - партнер "' .$partner->partner_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - партнер "' .$partner->partner_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $partner->partner_id;
        $action->save();

    }

}
