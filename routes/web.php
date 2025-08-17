
<?php
// routes/web.php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Main routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
Route::get('/project/{slug}', [HomeController::class, 'project'])->name('project.show');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{category}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{tag}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');
Route::get('/blog/rss', [BlogController::class, 'rss'])->name('blog.rss');
Route::get('/blog/sitemap', [BlogController::class, 'sitemap'])->name('blog.sitemap');

// Contact form
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// API routes
Route::prefix('api')->group(function () {
    Route::post('/chat', [ChatController::class, 'respond'])->name('api.chat');
});

// CV download
Route::get('/download-cv', function () {
    $filePath = storage_path('app/public/cv.pdf');
    if (file_exists($filePath)) {
        return response()->download($filePath, 'Awais_Ahmad_CV.pdf');
    }
    abort(404);
})->name('cv.download');

// Admin routes (optional file)
if (file_exists(__DIR__ . '/adminroutes.php')) {
    require __DIR__ . '/adminroutes.php';
}