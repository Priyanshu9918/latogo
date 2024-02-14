@extends('layouts.admin.master')
@section('content')
<style>
#example_wrapper .row{
    margin-left:auto;
    margin-right:auto;
}
.dataTables_length label{
    align-items: baseline !important;
    display: inline-flex !important;
}
.dataTables_length label select{
    min-width:55px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
<div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb" style="float: right">
                <!-- <li><a href="{{ route('admin.add_bottom_banner') }}"><button type="button" class="btn-lg mb-1 btn-primary"><i class="fa fa-plus-circle mr-1"></i>Add Bottom Banner<span class="btn-icon-right"></span></button></a></li> -->
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <h5 class="card-header">Bottom Banner</h5>
            @if(Session::has('msg'))
            <div class="alert alert-success" role="alert"><strong>{{ Session::get('msg') }}</strong></div>
            @endif
            <div class="table-responsive text-nowrap">
                <table class="table example table-light" id="example">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Title</th>
                            <th>Title_k</th>
                            <th>Sub title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            @php $q=1; @endphp
                            @foreach($banner_data as $row)
                            <td>{{ $q++ }}</td>
                            <td>{{$row->title}}</td>
                            <td>{{$row->title_k}}</td>
                            <td>{{$row->sub_title}}</td>
                            <td>
                                <img src="{{ asset('upload/bottom_banner').'/'.$row->image }}" style="width: 100px;">
                            </td>
                            <?php if ($row->status == 0) { ?>
                                <td><a href="javascript:void(0)" data-href="{{ route('admin.banner_status',['id'=>$row->id])}}" type="button" class="btn-sm btn-warning active" >Inactive</a></td>
                            <?php } else { ?>
                                <td><a href="javascript:void(0)" data-href="{{ route('admin.banner_status',['id'=>$row->id])}}" type="button" class="btn-sm btn-success active" >Active</a></td>
                            <?php } ?>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.edit_bottom_banner',['id'=>$row->id]) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                        <!-- <a class="dropdown-item delete" href="javascript:void(0)" data-href="{{ route('admin.delete_bottom_banner',['id'=>$row->id])}}" ><i class="bx bx-trash me-1"></i>Delete</a> -->
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endsection
        @push('script')
        <script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
        <script>
            $(".active").click(function () {
                Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change the status",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).data('href');
                }
                })
            });
            $(".delete").click(function () {
                Swal.fire({
                title: 'Are you sure you Want to delete?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).data('href');
                }
                })
            });
        </script>
        @endpush
