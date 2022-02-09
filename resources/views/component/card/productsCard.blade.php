<div class="productbox">
    <div class="fadeshop">
        <div class="captionshop text-center" style="display: none;">
            <h3>{{$title}}</h3>
            <p>
                {{$excerpt}}
            </p>
            <p>
               @include('component.card.addToCart',['model'=>$id])
                <a href="{{ route('productDetails', ['slug' => $slug]) }}" class="learn-more detailslearn"><i class="fa fa-link"></i> Details</a>
            </p>
        </div>
        <span class="maxproduct"><img src="{{asset($image)}}" alt="" style="width: 100%; box-shadow: 3px 3px 3px 3px #707070; border-radius: 5px"></span>
    </div>
    <div class="product-details">
        <a href="#">
            <h1>{{$title}}</h1>
        </a>
        <span class="price">
					<span class="edd_price">${{$price}}</span>
					</span>
    </div>
</div>
