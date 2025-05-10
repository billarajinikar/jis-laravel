<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\JobController;

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/about-us', function () {
    return view('about-us');
});
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});
Route::get('/contact-us', function () {
    return view('contact-us');
});

Route::get('/', [HomeController::class, 'homePageData'])->name('homePageData');;
Route::get('/faqs', action: [FAQController::class, 'allFaqs'])->name('faqs');
Route::get('/find-a-job', action: [JobController::class, 'findaJob'])->name('jobList');
Route::get('/ask-me', action: [FAQController::class, 'allFaqs'])->name('faqs');
Route::post('/ask-me', [FAQController::class, 'askQuestion'])->name('askme');
Route::get('/ask-me/{id}/{title}', action: [FAQController::class, 'answerPage'])->name('answerPage');

Route::post('/cast-vote', [FAQController::class, 'store'])->name('cast-vote');



Route::get('/cat/{slug}/{page?}', action: [JobController::class, 'jobListByCategory'])
    ->name('jobList');
Route::get('/city/{slug}/{page?}', action: [JobController::class, 'jobListByCity'])
    //->where('slug', '(?!^\d+$)^[A-Za-z0-9\-]+$')
    ->name('jobListCity');

Route::get('/job/{title}/{id}', action: [JobController::class, 'showJob'])
    ->name('jobs.show');

Route::get('/search/{keyword}/{city}/{page?}', [JobController::class, 'jobsBySearch'])
    ->where('keyword', '(?!^\d+$)^[A-Za-z0-9\-]+$')
    ->where('city', '(?!^\d+$)^[A-Za-z0-9\-]+$')
    ->where('page', '[0-9]+')
    ->name('jobSearch');


Route::get('/blog', [BlogPostController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', action: [BlogPostController::class, 'show'])->name('blog.show');

Route::get('/search', [HomeController::class, 'searchBox'])->name('search');
Route::get('/find-a-job-in-sweden', [HomeController::class, 'findAJob'])->name('find-a-job');

Route::get('/my-favorite-jobs', function () {
    return view('favorite-jobs');
})->name('favoriteJobs');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
