<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\FundingController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ConsultationController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\AuthController;

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
  Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::get('/login','showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
  });

  // Protected Admin Routes
  Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Events
    Route::resource('events', EventController::class);
    Route::get('/events/{event}/registrations', [EventController::class, 'registrations'])->name('events.registrations');

    // Universities
    Route::resource('universities', UniversityController::class);
    Route::get('/universities/{university}/edit', [UniversityController::class, 'edit'])->name('universities.edit');

    // Admissions
    Route::resource('admissions', AdmissionController::class);
    Route::get('/admissions/filter', [AdmissionController::class, 'filter'])->name('admissions.filter');
    Route::get('/admissions/{admission}/edit', [AdmissionController::class, 'edit'])->name('admissions.edit');

    // Funding
    Route::resource('funding', FundingController::class);
    Route::get('/funding/filter', [FundingController::class, 'filter'])->name('funding.filter');
    Route::get('/funding/{funding}/edit', [FundingController::class, 'edit'])->name('funding.edit');

    // Blogs
    Route::resource('blogs', BlogController::class);
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');

    // Consultations
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/filter', [ConsultationController::class, 'filter'])->name('consultations.filter');
    Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])->name('consultations.show');
    Route::get('/consultations/export/csv', [ConsultationController::class, 'export'])->name('consultations.export');

    // Newsletters
    Route::get('/newsletters', [NewsletterController::class, 'index'])->name('newsletters.index');
    Route::post('/newsletters/send', [NewsletterController::class, 'send'])->name('newsletters.send');
    Route::get('/newsletters/search', [NewsletterController::class, 'search'])->name('newsletters.search');
    Route::get('/newsletters/export', [NewsletterController::class, 'export'])->name('newsletters.export');
    Route::delete('/newsletters/{newsletter}', [NewsletterController::class, 'destroy'])->name('newsletters.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
  });
});
