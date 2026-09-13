<?php

use App\Livewire\HomePage;
use App\Livewire\TourDetail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Beranda (Home)
Route::get('/', HomePage::class)->name('home');

// Halaman Detail Paket Wisata (Tour Detail)
// Route::get('/tour/{slug}', TourDetail::class)->name('tour.detail');
