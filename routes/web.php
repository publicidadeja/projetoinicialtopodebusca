<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\BusinessPostController;
use App\Http\Controllers\BusinessReviewController;
use App\Http\Controllers\BusinessAnalyticController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/business', [BusinessProfileController::class, 'index'])->middleware(['auth'])->name('business.index');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Redireciona o dashboard para a listagem de negócios
    Route::get('/dashboard', function () {
        return redirect()->route('business-profiles.index');
    })->name('dashboard');

    // Rotas para perfis de negócio
    Route::resource('business-profiles', BusinessProfileController::class);

    // Rotas para posts
    Route::prefix('business-profiles/{profile}/posts')->name('business-profiles.posts.')->group(function () {
        Route::get('/', [BusinessPostController::class, 'index'])->name('index');
        Route::get('/create', [BusinessPostController::class, 'create'])->name('create');
        Route::post('/', [BusinessPostController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [BusinessPostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [BusinessPostController::class, 'update'])->name('update');
        Route::delete('/{post}', [BusinessPostController::class, 'destroy'])->name('destroy');
        Route::post('/{post}/publish', [BusinessPostController::class, 'publish'])->name('publish');
    });

    // Rotas para reviews
    Route::prefix('business-profiles/{profile}/reviews')->name('business-profiles.reviews.')->group(function () {
        Route::get('/', [BusinessReviewController::class, 'index'])->name('index');
        Route::post('/sync', [BusinessReviewController::class, 'sync'])->name('sync');
        Route::post('/{review}/reply', [BusinessReviewController::class, 'reply'])->name('reply');
    });

    // Rotas para analytics
    Route::prefix('business-profiles/{profile}/analytics')->name('business-profiles.analytics.')->group(function () {
        Route::get('/', [BusinessAnalyticController::class, 'index'])->name('index');
        Route::post('/sync', [BusinessAnalyticController::class, 'sync'])->name('sync');
        Route::get('/export', [BusinessAnalyticController::class, 'export'])->name('export');
    });
});

// Rotas de perfil do usuário (mantidas do Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/login', function () {
    return view('auth/login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';