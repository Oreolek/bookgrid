<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(BookController::class)->group(function() {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::post('/create', 'edit')->name('book.create');
    Route::any('/edit/{id}', 'edit')->name('book.edit');
    Route::post('/delete/{id}', 'delete')->name('book.delete');
    Route::get('/view/{id}', 'edit')->name('book.view');
    Route::post('/collaborator/add/{id}', 'add_collab')->name('book.set_collab');
    Route::post('/collaborator/delete/{id}', 'remove_collab')->name('book.unset_collab');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
