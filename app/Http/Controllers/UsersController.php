<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Users;
class USersController extends Controller
{
    public function users(){
        $page = request()->page??1;

        $query=request()->all();
        $user_email=$query['user_email']??'';
        $user_desc=$query['user_desc']??'';
        //dd($query);

        $data = cache('list_'.$page.'_'.$user_email.'_'.$user_desc);
        if(!$data){
            echo 'DB';
            $where=[];
            if($user_email){
                $where[]=['user_email','like',"%$query[user_email]%"];
            }
            if($user_desc){
                $where['user_desc']=$query['user_desc'];
            }
            $pagesize = config('app.pageSize');
            //DB::connection()->enableQueryLog();
            $data = Users::where($where)->orderBy('user_id','desc')->paginate($pagesize);
            // $logs=DB::GetQueryLog();
            //dd($logs);

            cache(['list_'.$page.'_'.$user_email.'_'.$user_desc=>$data],5);

        }
        if(request()->ajax()){
            return view('users.ajaxusers',compact('data','query'));
        }
        return view('users.users',compact('data','query'));



        //$data=cache('list_'.$id);
//        $data = DB::table('users')->get();
//        //dd($data);
//        $count=count($data);
//        return view('users.users',compact('data','count'));
    }

    public function usersAdd(){
        $data = request()->except(['_token']);
        $data['user_time']=time();
        //dd($data);
        $res = Users::insert($data);
        //dd($res);

        if($res){
            return redirect('/users/users');
        }
    }
}
