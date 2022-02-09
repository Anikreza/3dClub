<form class="learn-more detailslearn" style="margin: 25px 25px" action="{{route("addToCart")}}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value={{$model}}>
    <button class="btn btn-buynow"><i class="fa fa-shopping-cart"></i> purchase</button>
</form>

<div style="display: none">
    <?php foreach (Cart::content() as $row) : ?>
            <?php $row->qty = 1 ?>
    <?php endforeach;?>
</div>
