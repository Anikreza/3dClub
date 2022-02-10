<a class="list-group-item list-group-item-action" href="#sub-men{{$key+1}}" data-toggle="collapse" aria-expanded="false"
   aria-controls="sub-men{{$key+1}}">{{$category->name}}
    <small class="text-muted">({{$category->subCategory->count()}})</small>
</a>
<div class="collapse" id="sub-men{{$key+1}}" data-parent="#list-group-men">
    <div class="list-group">
        @foreach($subCategory as $key=>$subCategory)
            @if(isset($article[$key]['title']))
                <a href="{{route('productDetails', ['slug' =>$article[$key]['slug']])}}"
                   class="list-group-item list-group-item-action">{{$subCategory->name}} <small
                        class="text-muted"></small>
                </a>
            @else
            @endif

        @endforeach
    </div>
</div>
