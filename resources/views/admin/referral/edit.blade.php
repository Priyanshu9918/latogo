@extends('layouts.admin.master')
@section('content')
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Referral Coupon Management</h4>
    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Referral Coupon</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.referral.edit',['id'=>base64_encode($new->id)]) }}" method="POST" id="editFrm" enctype="multipart/form-data">
              @csrf
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Referral Amount</label>
                <div class="col-sm-8">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                    <input type="number" class="form-control" name="referral" id="basic-icon-default-fullname" value="{{$new->referral}}">
                  </div>
                  <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-referral"></p>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Referral Coupon</label>
                <div class="col-sm-8">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                    <input type="text" class="form-control" name="referral_coupon" id="basic-icon-default-fullname" value="{{$new->referral_coupon}}">
                  </div>
                  <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-referral_coupon"></p>
                </div>
              </div>



              {{--<div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Referring</label>
                <div class="col-sm-8">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                    <input type="text" class="form-control" name="referring" id="basic-icon-default-fullname" value="{{$new->referring}}">
                  </div>
                  <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-referring"></p>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Referring Coupon</label>
                <div class="col-sm-8">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"></span>
                    <input type="text" class="form-control" name="referring_coupon" id="basic-icon-default-fullname" value="{{$new->referring_coupon}}">
                  </div>
                  <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-referring_coupon"></p>
                </div>
              </div>--}}
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endsection
      @push('script')
      <script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>
      <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js
"></script>
      <link src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
      </link>
      <script>
        $(document).ready(function() {
          //on change country

          $(document).on('submit', 'form#editFrm', function(event) {
            event.preventDefault();
            //clearing the error msg
            $('p.error_container').html("");

            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            $('.submit').attr('disabled', true);
            $('.form-control').attr('readonly', true);
            $('.form-control').addClass('disabled-link');
            $('.error-control').addClass('disabled-link');
            if ($('.submit').html() !== loadingText) {
              $('.submit').html(loadingText);
            }
            $.ajax({
              type: form.attr('method'),
              url: url,
              data: data,
              cache: false,
              contentType: false,
              processData: false,
              success: function(response) {
                window.setTimeout(function() {
                  $('.submit').attr('disabled', false);
                  $('.form-control').attr('readonly', false);
                  $('.form-control').removeClass('disabled-link');
                  $('.error-control').removeClass('disabled-link');
                  $('.submit').html('Update');
                }, 2000);
                //console.log(response);
                if (response.success == true) {

                  //notify
                  toastr.success("Referral Management updated Successfully");
                  // Swal.fire({
                  //   position: 'top-end',
                  //   icon: 'success',
                  //   title: ' Referral  Updated Successfully',
                  //   showConfirmButton: false,
                  //   timer: 1500
                  // })
                  // redirect to google after 5 seconds
                  window.setTimeout(function() {
                    window.location = "{{ url('/')}}" + "/admin/referral";
                  }, 2000);

                }
                //show the form validates error
                if (response.success == false) {
                  for (control in response.errors) {
                    var error_text = control.replace('.', "_");
                    $('#error-' + error_text).html(response.errors[control]);
                   
                  }
                  // console.log(response.errors);
                }
              },
              error: function(response) {
                // alert("Error: " + errorThrown);
                console.log(response);
              }
            });
            event.stopImmediatePropagation();
            return false;
          });
        });
       
      </script>
      @endpush
