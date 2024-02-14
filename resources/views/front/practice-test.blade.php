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
.sold1{
    width: 285px;
    position: relative;
    height: 40px;
    line-height: 39px;
    padding: 0 18px;
    display: block;
    border-radius: 25px;
    font-weight: 700;
    font-size: 14px;
    color: var(--color-white);
    background-color: var(--color-secondary);
    transition: .3s;
    box-shadow: 0 16px 32px 0 rgba(0, 0, 0, .06);
    position: relative;
    z-index: 1;
    background: beige;
}
.label-btn{
    margin-bottom: -31px;
    z-index: 99; 
    background: #f6697b;
    color: #fff;
    text-transform: uppercase;
    padding: 5px 10px;
    font-size: 14px;
    width: fit-content;
}
</style>
<div class="">
    <section class="section bg-light pt-5">
        <div class="container">
        <div class="row hidden-md-up">
        @foreach($child as $child1)
        <div class="col-md-4">
        <div class="card" style="width: 18rem;">
        @php
            $stat =  DB::table('quize_tests')->where('parent',$child1->id)->get()->pluck('id');
            $stat1 = App\Models\QuizTestResult::where('user_id',Auth::user()->id)->whereIn('quiz_id',$stat)->get();


        @endphp

        @if(count($stat1) == 0)
            <span class="label-btn">Not Started</span>
        @else
            @php 
                $string = true;
                foreach($stat as $sub){
                    $stat12 = App\Models\QuizTestResult::where('user_id',Auth::user()->id)->where('quiz_id',$sub)->where('completion',100)->pluck('id');
                    if($stat12 == null){
                        $string = false;
                        break;
                    }
                }
            @endphp
            @if($string == false)
            <span class="label-btn">In progress</span>
            @else
            <span class="label-btn">In progress</span>
            @endif
        @endif
            <img class="card-img-top" src="{{asset('uploads/quize/'.$child1->image)}}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{$child1->name}}</h5>
                <a href="{{ route('student.quizesub',['id'=>base64_encode($child1->id),'parent_id'=>base64_encode($parent_id)]) }}" class="btn btn-primary">See More</a>
            </div>
            </div>
        </div>
        @endforeach
    </div>
    </section>
</div>
<div class="modal fade" id="remove12" tabindex="-1" role="dialog" aria-labelledby="remove1Title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body flex-grow-0" >
                <div class="col-12 table-responsive">
                <table id="table_id" class="table plan-data">
                    
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')

@endpush
