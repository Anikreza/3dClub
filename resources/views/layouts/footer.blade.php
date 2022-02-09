<!-- footer -->
<footer class="section footer bg-dark-alt tc-light footer-s1">
    <div class="container">
        <div class="row gutter-vr-30px">
            <div class="col-lg-3 col-sm-6">
                <div class="wgs">
                    <div class="wgs-content">
                        <div class="wgs-logo">
                            <a class="navbar-brand" href="{{ route('home') }}"><h2>3d <em>Club</em></h2></a>
                        </div>
                        <p>&copy; 2019. All rights reserved.<br> Designed & Developed by <a href="#">Softnio</a></p>
                    </div>
                </div><!-- .wgs -->
            </div><!-- .col -->
            <div class="col-lg-3 col-sm-6">
                <div class="wgs">
                    <div class="wgs-content">
                        <h3 class="wgs-title"> About</h3>
                        <ul class="wgs-menu">
                            <a href="{{ url('columnist') }}" class="footer-links">Columnist</a>
                        </ul>
                    </div>
                </div><!-- .wgs -->
            </div><!-- .col -->
            <div class="col-lg-3 col-sm-6">
                <div class="wgs">
                    <div class="wgs-content">
                        <h3 class="wgs-title">Services</h3>
                        <ul class="wgs-menu">
                            @foreach($footerPages as $pageLink)
                                <a href="{{ route('productDetails', ['slug' => $pageLink['page']['slug']]) }}">{{ $pageLink['page']['title'] }}</a>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- .wgs -->
            </div><!-- .col -->
            <div class="col-lg-3 col-sm-6">
                <div class="wgs">
                    <div class="wgs-content">
                        <h3 class="wgs-title">Get our staff</h3>
                        <form class="genox-form" action="form/subscribe.php" method="POST">
                            <div class="form-results"></div>
                            <div class="field-group btn-inline">
                                <input name="s_email" type="email" class="input" placeholder="Your  Email">
                                <input type="text" class="d-none" name="form-anti-honeypot" value="">
                                <button type="submit"  class="far fa-paper-plane button"></button>
                            </div>
                        </form>
                    </div>
                </div><!-- .wgs -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</footer>
<!-- .footer -->

<!-- preloader -->
<div class="preloader preloader-light preloader-dalas no-split"><span class="spinner spinner-alt"><img class="spinner-brand" src="{{ asset('assets/images/logo-white.png') }}" src="images/logo-white.png" alt=""></span></div>

<!-- JavaScript -->
<script src="{{ asset('assets/js/jquery.bundle.js?ver=141') }}"></script>
<script src="{{ asset('assets/js/scripts.js?ver=141') }}"></script>
