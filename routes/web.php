<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'view'])->name('blogs.view'); // Blade page
Route::get('/blogs/data', [BlogController::class, 'index'])->name('blogs.data'); // JSON for DataTables