<div class="products-single fix">
    <div class="box-img-hover">
        <div class="type-lb">
{{--            <p class="sale">Sale</p>--}}
        </div>
        <img src="{{asset($image)}}" class="img-fluid" alt="Image" style="min-width: 250px;max-width: 250px; min-height: 250px; max-height: 250px;">
        <div class="mask-icon">
            <ul>
                <li><a href="{{route('productDetails', ['slug' =>$slug])}}" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
            </ul>
            @include('component.card.addToCart',['model'=>$id])
        </div>
    </div>
    <div class="why-text">
        <h4>{{$title}}</h4>
        <h5> ${{$price}}</h5>
    </div>
</div>


