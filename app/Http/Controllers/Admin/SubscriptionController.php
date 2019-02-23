<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Subscription;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'subscription');
    }

    public function index(Request $request)
    {
        $row = Subscription::orderBy('subscription_id','desc')
                      ->select('*',
                          'subscription.created_at as date');

        if(isset($request->search))
            $row->where(function($query) use ($request){
               $query->where('user_name','like','%' .$request->search .'%')
              ->orWhere('email','like','%' .$request->search .'%');
            });

        if(isset($request->active))
            $row->where('subscription.is_show',$request->active);
        else $row->where('subscription.is_show','0');

        $row = $row->paginate(10);

        return  view('admin.subscription.subscription',[
            'row' => $row,
            'title' => 'Отзывы',
            'request' => $request
        ]);
    }

    public function changeIsShow(Request $request){
        $advert = Subscription::find($request->id);
        $advert->is_show = $request->is_show;
        $advert->save();
    }

    public function destroy($id)
    {
        $user = Subscription::find($id);
        $user->delete();
    }


    
}
