@extends('layouts.empty')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Book Grid') }}
    </h2>
@endsection

@section('content')
    @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <h1> Book {{$book->title}} </h1>
    <h2>Collaborators</h2>
    @if ($collaborators->count() > 0)
    <table class="table">
    @foreach($collaborators as $collaborator)
        <tr><td>{{ $collaborator->name }}</td><td><form method="post" action="{{ route('book.unset_collab', ['id' => $book->id])}}">@csrf<input type="hidden" name="user_id" value="{{ $collaborator->id }}"><button type="submit">{{ __('Strike out') }}</button></form></td></tr>
    @endforeach
    </table>
    @endif
    @if ($book->owned() && isset($book->id) && !empty($users))
    <h3>Add new</h3>
    <form method="post" action="{{ route('book.set_collab', ['id' => $book->id])}}">@csrf
        {{-- Normally, this should be an autocomplete (less secure) or text field (secure but fiddly). --}}
        <select name="user_id">
            @foreach($users as $user)
                <option value="{{$user->id}}"> {{ $user->name }} </option>
            @endforeach
        </select>
        <button type="submit">{{ __('Add') }}</button>
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
