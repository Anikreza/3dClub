@extends('master')
@section('content')

    <section class="item content " style="margin-top: -100px">
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
                    <img src="{{asset($product->image)}}" alt="" style="width: 100%; box-shadow: 3px 3px 3px 3px #707070; border-radius: 75px">
                    <div class="clearfix">
                    </div>
                    <br/>
                    <div class="product-details text-left">
                        {!! $product['description'] !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('component.card.addToCart',['model'=>$product['id'],'stock'=>$product['stock']])
                <div class="properties-box">
                    <ul class="unstyle">
                        <li><b class="propertyname">Version:</b> 1.0</li>
                        <li><b class="propertyname">Image Size:</b> 2340x1200</li>
                        <li><b class="propertyname">Files Included:</b> mp3, audio, jpeg, png</li>
                        <li><b class="propertyname">Documentation:</b> Well Documented</li>
                        <li><b class="propertyname">License:</b> GNU</li>
                        <li><b class="propertyname">Requires:</b> Easy Digital Downloads</li>
                        <li><b class="propertyname">Environment:</b> Wordpress</li>
                        <li><b class="propertyname">Any Field Etc:</b> Any Detail</li>
                        <li><b class="propertyname">Number:</b> Up to 20 specifications in this box</li>
                        <li><b class="propertyname">Live Demo:</b><a target="_blank" href="http://www.wowthemes.net/">http://www.wowthemes.net/</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
