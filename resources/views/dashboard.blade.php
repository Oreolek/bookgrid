<x-app-layout>
    <x-slot name="header">{{ __('Dashboard') }}</x-slot>

    @if ($books->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Sections</th>
                    <th colspan=2>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td> <a href="{{ route('book.view', ['id' => $book->id])}}">{{ $book->title }}</a></td>
                        <td> @if ($book->owned()) You @else {{ $book->user->name }} @endif</td>
                        <td> {{ $book->sections()->count() }}</td>
                        <td>
                            <a class="btn btn-warning" href="{{ route('book.edit', ['id' => $book->id])}}">Edit</a>
                        </td>
                        <td>
                            <form method="POST" action=" {{ route('book.delete', ['id' => $book->id])}}">@csrf <button class="btn btn-danger" type="submit">Delete</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $books->links() }}
    @endif

    @if (Auth::user())
        <h3>Create a new book</h3>
        <form class="form" method=POST action="{{ route('book.create') }}">@csrf
            <div class="row mb-3">
                <label class="col-form-label col-sm-2" for="title">Title</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="title" />
                </div>
            </div>
            <x-primary-button> {{ __('Add a new book') }} </x-primary-button>
        </form>
    @else
        {{ __('Please log in to start.') }}
    @endif
</x-app-layout>
