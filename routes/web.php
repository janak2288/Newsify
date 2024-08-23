<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/news-list', [PostController::class, 'index'])->name('posts.index');

    Route::resource('sources', SourceController::class);
});

Route::get('/', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/load-more', [NewsController::class, 'loadMore'])->name('news.load_more');

require __DIR__.'/auth.php';
