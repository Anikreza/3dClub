@extends('master')
@section('content')

    @include('pages.products.partial.topSection')
    <div class="shop-box-inner">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-sm-12 col-xs-12 shop-content-right">
                    <div class="right-product-box">
                        <div class="product-item-filter row">
                            <div class="col-12 col-sm-8 text-center text-sm-left">
                                <div class="toolbar-sorter-right">
                                    <span> <p>Showing {{$allArticles->count()}} Models Per Page</p></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 text-center text-sm-right">
                                <ul class="nav nav-tabs ml-auto">
                                    <li>
                                        <a class="nav-link active" href="#grid-view" data-toggle="tab"> <i
                                                class="fa fa-th"></i> </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="#list-view" data-toggle="tab"> <i
                                                class="fa fa-list-ul"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="product-categorie-box">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active" id="grid-view">
                                    <div class="row">
                                        @foreach($allArticles as $products)
                                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
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
                                </div>


                                <div role="tabpanel" class="tab-pane fade" id="list-view">

                                    <div class="list-view-box">

                                    </div>
                                    <div class="list-view-box">
                                        <div class="row">
                                            @foreach($allArticles as $products)
                                                @include('component.card.productsCardAlternative',
                                                                [
                                                                    'image' => $products['image'],
                                                                    'id'=>$products['id'],
                                                                    'title' => $products['title'],
                                                                    'slug' => $products['slug'],
                                                                    'excerpt' => $products['excerpt'],
                                                                    'price' => $products['price'],
                                                                    'description' => $products['description'],
                                                                    'category' => $category ?? $products['categories'],
                                                                ])
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 order-md-last">
                    <div class="button-area pagination-area">
                        <ul class="pagination text-center text-md-right" style="margin-left: 50%">
                            {{ $allArticles->render("pagination::bootstrap-4") }}
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12 sidebar-shop-left">
                    <div class="product-categori">
                        <div class="search-product">
                            <form action="#">
                                <input class="form-control" placeholder="Search here..." type="text">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="filter-sidebar-left">
                            <div class="title-left">
                                <h3>Cities</h3>
                            </div>
                            <div class="list-group list-group-collapse list-group-sm list-group-tree"
                                 id="list-group-men" data-children=".sub-men">
                                <div class="list-group-collapse sub-men">
                                    @foreach($categories as $key=>$category)
                                        @include('component.card.categoryOptions',
                                                [
                                                    'key'=>$key,
                                                    'category'=>$category,
                                                    'subCategory'=>$category->subCategory,
                                                    'title' => $category['name'],
                                                    'article' => $category->articles,
                                                    'parentCategory'=>$category->category,
                                                ])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
