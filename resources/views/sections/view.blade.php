@if(!$section->isRoot())
<p>{{ $section->title }}</p>
@endif
{!! $section->content !!}
