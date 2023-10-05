@if (isset($book))
<input type="hidden" name="book_id" value="{{ $book->id }}" />
@else
    <input type="hidden" name="book_id" value="{{ $section->book->id }}" />
@endif
<input type="text" name="title" value="{{$section->title}}" placeholder="Title" />
<select name="parent_id">
    @foreach($sections as $s)
        @if ($s->id !== $section->id)
            <option value="{{$s->id}}">{{$s->title}}</option>
        @endif
    @endforeach
</select>
<textarea name="content" placeholder="Section content">{{$section->content}}</textarea>
<button type="submit">
    @if($section->id > 0)
        {{ __('Save section') }}
    @else
        {{ __('Add a new section') }}
    @endif
</button>
