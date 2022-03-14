<div class="col-md-14">
    <a href="{{route('productDetails',['slug'=>$slug])}}"><img src="{{asset($image)}}"
                     style="width: 100%; box-shadow: 3px 3px 3px 3px #707070; border-radius: 5px"/></a>
    <div class="down-content" style="text-align: center">
        <br/>
        <a href="{{route('productDetails',['slug'=>$slug])}}"><h4  style="color: #5da9a1">{{$title}}</h4></a>
{{--        <h6 style="color: #150404">${{$price}}</h6>--}}
{{--        <p>{{$excerpt}}</p>--}}
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
</div>
