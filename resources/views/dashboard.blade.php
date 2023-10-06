<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($books->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Sections</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td> <a href="{{ route('book.view', ['id' => $book->id])}}">{{ $book->title }}</a></td>
                                <td> @if ($book->owned()) You @else {{ $book->user->name }} @endif</td>
                                <td> {{ $book->sections()->count() }}</td>
                                <td>
                                    <a href="{{ route('book.edit', ['id' => $book->id])}}">Edit</a>
                                    <form method="POST" action=" {{ route('book.delete', ['id' => $book->id])}}">@csrf <button type="submit">Delete</button></form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $books->links() }}
                    @endif

                    @if (Auth::user())
                        <h3>Create a new book</h3>
                        <form method=POST action="{{ route('book.create') }}">@csrf
                            <input type="text" name="title" placeholder="Title" />
                            <button type="submit"> {{ __('Add a new book') }} </button>
                        </form>
                    @else
                        {{ __('Please log in to start.') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
