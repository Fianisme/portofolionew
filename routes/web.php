<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AuthController;
use App\Services\ContentService;

// Frontend Routes
Route::get('/', function (ContentService $content) {
    $homeData = [
        'title' => 'FYANZ XDEV',
        'profile' => $content->get('profile'),
        'projects' => $content->getActive('projects'),
        'articles' => $content->getActive('articles'),
        'certificates' => $content->getActive('certificates'),
    ];

    return view('home', $homeData);
})->name('home');

// Frontend Article Route
Route::get('/article/{id}', function (\App\Services\ContentService $content, int $id) {
    $article = $content->find('articles', $id);

    if (!$article || !($article['active'] ?? true)) {
        abort(404);
    }

    return view('article-show', [
        'title' => $article['title'] . ' - FYANZ XDEV',
        'article' => $article,
        'articles' => $content->getActive('articles'),
    ]);
})->name('article.show');

// Admin Auth Routes (no middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Protected Routes (with middleware)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Articles
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // Certificates
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/create', [CertificateController::class, 'create'])->name('certificates.create');
    Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::get('/certificates/{id}/edit', [CertificateController::class, 'edit'])->name('certificates.edit');
    Route::put('/certificates/{id}', [CertificateController::class, 'update'])->name('certificates.update');
    Route::delete('/certificates/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
});
