<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>
    
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="">
     <!-- CSS here -->
     <link rel="stylesheet" href="{{asset('web-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('web-assets/css/owl.carousel.min.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('web-assets/css/magnific-popup.css')}}"> -->
    <link rel="stylesheet" href="{{asset('web-assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('web-assets/css/themify-icons.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('web-assets/css/nice-select.css')}}"> -->
    <link rel="stylesheet" href="{{asset('web-assets/css/flaticon.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('web-assets/css/gijgo.css')}}"> -->
    <link rel="stylesheet" href="{{asset('web-assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('web-assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('web-assets/css/slicknav.css')}}">
    <link rel="stylesheet" href="{{asset('web-assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('web-assets/css/prism.css')}}">
    <link rel="stylesheet" href="css/responsive.css">
    <!-- <link rel="stylesheet" href="{{asset('animated_web/style.css')}}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('web-assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('web-assets/js/bootstrap.min.js')}}"></script>
    <style>
        .header-area .main-header-area {
            padding-top: 2px;
            padding-bottom: 2px;
        }
    </style>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js" integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
</head>

<body class="antialiased">
    @if (Auth::check() && Auth::user()->role == 0)
        @php
        $user_auth_data = [
            'isLoggedin' => true,
            'user' =>  Auth::user()
        ];
        @endphp
    @else
        @php
        $user_auth_data = [
            'isLoggedin' => false
        ];
        @endphp
    @endif
 
    <div id="app"></div>
    <!-- <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init();
    </script> -->
    <input type="hidden" value="{{url('/')}}" id="app_base_url">
    <input type="hidden" value="{{url('/')}}" id="not_found_image">
    <script>
        window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- JS here -->
    <script src="{{asset('web-assets/js/vendor/modernizr-3.5.0.min.js')}}"></script>
    <script src="{{asset('web-assets/js/popper.min.js')}}"></script>
    <script src="{{asset('web-assets/js/owl.carousel.min.js')}}"></script>
    <!-- <script src="{{asset('web-assets/js/isotope.pkgd.min.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/ajax-form.js')}}"></script> -->
    <script src="{{asset('web-assets/js/waypoints.min.js')}}"></script>
    <script src="{{asset('web-assets/js/jquery.counterup.min.js')}}"></script>
    <!-- <script src="{{asset('web-assets/js/imagesloaded.pkgd.min.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/scrollIt.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/jquery.scrollUp.min.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/wow.min.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/nice-select.min.js')}}"></script> -->
    <script src="{{asset('web-assets/js/jquery.slicknav.min.js')}}"></script>
    <!-- <script src="{{asset('web-assets/js/jquery.magnific-popup.min.js')}}"></script> -->
    <script src="{{asset('web-assets/js/plugins.js')}}"></script>
    <!-- <script src="{{asset('web-assets/js/gijgo.min.js')}}"></script> -->

    <!--contact js-->
    <!-- <script src="{{asset('web-assets/js/contact.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/jquery.ajaxchimp.min.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/jquery.form.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/jquery.validate.min.js')}}"></script> -->
    <!-- <script src="{{asset('web-assets/js/mail-script.js')}}"></script> -->
    <script src="{{asset('web-assets/js/main.js')}}"></script>
    <button id="scrollUp"><i class="ti-angle-double-up"></i></button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- <script src="{{asset('animated_web/index.js')}}"></script> -->
</body>

</html>