<?php

use App\Livewire\AboutPage;
use App\Livewire\ArticleDetailPage;
use App\Livewire\ArticleIndexPage;
use App\Livewire\ContactPage;
use App\Livewire\FaqPage;
use App\Livewire\HomePage;
use App\Livewire\PrivateTripPage;
use App\Livewire\TermsPage;
use App\Livewire\TourDetail;
use App\Livewire\TourDetailPage;
use App\Livewire\TourSchedulePage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Beranda (Home)
Route::get('/', HomePage::class)->name('home');

// Halaman Tentang Kami (About Us)
Route::get('/about-us', AboutPage::class)->name('about');

// Halaman Jadwal Tour (Tour Schedule)
Route::get('/tour-schedule', TourSchedulePage::class)->name('tour-schedule');

// Halaman Detail Paket Wisata (Tour Detail)
Route::get('/tour/{slug}', TourDetailPage::class)->name('tour.detail');

// Halaman Private Trip & Custom Tour
Route::get('/private-trip', PrivateTripPage::class)->name('private-trip');

// Halaman Artikel & Edukasi Wisata
Route::get('/articles', ArticleIndexPage::class)->name('articles.index');
Route::get('/article/{slug}', ArticleDetailPage::class)->name('articles.detail');

// Halaman Syarat & Ketentuan (Terms & Conditions)
Route::get('/terms-conditions', TermsPage::class)->name('terms');

// Halaman FAQ (Frequently Asked Questions)
Route::get('/faq', FaqPage::class)->name('faq');

// Halaman Kontak Kami (Contact Us)
Route::get('/contact', ContactPage::class)->name('contact');

// Halaman Detail Paket Wisata (Tour Detail)
// Route::get('/tour/{slug}', TourDetail::class)->name('tour.detail');




