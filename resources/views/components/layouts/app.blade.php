<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'TravelGo - Paket Wisata & Open Trip Terpercaya' }}</title>

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>

        <!-- Vite Assets & Livewire Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

        <!-- NAVBAR PUTIH-BIRU STICKY -->
        <header x-data="{ mobileMenuOpen: false, scrolled: false }" 
                @scroll.window="scrolled = (window.pageYOffset > 10)"
                :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md py-3.5' : 'bg-white border-b border-slate-100 py-5'"
                class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <!-- Logo TravelGo -->
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-sky-400 flex items-center justify-center text-white font-black text-xl shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform duration-300">
                            TG
                        </div>
                        <span class="text-2xl font-black tracking-tight text-slate-900">Travel<span class="text-blue-600">Go</span></span>
                    </a>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-700">
                        <a href="#hero" class="hover:text-blue-600 transition-colors">Beranda</a>
                        <a href="#tours" class="hover:text-blue-600 transition-colors">Open Trip</a>
                        <a href="#tours" class="hover:text-blue-600 transition-colors">Private Trip</a>
                        <a href="#destinations" class="hover:text-blue-600 transition-colors">Destinasi</a>
                        <a href="#testimonials" class="hover:text-blue-600 transition-colors">Testimoni</a>
                        <a href="#footer" class="hover:text-blue-600 transition-colors">Kontak</a>
                    </nav>

                    <!-- Social Media Icons & Admin Button -->
<div class="hidden md:flex items-center gap-4">
    <!-- Icon Social Media Cluster -->
    <div class="flex items-center gap-2">
        <!-- Instagram Icon -->
        <a href="https://instagram.com" target="_blank" title="Instagram" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-pink-50 text-slate-600 hover:text-pink-600 flex items-center justify-center transition shadow-sm hover:scale-105">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
        </a>

        <!-- TikTok Icon -->
        <a href="https://tiktok.com" target="_blank" title="TikTok" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-900 text-slate-600 hover:text-white flex items-center justify-center transition shadow-sm hover:scale-105">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.67 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.57-1.32 1.54-1.33 2.54.01.88.45 1.74 1.17 2.25.86.61 2.01.76 3 .39 1.04-.37 1.77-1.35 1.83-2.45.04-2.89.02-5.79.03-8.68.01-1.87.01-3.74.01-5.61z"/>
            </svg>
        </a>

        <!-- YouTube Icon -->
        <a href="https://youtube.com" target="_blank" title="YouTube" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 flex items-center justify-center transition shadow-sm hover:scale-105">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
        </a>

        <!-- WhatsApp Icon -->
        <a href="https://wa.me/6281234567890?text=Halo%20Admin" target="_blank" title="WhatsApp" class="w-9 h-9 rounded-full bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white flex items-center justify-center transition shadow-sm hover:scale-105">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
        </a>
    </div>

</div>


                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Dropdown Menu -->
            <div x-show="mobileMenuOpen" 
                 x-cloak 
                 @click.away="mobileMenuOpen = false" 
                 class="md:hidden bg-white border-b border-slate-200 px-6 pt-4 pb-6 mt-3 space-y-3 shadow-xl">
                <a href="#hero" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-blue-600 font-semibold py-1">Beranda</a>
                <a href="#tours" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-blue-600 font-semibold py-1">Paket Wisata</a>
                <a href="#destinations" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-blue-600 font-semibold py-1">Destinasi</a>
                <a href="#testimonials" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-blue-600 font-semibold py-1">Testimoni</a>
                <a href="https://wa.me/6281234567890" target="_blank" class="block w-full text-center py-3 rounded-xl bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider">💬 Tanya Admin WA</a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="min-h-screen">
            {{ $slot }}
        </main>

        <!-- FOOTER PUTIH-BIRU -->
        <footer id="footer" class="bg-slate-900 text-slate-300 py-16 border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                    
                    <!-- Brand Column -->
                    <div class="space-y-4">
                        <a href="/" class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-black text-lg">
                                TG
                            </div>
                            <span class="text-xl font-extrabold text-white">Travel<span class="text-blue-400">Go</span></span>
                        </a>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Agensi perjalanan dan open trip resmi tepercaya di Indonesia. Menghadirkan liburan seru, aman, dan dokumentasi foto/video gratis.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-white font-bold text-sm mb-4">Navigasi</h4>
                        <ul class="space-y-2.5 text-xs">
                            <li><a href="#hero" class="hover:text-blue-400 transition">Beranda</a></li>
                            <li><a href="#tours" class="hover:text-blue-400 transition">Open Trip Indonesia</a></li>
                            <li><a href="#tours" class="hover:text-blue-400 transition">Private Trip Custom</a></li>
                            <li><a href="#testimonials" class="hover:text-blue-400 transition">Testimoni Wisatawan</a></li>
                        </ul>
                    </div>

                    <!-- Popular Destinations -->
                    <div>
                        <h4 class="text-white font-bold text-sm mb-4">Destinasi Favorit</h4>
                        <ul class="space-y-2.5 text-xs text-slate-400">
                            <li>🌴 Open Trip Labuan Bajo</li>
                            <li>🏝️ Private Trip Raja Ampat</li>
                            <li>🌋 Tour Bromo Midnight</li>
                            <li>🌊 Trip Nusa Penida Bali</li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-white font-bold text-sm mb-4">Hubungi Kami</h4>
                        <ul class="space-y-2.5 text-xs text-slate-400">
                            <li class="flex items-center gap-2">
                                <span>📧 info@travelgo.com</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span>📱 +62 812-3456-7890</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span>📍 Jakarta & Bali, Indonesia</span>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                    <p>&copy; {{ date('Y') }} TravelGo. All rights reserved.</p>
                    <p>Didesain dengan <span class="text-blue-400">&hearts;</span> Tema Putih & Biru.</p>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>