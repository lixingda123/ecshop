<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/page.css')}}">
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
</head>
<body>
    <form action="">
        <input type="text" name="user_email" value="{{$query['user_email']??''}}" placeholder="请输入用户名称关键字">
        <input type="text" name="user_desc" value="{{$query['user_desc']??''}}" placeholder="请输入评论内容关键字">
        <button>搜索</button>
    </form>
    <br>
    <div id="con" >
    <table border="1">
        <tr>
            <td colspan="4" style="text-align: left">用户评论</td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"></td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td>评价等级</td>
            <td>评论内容</td>
            <td>评论时间</td>
        </tr>
        @foreach($data as $v)
        <tr>
            <td>{{$v->user_email}}</td>
            <td>

                @if($v->user_star==1)
                    1星
                @elseif($v->user_star==2)
                    2星
                @elseif($v->user_star==3)
                    3星
                @elseif($v->user_star==4)
                    4星
                @else
                    5星
                @endif
            </td>
            <td>{{$v->user_desc}}</td>
            <td>{{date('Y-m-d H:i:s',$v->user_time)}}</td>
        </tr>

        @endforeach

    </table>
        {{$data->appends($query)->links()}}
    </div>



    <br>
    <hr>




            <form action="/users/usersAdd/1" method="post">
                <table border="1">
                    @csrf
                    <tr>
                        <td>用户名:</td>
                        <td>匿名用户</td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td><input type="text" name="user_email"></td>
                    </tr>
                    <tr>
                        <td>评价等级:</td>
                        <td>
                            <input type="radio" value="1" name="user_star">1级
                            <input type="radio" value="2" name="user_star">2级
                            <input type="radio" value="3" name="user_star">3级
                            <input type="radio" value="4" name="user_star">4级
                            <input type="radio" value="5" name="user_star">5级
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><textarea name="user_desc" id="" cols="30" rows="5"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button>发布评论</button></td>
                    </tr>
                </table>

            </form>

</body>
</html>
<script>
    $(function () {
        $(document).on('click','.pagination a',function () {
            var url = $(this).attr('href');

            $.ajax({
               method:"GET" ,
                url:url,
                data:''
            }).done(function (msg) {
                $('#con').html(msg);
            })

            return false;
        })
    })
</script>