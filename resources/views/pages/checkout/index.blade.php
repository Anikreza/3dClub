@extends('master')
@section('content')

    <div style="">
        <div style="padding: 100px 200px 200px 200px">

            <div class="col-md-12">
                <div class="checkout-address">
                    <div class="title-left">
                        <h3>Billing address</h3>
                    </div>
                    <form class="needs-validation" action="{{route('checkout')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First name *</label>
                                <input style="background-color: #e3e3e3" type="text" class="form-control" id="firstName" name="firstName" placeholder=""
                                       value="" required>
                                <div class="invalid-feedback"> Valid first name is required.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Last name *</label>
                                <input style="background-color: #e3e3e3" type="text" class="form-control" id="lastName" name="lastName" placeholder=""
                                       value="" required>
                                <div class="invalid-feedback"> Valid last name is required.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email Address *</label>
                            <input style="background-color: #e3e3e3" type="email" class="form-control" id="email" name="email" placeholder="" required>
                            <div class="invalid-feedback"> Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input style="background-color: #e3e3e3" type="checkbox" class="custom-control-input" id="save-info">
                            <label class="custom-control-label" for="save-info">Save this information for next
                                time</label>
                        </div>
                        <hr class="mb-4">
                        <div class="title"><span>Payment</span></div>
                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input style="background-color: #e3e3e3" id="credit" name="paymentMethod" type="radio" class="custom-control-input"
                                       checked required>
                                <label class="custom-control-label" for="credit">Credit card</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input style="background-color: #e3e3e3" id="debit" name="paymentMethod" type="radio" class="custom-control-input"
                                       required>
                                <label class="custom-control-label" for="debit">Debit card</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input style="background-color: #e3e3e3" id="paypal" name="paymentMethod" type="radio" class="custom-control-input"
                                       required>
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc-name">Name on card</label>
                                <input style="background-color: #e3e3e3" type="text" name="cardName" class="form-control" id="cc-name" placeholder=""
                                       required> <small class="text-muted">Full name as displayed on card</small>
                                <div class="invalid-feedback"> Name on card is required</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-number">Credit card number</label>
                                <input style="background-color: #e3e3e3" type="text" name="cardNumber" class="form-control" id="cc-number" placeholder=""
                                       required>
                                <div class="invalid-feedback"> Credit card number is required</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">Expiration</label>
                                <input style="background-color: #e3e3e3" type="text" name="cardExpiration" class="form-control" id="cc-expiration"
                                       placeholder="" required>
                                <div class="invalid-feedback"> Expiration date required</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">CVV</label>
                                <input style="background-color: #e3e3e3" type="text" name="cvv" class="form-control" id="cc-cvv" placeholder="" required>
                                <div class="invalid-feedback"> Security code required</div>
                            </div>
                            <input type="hidden" value="">
                            <div class="col-md-6 mb-3">
                                <div class="payment-icon">
                                    <ul>
                                        <li><img class="img-fluid" src="images/payment-icon/1.png" alt=""></li>
                                        <li><img class="img-fluid" src="images/payment-icon/2.png" alt=""></li>
                                        <li><img class="img-fluid" src="images/payment-icon/3.png" alt=""></li>
                                        <li><img class="img-fluid" src="images/payment-icon/5.png" alt=""></li>
                                        <li><img class="img-fluid" src="images/payment-icon/7.png" alt=""></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex shopping-box">
                            <button type="submit" class="ml-auto btn hvr-hover">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
