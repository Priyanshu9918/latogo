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
                    <h4 class="card-title m-0">Referral Coupon Manegement</h4>
                    {{-- <a href="/admin/referral/create" class="btn btn-primary btn-rounded cu">
                        <i class="fa fa-plus-circle mr-1"></i>
                         <span style="bottom: 3px; position: relative;"> Add Referral</span></a> --}}
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="point-datatable" class="table">
                            <thead style="background:#a0b8ed29;">
                                <tr>
                                    <th> #</th>
                                    <th><b>Referral Amount</b></th>
                                    <th><b>Referral Coupon</b></th>
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
                    $(document).ready(function() {

                        if ($("#point-datatable").length > 0) {
                            /*Checkbox Add*/
                            var tdCnt = 0;
                            var targetDt = $('#point-datatable').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: "{{route('admin.referral')}}",

                                columns: [{
                                        data: 'check',
                                        name: 'check'
                                    },

                                    {
                                        data: 'referral',
                                        name: 'referral'
                                    },

                                    {
                                        data: 'referral_coupon',
                                        name: 'referral_coupon'
                                    },

                                    {
                                        data: 'created_at',
                                        name: 'created_at'
                                    },

                                    {
                                        data: 'action',
                                        name: 'action'
                                    },

                                ],

                                "dom": '<"row"<"col-7 mb-3"<"contact-toolbar-left">><"col-5 mb-3"<"contact-toolbar-right"f>>><"row"<"col-sm-12"t>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',

                                "ordering": true,

                                "columnDefs": [{
                                    "searchable": false,
                                    "orderable": false,
                                    "targets": [0, 4]
                                }],

                                "order": [1, 'asc'],

                                language: {
                                    search: "",
                                    searchPlaceholder: "Search",
                                    "info": "_START_ - _END_ of _TOTAL_",
                                    sLengthMenu: "View  _MENU_",
                                    paginate: {
                                        next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
                                        previous: '<i class="ri-arrow-left-s-line"></i>' // or '←'
                                    }
                                },
                                "drawCallback": function() {
                                    $('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple pagination-sm');
                                }
                            });

                            $("div.contact-toolbar-right").addClass('d-flex justify-content-end').append('	<button class="btn btn-sm btn-outline-light ms-3"><span><span class="icon"><i class="bi bi-filter"></i></span><span class="btn-text">Filters</span></span></button>');
                            $("#point-datatable").parent().addClass('table-responsive');

                            /*Select all using checkbox*/
                            var DT1 = $('#point-datatable').DataTable();
                            $(".check-select-all").on("click", function(e) {
                                $('.check-select').attr('checked', true);
                                if ($(this).is(":checked")) {
                                    DT1.rows().select();
                                    $('.check-select').prop('checked', true);
                                } else {
                                    DT1.rows().deselect();
                                    $('.check-select').prop('checked', false);
                                }
                            });
                            $(".check-select").on("click", function(e) {
                                if ($(this).is(":checked")) {
                                    $(this).closest('tr').addClass('selected');
                                } else {
                                    $(this).closest('tr').removeClass('selected');
                                    $('.check-select-all').prop('checked', false);
                                }
                            });
                        }
                        $(document).on('click', '.statusBtn', function(event) {
                            var id = $(this).attr('data-id');
                            var type = $(this).attr('data-type');
                            var table = 'referrals';

                            swal({
                                    type: "warning",
                                    title: "Do you Want to Change The Status of This Category?",
                                    text: "",
                                    dangerMode: true,
                                    showCancelButton: true,
                                    confirmButtonColor: "#007358",
                                    confirmButtonText: "YES",
                                    cancelButtonText: "CANCEL",
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function(e) {
                                    if (e == true) {
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{route('admin.status-action')}}",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                'id': id,
                                                'table_name': table,
                                                'type': type
                                            },
                                            success: function(response) {

                                                if (response.success) {
                                                    if (response.type == 'enable') {
                                                        $('table.categoryTable tr').find("[data-ac='" + id + "']").fadeIn("slow");
                                                        $('table.categoryTable tr').find("[data-ac='" + id + "']").removeClass("d-none");

                                                        $('table.categoryTable tr').find("[data-dc='" + id + "']").fadeOut("slow");

                                                        $('table.categoryTable tr').find("[data-dc='" + id + "']").addClass("d-none");

                                                    } else if (response.type == 'disable') {
                                                        $('table.categoryTable tr').find("[data-dc='" + id + "']").fadeIn("slow");
                                                        $('table.categoryTable tr').find("[data-dc='" + id + "']").removeClass("d-none");

                                                        $('table.categoryTable tr').find("[data-ac='" + id + "']").fadeOut("slow");

                                                        $('table.categoryTable tr').find("[data-ac='" + id + "']").addClass("d-none");
                                                    }

                                                    toastr.success(response.message);

                                                    window.setTimeout(() => {
                                                        window.location.reload();
                                                    }, 2000);
                                                } else {

                                                }

                                                swal.close();

                                            },
                                            error: function(xhr, textStatus, errorThrown) {
                                            }

                                        });
                                    } else {
                                        swal.close();
                                    }
                                });

                        });

                        $(document).on('click', '.deleteBtn', function() {

                            var _this = $(this);
                            var id = $(this).data('id');
                            var table = 'referrals';
                            swal({
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
                                function(e) {
                                    if (e == true) {
                                        _this.addClass('disabled-link');
                                        $.ajax({
                                            type: "POST",
                                            dataType: "json",
                                            url: "{{route('admin.delete-action')}}",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                'id': id,
                                                'table_name': table
                                            },
                                            success: function(data) {
                                                console.log(data);
                                                window.setTimeout(function() {
                                                    _this.removeClass('disabled-link');
                                                }, 2000);

                                                if (data.code == 200) {
                                                    window.setTimeout(function() {
                                                        window.location.reload();
                                                    }, 2000);
                                                }
                                            },
                                            error: function(response) {
                                                console.log(response);
                                            }
                                        });
                                        swal.close();
                                    } else {
                                        swal.close();
                                    }
                                }
                            );
                        });
                    });
                </script>
                @endpush
