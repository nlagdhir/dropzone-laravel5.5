@foreach ($images as $image)
<div class="col-sm-4 imgList">
    <div class="upldPhoto">
    <span title="Delete image" data-id="{{ $image->id }}" class="alert-danger pull-right removeImage">X</span> 
        <img src="{{url('/uploads/').'/'.$image->image }}" alt="" style="height: 252px; width: 293px">
    </div>
</div>
@endforeach