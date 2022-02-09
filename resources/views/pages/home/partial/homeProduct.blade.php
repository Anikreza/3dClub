
<div class="latest-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h2>Latest Products</h2>
                    <a href="{{route('shop')}}">view all products <i class="fa fa-angle-right"></i></a>
                </div>
            </div>

                @foreach($products as $products)
                <div class="col-md-4">

                @include('component.card.homeProductCard',
                        [
                            'image' => $products['image'],
                            'title' => $products['title'],
                            'slug' => $products['slug'],
                            'excerpt' => $products['excerpt'],
                            'price' => $products['price'],
                            'category' => $category ?? $products['categories'],
                        ])
                </div>

            @endforeach

        </div>
    </div>
</div>

