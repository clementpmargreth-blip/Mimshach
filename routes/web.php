<?php

use App\Http\Controllers\Guest\AdmissionController;
use App\Http\Controllers\Guest\BlogController;
use App\Http\Controllers\Guest\ConsultationController;
use App\Http\Controllers\Guest\ContactController;
use App\Http\Controllers\Guest\EventController;
use App\Http\Controllers\Guest\FundingController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\NewsletterController;
use App\Http\Controllers\Guest\UniversityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admissions')->name('admissions.')->controller(AdmissionController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{admission}', 'show')->name('admission');
});

Route::prefix('fundings')->name('fundings.')->controller(FundingController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{funding}', 'show')->name('funding');
});

Route::prefix('universities')->name('universities.')->controller(UniversityController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{university}', 'show')->name('university');
});

Route::prefix('events')->name('events.')->controller(EventController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{event}', 'show')->name('event');
    Route::post('/{event}/register', 'store')->name('register');
});

Route::prefix('blogs')->name('blogs.')->controller(BlogController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{article}', 'show')->name('article');
});

Route::prefix('contact')->name('contact.')->controller(ContactController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/submit', 'submit')->name('submit');
});

Route::prefix('consultation')->name('consultation.')->controller(ConsultationController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/submit', 'submit')->name('submit');
});

Route::post('/newsletter/subscribe', NewsletterController::class)->name('newsletter.subscribe');

if (file_exists(__DIR__ . '/admin.php')) {
    require __DIR__ . '/admin.php';
}
