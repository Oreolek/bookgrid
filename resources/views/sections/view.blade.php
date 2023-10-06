@if(!$section->isRoot())
<p>{{ $section->title }}</p>
@endif
{!! $section->content !!}
@foreach($section->children as $child)
    @include('sections.view', ['section' => $child])
@endforeach
