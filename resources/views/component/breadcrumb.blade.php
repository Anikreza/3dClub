@if(isset($segments))
    <nav>
        <ol class="breadcrumb" style="background-color: inherit">
            <li class="breadcrumb-item">
                <a style="color: #5da9a1" href="{{route('home')}}">Home</a>
            </li>
            @for($i = 0; $i < count($segments); $i++)
                <li  class="breadcrumb-item @if($i == (count($segments) - 1)) active @endif" aria-current="page">
                    @if($i == (count($segments) - 1))
                        {{$segments[$i]['name']}}
                    @else
                        <a style="color: #5da9a1" href="{{ $i != (count($segments) - 1) ? $segments[$i]['url'] : '#' }}">
                            {{$segments[$i]['name']}}
                        </a>
                    @endif
                </li>
            @endfor
        </ol>
    </nav>
@endif
