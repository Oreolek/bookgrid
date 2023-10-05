@if ($s->id !== $skip)
    <option value="{{$s->id}}">{{$s->title}}</option>
@endif
@foreach($s->children as $sub)
    @include('sections._select', ['s' => $sub, 'skip' => $skip])
@endforeach
