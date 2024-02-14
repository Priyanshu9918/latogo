@if(count($upcommit)>0)
                                                                <table class="table table-nowrap mb-2">
                                                                    <tbody>
                                                                        @foreach($upcommit as $key => $val)
                                                                        @php
                                                                            $t1 = new \DateTime($val->start_time, new \DateTimeZone('UTC'));
                                                                            $t1->setTimezone(new \DateTimeZone($tz));
                                                                            $times = $t1->format("Y-m-d H:i");
                                                                            $showT = $t1->format("d.m.Y - h:i A");
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="row-action" data-url="{{ $val->student_url }}">
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            @php $findTeacherdetails = Helper::findTeacherdetails($val->teacher_id); @endphp
                                                                                            @if($findTeacherdetails!=null && $findTeacherdetails->avatar!=null && File::exists(public_path('uploads/user/avatar/'.$findTeacherdetails->avatar)))
                                                                                            <img src="{{asset('uploads/user/avatar/'.$findTeacherdetails->avatar)}}" class="img-fluid " alt="">
                                                                                            @else
                                                                                            <img src="{{ asset('assets/img/user/user.png') }}" class="img-fluid " alt="">
                                                                                            @endif
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p>
                                                                                            <a href="#">
                                                                                                @php $t_name = Helper::findTeacherName($val->teacher_id) @endphp
                                                                                                {{ ($t_name!=null && $t_name->name!=null)?$t_name->name:'-' }}
                                                                                            </a>
                                                                                        </p>
                                                                                        {{-- <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div> --}}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="row-action" data-url="{{ $val->student_url }}">
                                                                                <div class="sell-tabel-info">
                                                                                    <p class="m-0">
                                                                                        {{ $showT }}
                                                                                    </p>
                                                                                    {{-- <p class="m-0">
                                                                                        <a href="#">
                                                                                            {{ ($val->Classis!=null && $val->Classis->totle_class!=null)?$val->Classis->totle_class.'x Classes':'' }}
                                                                                        </a>
                                                                                    </p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">{{ ($val->Classis!=null && $val->Classis->time!=null)?$val->Classis->time:'00' }} min
                                                                                        </p>
                                                                                    </div> --}}
                                                                                </div>
                                                                            </td>
                                                                            @php 
                                                                                $class = DB::table('book_sessions')->where('id',$val->id)->first();
                                                                            @endphp
                                                                            @if(isset($class))
                                                                                @if($class->is_cancelled == 1)
                                                                                <td>
                                                                                <div class="sell-tabel-info text-center">
                                                                                    <a  class="btn btn-danger">Cancelled</a>
                                                                                    </div>
                                                                                </td>
                                                                                @else
                                                                                <td class="row-action" data-url="{{ $val->student_url }}">
                                                                                    <div
                                                                                        class="sell-tabel-info text-center">
                                                                                        <p class="m-0"><a href="#">Your
                                                                                                lesson will
                                                                                                start in</a></p>
                                                                                        <div class="rating-img justify-content-center d-flex align-items-center">
                                                                                            <p class="m-0 countdown-text-ds" id="count-{{ $key }}" data-temp="{{ $val->con_time }}" data-tz="{{ $tz }}"></p>

                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="javascript:void(0)" class="btn btn-danger cancle1" data-id="{{$val->id}}">Cancel class</a>
                                                                                </td>
                                                                                @endif
                                                                            @endif
                                                                            <script>
                                                                                // Set the date we're counting down to
                                                                                var countDownDate_{{ $key }} = new Date("{{ $times }}").getTime();

                                                                                // Update the count down every 1 second
                                                                                var x_{{ $key }} = setInterval(function() {
                                                                                    var field = 'count-{{ $key }}';

                                                                                    var now = new Date(new Date().toLocaleString('en', {timeZone: '{{ $tz }}'})).getTime();
                                                                                    // console.log(countDownDate_{{ $key }} +'-'+ now);
                                                                                    var distance = countDownDate_{{ $key }} - now;

                                                                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                                                    var ttl = '';
                                                                                    if(days>0)
                                                                                    {
                                                                                        ttl += days + "d ";
                                                                                    }
                                                                                    if(hours>0)
                                                                                    {
                                                                                        ttl += hours + "h " ;
                                                                                    }
                                                                                    if(minutes>0)
                                                                                    {
                                                                                        ttl += minutes + "m " ;
                                                                                    }
                                                                                    if(seconds>0)
                                                                                    {
                                                                                        ttl += seconds + "s ";
                                                                                    }

                                                                                    document.getElementById(field).innerHTML = ttl;
                                                                                    // document.getElementById(field).innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                                                                                    if (distance < 0) {
                                                                                        clearInterval(x_{{ $key }});
                                                                                        document.getElementById(field).innerHTML = '<a href="{{ $val->student_url }}" target="_blank"></a>';
                                                                                    }
                                                                                }, 1000);
                                                                                </script>
                                                                        </tr>
                                                                        @endforeach
                                                                        {{-- <tr>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            <img src="{{asset('assets/img/course/course-10.jpg')}}"
                                                                                                class="img-fluid "
                                                                                                alt="">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p><a href="#">Henning
                                                                                                Gustavsen</a></p>
                                                                                        <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="sell-tabel-info">
                                                                                    <p class="m-0"><a href="#">Slide
                                                                                            Through! B1
                                                                                            - B2 Kurs</a></p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">German -
                                                                                            60 min
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0"><a href="#">Your
                                                                                            lesson will
                                                                                            start in</a></p>
                                                                                    <div
                                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                                        <p
                                                                                            class="m-0 countdown-text-ds">
                                                                                            16h 29m
                                                                                            08s</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-table-group d-flex align-items-center">
                                                                                    <div class="sell-group-img">
                                                                                        <a href="#">
                                                                                            <img src="{{asset('assets/img/course/course-10.jpg')}}"
                                                                                                class="img-fluid "
                                                                                                alt="">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="sell-tabel-info">
                                                                                        <p><a href="#">Henning
                                                                                                Gustavsen</a></p>
                                                                                        <div
                                                                                            class="rating-img d-flex align-items-center">
                                                                                            <p class="m-0 light-g">
                                                                                                Lesson ID:
                                                                                                9874563215</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="sell-tabel-info">
                                                                                    <p class="m-0"><a href="#">Slide
                                                                                            Through! B1
                                                                                            - B2 Kurs</a></p>
                                                                                    <div
                                                                                        class="rating-img d-flex align-items-center">
                                                                                        <p class="m-0 light-g">German -
                                                                                            60 min
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div
                                                                                    class="sell-tabel-info text-center">
                                                                                    <p class="m-0"><a href="#">Your
                                                                                            lesson will
                                                                                            start in</a></p>
                                                                                    <div
                                                                                        class="rating-img justify-content-center d-flex align-items-center">
                                                                                        <p
                                                                                            class="m-0 countdown-text-ds">
                                                                                            16h 29m
                                                                                            08s</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr> --}}
                                                                    </tbody>
                                                                </table>
                                                                @else
                                                                <div class="no_order_div py-5 text-center">
                                                                    <svg style="max-width: 50px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                                    </svg>
                                                                    <h4  class="fs-4 pt-3 mb-2 fw-bold">No lesson found</h4>
                                                                    <p class="text-black-50">We could not find any lessons.</p>
                                                                </div>
                                                                @endif
