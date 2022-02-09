<td class="thumbnail-img">
    <a href="#">
        <img src="{{asset($image)}}"
             style="width: 100%; box-shadow: 3px 3px 3px 3px #707070; border-radius: 5px"/>
    </a>
</td>
<td class="name-pr">
    <a href="#">
        {{$title}}
    </a>
</td>
<td class="price-pr">
    <p>$ {{$price}}</p>
</td>
<td class="total-pr">
    <p>$ {{$price*$quantity}}</p>
</td>
<td class="remove-pr">
    <a href="#">
        <i class="fas fa-times"></i>
    </a>
</td>
