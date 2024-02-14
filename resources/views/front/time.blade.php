<div class="timimg-btn mb-2 data">
    @if($pv_master->time == 1)
    <input type="hidden" name="id" id="p_id" value="{{$pv_master->id}}">
        @if($time != null)
            @foreach($time as $key => $ti)
                @if($key == 0)
                <label class="da active cl blue{{$key}}" data-key="{{$key}}" data id="ad{{$ti->time}}" onclick="timeprice({{$ti->time}})">{{$ti->time}} mins</label>
                @else
                <label class="da " id="ad{{$ti->time}}" onclick="timeprice({{$ti->time}})">{{$ti->time}} mins</label>
                @endif
            @endforeach
        @endif
    @endif
    <span class="">
        <div class="dsdropdown " style="background: #fff;line-height: 15px;margin-top: 15px;position: relative;display: inline;">
            <button class="btn langbtn" type="button"> 
            @if(Session::get('currency') == 'EUR')
                <span class="lang-change"> <i class="fa-euro fa"></i> EUR </span>
            @else
                <span class="lang-change"> <i class="fa fa-dollar"></i> USD </span>
            @endif
                <i class="fa fa-chevron-down"></i>
            </button>
            <ul class="dsdropdown-menu" style="">
                <li class="dsdropdown-item selectlang text-black" style="line-height: 0;margin: 5px 0px;padding: 5px 0px;" onclick="changeLanguage('en')" data-value="USD" id="currency">
                    <i class="fa fa-dollar"></i> USD
                </li>
                <li class="dsdropdown-item selectlang text-black" style="line-height: 0; margin: 5px 0px;padding: 5px 0px;" onclick="changeLanguage('fr')" data-value="EUR" id="currency">
                    <i class="fa-euro fa"></i> EUR
                </li>
            </ul>
        </div>
    </span>
</div>
