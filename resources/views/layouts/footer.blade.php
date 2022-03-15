<!-- footer -->
<footer class="section footer bg-dark-alt tc-light footer-s1">
    <div class="container">
        <div class="row gutter-vr-30px">
            <div class="col-lg-2 col-sm-12" style="margin-top: -5%">
                        <div class="wgs-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{asset('assets/images/logo.png')}}">
                            </a>
                        </div>
                        <p style="color:#546b77 ">&copy;2022. All rights reserved</p>
                    </div>

            <div class="col-lg-3 col-sm-12">
                <div class="wgs">
                    <div class="wgs-content">
                        <h5 class="wgs-title"> LINKS</h5>
                        <ul class="wgs-menu" style="display: flex; flex-direction: column; margin-top: -10px">
                            <a style="font-size: 13px; color:#546b77 " href="{{ route('about') }}" class="footer-links">About Us</a>
                            <a style="font-size: 13px;color:#546b77 " href="{{ route('shop') }}" class="footer-links">Our Models</a>
                            <a style="font-size: 13px;color:#546b77 " href="{{ route('contact') }}" class="footer-links">Contact Us</a>
                        </ul>
                    </div>
                </div><!-- .wgs -->
            </div><!-- .col -->
            <div  style="display: flex; justify-content: space-evenly; width: 33%">
                <div class="wgs">
                    <div class="wgs-content">
                        <h5 class="wgs-title">OTHERS</h5>
                        <ul class="wgs-menu">
                            @foreach($footerPages as $pageLink)
                                <a style="font-size: 12px;color:#546b77; margin-top: -10px"
                                   href="{{ route('productDetails', ['slug' => $pageLink['page']['slug']]) }}">{{ $pageLink['page']['title'] }}</a>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- .wgs -->
            </div><!-- .col -->
            <div class="col-lg-3 col-md-auto">
                <div class="wgs">
                    <div class="wgs-content">
                        <h5 class="wgs-title">NEWSLETTER</h5>
                        <form class="genox-form" action="{{route('newsLetter')}}" method="POST">
                            @csrf
                            <div class="form-results"></div>
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            <div style="display: flex">
                                <input name="email" type="email"
                                       style="min-height: 35px; margin-left: 22%; padding-left: 20px; background-color: inherit;color: #546b77;border:.2px solid #546b77"
                                       placeholder="Your  Email"
                                       required
                                >
                                @error('email')<span class="text-danger">{{$message}}</span>@enderror
                                <span>
                                    <button style="min-height: 35px;border-style: none; background-color: #546b77; cursor: pointer" type="submit" class="far fa-paper-plane button"></button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div><!-- .wgs -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</footer>
