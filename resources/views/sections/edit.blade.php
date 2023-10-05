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

    <h1> Section {{$section->title}} </h1>
    <p>Order: {{ $section->order }}</p>
    {{ $section->content }}

    <form method="post">@csrf
        @include('sections.form')
    </form>

    @if(isset($children) && $children->count() > 0)
        <h3>Subsections</h3>
        <ul>
            @foreach($children as $section)
                <li>
                    @include('sections.single', ['section' => $section])
                    @include('sections.index', ['sections' => $section->children])
                </li>
            @endforeach
        </ul>
    @endif
@endsection
