@extends('layouts.dashboard.master2')
@section('content')
<div class="breadcrumb-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="breadcrumb-list">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item">Support</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            @php
            $contact_videos = Helper::contact_videos();
            @endphp
            @if($contact_videos)
                <iframe width="100%" height="315" src="{{ $contact_videos->link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            @else
        <h1>No Data Found</h1>
        @endif
            <div class="col-md-12">

            
                <div class="row mt-4">

                    <div class="col-md-4">
                        <div class="category-tab">
                            <ul class="nav nav-justified">
                            @php
                                $contact_titles = Helper::contact_titles();
                                @endphp
                                @if($contact_titles)
                                @foreach($contact_titles as $key => $contact)
                                @if($key == 0)
                                <li class="nav-item"><a href="#question1" class="nav-link active" data-bs-toggle="tab" onclick="support({{$contact->id}})">{{ $contact->title }}</a></li>
                                @else
                                <li class="nav-item"><a href="#question1" class="nav-link" data-bs-toggle="tab" onclick="support({{$contact->id}})">{{ $contact->title }}</a></li>
                                @endif
                                @endforeach
                            @else
                            <h1>No Data Found</h1>
                            @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="question1">
                                <div class="row dash">
                                    <div class="col-lg-12">
                                    @if($support)
                                        @foreach($support as $su)
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faq{{$su->id}}" aria-expanded="false">{{$su->title}}</a>
                                            </h6>
                                            <div id="faq{{$su->id}}" class="collapse" style="">
                                                <div class="faq-detail">
                                                    <p>{!! $su->description !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                                @else
                                                <h1>No Data Found</h1>
                                        @endif
                                       
                                    </div>
                                </div>
                            </div>
                            {{--<div class="tab-pane fade" id="question2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqone" aria-expanded="false">What courses does Latogo offer?</a>
                                            </h6>
                                            <div id="faqone" class="collapse" style="">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqtwo" aria-expanded="false">How do online classes work?</a>
                                            </h6>
                                            <div id="faqtwo" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqthree" aria-expanded="false">What do I need to use Latogo?</a>
                                            </h6>
                                            <div id="faqthree" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqthree" aria-expanded="false">How can I book my first live class?</a>
                                            </h6>
                                            <div id="faqthree" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="question3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqone" aria-expanded="false">What courses does Latogo offer?</a>
                                            </h6>
                                            <div id="faqone" class="collapse" style="">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqtwo" aria-expanded="false">How do online classes work?</a>
                                            </h6>
                                            <div id="faqtwo" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqthree" aria-expanded="false">What do I need to use Latogo?</a>
                                            </h6>
                                            <div id="faqthree" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqthree" aria-expanded="false">How can I book my first live class?</a>
                                            </h6>
                                            <div id="faqthree" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="question4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqone" aria-expanded="false">What courses does Latogo offer?</a>
                                            </h6>
                                            <div id="faqone" class="collapse" style="">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqtwo" aria-expanded="false">How do online classes work?</a>
                                            </h6>
                                            <div id="faqtwo" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqthree" aria-expanded="false">What do I need to use Latogo?</a>
                                            </h6>
                                            <div id="faqthree" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-card">
                                            <h6 class="faq-title">
                                                <a class="collapsed" data-bs-toggle="collapse" href="#faqthree" aria-expanded="false">How can I book my first live class?</a>
                                            </h6>
                                            <div id="faqthree" class="collapse">
                                                <div class="faq-detail">
                                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                        terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                        skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.</p>
                                                    <p>If several languages coalesce, the grammar of the resulting language is
                                                        more simple and regular than that of the individual languages. The new
                                                        common language will be more simple and regular than the existing
                                                        European languages.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">


            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
    function support(Value){
        var active = Value;
        $.ajax({
            url: "{{ route('support') }}",
            type: "get",
            data: {
                'active': active,
            },
            success: function(response) {
                console.log(response);
                $('.dash').replaceWith(response);
            }
        });
    }
</script>
<script>
    $(document).on('click', '.faq-card', function () {
            // console.log($(this).parent().find('.collapse').length);
            $('.faq-card .collapse').removeClass('show')
            $('.faq-card .faq-title a').addClass('collapsed')
            $(this).find('a').removeClass('collapsed')
        });
    </script>
@endpush
