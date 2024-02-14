@if(Auth::user()->user_type == 0)
@include('layouts.admin.chatify')
@else
@include('layouts.teacher.chatify')
@endif
