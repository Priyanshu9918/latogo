@extends('layouts.student.master')
@section('content')
<style>
    .mw-80 {
        max-width: 80px;
    }
.rating{
    min-height:50px;
}
    .student-ticket-view {
        width: 70%;
    }
    :root {
  --star-size: 60px;
  --star-color: #777;
  --star-background: #fc0;
}
.average-rating span {
    color: #ffb54a;
    font-size: 20px;
}

.Stars {
  --percent: calc(var(--rating) / 5 * 100%);
  
  display: inline-block;
  font-size: 34px;
  font-family: Times; // make sure ★ appears correctly
  line-height: 1;
  
  &::before {
    content: '★★★★★';
    letter-spacing: -5px;
    background: linear-gradient(90deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
}
</style>
<div class="">
    <section class="section bg-light pt-5">
        <div class="container">
            <div class="modal fade" id="remove1" tabindex="-1" role="dialog" aria-labelledby="remove1Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                    <button style="max-width: fit-content;border: none;background: none; font-size: 20px;" type="button" class="close align-self-md-end" data-dismiss="modal" aria-label="Close" id="close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-body flex-grow-0" >
                            <div class="col-12 table-responsive">
                            <table id="table_id" class="table">
                                <thead style="background:#a0b8ed29;">
                                <tr>
                                    <!-- <th> SNo.</th>
                                    <th><b>Image</b></th>
                                    <th><b>Parent</b></th>
                                    <th><b>Action</b></th> -->
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($parent as $key => $quize)
                                <tr valign="middle">
                                    <td>{{++$key}}</td>
                                    <td>@if($quize->image!=NULL && file_exists(public_path('uploads/quize/'.$quize->image)))
                                            <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <a href="{{asset('uploads/quize/'.$quize->image)}}" target="_blank">
                                                            <img style="object-fit:cover;" src="{{asset('uploads/quize/'.$quize->image)}}" width="70px" height="70px">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    <td><span style="color:red; font-weight:bold; font-size:16px"></span>{{$quize->name}}</td>
                                    <td> <a href="{{ route('student.quizechild',['id'=>base64_encode($quize->id)]) }}" class="btn btn-primary">Go To {{substr($quize->name, 0, 4)}}</a> </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;">Empty!</td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script')
    <script>
            $(document).ready(function(){
                $("#remove1").modal({
                    show: false,
                    backdrop: 'static'
                });
                $('#remove1').modal('show');

                $(document).on('click','#close',function(){
                    $("#remove1").modal({
                        show: true,
                        backdrop: 'static'
                    });
                    $('#remove1').modal('hide');
                });
            });

    </script>
@endpush
