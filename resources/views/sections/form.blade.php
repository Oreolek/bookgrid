@if (isset($book))
    <input type="hidden" name="book_id" value="{{ $book->id }}" />
@else
    <input type="hidden" name="book_id" value="{{ $section->book->id }}" />
@endif
<div class="row mb-3">
    <label class="col-form-label col-sm-2" for="sectionTitle">Title</label>
    <div class="col-sm-10">
        <input type="text" id="sectionTitle" class="form-control" name="title" value="{{$section->title}}" />
    </div>
</div>
<div class="row mb-3">
    <label class="col-form-label col-sm-2" for="sectionParent">Parent section</label>
    <div class="col-sm-10">
        <select name="parent_id" class="form-select" id="sectionParent">
            @foreach($sections as $s)
                @include('sections._select', ['section' => $s, 'skip' => $section->id])
            @endforeach
        </select>
    </div>
</div>
<div class="row mb-3">
    <label class="col-form-label col-sm-2" for="sectionContent">Section content</label>
    <div class="col-sm-10">
        <textarea id="content" name="content" class="form-control sun-editor-editable" placeholder="Section content">{{$section->content}}</textarea>
        <div id="editor"></div>
    </div>
</div>
<x-primary-button>
    @if($section->id > 0)
        {{ __('Save section') }}
    @else
        {{ __('Add a new section') }}
    @endif
</x-primary-button>

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        var html = $('#content').summernote();
    </script>
});
@endpush
