<?php

use App\Http\Controllers\NotebookController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashedNoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('notes.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::resource('notes', NoteController::class)->middleware(['auth']);

Route::resource('notebooks', NotebookController::class)->middleware(['auth']);

//Route::get('/trashed', [TrashedNoteController::class, 'index'])->middleware(['auth'])->name('trashed.index');
//
//Route::get('/trashed/{note}', [TrashedNoteController::class, 'show'])->withTrashed()->middleware(['auth'])->name('trashed.show');
//
//Route::put('/trashed/{note}', [TrashedNoteController::class, 'update'])->withTrashed()->middleware(['auth'])->name('trashed.update');
//
//Route::delete('/trashed/{note}', [TrashedNoteController::class, 'destroy'])->withTrashed()->middleware(['auth'])->name('trashed.destroy');

Route::prefix('/trashed')->name('trashed.')->middleware(['auth'])->group(function () {
    Route::get('/', [TrashedNoteController::class, 'index'])->name('index');
    Route::get('/{note}', [TrashedNoteController::class, 'show'])->withTrashed()->name('show');
    Route::put('/{note}', [TrashedNoteController::class, 'update'])->withTrashed()->name('update');
    Route::delete('/{note}', [TrashedNoteController::class, 'destroy'])->withTrashed()->name('destroy');
});
