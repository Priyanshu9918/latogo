@extends('layouts.admin.master')
@section('content')
<style>

</style>
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">

            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <h4 class="card-title m-0">Referral history</h4>
                        <a href="javascript:void(0)" class="btn btn-primary btn-rounded referal_mail">
                             <span style="bottom: 3px; position: relative;">Send reminder email</span></a>
                    </div>
                    <div class="row">
                    <div class="col-12">
                        <table id="coupon-user" class="table">
                        <thead style="background:#a0b8ed29;">
                            <tr>
                                <th> #</th>
                                <th><b>Referral User</b></th>
                                <th><b>Referring User</b></th>
                                <th><b>Coupon Code</b></th>
                                <th><b>Created At</b></th>
                                <th><b>Action</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>
@endsection
@push('script')

<script>
    $(document).ready(function(){

        if ($("#coupon-user").length > 0) {
            /*Checkbox Add*/
            var tdCnt=0;
            var targetDt = $('#coupon-user').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('admin.coupon')}}",

                columns: [

                        //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'check', name: 'check'},

                        {data: 'referal', name: 'referal'},

                        {data: 'refering', name: 'refering'},

                        {data: 'referral_coupon', name: 'referral_coupon'},

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
            // $("div.contact-toolbar-right").addClass('d-flex justify-content-end').append('	<button class="btn btn-sm btn-outline-light ms-3"><span><span class="icon"><i class="bi bi-filter"></i></span><span class="btn-text">Filters</span></span></button>');
            $("#coupon-user").parent().addClass('table-responsive');

            /*Select all using checkbox*/
            var  DT1 = $('#coupon-user').DataTable();
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

        $(document).on('click','.deleteBtn',function(){
            
            var _this=$(this);
            // var result=confirm("Are You Sure You Want to Delete?");
            var id = $(this).data('id');
            var table = 'records_of_references';
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
                                url: "{{route('admin.delete-action')}}",
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
        
        $(document).on('click', '.referal_mail', function() {
            $('.pre-loader').show();
            $.ajax({
                type: "get",
                url: "{{ route('admin.coupon_remember') }}",
                data: {
                    'id': 1,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.success == true) {
                        toastr.success("Email send Successfully!");
                        location.reload();
                    }
                }
            });
        });

    });
    </script>
@endpush
