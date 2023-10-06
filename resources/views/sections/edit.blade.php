@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Book Grid') }}
    </h2>
@endsection

@section('content')
    <h1> Section {{$section->title}} </h1>
    {!! $section->content !!}

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
