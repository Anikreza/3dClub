<a class="list-group-item list-group-item-action" href="#sub-men{{$key+1}}" data-toggle="collapse" aria-expanded="false"
   aria-controls="sub-men{{$key+1}}">{{$title}}
    <small class="text-muted">({{$subCategory->count()}})</small>
</a>
<div class="collapse" id="sub-men{{$key+1}}" data-parent="#list-group-men">
    <div class="list-group">
        @foreach($subCategory as $subCategory)
            <a href="{{route('category', ['slug' =>$subCategory->slug])}}" class="list-group-item list-group-item-action">{{$subCategory->name}} <small
                    class="text-muted">({{$subCategoryCount}})</small>
            </a>
        @endforeach
    </div>
</div>
