<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    {!! SEO::generate() !!}
    <link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700" rel="stylesheet">

    <link href="{{ asset('assets/css/templatemo-sixteen.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/owl.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style2.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">--}}

{{--    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">--}}

</head>

<body>
@include('layouts.navbar')
<div id="preloader">
    <div class="jumper">
        <div></div>
    </div>
</div>
@yield('content')
@include('layouts.footer')

<!-- Bootstrap core JavaScript -->

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"> </script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"> </script>

<!-- Additional Scripts -->
<script src="{{ asset('assets/js/custom.js') }}"> </script>
<script src="{{ asset('assets/js/owl.js') }}"> </script>
{{--<script src="{{ asset('assets/js/slick.js') }}"> </script>--}}
{{--<script src="{{ asset('assets/js/isotope.js') }}"> </script>--}}
{{--<script src="{{ asset('assets/js/accordions.js') }}"> </script>--}}
{{--<script src="{{ asset('assets/js/accordions.js') }}"> </script>--}}
{{--<script src="{{ asset('assets/js/jquery-.js') }}"> </script>--}}
{{--<script src="{{ asset('assets/js/bootstrap.min.js') }}"> </script>--}}
{{--<script src="{{ asset('assets/js/js/anim.js') }}"> </script>--}}

{{--<script language = "text/Javascript">--}}
{{--    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field--}}
{{--    function clearField(t){                   //declaring the array outside of the--}}
{{--        if(! cleared[t.id]){                      // function makes it static and global--}}
{{--            cleared[t.id] = 1;  // you could use true and false, but that's more typing--}}
{{--            t.value='';         // with more chance of typos--}}
{{--            t.style.color='#fff';--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}

</body>
</html>

