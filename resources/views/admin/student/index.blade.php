@extends('layouts.admin.master')
@section('content')
<style>
    /* .cu{
        position: relative;
    left: 850px;
    } */
</style>
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">

            <div class="card">
                <div class="card-body">
                
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <h4 class="card-title m-0">Student</h4>
                    <a href="/admin/student/create" class="btn btn-primary btn-rounded cu">
                        <i class="fa fa-plus-circle mr-1"></i>
                         <span style="bottom: 3px; position: relative;"> Add Student</span></a>
                </div>
                    <div class="row">
                    <div class="col-12">
                        <table id="student-datatable" class="table">
                        <thead style="background:#a0b8ed29;">
                            <tr>
                                <th> #</th>
                                <th><b>Name</b></th>
                                <th><b>Email</b></th>
                                <th><b>Created At</b></th>
                                <th><b>Action</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>

            <!-- modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" style="height:590px;">
                <div class="modal-header" style="background:#dbdbdb;">
                <h4 class="fw-bold" id="head_cred">Total Credits : <span class="credit1"></span></h4>
                </div>
                <div class="modal-body flex-grow-0" >
                <form action="{{route('admin.credit.add')}}" method="POST" id="createFrm">
                    @csrf
                    <input type="hidden" class="form-control" name="user_id" id="user1" value="" />
                    <input type="hidden" class="form-control" name="price_master" id="price_master" value="" />
                    <input type="hidden" class="form-control" name="cred_value" id="cred_value" value="" />
                    <div class="container">
                        <label class="fw-bold">Class Category</label>
                        <select class="form-select class" aria-label="Default select example" name="class" id="class_id">
                            <option>Select Class Category</option>
                        </select>
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-class"></p>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                    <div class="container" id="tiz">
                        <label class="fw-bold">Time</label>
                        <select class="form-select time" aria-label="Default select example" name="time" id="time_id">

                        </select>
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-time"></p>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                    <div class="container" id="tiz">
                        <label class="fw-bold">Class Type</label>
                        <select class="form-select class1" aria-label="Default select example" name="class_type" id="class_type">

                        </select>
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-class_type"></p>
                        <p style="margin-bottom: 2px;" class="text-warning error_container" id="error111-class_type"></p>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                    <div class="container" id="tiz">
                        <label class="fw-bold">Add Credit</label>
                        <input type="number" class="form-control" name="credit" id="credit" />
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-credit"></p>
                    </div>
                </div>
                <div class="modal-footer text-center justify-content-center" >
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Save</button>
                </div>
                </form>
                </div>
            </div>
            </div>
@endsection
@push('script')

<script>
    $(document).ready(function(){

        if ($("#student-datatable").length > 0) {
            /*Checkbox Add*/
            var tdCnt=0;
            var targetDt = $('#student-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('admin.student')}}",

                columns: [

                        //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'check', name: 'check'},

                        {data: 'name', name: 'name'},

                        {data: 'email', name: 'email'},

                        {data: 'created_at', name: 'created_at'},

                        {data: 'action', name: 'action'},

                    ],

                "dom": '<"row"<"col-7 mb-3"<"contact-toolbar-left">><"col-5 mb-3"<"contact-toolbar-right"f>>><"row"<"col-sm-12"t>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',

                "ordering": false,

                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0,3]
                } ],

                //"order": [3, 'desc' ],

                language: { search: "",
                    searchPlaceholder: "Search",
                    "info": "_START_ - _END_ of _TOTAL_",
                    sLengthMenu: "View  _MENU_",
                    paginate: {
                    next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
                    previous: '<i class="ri-arrow-left-s-line"></i>' // or '←'
                    }
                },
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple pagination-sm');
                }
            });

            // $('table tr').each(function(){
            //     $('<span class="form-check mb-0"><input type="checkbox" class="form-check-input check-select" id="chk_sel_'+tdCnt+'"><label class="form-check-label" for="chk_sel_'+tdCnt+'"></label></span>').appendTo($(this).find("td:first-child"));
            //     tdCnt++;
            // });
            // $(document).on('click', '.del-button', function () {
            //     targetDt.rows('.selected').remove().draw( false );
            //     return false;
            // });
            //$("div.contact-toolbar-left").html('<div class="d-xxl-flex d-none align-items-center"><div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example"><button type="button" class="btn btn-outline-light active">View all</button><button type="button" class="btn btn-outline-light">Monitored</button><button type="button" class="btn btn-outline-light">Unmonitored</button></div>');
            $("div.contact-toolbar-right").addClass('d-flex justify-content-end').append('	<button class="btn btn-sm btn-outline-light ms-3"><span><span class="icon"><i class="bi bi-filter"></i></span><span class="btn-text">Filters</span></span></button>');
            $("#student-datatable").parent().addClass('table-responsive');

            /*Select all using checkbox*/
            var  DT1 = $('#student-datatable').DataTable();
            $(".check-select-all").on( "click", function(e) {
                $('.check-select').attr('checked', true);
                if ($(this).is( ":checked" )) {
                    DT1.rows().select();
                    $('.check-select').prop('checked', true);
                } else {
                    DT1.rows().deselect();
                    $('.check-select').prop('checked', false);
                }
            });
            $(".check-select").on( "click", function(e) {
                if ($(this).is( ":checked" )) {
                    $(this).closest('tr').addClass('selected');
                } else {
                    $(this).closest('tr').removeClass('selected');
                    $('.check-select-all').prop('checked', false);
                }
            });
        }


        $(document).on('click', '.statusBtn', function (event) {
            var id = $(this).attr('data-id');
            var type =$(this).attr('data-type');
            //  alert(user_id);
            var table = 'users';
            //alert('hello');

            swal({
                // icon: "warning",
                type: "warning",
                title: "Do you Want to Change The Status?",
                text: "",
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#007358",
                confirmButtonText: "YES",
                cancelButtonText: "CANCEL",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(e){
                if(e==true)
                {
                    $.ajax({
                        type:'POST',
                        url: "{{route('admin.status-action')}}",
                        data: {"_token" : "{{ csrf_token() }}",'id':id,'table_name':table,'type':type},
                        success: function (response) {

                            //console.log(response);
                            if (response.success) {
                                // window.setTimeout(function(){
                                //    location.reload();
                                // },2000);
                                // toastr.success("Status Changed Successfully");

                                if(response.type=='enable')
                                {
                                    $('table.categoryTable tr').find("[data-ac='" + id + "']").fadeIn("slow");
                                    $('table.categoryTable tr').find("[data-ac='" + id + "']").removeClass("d-none");

                                    $('table.categoryTable tr').find("[data-dc='" + id + "']").fadeOut("slow");

                                    $('table.categoryTable tr').find("[data-dc='" + id + "']").addClass("d-none");

                                }
                                else if(response.type=='disable')
                                {
                                    $('table.categoryTable tr').find("[data-dc='" + id + "']").fadeIn("slow");
                                    $('table.categoryTable tr').find("[data-dc='" + id + "']").removeClass("d-none");

                                    $('table.categoryTable tr').find("[data-ac='" + id + "']").fadeOut("slow");

                                    $('table.categoryTable tr').find("[data-ac='" + id + "']").addClass("d-none");
                                }

                                toastr.success(response.message);

                                window.setTimeout(()=>{
                                    window.location.reload();
                                },2000);
                            }
                            else {

                            }

                            swal.close();

                        },
                        error: function (xhr, textStatus, errorThrown) {
                            // alert("Error: " + errorThrown);
                        }

                    });
                }
                else
                {
                    swal.close();
                }
            });

        });

        $(document).on('click','.deleteBtn',function(){
            
            var _this=$(this);
            // var result=confirm("Are You Sure You Want to Delete?");
            var id = $(this).data('id');
            var table = 'users';
            swal({
                    // icon: "warning",
                    type: "warning",
                    title: "Are You Sure You Want to Delete?",
                    text: "",
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonColor: "#007358",
                    confirmButtonText: "YES",
                    cancelButtonText: "CANCEL",
                    closeOnConfirm: false,
                    closeOnCancel: false
                    },
                    function(e){
                        if(e==true)
                        {
                            _this.addClass('disabled-link');
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "{{route('admin.pureDelete')}}",
                                data: {"_token": "{{ csrf_token() }}",'id': id,'table_name':table},
                                success: function(data){
                                    console.log(data);
                                    window.setTimeout(function(){
                                    _this.removeClass('disabled-link');
                                    },2000);

                                    if(data.code==200)
                                    {
                                        window.setTimeout(function(){
                                            window.location.reload();
                                        },2000);
                                    }
                                },
                                error : function(response)
                                {
                                    console.log(response);
                                }
                            });
                            swal.close();
                        }
                        else
                        {
                            swal.close();
                        }
                    }
            );
        });

        $(document).on('click', '.creditBtn', function (event) {
            var id = $(this).attr('data-id');
            $("#error111-class_type").html('');
            var c_val = $('#cred_value').val();
            $("#head_cred1").replaceWith('<h4 class="fw-bold" id="head_cred">Total Credits : <span class="credit1"> '+c_val+' </span></h4>');
            $.ajax({
                url: "{{ route('admin.credit') }}",
                type: "get",
                data: {
                    'id': id,
                },
                success: function(response) {
                    console.log(response);
                    if(response.success==true) {
                    $('.credit1').html(response.credit);
                    $('#cred_value').val(response.credit);
                    $('#user1').val(response.user_id);
                    $("#class_id").empty();
                    $("#class_id").html('<option value="">Select Class Type</option>');
                    $.each(response.class,function(key,value){
                    $("#class_id").append('<option value="'+value.id+'">'+value.title+'</option>');
                    });
                    $("#exampleModalCenter").modal("show");
                    }
                }
            });
        });

        $(document).on('change','.class',function(){
            var id = $('#class_id').val();
            var c_val = $('#cred_value').val();
            $("#head_cred1").replaceWith('<h4 class="fw-bold" id="head_cred">Total Credits : <span class="credit1"> '+c_val+' </span></h4>');
            $("#error111-class_type").html('');
            $.ajax({
                type:"get",
                url:"{{route('admin.time')}}",
                data:{'country_id':id,"_token": "{{ csrf_token() }}"},
                success:function(response)
                {
                    if(response.success==true) {
                        $('#price_master').val(response.price_master);
                        $("#time_id").empty();
                        $("#time_id").html('<option value="">Select Time</option>');
                        $.each(response.time,function(key,value){
                            console.log(value.time);
                            var t = value.time;
                        $("#time_id").append('<option value="'+t+'">'+t+' min'+'</option>');
                        });
                    }
                }
            });
        });

        $(document).on('change','.time',function(){
            var time = $('#time_id').val();
            var price = $('#price_master').val();
            var c_val = $('#cred_value').val();
            $("#head_cred").replaceWith('<h4 class="fw-bold" id="head_cred">Total Credits : <span class="credit1"> '+c_val+' </span></h4>');
            $("#error111-class_type").html('');
            $.ajax({
                type:"get",
                url:"{{route('admin.classtype')}}",
                data:{'time':time,'price':price,"_token": "{{ csrf_token() }}"},
                success:function(response)
                {
                    if(response.success==true) {
                        $("#class_type").empty();
                        $("#class_type").html('<option value="">Select Time</option>');
                        $.each(response.pricing,function(key,value){
                            console.log(value.time);
                        $("#class_type").append('<option value="'+value.id+'">'+value.totle_class+'x Classes'+'</option>');
                        });
                    }
                }
            });
        });

        $(document).on('change','.class1',function(){
            var class1 = $('#class_type').val();
            var user_id = $('#user1').val();
            $.ajax({
                type:"get",
                url:"{{route('admin.creditclass')}}",
                data:{'class1':class1,'user_id':user_id,"_token": "{{ csrf_token() }}"},
                success:function(response)
                {
                    if(response.success==true) {
                        $("#credit").empty();
                        $("#credit").val(response.credit);
                        $("#head_cred").replaceWith('<h4 class="fw-bold" id="head_cred"> Credits : <span class="credit1"> '+response.credit_value+' </span></h4>');
                        $("#error111-class_type").html('Remaining '+response.credit_value+' Credits in this class!');
                    }
                }
            });
        });

        $(document).on('submit', 'form#createFrm', function (event) {
            event.preventDefault();
            //clearing the error msg
            $('p.error_container').html("");

            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            $('.submit').attr('disabled',true);
            $('.form-control').attr('readonly',true);
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
                success: function (response) {
                    window.setTimeout(function(){
                        $('.submit').attr('disabled',false);
                        $('.form-control').attr('readonly',false);
                        $('.form-control').removeClass('disabled-link');
                        $('.error-control').removeClass('disabled-link');
                        $('.submit').html('Save');
                      },2000);
                    //console.log(response);
                    if(response.success==true) {
                        //notify
                    $("#exampleModalCenter").modal("hide");

                    toastr.success("Credit Added Successfully");

                        window.setTimeout(function() {
                            window.location = "{{ url('/')}}"+"/admin/student";
                        }, 2000);

                    }
                    //show the form validates error
                    if(response.success==false ) {
                        for (control in response.errors) {
                           var error_text = control.replace('.',"_");
                           $('#error-'+error_text).html(response.errors[control]);
                           // $('#error-'+error_text).html(response.errors[error_text][0]);
                           // console.log('#error-'+error_text);
                        }
                        // console.log(response.errors);
                    }
                },
                error: function (response) {
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
