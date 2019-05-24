<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/','Index\IndexController@index');//首页
Route::get('/login/login','Index\LoginController@login');//登陆页面
Route::post('/login/loginAdd','Index\LoginController@loginAdd');//登陆执行
Route::post('/login/tel','Index\LoginController@tel');//发送短信验证码
Route::match(['get','post'],'/login/quit',"Index\LoginController@quit");//退出


Route::get('/prolist/prolist','Index\ProlistController@prolist');//所有商品

//Route::post('/prolist/comment','Index\ProlistController@comment');//评论

Route::get('/proinfo/proinfo/{id}','Index\ProlistController@proinfo');//商品详情
//发送邮箱验证码
Route::post('/login/email','Index\LoginController@email');
Route::get('/login/reg','Index\LoginController@reg');//注册页面
Route::get('/login/regAdd','Index\LoginController@regAdd');//执行注册页面
Route::get('/login/sendemail','Index\LoginController@sendemail');//发送邮件


Route::get('/car/car','Index\CarController@car');//购物车列表
Route::post('/car/AddCar','Index\CarController@AddCar');//加入购物车
Route::post('/car/updNum','Index\CarController@updNum');//修改商品数量
Route::post('/car/payAdd','Index\CarController@payAdd');//结算
Route::match(['get','post'],'car/pay',"Index\CarController@pay");//结算页面
Route::post('/car/total','Index\CarController@total');//总价格

Route::get('/users/users','UsersController@users');
Route::post('/users/usersAdd/{id}','UsersController@usersAdd');