<td class="thumbnail-img">

        <img src="{{asset($image)}}"
             style="width: 100%; box-shadow: 3px 3px 3px 3px #707070; border-radius: 5px"/>
</td>
<td class="name-pr">
    <a href="#">
        {{$title}}
    </a>
</td>
<td class="price-pr">
    <p>$ {{$price}}</p>
</td>
{{--<td class="total-pr">--}}
{{--    <p>$ {{$price*$quantity}}</p>--}}
{{--</td>--}}
<td style="">
    <a href="{{route('removeCart', ['id' =>$id])}}">
        <i style="color: #7a2828" class="fas fa-trash"></i>
    </a>
</td>
