@extends('master')
@section('content')

    @include('pages.products.topSection')
    <section class="item content">
        <div class="container toparea" style="margin-top: -200px">
            <div class="underlined-title">
                <div class="editContent">
{{--                    <h1 class="text-center latestitems">OUR PRODUCTS</h1>--}}
                </div>
{{--                <div class="wow-hr type_short">--}}
{{--			<span class="wow-hr-h">--}}
{{--			<i class="fa fa-star"></i>--}}
{{--			<i class="fa fa-star"></i>--}}
{{--			<i class="fa fa-star"></i>--}}
{{--			</span>--}}
{{--                </div>--}}
            </div>
            <div class="row">
                @foreach($allArticles as $products)
                    <div class="col-md-4">

                        @include('component.card.productsCard',
                                [
                                    'image' => $products['image'],
                                    'id'=>$products['id'],
                                    'title' => $products['title'],
                                    'slug' => $products['slug'],
                                    'excerpt' => $products['excerpt'],
                                    'price' => $products['price'],
                                    'stock' => $products['stock'],
                                    'category' => $category ?? $products['categories'],
                                ])
                    </div>
                @endforeach
            </div>
            <div class="col-md-8 order-md-last">
                <div class="button-area pagination-area">
                    <ul class="pagination text-center text-md-right" style="margin-left: 30%">
                        {{ $allArticles->render("pagination::bootstrap-4") }}
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery-.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/anim.js"></script>
    <script>
        //----HOVER CAPTION---//
        jQuery(document).ready(function ($) {
            $('.fadeshop').hover(
                function () {
                    $(this).find('.captionshop').fadeIn(150);
                },
                function () {
                    $(this).find('.captionshop').fadeOut(150);
                }
            );
        });
    </script>
@endsection
