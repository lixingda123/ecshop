<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
      <script src="{{asset('/js/jquery-3.2.1.min.js')}}"></script>
    <title>三级分销</title>
    <link rel="shortcut icon" href="/index/images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/index/css/style.css" rel="stylesheet">
    <link href="/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="/login/loginAdd" method="post" class="reg-login">
         @if ($errors->any())
             <div class="alert alert-danger">
                 <ul>
                     @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
         @endif
         @csrf
      <h3>还没有三级分销账号？点此<a class="orange" href="/login/reg">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="user_email" id="email" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList"><input type="text" name="user_pwd" id="pwd" placeholder="输入证码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" id="sub" value="立即登录" />
      </div>
     </form><!--reg-login/-->
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="index/index">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="prolist.html">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl>
      <dl>
       <a href="car.html">
        <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
        <dd>购物车 </dd>
       </a>
      </dl>
      <dl>
       <a href="user.html">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/index/js/bootstrap.min.js"></script>
    <script src="/index/js/style.js"></script>

  </body>
</html>
<link rel="stylesheet" href="/layui/css/layui.css">
<script src="/layui/layui.js"></script>
@if(session('fail'))
    <script type="text/javascript">
        layui.use('layer',function(){
            var layer=layui.layer;
            layer.msg("{{session('fail')}}",{icon:2});
        })
    </script>
@endif
<script>

    $(function () {
        layui.use('layer',function () {
            //点击提交
            $('#sub').click(function(){
                var _form=$('form');
                var pwd=$('#pwd').val();
                if($('#email').val()==''){
                    layer.msg('邮箱必填',{icon:2})
                    _form.attr('onsubmit','return false');
                    return false;
                }else{
                    _form.attr('onsubmit','return true');
                }
                if(pwd==''){
                    layer.msg('密码必填',{icon:2})
                    _form.attr('onsubmit','return false');
                    return false
                }else{
                    _form.attr('onsubmit','return true');
                }
            })
        })
    })
</script>