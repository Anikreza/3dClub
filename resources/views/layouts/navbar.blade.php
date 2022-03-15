
<!-- Header -->
<header style="position: fixed; top: 0;    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.1);
">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}"><h2>3d <em>Club</em></h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li {!! (Request::url() == url('/')) ? ' class="nav-item active"' : 'nav-item' !!}>
                        <a class="nav-link" href="/">Home
                        </a>
                    </li>
                    <li {!! (Request::url() == url('/products')) ? ' class="nav-item active"' : 'nav-item' !!}>
                        <a class="nav-link" href="{{ route('shop') }}">Our Models</a>
                    </li>
                    <li {!! (Request::url() == url('/about')) ? ' class="nav-item active"' : 'nav-item' !!}>
                        <a class="nav-link" href="{{route('about')}}">About Us</a>
                    </li>
                    <li {!! (Request::url() == url('/contact')) ? ' class="nav-item active"' : 'nav-item' !!}>
                        <a class="nav-link" href="{{route('contact')}}">Contact Us</a>
                    </li>
                    <li {!! (Request::url() == url('/cartItems')) ? ' class="nav-item active"' : 'nav-item' !!}>
                        <a class="nav-link" href="{{route('cartItems')}}">
                            <i class="fas fa-shopping-cart"></i>
                            <span style="margin-left: 1px;">{{\Gloudemans\Shoppingcart\Facades\Cart::count()}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
