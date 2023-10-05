<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SectionController;

Route::get('/', function () {
    return view('welcome');
});

// not auth-limited
Route::get('/view/{id}', [BookController::class, 'view'])->name('book.view');

Route::controller(BookController::class)->middleware('auth')->group(function() {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::post('/create', 'edit')->name('book.create');
    Route::any('/edit/{id?}', 'edit')->name('book.edit');
    Route::post('/delete/{id}', 'delete')->name('book.delete');
    Route::post('/collaborator/add/{id}', 'add_collab')->name('book.set_collab');
    Route::post('/collaborator/delete/{id}', 'remove_collab')->name('book.unset_collab');
});

Route::controller(SectionController::class)->middleware('auth')->group(function() {
    Route::post('/section/create', 'edit')->name('section.create');
    Route::any('/section/edit/{id?}', 'edit')->name('section.edit');
    Route::post('/section/delete/{id}', 'delete')->name('section.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
