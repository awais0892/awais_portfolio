<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\FileUploadController;
use App\Models\SiteSetting;
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

    // Public comment routes
    Route::post('/comments', [CommentController::class, 'store'])->name('api.comments.store');
    Route::get('/comments', [CommentController::class, 'index'])->name('api.comments.index');
    Route::get('/comments/count', [CommentController::class, 'count'])->name('api.comments.count');

    // Public rating routes
    Route::post('/ratings', [RatingController::class, 'store'])->name('api.ratings.store');
    Route::get('/ratings', [RatingController::class, 'index'])->name('api.ratings.index');
    Route::get('/ratings/stats', [RatingController::class, 'stats'])->name('api.ratings.stats');

    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('api.comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('api.comments.destroy');

        Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('api.ratings.update');
        Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('api.ratings.destroy');

        Route::post('/upload/image', [FileUploadController::class, 'uploadImage'])->name('api.upload.image');
        Route::post('/upload/document', [FileUploadController::class, 'uploadDocument'])->name('api.upload.document');
        Route::delete('/upload/file', [FileUploadController::class, 'deleteFile'])->name('api.upload.delete');
        Route::get('/upload/file-info', [FileUploadController::class, 'getFileInfo'])->name('api.upload.info');
        Route::post('/upload/transform', [FileUploadController::class, 'transformImage'])->name('api.upload.transform');
    });
});

// CV download
Route::get('/download-cv', function () {
    $cvFile = SiteSetting::get('cv_file', 'Awais_Ahmad_CV.pdf');
    $filePath = public_path('assets/' . $cvFile);
    if (file_exists($filePath)) {
        return response()->download($filePath, basename($filePath));
    }
    abort(404, 'CV not found.');
})->name('cv.download');

if (app()->environment('local')) {
    Route::get('/test-comments', function () {
        return view('test-comments');
    })->name('test.comments');

    Route::get('/test-upload', function () {
        return view('test-upload');
    })->name('test.upload');

    Route::get('/test-blog-upload', function () {
        return view('test-blog-upload');
    })->name('test.blog-upload');
}

// Admin routes (optional file)
if (file_exists(__DIR__ . '/adminroutes.php')) {
    require __DIR__ . '/adminroutes.php';
}
