{{--
    Recursive parent node selection control.

    Do not allow to set a section as a child of itself
    or its children, lest we get a circular reference.
    This is also checked on controller side.
--}}
@if ($s->id !== $current->id)
    <option value="{{$s->id}}" @if($current->parent_id === $s->id) selected="selected" @endif >
        @if ($s->isRoot())
            [No parent]
        @else
            {{$s->title}}
        @endif
    </option>
    @foreach($s->children as $sub)
        @include('sections._select', ['s' => $sub, 'current' => $current])
    @endforeach
@endif
