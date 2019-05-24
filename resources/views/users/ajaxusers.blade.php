
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
