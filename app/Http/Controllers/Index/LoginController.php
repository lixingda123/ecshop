<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use \email\PHPMailer;
use App\Reg;
use Illuminate\Support\Facades\DB;
class LoginController extends Controller
{
    //登陆页面
    public function login(){
        return view('login.login');
    }

    //登录验证
    public function loginAdd(Request $request){

        $data=$request->except('_token');
        //dd($data);
        //$model=new \App\Reg;
        $Info=Reg::where('user_email',$data['user_email'])->first();
        //dd($Info);
        if(empty($Info)){
            return redirect('index/login')->with('fail','用户名或密码不正确');
        }else{
             //dd($data['user_pwd']);
            if($data['user_pwd']!=$Info['user_pwd']){
                return redirect('login/login')->with('fail','用户名或密码不正确');
            }else{
                session(['user'=>['user_email'=>$data['user_email'],'user_id'=>$Info['user_id']]]);
                return redirect('/')->with('success','登录成功');
            }
        }
    }

    //退出
    public function quit(Request $request){
        $request->session()->forget('user');
        return redirect('/');
    }











    //注册页面
    public function reg(){
        return view('login.reg');
    }
    //注册执行
    public function regAdd(Request $request){
        $data=$request->all();

        unset($data['_token']);
        unset($data['user_pwd1']);

        $data['create_time']=time();
        $res=Reg::insert($data);
        //dd($res);
        if($res){
            return redirect('/login/login');
        }
    }

    public function email(){
        $code=rand(100000,999999);
        Mail::send('login.email',['data'=>$code],function($message){
            $to='1466976980@qq.com';
            $message->to($to)->subject('验证码');
        });
    }


    public function send($tel,$rand){
        $host = "http://dingxin.market.alicloudapi.com";
        $path = "/dx/sendSms";
        $method = "POST";
        $appcode = "8f106ac02a704c1794bc1baebdf51755";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "mobile=".$tel."&param=code%3A".$rand."&tpl_id=TP1711063";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        var_dump(curl_exec($curl));
    }

    public function tel(){
        // echo(1234567);die;
        $tel=Request()->tel;
        // echo $tel;die;
        $rand=rand(100000,999999);
        // dd($rand);die;
        $send=$this->send($tel,$rand);

        $arr=[
            'tel'=>$tel,
            'time'=>time(),
            'rand'=>$rand
        ];
        if($send==00000){
            return ['code'=>'1','msg'=>'发送成功'];
            Request()->session()->put('tel',$arr);
        }else{
            return ['code'=>'2','msg'=>'发送失败'];
        }
    }










}
