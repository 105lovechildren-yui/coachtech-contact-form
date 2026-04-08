<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
	Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
	Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
	Route::get('/reset', [AdminController::class, 'reset'])->name('admin.reset');
	Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
	Route::delete('/admin/{contact}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::get('/', [ContactController::class, 'create'])->name('contact.create');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');
