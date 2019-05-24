<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class IndexController extends Controller
{
    public function index(){
        $data = DB::table('category')->where('pid',0)->get();
        $res = DB::table('goods')->get();
//        dd($res);
//        dd($data);
        return view('index.index',['data'=>$data,'res'=>$res]);
    }

    public function prolist(){
        return view('prolist.prolist');
    }
}
