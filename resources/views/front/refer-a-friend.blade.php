@extends('layouts.student.master')
@section('content')
<style>
    .mw-80 {
        max-width: 80px;
    }

    .student-ticket-view {
        width: 70%;
    }

    .content-refer h2 {
        font-weight: 600;
        font-size: 50px;
    }


</style>
<div class="">
<div class="pre-loader" style="display: block;"></div>
    <section class="section bg-light pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="content-refer">
                        <h2>Learning together is better!</h2>
                        <!-- <p>Refer a friend and you will get 20 USD off your next purchase </p>
                        <ul>
                            <li>Your friends get a 5 USD 45 min trial class</li>
                            <li>Share this Coupon : <code> trialclass</code></li>
                        </ul> -->
                    </div>
                    <div class="card link-box flex-fill col-10">
                        <div class="card-body">
                            <h3>Your Referral Link</h3>
                            <div class="form-group">
                                <input type="text"  class="form-control" value="{{url('/student/register/')}}?reffer_code={{ Auth::user()->reffer_code }}" id="myInput">
                            </div>
                            <a href="javascript:;" onclick="myFunction()" onmouseout="outFunc()"><span class="tooltiptext" id="myTooltip">Copy to link</span></a>
                        </div>
                    </div>
                    <div class="card link-box flex-fill col-10">
                        <div class="card-body">
                            <h3>Enter Your Friend Email To Send Referral Code</h3>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Your Friend Email">
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p>
                            </div>
                            <a href="javascript:;" onclick="emailsend()"><span class="tooltiptext" id="myTooltip">Send Mail</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('assets/img/refer-img.png') }}" class="w-100" alt="" />
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
<script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>
<script>
    $(document).ready(function(){
        $('.pre-loader').hide();
    });
</script>
<script>

function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "link has been copy successfully: " + copyText.value;
}
function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to link";
}
function emailsend() {
    $('.pre-loader').show();
    var email = $('#email').val();

    var referal = $('#myInput').val();
        $.ajax({
            url: "{{ route('student.referemail') }}",
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                'email': email,
                'referal':referal
            },
            success: function(response) {
                console.log(response);
                if(response.success==true) {
                    $('.pre-loader').hide();

                    toastr.success("Mail send Successfully");

                    // Swal.fire({
                    //     position: 'top-end',
                    //     icon: 'success',
                    //     title: 'Mail Send Successfully',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    //     })
                    window.setTimeout(function() {
                        window.location = "{{ url('/')}}"+"/student/refer-a-friend";
                    }, 2000);
                }
                if(response.success==false ) {
                    for (control in response.errors) {
                        var error_text = control.replace('.',"_");
                        $('#error-'+error_text).html(response.errors[control]);
                        // $('#error-'+error_text).html(response.errors[error_text][0]);
                        // console.log('#error-'+error_text);
                        $('.pre-loader').hide();
                    }
                    // console.log(response.errors);
                }
            }
        });
}
</script>
@endpush
