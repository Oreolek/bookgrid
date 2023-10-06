@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Book Grid') }}
    </h2>
@endsection

@section('content')
    <h1> Book {{$book->title}} </h1>
    <h2>Collaborators</h2>
    @if ($collaborators->count() > 0)
    <table class="table">
    @foreach($collaborators as $collaborator)
        <tr><td>{{ $collaborator->name }}</td><td><form method="post" action="{{ route('book.unset_collab', ['id' => $book->id])}}">@csrf<input type="hidden" name="user_id" value="{{ $collaborator->id }}"><x-danger-button>{{ __('Strike out') }}</x-danger-button></form></td></tr>
    @endforeach
    </table>
    @endif
    @if ($book->owned() && isset($book->id) && !empty($users))
    <h3>Add new</h3>
    <form method="post" class="row row-cols-lg-auto align-items-center" action="{{ route('book.set_collab', ['id' => $book->id])}}">@csrf
        {{-- Normally, this should be an autocomplete (less secure) or text field (secure but fiddly). --}}
        <div class="col">
            <select class="form-select" name="user_id">
                @foreach($users as $user)
                    <option value="{{$user->id}}"> {{ $user->name }} </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <x-primary-button>{{ __('Add') }}</x-primary-button>
        </div>
    </form>
@endif
<h2>Sections</h2>
<p>Sections can be edited by any collaborators. @if($book->owned())But only you can add or delete them.@endif</p>
<ul>
    @foreach($sections as $section)
        <li>
            @include('sections.single', ['section' => $section])
            @include('sections.index', ['sections' => $section->children])
        </li>
    @endforeach
</ul>
@if ($book->owned())
    <h3>Add new section</h3>
    <form method="post" action="{{ route('section.create') }}">@csrf
        @include('sections.form', [
            'section' => new App\Models\Section(),
            'sections' => $sections,
            ])
    </form>
@endif
@endsection
