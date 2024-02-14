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
