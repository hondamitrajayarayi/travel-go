<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'TravelGo - Paket Wisata & Open Trip Terpercaya' }}</title>
        <link rel="icon" href="{{ asset('images/logo/LOGO.png') }}" type="image/png">

        <!-- Google Fonts: Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
        </style>

        <!-- Vite Assets & Livewire Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

        <!-- NAVBAR PUTIH-BIRU STICKY DENGAN ACTIVE MENU & DROPDOWN -->
        <header x-data="{ 
                    mobileMenuOpen: false, 
                    mobileAboutOpen: false,
                    aboutDropdownOpen: false, 
                    scrolled: false,
                    activeNav: '{{ request()->routeIs('about') ? 'about' : (request()->routeIs('contact') ? 'contact' : (request()->routeIs('terms') ? 'terms' : (request()->routeIs('faq') ? 'faq' : 'home'))) }}',
                    init() {
                        const updateScroll = () => {
                            this.scrolled = window.pageYOffset > 10;
                        };
                        window.addEventListener('scroll', updateScroll);
                        updateScroll();
                    }
                }" 
                :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md py-3.5' : 'bg-white border-b border-slate-100 py-4 sm:py-5'"
                class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <!-- Logo TravelGo -->
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 group">
                        <img src="{{ asset('images/logo/LOGO HORIZONTAL.png') }}" alt="Super Vacation Logo" class="h-10 sm:h-12 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
                    </a>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center space-x-7 lg:space-x-9 text-xs font-medium tracking-tight">
                        
                        <!-- 1. HOME -->
                        <a href="{{ route('home') }}" 
                           wire:navigate
                           @click="activeNav = 'home'" 
                           :class="activeNav === 'home' ? 'text-[#3372A1] font-semibold' : 'text-slate-600 hover:text-[#3372A1] font-normal'" 
                           class="py-1 transition-colors duration-200 uppercase">
                            Home
                        </a>

                        <!-- 2. ABOUT US (DROPDOWN) -->
                        <div class="relative py-1" 
                             @mouseenter="aboutDropdownOpen = true" 
                             @mouseleave="aboutDropdownOpen = false">
                            <a href="{{ route('about') }}" 
                               wire:navigate
                               @click="activeNav = 'about'"
                               :class="activeNav === 'about' ? 'text-[#3372A1] font-semibold' : 'text-slate-600 hover:text-[#3372A1] font-normal'" 
                               class="inline-flex items-center gap-1.5 transition-colors duration-200 uppercase cursor-pointer focus:outline-none">
                                <span>About us</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" 
                                     :class="aboutDropdownOpen ? 'rotate-180 text-[#3372A1]' : 'text-slate-400'" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>

                            <!-- Dropdown Box -->
                            <div x-show="aboutDropdownOpen" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute left-0 mt-2 w-44 rounded-2xl bg-white shadow-lg shadow-slate-900/10 border border-slate-100 py-1.5 z-50 divide-y divide-slate-50">
                                
                                <a href="{{ route('about') }}#history" 
                                   wire:navigate
                                   @click="activeNav = 'about'; aboutDropdownOpen = false; scrollToSection('history')" 
                                   class="flex items-center px-4 py-2 text-xs uppercase tracking-wider text-slate-600 hover:text-[#3372A1] hover:bg-sky-50/50 transition-colors">
                                    <span>History</span>
                                </a>

                                <a href="{{ route('about') }}#why-us" 
                                   wire:navigate
                                   @click="activeNav = 'about'; aboutDropdownOpen = false; scrollToSection('why-us')" 
                                   class="flex items-center px-4 py-2 text-xs uppercase tracking-wider text-slate-600 hover:text-[#3372A1] hover:bg-sky-50/50 transition-colors">
                                    <span>Why Us</span>
                                </a>

                                <!-- <a href="{{ route('about') }}#career" 
                                   wire:navigate
                                   @click="activeNav = 'about'; aboutDropdownOpen = false; scrollToSection('career')" 
                                   class="flex items-center px-4 py-2 text-xs uppercase tracking-wider text-slate-600 hover:text-[#3372A1] hover:bg-sky-50/50 transition-colors">
                                    <span>Career</span>
                                </a> -->
                            </div>
                        </div>

                        <!-- 3. TOUR SCHEDULE -->
                        <a href="{{ route('home') }}#tours" 
                           wire:navigate
                           @click="activeNav = 'tour-schedule'" 
                           :class="activeNav === 'tour-schedule' ? 'text-[#3372A1] font-semibold' : 'text-slate-600 hover:text-[#3372A1] font-normal'" 
                           class="py-1 transition-colors duration-200 uppercase">
                            Tour Schedule
                        </a>

                        <!-- 4. PRIVATE TRIP -->
                        <a href="{{ route('home') }}#tours" 
                           wire:navigate
                           @click="activeNav = 'private-trip'" 
                           :class="activeNav === 'private-trip' ? 'text-[#3372A1] font-semibold' : 'text-slate-600 hover:text-[#3372A1] font-normal'" 
                           class="py-1 transition-colors duration-200 uppercase">
                            Private Trip
                        </a>

                        <!-- 5. CONTACT -->
                        <a href="{{ route('contact') }}" 
                           wire:navigate
                           @click="activeNav = 'contact'" 
                           :class="activeNav === 'contact' ? 'text-[#3372A1] font-semibold' : 'text-slate-600 hover:text-[#3372A1] font-normal'" 
                           class="py-1 transition-colors duration-200 uppercase">
                            Contact
                        </a>
                    </nav>

                    <!-- Social Media Icons -->
                    <div class="hidden md:flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <!-- Instagram Icon -->
                            <a href="{{ \App\Models\Setting::get('instagram_url', 'https://instagram.com') }}" target="_blank" title="Instagram" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-pink-50 text-slate-600 hover:text-pink-600 flex items-center justify-center transition shadow-xs hover:scale-105">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>

                            <!-- TikTok Icon -->
                            <a href="{{ \App\Models\Setting::get('tiktok_url', 'https://tiktok.com') }}" target="_blank" title="TikTok" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-900 text-slate-600 hover:text-white flex items-center justify-center transition shadow-xs hover:scale-105">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.67 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.57-1.32 1.54-1.33 2.54.01.88.45 1.74 1.17 2.25.86.61 2.01.76 3 .39 1.04-.37 1.77-1.35 1.83-2.45.04-2.89.02-5.79.03-8.68.01-1.87.01-3.74.01-5.61z"/>
                                </svg>
                            </a>

                            <!-- WhatsApp Icon -->
                            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode(\App\Models\Setting::get('whatsapp_default_message', 'Halo Admin Super Vacation, saya ingin konsultasi rencana perjalanan saya')) }}" target="_blank" title="WhatsApp" class="w-9 h-9 rounded-full bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white flex items-center justify-center transition shadow-xs hover:scale-105">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button @click="mobileMenuOpen = true" type="button" aria-label="Buka Menu" class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 focus:outline-none transition">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Full Page Mobile Menu Overlay (Teleported to Body) -->
            <template x-teleport="body">
                <div x-show="mobileMenuOpen" 
                     x-cloak 
                     x-effect="document.body.style.overflow = mobileMenuOpen ? 'hidden' : ''"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="fixed inset-0 z-[9999] bg-white flex flex-col justify-between p-6 sm:p-8 overflow-y-auto md:hidden w-screen h-screen">
                
                <!-- Top Header in Full Page Menu -->
                <div>
                    <div class="flex items-center justify-between pb-6 border-b border-slate-100">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" 
                           wire:navigate 
                           @click="activeNav = 'home'; mobileMenuOpen = false" 
                           class="flex items-center gap-2">
                            <img src="{{ asset('images/logo/LOGO HORIZONTAL.png') }}" alt="Super Vacation Logo" class="h-9 w-auto object-contain">
                        </a>

                        <!-- Close (X) Button -->
                        <button @click="mobileMenuOpen = false" 
                                type="button" 
                                aria-label="Tutup Menu"
                                class="w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition focus:outline-none">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation Links List -->
                    <nav class="py-6 space-y-1">
                        
                        <!-- 1. HOME -->
                        <div class="border-b border-slate-100/80">
                            <a href="{{ route('home') }}" 
                               wire:navigate
                               @click="activeNav = 'home'; mobileMenuOpen = false" 
                               :class="activeNav === 'home' ? 'text-[#3372A1] font-semibold' : 'text-slate-800 font-medium hover:text-[#3372A1]'"
                               class="flex items-center justify-between py-3.5 text-[15px] uppercase tracking-wider transition">
                                <span>HOME</span>
                                <span x-show="activeNav === 'home'" class="w-2 h-2 rounded-full bg-[#3372A1]"></span>
                            </a>
                        </div>

                        <!-- 2. ABOUT US (Accordion / Submenu) -->
                        <div class="border-b border-slate-100/80">
                            <div class="flex items-center justify-between py-3.5"
                                 :class="activeNav === 'about' ? 'text-[#3372A1] font-semibold' : 'text-slate-800 font-medium hover:text-[#3372A1]'">
                                <a href="{{ route('about') }}" 
                                   wire:navigate
                                   @click="activeNav = 'about'; mobileMenuOpen = false"
                                   class="flex-1 text-[15px] uppercase tracking-wider">
                                    ABOUT US
                                </a>
                                <button type="button" 
                                        @click="mobileAboutOpen = !mobileAboutOpen"
                                        aria-label="Toggle About Submenu"
                                        class="p-2 -mr-2 text-slate-400 hover:text-slate-700 focus:outline-none">
                                    <svg class="w-4 h-4 transition-transform duration-200" 
                                         :class="mobileAboutOpen ? 'rotate-180 text-[#3372A1]' : 'text-slate-400'" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Submenu -->
                            <div x-show="mobileAboutOpen" x-cloak class="pl-4 pr-2 pb-3 space-y-2 bg-slate-50/70 rounded-2xl mb-3 border border-slate-100">
                                <a href="{{ route('about') }}#history" 
                                   wire:navigate
                                   @click="activeNav = 'about'; mobileMenuOpen = false; scrollToSection('history')" 
                                   class="block px-3 py-2 text-xs font-semibold text-slate-600 hover:text-[#3372A1] uppercase tracking-wider">
                                    HISTORY
                                </a>
                                <a href="{{ route('about') }}#why-us" 
                                   wire:navigate
                                   @click="activeNav = 'about'; mobileMenuOpen = false; scrollToSection('why-us')" 
                                   class="block px-3 py-2 text-xs font-semibold text-slate-600 hover:text-[#3372A1] uppercase tracking-wider">
                                    WHY US
                                </a>
                            </div>
                        </div>

                        <!-- 3. TOUR SCHEDULE -->
                        <div class="border-b border-slate-100/80">
                            <a href="{{ route('home') }}#tours" 
                               wire:navigate
                               @click="activeNav = 'tour-schedule'; mobileMenuOpen = false" 
                               :class="activeNav === 'tour-schedule' ? 'text-[#3372A1] font-semibold' : 'text-slate-800 font-medium hover:text-[#3372A1]'"
                               class="flex items-center justify-between py-3.5 text-[15px] uppercase tracking-wider transition">
                                <span>TOUR SCHEDULE</span>
                                <span x-show="activeNav === 'tour-schedule'" class="w-2 h-2 rounded-full bg-[#3372A1]"></span>
                            </a>
                        </div>

                        <!-- 4. PRIVATE TRIP -->
                        <div class="border-b border-slate-100/80">
                            <a href="{{ route('home') }}#tours" 
                               wire:navigate
                               @click="activeNav = 'private-trip'; mobileMenuOpen = false" 
                               :class="activeNav === 'private-trip' ? 'text-[#3372A1] font-semibold' : 'text-slate-800 font-medium hover:text-[#3372A1]'"
                               class="flex items-center justify-between py-3.5 text-[15px] uppercase tracking-wider transition">
                                <span>PRIVATE TRIP</span>
                                <span x-show="activeNav === 'private-trip'" class="w-2 h-2 rounded-full bg-[#3372A1]"></span>
                            </a>
                        </div>

                        <!-- 5. CONTACT -->
                        <div>
                            <a href="{{ route('contact') }}" 
                               wire:navigate
                               @click="activeNav = 'contact'; mobileMenuOpen = false" 
                               :class="activeNav === 'contact' ? 'text-[#3372A1] font-semibold' : 'text-slate-800 font-medium hover:text-[#3372A1]'"
                               class="flex items-center justify-between py-3.5 text-[15px] uppercase tracking-wider transition">
                                <span>CONTACT</span>
                                <span x-show="activeNav === 'contact'" class="w-2 h-2 rounded-full bg-[#3372A1]"></span>
                            </a>
                        </div>

                    </nav>
                </div>

                <!-- Bottom Action & Socials -->
                <div class="pt-6 border-t border-slate-100 space-y-4">
                    <!-- WhatsApp Action Button -->
                        <!-- WhatsApp Button -->
                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode(\App\Models\Setting::get('whatsapp_default_message', 'Halo Admin Super Vacation, saya ingin konsultasi rencana perjalanan saya')) }}" 
                        target="_blank" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-full bg-[#1b5a7a] hover:bg-[#13425a] text-white font-medium text-sm transition-all duration-200 shadow-sm hover:shadow active:scale-95">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi gratis via WhatsApp</span>
                        </a>

                    <!-- Social Icons -->
                    <div class="flex items-center justify-center gap-3 pt-2 text-slate-400 text-xs">
                        <a href="{{ \App\Models\Setting::get('instagram_url', 'https://instagram.com') }}" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-pink-50 text-slate-600 hover:text-pink-600 flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="{{ \App\Models\Setting::get('tiktok_url', 'https://tiktok.com') }}" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-900 text-slate-600 hover:text-white flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.67 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.57-1.32 1.54-1.33 2.54.01.88.45 1.74 1.17 2.25.86.61 2.01.76 3 .39 1.04-.37 1.77-1.35 1.83-2.45.04-2.89.02-5.79.03-8.68.01-1.87.01-3.74.01-5.61z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            </template>
        </header>

        <!-- Main Content -->
        <main class="min-h-screen">
            {{ $slot }}
        </main>

        <!-- FOOTER CLEAN PUTIH -->
        <footer id="contact" class="bg-white text-slate-600 pt-16 pb-10 border-t border-slate-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-12 pb-12 border-b border-slate-100">
                    
                    <!-- 1. Brand & Essence (Col-span 5) -->
                    <div class="md:col-span-5 space-y-3">
                        <a href="{{ route('home') }}" wire:navigate class="inline-block group">
                            <img src="{{ asset('images/logo/LOGO HORIZONTAL.png') }}" alt="Super Vacation Logo" class="h-9 sm:h-10 w-auto object-contain group-hover:opacity-90 transition-opacity">
                        </a>
                        <p class="text-xs sm:text-[13px] text-slate-500 leading-relaxed max-w-sm font-normal">
                            Super Vacation menghadirkan paket perjalanan luar negeri dan open trip terpercaya dengan dedikasi pengalaman industri sejak 2003. Wujudkan liburan impian Anda dengan nyaman dan aman.
                        </p>
                        
                        <!-- Social Media Icons -->
                        <div class="flex items-center gap-2.5 pt-2">
                            <a href="{{ \App\Models\Setting::get('instagram_url', 'https://instagram.com') }}" target="_blank" title="Instagram" class="w-9 h-9 rounded-full bg-slate-50 hover:bg-pink-50 text-slate-500 hover:text-pink-600 flex items-center justify-center transition duration-200 border border-slate-200/80 shadow-2xs">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <a href="{{ \App\Models\Setting::get('tiktok_url', 'https://tiktok.com') }}" target="_blank" title="TikTok" class="w-9 h-9 rounded-full bg-slate-50 hover:bg-slate-900 text-slate-500 hover:text-white flex items-center justify-center transition duration-200 border border-slate-200/80 shadow-2xs">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.67 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.57-1.32 1.54-1.33 2.54.01.88.45 1.74 1.17 2.25.86.61 2.01.76 3 .39 1.04-.37 1.77-1.35 1.83-2.45.04-2.89.02-5.79.03-8.68.01-1.87.01-3.74.01-5.61z"/></svg>
                            </a>
                            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode(\App\Models\Setting::get('whatsapp_default_message', 'Halo Admin Super Vacation, saya ingin konsultasi rencana perjalanan saya')) }}" target="_blank" title="WhatsApp" class="w-9 h-9 rounded-full bg-slate-50 hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 flex items-center justify-center transition duration-200 border border-slate-200/80 shadow-2xs">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- 2. Navigasi Cepat (Col-span 2) -->
                    <div class="md:col-span-2 space-y-3">
                        <h4 class="text-slate-900 text-xs font-semibold uppercase tracking-widest">
                            Navigasi
                        </h4>
                        <ul class="space-y-2.5 text-xs text-slate-600 font-medium">
                            <li>
                                <a href="{{ route('home') }}" wire:navigate class="hover:text-[#3372A1] transition-colors duration-150 inline-flex items-center gap-1.5">
                                    <span>HOME</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}" wire:navigate class="hover:text-[#3372A1] transition-colors duration-150 inline-flex items-center gap-1.5">
                                    <span>ABOUT US</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}#history" wire:navigate class="hover:text-[#3372A1] transition-colors duration-150 inline-flex items-center gap-1.5">
                                    <span>HISTORY</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}#why-us" wire:navigate class="hover:text-[#3372A1] transition-colors duration-150 inline-flex items-center gap-1.5">
                                    <span>WHY US</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}#tours" wire:navigate class="hover:text-[#3372A1] transition-colors duration-150 inline-flex items-center gap-1.5">
                                    <span>TOUR SCHEDULE</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" wire:navigate class="hover:text-[#3372A1] transition-colors duration-150 inline-flex items-center gap-1.5">
                                    <span>CONTACT</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- 3. Hubungi Kami (Col-span 3) -->
                    <div class="md:col-span-3 space-y-3">
                        <h4 class="text-slate-900 text-xs font-semibold uppercase tracking-widest">
                            Contact Us
                        </h4>
                        <ul class="space-y-3.5 text-xs text-slate-600">
                            <li class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block font-medium">WhatsApp / Konsultasi</span>
                                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode(\App\Models\Setting::get('whatsapp_default_message', 'Halo Admin Super Vacation, saya ingin konsultasi rencana perjalanan saya')) }}" target="_blank" class="text-slate-800 hover:text-emerald-600 font-medium transition-colors">
                                        {{ \App\Models\Setting::get('whatsapp_display', '+62 878-8784-0636') }}
                                    </a>
                                </div>
                            </li>

                            <li class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block font-medium">Email Resmi</span>
                                    <a href="mailto:{{ \App\Models\Setting::get('email', 'supervacationtour@gmail.com') }}" class="text-slate-800 hover:text-[#3372A1] font-medium transition-colors">
                                        {{ \App\Models\Setting::get('email', 'supervacationtour@gmail.com') }}
                                    </a>
                                </div>
                            </li>

                            <li class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center shrink-0 border border-rose-100 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wider block font-medium">Kantor Layanan</span>
                                    <span class="text-slate-700 font-medium block leading-relaxed">
                                        {{ \App\Models\Setting::get('address', 'Jl. Pahlawan Raya, Gg Galery No 5A, Cinangka, Sawangan, Depok, Jawa Barat, 16516') }}
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- 4. Information (Col-span 2) -->
                    <div class="md:col-span-2 space-y-3">
                        <h4 class="text-slate-900 text-xs font-semibold uppercase tracking-widest">
                            Information
                        </h4>
                        <ul class="space-y-2.5 text-xs text-slate-600 font-medium">
                            <li>
                                <a href="{{ route('terms') }}" wire:navigate class="hover:text-[#3372A1] transition-colors duration-150 inline-flex items-center gap-1.5">
                                    <span>Terms & Conditions</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq') }}" wire:navigate class="hover:text-[#3372A1] transition-colors duration-150 inline-flex items-center gap-1.5">
                                    <span>FAQ</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Copyright & Badges -->
                <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-3">
                    <p>&copy; {{ date('Y') }} Super Vacation. All rights reserved.</p>
                    <p class="text-[11px] text-slate-400">Sister Brand of Golden Vacation (Est. 2003)</p>
                </div>
            </div>
        </footer>

        @livewireScripts
        <script>
            function scrollToSection(sectionId) {
                setTimeout(() => {
                    const el = document.getElementById(sectionId);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth' });
                    }
                }, 100);
            }

            document.addEventListener('livewire:navigated', () => {
                if (window.location.hash) {
                    const id = window.location.hash.replace('#', '');
                    scrollToSection(id);
                }
            });

            window.addEventListener('hashchange', () => {
                if (window.location.hash) {
                    const id = window.location.hash.replace('#', '');
                    scrollToSection(id);
                }
            });
        </script>
    </body>
</html>