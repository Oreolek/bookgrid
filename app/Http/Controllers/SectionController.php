<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function edit(Request $request, int $id = 0) {
        if ($id > 0) {
            $section = Section::findOrFail($id);
        } else {
            $section = new Section();
            $section->content = '';
        }
        if ($section->id === 0) {
            $book = Book::findOrFail((int) $request->input('book_id'));
            $section->book_id = $book->id;
        } else {
            $book = $section->book;
        }
        if (!$section->is_editable) {
            return redirect(route('book.edit', ['id' => $section->book_id]))->with('error', __('Section is not editable.'));
        }
        if ($request->isMethod('POST')) {
            // fills parent_id here
            $section->fill($request->all());
            if ($section->content === NULL) {
                $section->content = '';
            }
            if (!$request->input('parent_id')) {
                $section->makeRoot();
            }
            $section->save();
            if (isset($book)) {
                redirect(route('book.edit', ['id' => $book->id]))->with('success', __('Section was saved successfully.'));
            } else {
                return redirect(route('section.edit', ['id' => $section->id]))->with('success', __('Section was saved successfully.'));

            }
        }
        return view('sections.edit', [
            'section' => $section,
            'sections' => $book->sections,
            'children' => $section->children,
            'book' => $book,
        ]);
    }

    public function delete(Request $request, int $id = 0) {
        $section = Section::findOrFail($id);
        $book_id = $section->book_id;
        if (!$section->is_editable) {
            return redirect(route('book.edit', ['id' => $book_id]))->with('error', __('Section is not editable.'));
        }
        $section->delete();
        return redirect(route('book.edit', ['id' => $book_id]))->with('success', __('Section was deleted successfully.'));
    }

}
