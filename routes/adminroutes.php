<?php
// routes/admin.php (create this file)

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommentManagementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Authentication routes (simple implementation)
    Route::get('/login', function () {
        return view('admin.auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        // Simple authentication - replace with proper auth later
        if ($request->password === env('ADMIN_PASSWORD', 'admin123')) { // Change this!
            session(['is_admin' => true]);
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['password' => 'Invalid credentials']);
    })->name('login.submit');

    Route::post('/logout', function () {
        session()->forget('is_admin');
        return redirect()->route('home');
    })->name('logout');

    // Protected admin routes (use explicit middleware class to avoid alias resolution issues)
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Projects
        Route::resource('projects', ProjectController::class);
        Route::post('projects/{project}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
        Route::delete('projects/bulk-delete', [ProjectController::class, 'bulkDelete'])->name('projects.bulk-delete');
        
        // Contacts
        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::put('contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.update-status');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::delete('contacts', [ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
        
        // Settings - Full CRUD
        Route::resource('settings', SettingsController::class);
        Route::put('settings', [SettingsController::class, 'bulkUpdate'])->name('settings.bulk-update');
        Route::post('settings/{setting}/toggle-status', [SettingsController::class, 'toggleStatus'])->name('settings.toggle-status');
        
        // Blogs - Full CRUD
        Route::resource('blogs', BlogController::class);
        Route::put('blogs/{blog}/status', [BlogController::class, 'updateStatus'])->name('blogs.status');
        Route::post('blogs/{blog}/toggle-status', [BlogController::class, 'toggleStatus'])->name('blogs.toggle-status');
        Route::post('blogs/bulk-action', [BlogController::class, 'bulkAction'])->name('blogs.bulk-action');
        Route::post('blogs/{blog}/duplicate', [BlogController::class, 'duplicate'])->name('blogs.duplicate');
        
        // Comments & Ratings Management
        Route::get('comments', [CommentManagementController::class, 'index'])->name('comments.index');
        Route::post('comments/{comment}/approve', [CommentManagementController::class, 'approveComment'])->name('comments.approve');
        Route::post('comments/{comment}/reject', [CommentManagementController::class, 'rejectComment'])->name('comments.reject');
        Route::delete('comments/{comment}', [CommentManagementController::class, 'deleteComment'])->name('comments.delete');
        Route::post('ratings/{rating}/approve', [CommentManagementController::class, 'approveRating'])->name('ratings.approve');
        Route::post('ratings/{rating}/reject', [CommentManagementController::class, 'rejectRating'])->name('ratings.reject');
        Route::delete('ratings/{rating}', [CommentManagementController::class, 'deleteRating'])->name('ratings.delete');
        Route::get('comments/stats', [CommentManagementController::class, 'stats'])->name('comments.stats');
    
    // File Manager
    Route::get('file-manager', function () {
        return view('admin.file-manager');
    })->name('file-manager');
});
});