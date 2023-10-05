@extends('layouts.empty')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Book Grid') }}
    </h2>
@endsection

@section('content')
    <h1>{{ $book->title }}</h1>
    @foreach($book->sections as $section)
        <li>@include('sections.view', ['sections' => $section->children])</li>
    @endforeach
@endsection
