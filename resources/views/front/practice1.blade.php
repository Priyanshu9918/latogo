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
<tr>
    <td>{{++$key}}</td>
    <td>@if($quize->image!=NULL && file_exists(public_path('uploads/quize/'.$quize->image)))
            <div class="col-sm-6">
                    <div class="form-group">
                        <a href="{{asset('uploads/quize/'.$quize->image)}}" target="_blank">
                            <img src="{{asset('uploads/quize/'.$quize->image)}}" width="100px" height="50px">
                        </a>
                    </div>
                </div>
            @endif
        </td>
    <td><span style="color:red; font-weight:bold; font-size:16px"></span>{{$quize->name}}</td>
    <td> <a href="{{ route('student.quizetest',['id'=>base64_encode($quize->id)]) }}" class="btn btn-primary">See More</a> </td>
</tr>
@empty
<tr>
    <td colspan="4" style="text-align:center;">Empty!</td>
</tr>
@endforelse
</tbody>
