<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportReviewController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\KetuaRt\ReportController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

// Chatbot API Proxy - Forward requests ke Node.js server internal
// Ini memungkinkan Laravel dan Node.js berbagi 1 hosting/domain yang sama
Route::any('/api/chatbot/{path}', function (Request $request, $path) {
    try {
        // Internal Node.js chatbot URL (localhost di server yang sama)
        $chatbotUrl = config('chatbot.api_url') . '/api/' . $path;
        
        // Forward request ke Node.js dengan timeout 35 detik
        $response = Http::timeout(35)
            ->withHeaders($request->headers->all())
            ->{strtolower($request->method())}($chatbotUrl, $request->all());
        
        // Return response dari Node.js ke client
        return response($response->body(), $response->status())
            ->withHeaders($response->headers());
            
    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        return response()->json([
            'ok' => false,
            'error' => 'Chatbot service tidak dapat dihubungi. Pastikan Node.js server berjalan.',
            'detail' => config('app.debug') ? $e->getMessage() : null
        ], 503);
    } catch (\Exception $e) {
        return response()->json([
            'ok' => false,
            'error' => 'Terjadi kesalahan pada layanan chatbot',
            'detail' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
})->where('path', '.*');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/layanan', [HomeController::class, 'services'])->name('services');
Route::get('/berita', [HomeController::class, 'news'])->name('news');
Route::get('/pengumuman', [HomeController::class, 'announcements'])->name('announcements');
Route::get('/data-rt', [RtController::class, 'index'])->name('rt.index');
Route::get('/data-rt/{rt_code}', [RtController::class, 'show'])->name('rt.show');
Route::get('/pengaduan', [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/pengaduan', [ComplaintController::class, 'store'])->name('complaint.store');
Route::get('/pengaduan/sukses', [ComplaintController::class, 'success'])->name('complaint.success');
Route::get('/post/{slug}', [HomeController::class, 'showPost'])->name('post.show');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Posts
    Route::resource('posts', PostController::class);
    Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
    
    // Complaints
    Route::resource('complaints', \App\Http\Controllers\Admin\ComplaintController::class)->except(['create', 'edit']);
    Route::patch('/complaints/{complaint}/status', [\App\Http\Controllers\Admin\ComplaintController::class, 'updateStatus'])->name('complaints.update-status');
    Route::get('/complaints/export', [\App\Http\Controllers\Admin\ComplaintController::class, 'export'])->name('complaints.export');
    
    // User Management (Ketua RT)
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // RT Management
    Route::resource('rts', \App\Http\Controllers\Admin\RtController::class);
    
    // Report Review
    Route::get('/reports', [ReportReviewController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [ReportReviewController::class, 'show'])->name('reports.show');
    Route::patch('/reports/{report}/status', [ReportReviewController::class, 'updateStatus'])->name('reports.update-status');
    Route::delete('/reports/{report}', [ReportReviewController::class, 'destroy'])->name('reports.destroy');
    Route::get('/reports/export', [ReportReviewController::class, 'export'])->name('reports.export');
});

// Ketua RT routes
Route::middleware(['auth', 'role:ketua_rt'])->prefix('ketua-rt')->name('ketua-rt.')->group(function () {
    Route::get('/', [ReportController::class, 'dashboard'])->name('dashboard');
    
    // Reports Management
    Route::resource('reports', ReportController::class);
    Route::post('/reports/{report}/submit', [ReportController::class, 'submit'])->name('reports.submit');
});

// User dashboard routes
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('index');
});