@extends('layouts.app')

@section('header'){{ __('Book Grid') }}@endsection

@section('breadcrumbs')
    @if ($book->editable())
        <x-nav-link :href="route('book.edit', ['id' => $book->id])">
            {{ __('Edit book') }}
        </x-nav-link>
    @endif
@endsection

@section('content')
    <h1>{{ $book->title }}</h1>
    {!! $view !!}
@endsection
