@extends('master')
@section('content')
    @foreach($cart as $products)
        <div class="col-md-4">

            @include('component.card.cartCard',
                    [
                        'title' => $products->name,
                        'price' => $products->price,
                        'image' => $products->options->image,
                        'quantity' => $products->qty,
                        'subTotal' => $subtotal,
                        'count'=>$count,

                    ])
        </div>
    @endforeach

@endsection
