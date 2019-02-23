<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'member');
    }

    public function index(Request $request)
    {
        $row = Member::select('*');

        if(isset($request->active))
            $row->where('member.is_show',$request->active);
        else $row->where('member.is_show','1');


        if(isset($request->member_name) && $request->member_name != ''){
            $row->where(function($query) use ($request){
                $query->where('member_name_ru','like','%' .$request->member_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.member.member',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Member();
        $row->member_image = '/default.jpg';

        return  view('admin.member.member-edit', [
            'title' => 'Добавить ассоциацию',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.member.member-edit', [
                'title' => 'Добавить ассоциацию',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $member = new Member();
        $member->member_name_ru = $request->member_name_ru;
        $member->member_name_en = $request->member_name_en;
        $member->member_name_kz = $request->member_name_kz;
        $member->member_redirect = $request->member_redirect;
        $member->member_image = $request->member_image;
        $member->sort_num = $request->sort_num?$request->sort_num:100;
        $member->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'member';
        $action->action_text_ru = 'добавил(а) ассоциацию "' .$member->member_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $member->member_id;
        $action->save();

        return redirect('/admin/member');
    }

    public function edit($id)
    {
        $row = Member::find($id);

        return  view('admin.member.member-edit', [
            'title' => 'Редактировать данные ассоциации',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'member_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.member.member-edit', [
                'title' => 'Редактировать данные ассоциации',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $member = Member::find($id);
        $member->member_name_ru = $request->member_name_ru;
        $member->member_name_en = $request->member_name_en;
        $member->member_name_kz = $request->member_name_kz;
        $member->member_redirect = $request->member_redirect;
        $member->member_image = $request->member_image;
        $member->sort_num = $request->sort_num?$request->sort_num:100;
        $member->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'member';
        $action->action_text_ru = 'редактировал(а) данные ассоциации "' .$member->member_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $member->member_id;
        $action->save();

        return redirect('/admin/member');
    }

    public function destroy($id)
    {
        $member = Member::find($id);

        $old_name = $member->member_name_ru;

        $member->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'member';
        $action->action_text_ru = 'удалил(а) ассоциацию "' .$member->member_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

    }

    public function changeIsShow(Request $request){
        $member = Member::find($request->id);
        $member->is_show = $request->is_show;
        $member->save();

        $action = new Actions();
        $action->action_comment = 'member';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - ассоциация "' .$member->member_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - ассоциация "' .$member->member_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $member->member_id;
        $action->save();

    }

}
