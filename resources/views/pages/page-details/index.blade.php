@extends('master')
@section('content')
    <div class="section blog section-x" style="margin-top: 100px">
        <div class="container">
            @include('component.breadcrumb')
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="post post-full post-details">
                        <div class="post-entry d-sm-flex d-block align-items-start">
                            <div class="content-left d-flex d-sm-block">
                                <ul class="social text-center" style="margin-top: 40px; margin-right: 10px">
                                    @foreach($shareLinks as $key=>$link)
                                        <li><a style="color: #5da9a1; font-size: 25px" href="{{$link}}" target="_blank" class="pin fab fa-{{$key}}"></a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="post-content post-content-wd">
                                <div class="post-meta d-block d-lg-flex align-items-center">
                                    <div class="post-author d-flex align-items-center flex-shrink-0 align-self-start">
                                    </div>
                                </div>
                                <h3 style="text-align: center">{{ $page['title'] }}</h3>

                                <div class="content">
                                    {!! $page['description'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- post -->
                    <!-- tags -->
                    <br/>
                    <br/>
                    <!-- tags -->
                    <!-- similar Posts -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div>
@endsection
