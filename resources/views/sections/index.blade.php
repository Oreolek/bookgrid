@if (isset($sections) && $sections->count() > 0)
    <ul>
        @foreach ($sections as $section)
            <li>
                @include('sections.single', ['section' => $section])
                @include('sections.index', ['sections' => $section->children])
            </li>
        @endforeach
    </ul>
@endif
