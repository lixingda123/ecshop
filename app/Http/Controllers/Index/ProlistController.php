<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class ProlistController extends Controller
{
    //所有商品
    public function prolist(){
        $data = DB::table('goods')->get();
        //dd($data);
        return view('prolist.prolist',compact('data'));
    }
    //商品详情
    public function proinfo($id){
        //dd($id);
        $data = DB::table('goods')->where('goods_id',$id)->first();
        //dd($data);
        $goods_imgs = $data->goods_imgs;
        $goods_imgs = rtrim($goods_imgs,'|');
        $goods_imgs = explode('|',$goods_imgs);
        return view('prolist.proinfo',compact('data','goods_imgs'));
    }

    //添加评论
    public function comment(){
        $data = request()->all();
        dd($data);
        //return view('prolist.proinfo',compact('data'));
    }
}
