@extends('master')
@section('content')
    <div class="cart-box-main" style=" padding: 130px">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-main table-responsive table-hover">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Model</th>
                                <th>Price</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (session()->has('success_message'))
                                <div class="alert alert-success">
                                    {{ session()->get('success_message') }}
                                </div>
                            @endif
                            @foreach($cartItems as $products)
                                <tr>
                                    @include('component.card.cartCard',
                                            [

                                                'id'=>$products->rowId,
                                                'title' => $products->name,
                                                'price' => $products->price,
                                                'image' => $products->options->image,
                                                'quantity' => $products->qty,
                                                'subTotal' => $subtotal,
                                                'count'=>$count,

                                            ])
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                <div class="row my-5">
                <div class="col-lg-6 col-sm-6">
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <hr>
                        <h3>Order summary</h3>
                        <hr>
                        <div class="d-flex">
                            <h4>Sub Total</h4>
                            <div class="ml-auto font-weight-bold"> ${{\Gloudemans\Shoppingcart\Facades\Cart::subtotal()}}</div>
                        </div>
                        <hr class="my-1">
{{--                        <div class="d-flex">--}}
{{--                            <h4>Coupon Discount</h4>--}}
{{--                            <div class="ml-auto font-weight-bold"> $ 10</div>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex">--}}
{{--                            <h4>Tax</h4>--}}
{{--                            <div class="ml-auto font-weight-bold"> $ 2</div>--}}
{{--                        </div>--}}
{{--                        <div class="d-flex">--}}
{{--                            <h4>Shipping Cost</h4>--}}
{{--                            <div class="ml-auto font-weight-bold"> Free</div>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="d-flex gr-total">--}}
{{--                            <h5>Grand Total</h5>--}}
{{--                            <div class="ml-auto h5"> $ 388</div>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="col-12 d-flex shopping-box"><a href="{{ route('order') }}"
                                                           class="ml-auto btn hvr-hover">Checkout</a></div>
            </div>
        </div>
    </div>


@endsection
