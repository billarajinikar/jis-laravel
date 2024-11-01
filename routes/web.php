<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\JobController;


Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'homePageData'])->name('homePageData');;
Route::get('/faqs', action: [FAQController::class, 'allFaqs'])->name('faqs');
Route::get('/cat/{slug}/{page?}', action: [JobController::class, 'jobListByCategory'])->name('jobList');
Route::get('/job/{title}/{id}', action: [JobController::class, 'showJob'])->name('jobs.show');


Route::get('/blog', [BlogPostController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', action: [BlogPostController::class, 'show'])->name('blog.show');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
