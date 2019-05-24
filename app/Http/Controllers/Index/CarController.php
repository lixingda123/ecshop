<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    //购物车列表
    public function car(){
        $data=DB::select("select * from shop_goods join shop_cart on shop_goods.goods_id=shop_cart.goods_id and status=1");
        $count=count($data);
        //dd($count);
        return view('car.car',compact('data','count'));
    }

    //加入购物车
    public function AddCar(Request $request){
        //dd(123);
        if(!session('user')){
            $arr=[
                'font'=>'请登录',
                'code'=>3
            ];
            return json_encode($arr);
        }else{
            $data=$request->all();
            //dd($data);
            unset($data['_token']);
            //dd($data);
            //dd($data['buy_num']);
            $goods_id=$data['goods_id'];
            $goodsInfo=DB::table('goods')->where('goods_id',$goods_id)->first();
            //dd($goodsInfo->goods_num);
            if(!$goodsInfo){
                $arr=[
                    'font'=>'请选择正确的商品',
                    'code'=>2
                ];
                return json_encode($arr);exit;
            }else{
                $reg="/^\d{1,}$/";
                if(!preg_match($reg,$data['buy_num'])){
                    $arr=[
                        'font'=>'请选择正确的购买数量',
                        'code'=>2
                    ];
                    return json_encode($arr);exit;
                }else if($data['buy_num']>$goodsInfo->goods_num){
                    $arr=[
                        'font'=>'库存不足',
                        'code'=>2
                    ];
                    return json_encode($arr);exit;
                }else if($data['buy_num']<1){
                    $arr=[
                        'font'=>'至少选择一件商品',
                        'code'=>2
                    ];
                    return json_encode($arr);exit;
                }else{
                    $cart_model=new \App\Car;
                    $where=[
                        'user_id'=>session('user.user_id'),
                        'goods_id'=>$data['goods_id'],
                        'status'=>1
                    ];
                    $carInfo=$cart_model::where($where)->first();
                    //dd($carInfo);
                    if($carInfo){
                        if(($carInfo['buy_num']+$data['buy_num'])>$goodsInfo->goods_num){
                            $arr=[
                                'font'=>'库存不足',
                                'code'=>2
                            ];
                            return json_encode($arr);exit;
                        }else{
                            $cart=$cart_model->find($carInfo['id']);
                            //dd($cart);
                            $cart->buy_num=$carInfo['buy_num']+$data['buy_num'];
                            $res=$cart->save();
                            //dd($res);
                            if($res){
                                $arr=[
                                    'font'=>'加入购物车成功',
                                    'code'=>1
                                ];
                                return json_encode($arr);exit;
                            }else{
                                $arr=[
                                    'font'=>'加入购物车失败',
                                    'code'=>2
                                ];
                                return json_encode($arr);exit;
                            }
                        }
                    }else{
                       //dd($data);
                        foreach($data as $k=>$v){
                            $cart_model->$k=$v;
                        }
                        $cart_model->user_id=session('user.user_id');
                        $res=$cart_model->save();
                        if($res){
                            $arr=[
                                'font'=>'加入购物车成功',
                                'code'=>1
                            ];
                            return json_encode($arr);exit;
                        }else{
                            $arr=[
                                'font'=>'加入购物车失败',
                                'code'=>2
                            ];
                            return json_encode($arr);exit;
                        }
                    }

                }

            }
        }
    }

    //修改商品数量
    public function updNum(Request $request){
        $data=$request->all();
        unset($data['_token']);
        $goods_id=$data['goods_id'];
        $where=[
            'goods_id'=>$goods_id
        ];
        // dd($where);
        $goods_model=new \App\Good;
        $goodsInfo=$goods_model::where($where)->first();
        $reg="/^\d{1,}$/";
        if(!$goodsInfo){
            $arr=[
                'font'=>'请选择正确的商品',
                'code'=>2
            ];
            return json_encode($arr);exit;
        }else{
            if(!preg_match($reg,$data['buy_num'])){
                $arr=[
                    'font'=>'请选择正确的购买数量',
                    'code'=>2
                ];
                return json_encode($arr);exit;
            }else if($data['buy_num']>$goodsInfo['goods_num']){
                $arr=[
                    'font'=>'库存不足',
                    'code'=>2
                ];
                return json_encode($arr);exit;
            }else if($data['buy_num']<1){
                $arr=[
                    'font'=>'至少选择一件商品',
                    'code'=>2
                ];
                return json_encode($arr);exit;
            }else{

                $cart_model=\App\Car::find($data['id']);
                $cart_model->buy_num=$data['buy_num'];
                $res=$cart_model->save();
                $Info=DB::table('cart')
                    ->join('goods','cart.goods_id','=','goods.goods_id')
                    ->where('cart.id',$data['id'])
                    ->first();
                // dd($Info);
                if($res){
                    $arr=[
                        'font'=>'操作成功',
                        'code'=>1,
                        'price'=>$Info->self_price*$Info->buy_num
                    ];
                    return json_encode($arr);exit;
                }else{
                    $arr=[
                        'font'=>'操作失败',
                        'code'=>2
                    ];
                    return json_encode($arr);exit;
                }
            }
        }
    }

    //总价格
    public function total(Request $request){
        $id=$request->id??'';
        $price=0;
        if($id){
            $data=DB::select("select * from shop_goods join shop_cart on shop_goods.goods_id=shop_cart.goods_id and status=1 and id in(".$id.")");
            // var_dump($data);die;
            foreach($data as $k=>$v){
                $price=$price+$v->self_price*$v->buy_num;
            }
            return $price;
        }else{
            return $price;
        }
    }
    //购物车结算
    public function pay(Request $request){
        $cart_id=$request->id??'';
        if(!session('user')){
            return redirect('/login/login');
        }else if(!$cart_id){
            return redirect('/car/car');
        }else{
            $cart_id=explode(',',$cart_id);
            $price=0;
            $data=DB::table('cart')
                ->join('goods','cart.goods_id','=','goods.goods_id')
                ->where('cart.status',1)
                ->wherein('cart.id',$cart_id)
                ->get();
            foreach($data as $k=>$v){
                $price=$price+$v->self_price*$v->buy_num;
            }
            //查询收货地址
            $where=[
                'user_id'=>session('user.user_id')
            ];
            $address=DB::table('address')->where($where)->get();
            $model=new \App\Area;
            foreach($address as $k=>$v){
                $address[$k]->province=$model->where(['id'=>$v->province])->first()['name'];
                $address[$k]->city=$model->where(['id'=>$v->city])->first()['name'];
                $address[$k]->area=$model->where(['id'=>$v->area])->first()['name'];
            }

            return view('car.pay',compact('data','price','address'));
        }
    }

    //购物车结算验证
    public function payAdd(Request $request){
        $cart_id=$request->id??'';
        if(!session('user')){
            $arr=[
                'font'=>'请登录',
                'code'=>3
            ];
            return json_encode($arr);exit;
        }else if(!$cart_id){
            $arr=[
                'font'=>'请选择商品进行结算',
                'code'=>2
            ];
            return json_encode($arr);exit;
        }else{
            return json_encode(['code'=>1]);exit;
        }
    }



}
