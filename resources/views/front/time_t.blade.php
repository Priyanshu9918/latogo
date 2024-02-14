<div class="timimg-btn mb-2 data">
    @if($pv_master->time == 1)
    <input type="hidden" name="id" id="p_id" value="{{$pv_master->id}}">
        @if($time != null)
            @foreach($time as $ti)
            <label class="da active cl blue{{$key}}" data-key="{{$key}}" id="ad{{$ti->time}}" onclick="timeprice(30)">{{$ti->time}} mins</label>
            @endforeach
        @endif
    @endif
</div>
