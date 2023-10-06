@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Book Grid') }}
    </h2>
@endsection

@section('content')
    <h1> Book {{$book->title}} </h1>
    <div class="row">
        <div class="col-md">
    @if ($collaborators->count() > 0)
    <h2>Collaborators</h2>
    <table class="table">
    @foreach($collaborators as $collaborator)
        <tr>
            <td>{{ $collaborator->name }}</td>
            <td>
                <form method="post" action="{{ route('book.unset_collab', ['id' => $book->id])}}">@csrf
                    <input type="hidden" name="user_id" value="{{ $collaborator->id }}">
                    <x-danger-button>{{ __('Strike out') }}</x-danger-button>
                </form>
            </td>
        </tr>
    @endforeach
    </table>
    @endif
        </div>
    @if ($book->owned() && isset($book->id) && !empty($users))
        <div class="col-md">
    <h3>Add new collaborator</h3>
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
        </div>
    @endif
    </div>

    <h2>Sections</h2>
    <p>Sections can be edited by any collaborators. @if($book->owned())But only you can add or delete them.@endif</p>
    @foreach($sections as $section)
        @if (!$section->isRoot())
            <li>
            @include('sections.single', ['section' => $section])
        @endif
            @include('sections.index', ['sections' => $section->children])
        @if (!$section->isRoot())
            </li>
        @endif
    @endforeach
    @if ($book->owned())
        <h3>Add new section</h3>
        <form class="form" method="post" action="{{ route('section.create') }}">@csrf
            @include('sections.form', [
            'section' => new App\Models\Section(),
            'sections' => $sections,
            ])
        </form>
    @endif
@endsection
