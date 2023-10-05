{{ $section->title }}
<a href="{{route('section.edit', ['id' => $section->id])}}">{{ __('Edit') }}</a>
<form method="post" action="{{ route('section.delete', ['id' => $section->id])}}">@csrf
    <button type="submit">{{ __('Destroy') }}</button>
</form>
<hr>

