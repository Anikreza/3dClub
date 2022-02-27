<div class="latest-products">
    <div class="container">
        <div class="row"><h2 style="margin-left: 20px;">Featured Products</h2>
            <div class="col-md-12">
                <div class="section-heading">
                    <a href="{{route('shop')}}">view all products <i class="fa fa-angle-right"></i></a>
                </div>
            </div>

            @foreach($featuredArticles as $products)
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

