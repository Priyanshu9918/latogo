</script><link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.ie11.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<style>
    .toastui-calendar-timegrid-now-indicator{
        display: none !important;
    }
</style>
@if(count($events)>0)
    <div class="container p-0 py-md-2" style="height: 100% !important;">
        <button class="btn btn-primary btn-prev"> <i class="fa fa-angle-left"></i></button>
        <button class="btn btn-primary btn-today">Today</button>
        <button class="btn btn-primary btn-nxt"> <i class="fa fa-angle-right"></i></button>
        <span class="navbar12"></span>
        <div id="container" style="min-height: 600px !important;height:600px"></div>
    </div>
    
    <script>

        function countCommaSeparatedValues(str) {
            if (!str.trim()) {
                return 0; // Return 0 when the string is empty
            }else{
                const values = str.split(',');
                return values.length;
            }
        }
        function slotcheck() {
            $('.toastui-calendar-event-time').each(function(index, element) {
                var eventTestId = $(element).attr('data-testid');
                var selected2 = $('#class_quee').val();
                var separatedArray = selected2.split(',');
                // alert(separatedArray.indexOf(eventTestId));
                if (separatedArray.indexOf(eventTestId) !== -1) {
                    // alert(separatedArray);
                    $(element).addClass('sec-slot');
                } 
            });
        }

        function cal_init_book()
        {
            var Cal = tui.Calendar;
            var calendar = new Cal('#container', {
                defaultView: 'week',
                taskView: false,
                id: 'cal1',
                isReadOnly: true,
            });
            calendar.setOptions({
                week: {
                    taskView: false,
                    eventView: ['time'],
                    defaultTimeDuration : 30,
                }
            });
            calendar.createEvents(@json($events));

            var s_c = 0;
            var n_c = 0;

            var timedEvent = calendar.getEvent('1', 'cal1'); // EventObject
            calendar.on('clickEvent', ({ event }) => {
                console.log(event); // EventObject
                // $('#date_time').val(event.body);

                    var cred = $('#t_credit').val();
                    var id = event.body;
                    var id1 = event.__cid;

                    var selected = $('#date_time').val();
                    var id_arr = (selected == '') ? [] : selected.split(',');

                    var selected2 = $('#class_quee').val();
                    var id_arr1 = (selected2 == '') ? [] : selected2.split(',');
                    // Add and Remove row id
                    // alert(selected2+selected);

                    var index = id_arr.indexOf(id);
                    var index1 = id_arr1.indexOf('time-event-Available Slot-'+id1);

                    var selected1 = $('#date_time').val();
                    var selected3 = $('#class_quee').val();

                    var count = countCommaSeparatedValues(selected1);
                    var count1 = countCommaSeparatedValues(selected3);

                    if(count >= cred && count1 >= cred){
                        if (index > -1) {
                            n_c = 0;
                            s_c = 0;
                            id_arr.splice(index, 1);
                            var new_id_arr = id_arr.join(",");
                            $('#date_time').val(new_id_arr);

                            id_arr1.splice(index1, 1);
                            var new_id_arr1 = id_arr1.join(",");
                            $('#class_quee').val(new_id_arr1);
                        } else{
                            n_c = 1;
                            toastr.warning('You have only '+cred+' credit! ');
                            return false;
                        }
                    }
                    
                    if (index > -1) {
                        s_c = 0;
                        id_arr.splice(index, 1);
                        id_arr1.splice(index1, 1);
                    } else {
                        s_c = 1;
                        id_arr.push(id);
                        id_arr1.push('time-event-Available Slot-'+id1);
                    }
                    var new_id_arr1 = id_arr1.join(",");
                    $('#class_quee').val(new_id_arr1);

                    var new_id_arr = id_arr.join(",");
                    $('#date_time').val(new_id_arr);

                    console.log(event.attendees[0]);
                    if(event.attendees[0]=='B')
                    {
                        return false;
                    }
            });
            $(document).ready(function() {
                setTimeout(() => {
                    $(document).on("click", ".toastui-calendar-event-time", function() {
                        if(n_c == 0){
                            if (s_c == 1) {
                                    $(this).addClass('sec-slot');
                            } else {
                                    $(this).removeClass('sec-slot');
                            }
                        }
                    });
                }, 500);
                
            });

            $(document).on("click", "#submit-session", function() {
                $('.pre-loader').show();
                var data = $('#boking_form').serialize();
                $.ajax({
                    url: "{{ route('admin.book_session') }}",
                    type: 'GET',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        if(data.status==true)
                        {
                            
                        toastr.success("Booking created Successfully");
                          
                        location.reload();
                        
                        }
                        else{
                            Swal.fire('Oops',data.msg,'');
                        }
                    }
                });
            });

            // function getMonthName(monthNumber) {
            //     const date = new Date();
            //     date.setMonth(monthNumber);

            //     return date.toLocaleString('en-US', {
            //         month: 'long',
            //     });
            // }
            // const date = calendar.getDate();
            // const month = date.getMonth();
            // const month_name = getMonthName(month)
            // const year = date.getFullYear();
            // $('.navbar12').text(month_name+ ' - ' + year);
            
            // $(document).on("click", ".btn-prev", function() {
            //     calendar.prev();
            //     const date = calendar.getDate();
            //     const month = date.getMonth();
            //     const month_name = getMonthName(month)
            //     const year = date.getFullYear();
            //     $('.navbar12').text(month_name+ ' - ' + year);
            // });
            // $(document).on("click", ".btn-nxt", function() {
            //     calendar.next();
            //     const date = calendar.getDate();
            //     const month = date.getMonth();
            //     const month_name = getMonthName(month)
            //     const year = date.getFullYear();
            //     $('.navbar12').text(month_name+ ' - ' + year);
            // });
            // $(document).on("click", ".btn-today", function() {
            //     calendar.today();
            // });
            function updateNavbar() {
                const date = calendar.getDate();
                const month = date.getMonth();
                const month_name = getMonthName(month);
                const year = date.getFullYear();
                $('.navbar12').text(month_name + ' - ' + year);
            }

            function getMonthName(monthNumber) {
                const date = new Date();
                date.setMonth(monthNumber);
                return date.toLocaleString('en-US', {
                    month: 'long',
                });
            }

            // Display initial calendar information
            updateNavbar();

            // Event listeners for navigation buttons
            $(document).on("click", ".btn-prev", function() {
                calendar.prev();
                updateNavbar();
                setTimeout(() => {
                    slotcheck();
                }, 500);
            });

            $(document).on("click", ".btn-nxt", function() {
                calendar.next();
                updateNavbar();
                setTimeout(() => {
                    slotcheck();
                }, 500);
            });

            $(document).on("click", ".btn-today", function() {
                calendar.today();
            });
        }
        </script>
@else
<div class="container text-center">
    We regretfully inform you that, at this moment, we do not have any available slots for the desired teacher.Thank you for your understanding and patience. We appreciate your interest and look forward to assisting you in the future.
    <div class="row mt-5">
        <div class="offset-3 col-6">
            <a class="btn btn-primary" href="{{ route('student.sbac') }}">Explore more</a>
        </div>
    </div>
</div>
@endif
