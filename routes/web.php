<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AddStudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Default welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Dashboard prediction route (POST)
Route::post('/dashboard/predict', [DashboardController::class, 'predict'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.predict');

// Students
Route::middleware('auth')->group(function () {
    Route::get('/students/add', [AddStudentController::class, 'create'])->name('add-student');
    Route::post('/students', [AddStudentController::class, 'store'])->name('student.store');
});

// Blogs
Route::middleware('auth')->group(function () {
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::post('/predict-run', [BlogController::class, 'predict'])->name('predict.run');
    
    // Add explicit like/unlike routes
    Route::post('/blogs/{id}/like', [BlogController::class, 'like'])->name('blogs.like');
    Route::post('/blogs/{id}/unlike', [BlogController::class, 'unlike'])->name('blogs.unlike');
});

// Posts
Route::resource('posts', PostController::class);

// User Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::get('/public-blogs', [BlogController::class, 'public'])->name('blogs.public');
Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');

// Store new blog post
Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
Route::get('/about',function(){
    return view('about');
});
// Show public blogs
Route::get('/public-blogs', [BlogController::class, 'public'])->name('blogs.public');
Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');
Route::post('/blogs/{id}/comments', [BlogController::class, 'storeComment'])->name('blogs.comment');
// Authentication Routes
require __DIR__.'/auth.php';
