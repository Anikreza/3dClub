@extends('master')
@section('content')

    <section class="item content " style="margin-top: -100px; margin-bottom: 100px">
        <div class="container toparea">
            @include('component.breadcrumb')
            <div class="underlined-title">
                <div class="editContent">
                    <h1 class="text-center latestitems">{{$product['title']}}</h1>
                </div>
                {{--            <div class="wow-hr type_short">--}}
                {{--			<span class="wow-hr-h">--}}
                {{--			<i class="fa fa-star"></i>--}}
                {{--			<i class="fa fa-star"></i>--}}
                {{--			<i class="fa fa-star"></i>--}}
                {{--			</span>--}}
                {{--            </div>--}}
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="productbox">
                        <img src="{{asset($product->image)}}" alt="">
                        <div class="clearfix">
                        </div>
                        <br/>
                        <div class="product-details text-left">
                            {!! $product['excerpt'] !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    @include('component.card.addToCart',['model'=>$product['id'],'stock'=>$product['stock']])
                    <div class="properties-box" >
                        <ul class="unstyle">
                            {!! $product['description'] !!}
                        </ul>
                    </div>
                    <ul class="social text-center" style="margin-top: 40px; margin-right: 10px;">
                        @foreach($shareLinks as $key=>$link)
                            <li><a style="color: #5da9a1; font-size: 25px" href="{{$link}}" target="_blank"
                                   class="fab fa-{{$key}}"></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection
