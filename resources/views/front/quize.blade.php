@extends('layouts.student.master2')
@section('content')
<style>
    .st1{
        color: #f6697b; 
        font-weight: 700;
    }
    .ppt-fullscreen{
        border: 2px solid red !important;
    }
</style>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-0 " style="background-color: #4c52e1;">
            <div class="d-flex flex-column align-items-center align-items-sm-start text-white min-vh-100">
                <a href="#" style="border-bottom: 1px solid #ffffff7a;width: 100%;" class="d-flex align-items-center px-3 py-2 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">{{$parent->name}}</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                @foreach($child as $key => $child12)
                    <li class="w-100">
                        <a href="#submenu1{{$key}}" style="border-bottom: 1px solid #ffffff7a;width: 100%;" data-bs-toggle="collapse" class="nav-link px-4 px-0 align-middle">
                            <span class="ms-1 d-none d-sm-inline" style="color:white;">{{$child12->name}}</span> <i class="text-white fa fa-angle-right fs-6 "></i> </a>
                            <ul class="collapse show nav flex-column ms-1 w-100" id="submenu1{{$key}}" data-bs-parent="#menu">
                            @php
                                $subchild1 = DB::table('quize_tests')->where('parent',$child12->id)->get();
                            @endphp
                            @foreach($subchild1 as $sub)
                                @if($sub)
                                
                                    <li style="border-bottom: 1px solid #ffffff7a;width: 100%;" class="w-100 ps-5">
                                        <a style="color: #ffffffa8;" href="javascript:void(0)" class="nav-link px-0 "> <span class="d-none d-sm-inline" onclick="sub({{$sub->id}})" id="sb1{{$sub->id}}">{{$sub->name}}</span></a>
                                    </li>
                                
                                @endif
                            @endforeach
                            </ul>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        <div class="col py-3">
            @if($subchild)
            <iframe id='mh-iframe' width='100%' height='800px' src="{{$subchild->url.'?user_id='.auth::user()->id.'&quiz_id='.$subchild->id}}" title='MeritHub content player' frameborder='0' allow='accelerometer' allowfullscreen>
            </iframe>
            @endif
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
    function sub(value) {
            var active = value;
            $.ajax({
                url: "{{ route('student.quizetest') }}",
                type: "get",
                data: {
                    'active': active,
                },
                success: function(response) {
                    console.log(response);
                    $('#menu .nav-link span').removeClass('st1');
                    $('#sb1'+value).addClass('st1');
                    $('#mh-iframe').attr('src',response.url);
                }
        });
    }

    
</script>

@endpush
