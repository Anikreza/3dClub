@extends('master')
@section('content')

    <div class="page-heading contact-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>contact us</h4>
                        <h2>let’s get in touch</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="find-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Our Location on Maps</h2>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- How to change your own map point
                        1. Go to Google Maps
                        2. Click on your location point
                        3. Click "Share" and choose "Embed map" tab
                        4. Copy only URL and paste it within the src="" field below
                    -->
                    <div id="map">
                        <iframe
                            src="https://maps.google.com/maps?q=+Gopalganj,+bankpara,+badar +road,284+Bangladesh&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            width="100%" height="330px" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="left-content">
                        <h4>About our office</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester
                            consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic
                            elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti.</p>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div style="padding: 100px 300px 150px 200px">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2 style="margin-left: 40%">Send us a Message</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="contact-form">
                        <form class="learn-more detailslearn" style="margin: 25px 25px" action="{{route("sendMail")}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" class="form-control" id="name"
                                               placeholder="Full Name"
                                               value="{{old('name')}}"
                                               style="background: #dcdcdc"
                                               required="">
                                    </fieldset>
                                    @error('name')<span class="text-danger">{{$message}}</span>@enderror

                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="text" class="form-control" id="email"
                                               placeholder="E-Mail Address"
                                               value="{{old('email')}}"
                                               style="background: #dcdcdc"
                                               required="">
                                        @error('email')<span class="text-danger">{{$message}}</span>@enderror
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="subject" type="text" class="form-control" id="subject"
                                               placeholder="Subject"
                                               value="{{old('subject')}}"
                                               style="background: #dcdcdc"
                                               required="">
                                        @error('subject')<span class="text-danger">{{$message}}</span>@enderror
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="3" class="form-control" id="message"
                                                  placeholder="Your Message"
                                                  value="{{old('message')}}"
                                                  style="background: #dcdcdc"
                                                  required=""></textarea>
                                        @error('message')<span class="text-danger">{{$message}}</span>@enderror
                                    </fieldset>
                                </div>
                                @if (Session::has('success'))
                                    <p style="color:#1e3319; font-size: 18px">
                                        {{Session::get('success')}}
                                    </p>
                                @endif
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="filled-button">Send Message
                                        </button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


@endsection
