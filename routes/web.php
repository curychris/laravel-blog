<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;


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

Route::middleware('auth')->group(function() {
    Route::prefix('blog')->group(function() {
        Route::get('/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('store', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('/edit/{blog}', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::patch('/update/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::get('/detail/{blog}', [BlogController::class, 'show'])->name('blogs.show');
        Route::delete('/delete/{blog}', [BlogController::class, 'delete'])->name('blogs.delete');

        // Menambahkan route untuk komentar
        Route::post('/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');
    });

    Route::prefix('users')->group(function() {
        Route::get('/{user}', [UserController::class, 'show'])->name('profile');
    });

    Route::get('/dashboard', [UserController::class, 'home'])->name('dashboard');
});


Route::get('/', function () {
    // return view('welcome');
    return redirect(route('dashboard'));
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';
*/
