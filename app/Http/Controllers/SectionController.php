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
        if ($section->id > 0 && !$section->is_editable) {
            return redirect(route('book.edit', ['id' => $section->book_id]))->with('error', __('Section is not editable.'));
        }
        if ($section->id === 0 && !$book->owned()) {
            // Cannot add new sections. Fine to edit the existing ones, however.
            throw new \Exception('Insufficient rights.');
        }
        if ($request->isMethod('POST')) {
            $section->fill($request->all());
            if ($section->content === NULL) {
                $section->content = '';
            }
            if (!$request->input('parent_id')) {
                $section->makeRoot();
            } else {
                $parent_id = (int) $request->input('parent_id', $section->parent_id);
                if ($parent_id === $id) {
                    return redirect(route('section.edit', ['id' => $id]))->with('error', __('You tried to make a node a child of itself.'));
                }
                $parent = Section::findOrFail($parent_id);
                if (!$parent->isChildOf($section)) {
                    $section->appendTo($parent);
                } else {
                    session()->flash('error', __('You may not move a node under its own children.'));
                }
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
            'sections' => $book->sections()->root()->get(),
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
        $book = Book::findOrFail($book_id);
        if (!$book->owned()) {
            throw new \Exception('Insufficient rights.');
        }
        $section->delete();
        return redirect(route('book.edit', ['id' => $book_id]))->with('success', __('Section was deleted successfully.'));
    }

}
