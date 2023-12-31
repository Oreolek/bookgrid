<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Blade;

class BookController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $books = new Collection();
        if ($user) {
            $books = Book::accessible($user->id)->paginate(25);
        }
        return view('dashboard', [
            'books' => $books
        ]);
    }

    public function view(int $id = 0) {
        $book = Book::with('sections')->findOrFail($id);
        $view = Cache::get('book_'.$id);
        if (!$view) {
            $view = Blade::render('sections.view', [
                'section' => $book->sections()->root()->first()
            ]);
            Cache::put('book_'.$id, $view);
        }
        return view('view', [
            'book' => $book,
            'view' => $view,
        ]);
    }

    public function edit(Request $request, int $id = 0) {
        if ($id > 0) {
            $book = Book::findOrFail($id);
        } else {
            $book = new Book();
            $book->user_id = Auth::user()->id;
        }
        if ($request->isMethod('POST')) {
            $book->fill($request->all());
            $book->save();
            Cache::delete('book_'.$id);
            if ($book->sections()->count() === 0) {
                $section = new Section();
                $section->book_id = $book->id;
                $section->title = 'Root section';
                $section->content = '';
                $section->is_editable = false;
                $section->makeRoot();
                $section->save();
            }
            return redirect('dashboard')->with('success', __('Book was saved successfully.'));
        }
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('edit', [
            'book' => $book,
            'sections' => $book->sections()->where('parent_id', NULL)->get(),
            'collaborators' => $book->collaborators,
            'users' => $users,
        ]);
    }

    public function delete(Request $request, int $id = 0) {
        $book = Book::findOrFail($id);
        if (!$book->owned()) {
            throw new \Exception('Insufficient rights.');
        }
        $book->sections()->delete();
        $book->delete();
        Cache::delete('book_'.$id);
        return redirect('dashboard')->with('success', __('Book was deleted successfully.'));
    }

    public function add_collab(Request $request, int $id) {
        $book = Book::findOrFail($id);
        if (!$book->owned()) {
            throw new \Exception('Insufficient rights.');
        }
        $user_id = (int) $request->input('user_id');
        $user = User::findOrFail($user_id);
        if (!$book->collaborators()->where('books_collaborators.user_id', $user_id)->exists()) {
            $book->collaborators()->attach($user_id);
        }
        return redirect(route('book.edit', ['id' => $book->id]))->with('success', __("Added user #{$user->name} to collaborators."));
    }

    public function remove_collab(Request $request, int $id) {
        $book = Book::findOrFail($id);
        if (!$book->owned()) {
            throw new \Exception('Insufficient rights.');
        }
        $user_id = (int) $request->input('user_id');
        $user = User::findOrFail($user_id);
        if ($book->collaborators()->where('books_collaborators.user_id', $user_id)->exists()) {
            $book->collaborators()->detach($user_id);
        }
        return redirect(route('book.edit', ['id' => $book->id]))->with('success', __("Removed user #{$user->name} from collaborators."));
    }
}
