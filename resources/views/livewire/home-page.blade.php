@php
    $slidesData = [];
    if (isset($banners) && $banners->count() > 0) {
        foreach ($banners as $b) {
            $desktopImg = $b->desktop_image_url 
                ?: ($b->image_path ? asset('storage/' . $b->image_path) : ($b->file_path ? asset('storage/' . $b->file_path) : null));
            $mobileVid = $b->mobile_video_url 
                ?: ($b->video_path ? asset('storage/' . $b->video_path) : ($b->type === 'video' && $b->file_path ? asset('storage/' . $b->file_path) : null));

            // Jika desktop belum ada gambar tapi ada file lama, pastikan fallback
            if (!$desktopImg && $mobileVid) {
                $desktopImg = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=2000&q=80';
            }

            $slidesData[] = [
                'placement'     => $b->placement ?? 'all', // 'all', 'desktop', 'mobile'
                'desktop_image' => $desktopImg,
                'mobile_video'  => $mobileVid,
                'title'         => $b->title,
                'subtitle'      => $b->subtitle,
                'button_text'   => $b->button_text,
                'link_url'      => $b->link_url,
            ];
        }
    } else {
        $defaultImages = [
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=2000&q=80',
            'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=2000&q=80',
            'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=2000&q=80',
            'https://images.unsplash.com/photo-1534008897995-27a23e859048?auto=format&fit=crop&w=2000&q=80'
        ];
        foreach ($defaultImages as $img) {
            $slidesData[] = [
                'placement'     => 'all',
                'desktop_image' => $img,
                'mobile_video'  => null,
                'title'         => null,
                'subtitle'      => null,
                'button_text'   => null,
                'link_url'      => null,
            ];
        }
    }
@endphp

<div>
    <!-- SCROLL ANIMATION STYLES -->
    <style>
        .reveal-item {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-up {
            transform: translateY(32px);
        }
        .reveal-left {
            transform: translateX(-36px);
        }
        .reveal-right {
            transform: translateX(36px);
        }
        .reveal-scale {
            transform: scale(0.94) translateY(20px);
        }
        .reveal-fade {
            transform: translateY(16px);
        }

        /* Triggered state */
        .is-revealed.reveal-item,
        .is-revealed .reveal-item {
            opacity: 1 !important;
            transform: translate3d(0, 0, 0) scale(1) !important;
        }
    </style>

        <!-- 1. HERO BANNER SECTION DENGAN FILTER TARGET TAMPILAN (MOBILE SAJA / WEB SAJA / DUA-DUANYA) -->
    <section id="hero" 
             x-data="{ 
                allSlides: @js($slidesData),
                currentSlide: 0, 
                isDesktop: window.innerWidth >= 1024,
                get slides() {
                    const filtered = this.allSlides.filter(s => {
                        if (this.isDesktop) {
                            return s.placement === 'all' || s.placement === 'desktop';
                        } else {
                            return s.placement === 'all' || s.placement === 'mobile';
                        }
                    });
                    return filtered.length > 0 ? filtered : this.allSlides;
                },
                init() {
                    window.addEventListener('resize', () => {
                        const wasDesktop = this.isDesktop;
                        this.isDesktop = window.innerWidth >= 1024;
                        if (wasDesktop !== this.isDesktop) {
                            this.currentSlide = 0;
                        }
                    });
                    setInterval(() => {
                        if (this.slides.length > 1) {
                            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                        }
                    }, 6000);
                }
             }"
             class="relative pt-24 pb-8 sm:pb-12 min-h-[85vh] sm:min-h-[90vh] flex flex-col justify-end items-center overflow-hidden">
        
        <!-- Background Slider (Video Khusus Mobile HP, Gambar Khusus Desktop Web) -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition opacity ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition opacity ease-in duration-1000"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 z-0">
                
                <!-- TAMPILAN MOBILE (HP): Prioritaskan Video Background jika tersedia -->
                <div class="block lg:hidden w-full h-full">
                    <template x-if="slide.mobile_video">
                        <video autoplay loop muted playsinline 
                               class="w-full h-full object-cover object-center">
                            <source :src="slide.mobile_video" type="video/mp4">
                            <source :src="slide.mobile_video" type="video/webm">
                        </video>
                    </template>
                    <template x-if="!slide.mobile_video">
                        <img :src="slide.desktop_image" 
                             alt="Hero Background Mobile Slide" 
                             class="w-full h-full object-cover object-center" />
                    </template>
                </div>

                <!-- TAMPILAN DESKTOP WEB BIASA: Selalu Menggunakan Gambar Berkualitas Tinggi -->
                <div class="hidden lg:block w-full h-full">
                    <img :src="slide.desktop_image" 
                         alt="Hero Background Desktop Slide" 
                         class="w-full h-full object-cover object-center transform transition-transform duration-10000" />
                </div>

                <!-- Overlay Dinamis: Lebih gelap dan kontras khusus banner yang memiliki judul/subjudul -->
                <div :class="(slide.title || slide.subtitle) 
                        ? 'absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/45 to-slate-950/30' 
                        : 'absolute inset-0 bg-gradient-to-b from-slate-500/20 via-slate-500/10 to-slate-500/20'"
                     class="transition-all duration-700"></div>
            </div>
        </template>

        <!-- Tombol Panah Navigasi Slider (Tampil Jika Slide > 1) -->
        <template x-if="slides.length > 1">
            <div>
                <button @click="currentSlide = (currentSlide - 1 + slides.length) % slides.length" 
                        type="button" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-white/20 hover:bg-white/40 text-white backdrop-blur-md transition hidden sm:flex items-center justify-center shadow-lg">
                    ❮
                </button>
                <button @click="currentSlide = (currentSlide + 1) % slides.length" 
                        type="button" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-white/20 hover:bg-white/40 text-white backdrop-blur-md transition hidden sm:flex items-center justify-center shadow-lg">
                    ❯
                </button>
            </div>
        </template>

        <!-- Hero Content Overlay (Posisi Bawah Tengah) -->
        <div class="relative z-10 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            
            <!-- Judul & Subjudul Dinamis Berdasarkan Banner yang Sedang Ditampilkan -->
            <template x-if="slides[currentSlide] && (slides[currentSlide].title || slides[currentSlide].subtitle)">
                <div class="space-y-2 pb-2"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <template x-if="slides[currentSlide].title">
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-semibold tracking-tight text-white leading-tight max-w-4xl mx-auto drop-shadow-[0_4px_16px_rgba(0,0,0,0.7)]"
                            x-text="slides[currentSlide].title"></h1>
                    </template>
                    <template x-if="slides[currentSlide].subtitle">
                        <p class="text-sm sm:text-base lg:text-lg text-white/95 font-medium max-w-2xl mx-auto drop-shadow-[0_2px_8px_rgba(0,0,0,0.8)] leading-relaxed"
                           x-text="slides[currentSlide].subtitle"></p>
                    </template>
                </div>
            </template>

            <template x-if="slides[currentSlide] && slides[currentSlide].button_text && slides[currentSlide].link_url">
                <div class="pt-1">
                    <a :href="slides[currentSlide].link_url" 
                       class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-gradient-to-r from-blue-600 to-sky-500 hover:from-blue-700 hover:to-sky-600 text-white font-semibold text-sm shadow-xl shadow-blue-600/30 hover:scale-105 transition duration-300">
                        <span x-text="slides[currentSlide].button_text"></span>
                        <span>➔</span>
                    </a>
                </div>
            </template>

            <!-- FLOATING SEARCH BAR (KAPSUL PUTIH SIMPEL & ELEGAN ALA REFERENSI GAMBAR) -->
            <div class="reveal-item reveal-scale w-full max-w-3xl mx-auto bg-white rounded-[28px] sm:rounded-full border border-slate-200/90 shadow-2xl p-3 sm:p-2 sm:pl-8 text-left transition-all" style="transition-delay: 150ms">
                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-0">
                    
                    <!-- 1. TUJUAN (LIST NEGARA) -->
                    <div class="flex-1 w-full sm:w-auto px-3 sm:px-4 py-1 sm:border-r border-slate-200">
                        <label for="search-country" class="block text-[11px] font-semibold tracking-[.18em] text-slate-500 uppercase mb-0.5">
                            TUJUAN
                        </label>
                        <div class="relative flex items-center">
                            <select id="search-country" 
                                    wire:model="selectedCountry" 
                                    class="w-full bg-transparent font-normal text-slate-900 text-[15px] sm:text-[16px] outline-none cursor-pointer appearance-none pr-7 py-0.5">
                                <option value="all">Semua Destinasi / Negara</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- 2. BULAN -->
                    <div class="flex-1 w-full sm:w-auto px-3 sm:px-6 py-1 border-t sm:border-t-0 border-slate-100 sm:border-r border-slate-200">
                        <label for="search-month" class="block text-[11px] font-semibold tracking-[.18em] text-slate-500 uppercase mb-0.5">
                            BULAN
                        </label>
                        <div class="relative flex items-center">
                            <select id="search-month" 
                                    wire:model="selectedMonth" 
                                    class="w-full bg-transparent font-normal text-slate-900 text-[15px] sm:text-[16px] outline-none cursor-pointer appearance-none pr-7 py-0.5">
                                <option value="all">Semua bulan</option>
                                @foreach($months as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- 3. TOMBOL CARI TOUR -->
                    <div class="w-full sm:w-auto pt-1 sm:pt-0 sm:pl-2">
                        <button type="button" 
                                wire:click="searchTours" 
                                class="w-full sm:w-auto inline-flex items-center justify-center bg-[#1B5A7A] hover:bg-[#12425B] text-white font-semibold text-[14px] sm:text-[15px] tracking-tight px-8 sm:px-10 py-3.5 sm:py-3.5 rounded-full transition-all duration-200 shadow-md hover:shadow-lg active:scale-95 cursor-pointer">
                            Cari Tour
                        </button>
                    </div>

                </div>
            </div>

            <!-- Reset Filter Active Indicator -->
            @if($selectedDestination !== 'all' || $selectedCountry !== 'all' || $selectedMonth !== 'all' || !empty($selectedMonths) || !empty($selectedYears) || $search !== '')
                <div class="flex justify-center pt-1">
                    <button type="button" 
                            wire:click="resetFilters" 
                            class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/90 backdrop-blur-md text-xs text-blue-700 hover:text-blue-900 font-semibold shadow-sm hover:scale-105 transition cursor-pointer">
                        🔄 Reset Filter (Kembali ke Semua)
                    </button>
                </div>
            @endif

            <!-- Dots Indicator Slider -->
            <div class="flex justify-center items-center gap-2 pt-1">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="currentSlide = index" 
                            type="button" 
                            :class="currentSlide === index ? 'w-8 bg-blue-500' : 'w-2.5 bg-white/60 hover:bg-white/90'" 
                            class="h-2.5 rounded-full transition-all duration-300 focus:outline-none shadow-sm"></button>
                </template>
            </div>

        </div>
    </section>

    <!-- KEUNGGULAN PERUSAHAAN (COMPANY ADVANTAGES - MODERN BENTO & INTERACTIVE SHOWCASE) -->
    <section id="why-us" class="reveal-group relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50/50 py-16 sm:py-20 lg:py-24 border-b border-slate-200/70 scroll-mt-20">
        <!-- Background Ambient Glow Accents -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
                
                <!-- SISI KIRI: MULTI-LAYER VISUAL SHOWCASE DENGAN FLOATING TRUST BADGES -->
                <div class="lg:col-span-5 relative reveal-item reveal-left">
                    <!-- Frame Foto Utama -->
                    <div class="relative rounded-[32px] overflow-hidden shadow-2xl shadow-blue-950/10 border-4 border-white bg-slate-100 aspect-[4/5] group">
                        <img src="https://images.unsplash.com/photo-1539635278303-d4002c07eae3?auto=format&fit=crop&w=1000&q=80" 
                             alt="Pengalaman Liburan Bersama Super Vacation" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
                    </div>

                    <!-- Floating Badge 1: Google Review Rating (Kiri Bawah) -->
                    <div class="absolute -bottom-6 -left-4 sm:left-4 bg-white/95 backdrop-blur-md rounded-2xl p-3 sm:p-4 shadow-xl shadow-slate-900/10 border border-slate-100 flex items-center gap-3 transform hover:-translate-y-1 transition duration-300 z-10">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 shadow-xs flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-1">
                                <span class="font-semibold text-slate-900 text-sm">5.0 / 5.0</span>
                                <span class="text-xs text-amber-500 font-semibold">★★★★★</span>
                            </div>
                            <p class="text-[11px] font-medium text-slate-500">Ulasan Google Review</p>
                        </div>
                    </div>

                    <!-- Floating Badge 2: Pasti Berangkat Guarantee (Kanan Atas) -->
                    <div class="absolute -top-4 -right-2 sm:right-4 bg-gradient-to-r from-blue-600 to-sky-500 text-white rounded-2xl px-4 py-2.5 shadow-lg shadow-blue-500/25 flex items-center gap-2.5 transform hover:scale-105 transition duration-300 z-10">
                        <span class="text-base">🛡️</span>
                        <div class="text-left">
                            <p class="text-xs font-semibold tracking-tight leading-none">100% GARANSI</p>
                            <p class="text-[10px] text-blue-100 font-medium leading-tight mt-0.5">Jadwal Pasti Berangkat</p>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN: KONTEN NARASI & 4 BENTO FEATURE CARDS -->
                <div class="lg:col-span-7 space-y-6 sm:space-y-7">
                    
                    <!-- Header Section -->
                    <div class="space-y-3 reveal-item reveal-up">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-slate-900 tracking-tight leading-[1.2]">
                            Wujudkan Liburan Impian dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-sky-600 to-blue-800">Pengalaman Terbaik</span>
                        </h2>
                        <p class="text-sm sm:text-[15px] text-slate-600 font-normal leading-relaxed text-justify sm:text-left pt-1">
                            Super Vacation hadir dengan tim profesional yang telah berpengalaman di industri perjalanan. Kami percaya bahwa perjalanan luar negeri tidak harus terasa rumit atau sulit dijangkau. Dengan pelayanan yang ramah, proses yang mudah, dan pilihan paket yang bernilai, kami siap membantu Anda mewujudkan perjalanan impian dengan penuh percaya diri.
                        </p>
                    </div>

                    <!-- 4 Bento Feature Cards (Grid 2x2 Interaktif) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 pt-1">
                        
                        <!-- 1. EXPERIENCED TEAM -->
                        <div class="reveal-item reveal-up group p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 hover:-translate-y-1 transition-all duration-300" style="transition-delay: 100ms">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-blue-600/80 bg-blue-50 px-2 py-0.5 rounded-md">
                                    01 / EXPERT
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-[15px] font-semibold text-slate-900 group-hover:text-blue-600 transition-colors">
                                EXPERIENCED TEAM
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed mt-1 font-medium">
                                Didukung oleh tim yang telah berpengalaman dalam menangani berbagai perjalanan domestik maupun internasional.
                            </p>
                        </div>

                        <!-- 2. BEST VALUE TRIP -->
                        <div class="reveal-item reveal-up group p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300" style="transition-delay: 200ms">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-emerald-600/80 bg-emerald-50 px-2 py-0.5 rounded-md">
                                    02 / VALUE
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-[15px] font-semibold text-slate-900 group-hover:text-emerald-600 transition-colors">
                                BEST VALUE TRIP
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed mt-1 font-medium">
                                Menghadirkan paket perjalanan dengan harga kompetitif tanpa mengurangi kualitas pelayanan dan pengalaman perjalanan.
                            </p>
                        </div>

                        <!-- 3. DESTINATION MADE ACCESSIBLE -->
                        <div class="reveal-item reveal-up group p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-sky-300 hover:-translate-y-1 transition-all duration-300" style="transition-delay: 300ms">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 012 2v2.945M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-sky-600/80 bg-sky-50 px-2 py-0.5 rounded-md">
                                    03 / ACCESSIBLE
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-[15px] font-semibold text-slate-900 group-hover:text-sky-600 transition-colors">
                                DESTINATION MADE ACCESSIBLE
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed mt-1 font-medium">
                                Kami membantu lebih banyak orang mewujudkan impian mengunjungi destinasi favorit dengan proses yang mudah dan nyaman.
                            </p>
                        </div>

                        <!-- 4. CUSTOMER CENTERED SERVICE -->
                        <div class="reveal-item reveal-up group p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-amber-300 hover:-translate-y-1 transition-all duration-300" style="transition-delay: 400ms">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-amber-600/80 bg-amber-50 px-2 py-0.5 rounded-md">
                                    04 / SERVICE
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-[15px] font-semibold text-slate-900 group-hover:text-amber-600 transition-colors">
                                CUSTOMER CENTERED SERVICE
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed mt-1 font-medium">
                                Memberikan pelayanan yang responsif, transparan, dan selalu siap mendampingi pelanggan sebelum, selama, hingga setelah perjalanan.
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 4. SECTION PAKET WISATA (LIVEWIRE FILTER & SEARCH) -->
    <section id="tours" class="reveal-group py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header & Filter Toolbar -->
            <div class="mb-12 space-y-6">
                <div class="text-center max-w-3xl mx-auto reveal-item reveal-up">
                    <p class="mb-2 text-[12px] font-semibold tracking-[.12em] text-[#1B5A7A] uppercase">Tour pilihan kami</p>
                    <h2 class="font-display text-[32px] leading-[1.15] font-semibold tracking-[-.025em] text-balance lg:text-[44px]">Tour yang pasti berangkat</h2>
                    <p class="mt-3 max-w-xl mx-auto text-[15px] leading-[1.7] font-normal text-[#525B6B]">Jelajahi berbagai destinasi impian anda</p>
                </div>

                <!-- Search & Multi-Select Array Filter Controls Container -->
                <div x-data="{ mobileFilterOpen: false }" wire:ignore.self class="reveal-item reveal-fade bg-slate-50 border border-slate-200/90 rounded-3xl p-4 sm:p-6 shadow-sm space-y-4" style="transition-delay: 150ms">
                    
                    <!-- Mobile Filter Toggle Bar (Visible only on mobile < sm) -->
                    <div class="sm:hidden">
                        <button type="button" 
                                @click="mobileFilterOpen = !mobileFilterOpen"
                                class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 shadow-xs active:scale-98 transition">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#1B5A7A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                <span>Filter & Pencarian Tour</span>
                                @if($search !== '' || $selectedCountry !== 'all' || !empty($selectedMonths) || !empty($selectedYears))
                                    <span class="bg-[#1B5A7A] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                        Filter Aktif
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-1 text-slate-500 text-[11px] font-medium">
                                <span x-text="mobileFilterOpen ? 'Sembunyikan' : 'Tampilkan'"></span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': mobileFilterOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                    </div>

                    <!-- 4 Column Filter Grid (Hidden on mobile by default, always visible on sm+) -->
                    <div :class="mobileFilterOpen ? 'block' : 'hidden sm:block'" class="transition-all duration-300">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- 1. Searching Input -->
                            <div class="relative">
                                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Pencarian Tour</label>
                                <div class="relative">
                                    <input type="text" 
                                           wire:model.live.debounce.300ms="search" 
                                           placeholder="Cari tour / destinasi..." 
                                           class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] focus:border-transparent transition" />
                                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- 2. Filter Destinasi (Negara) -->
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Destinasi / Negara</label>
                                <select wire:model.live="selectedCountry" 
                                        class="w-full px-3.5 py-2.5 rounded-2xl bg-white border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] focus:border-transparent transition cursor-pointer">
                                    <option value="all">Semua Destinasi / Negara</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 3. Bulan Pemberangkatan (Multi-Select Dropdown Popover) -->
                            <div class="relative" x-data="{ open: false }" @click.outside="open = false" wire:ignore.self>
                                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Bulan Pemberangkatan</label>
                                <button type="button" 
                                        @click="open = !open" 
                                        class="w-full px-3.5 py-2.5 rounded-2xl bg-white border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] transition flex items-center justify-between gap-2 shadow-xs cursor-pointer">
                                    <span class="truncate">
                                        @if(empty($selectedMonths))
                                            Semua Bulan
                                        @else
                                            {{ count($selectedMonths) }} Bulan Terpilih
                                        @endif
                                    </span>
                                    <svg class="w-4 h-4 text-slate-400 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu Popover -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute z-50 mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl p-3 space-y-2 left-0 sm:right-0 sm:left-auto"
                                     style="display: none;">
                                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pilih Bulan</span>
                                        @if(!empty($selectedMonths))
                                            <button type="button" wire:click="$set('selectedMonths', [])" class="text-[11px] font-semibold text-rose-500 hover:underline">Reset</button>
                                        @endif
                                    </div>
                                    <div class="max-h-56 overflow-y-auto space-y-1 custom-scrollbar pr-1">
                                        @foreach($monthsList as $mNum => $mName)
                                            <label wire:key="month-opt-{{ $mNum }}" class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-xl hover:bg-slate-50 cursor-pointer text-xs font-medium text-slate-700 select-none transition">
                                                <input type="checkbox" 
                                                       value="{{ $mNum }}" 
                                                       wire:model.live="selectedMonths" 
                                                       class="rounded border-slate-300 text-[#1B5A7A] focus:ring-[#1B5A7A] w-4 h-4" />
                                                <span>{{ $mName }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Tahun Pemberangkatan (Multi-Select Dropdown Popover) -->
                            <div class="relative" x-data="{ open: false }" @click.outside="open = false" wire:ignore.self>
                                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Tahun Pemberangkatan</label>
                                <button type="button" 
                                        @click="open = !open" 
                                        class="w-full px-3.5 py-2.5 rounded-2xl bg-white border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] transition flex items-center justify-between gap-2 shadow-xs cursor-pointer">
                                    <span class="truncate">
                                        @if(empty($selectedYears))
                                            Semua Tahun
                                        @else
                                            {{ implode(', ', $selectedYears) }}
                                        @endif
                                    </span>
                                    <svg class="w-4 h-4 text-slate-400 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu Popover -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute z-50 mt-2 w-52 bg-white border border-slate-200 rounded-2xl shadow-xl p-3 space-y-2 right-0"
                                     style="display: none;">
                                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pilih Tahun</span>
                                        @if(!empty($selectedYears))
                                            <button type="button" wire:click="$set('selectedYears', [])" class="text-[11px] font-semibold text-rose-500 hover:underline">Reset</button>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        @foreach($yearsList as $yVal)
                                            <label wire:key="year-opt-{{ $yVal }}" class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-xl hover:bg-slate-50 cursor-pointer text-xs font-medium text-slate-700 select-none transition">
                                                <input type="checkbox" 
                                                       value="{{ $yVal }}" 
                                                       wire:model.live="selectedYears" 
                                                       class="rounded border-slate-300 text-[#1B5A7A] focus:ring-[#1B5A7A] w-4 h-4" />
                                                <span>Tahun {{ $yVal }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Active Filter Bar & Reset Button -->
                    @if($search !== '' || $selectedCountry !== 'all' || !empty($selectedMonths) || !empty($selectedYears))
                        <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-medium">
                            <span class="text-slate-600">
                                Menampilkan hasil filter paket tour (Total: <strong class="text-[#1B5A7A] font-extrabold">{{ $totalToursCount }}</strong>)
                            </span>
                            <button type="button" 
                                    wire:click="resetFilters" 
                                    class="text-rose-600 hover:text-rose-700 font-bold flex items-center gap-1 underline cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reset Semua Filter
                            </button>
                        </div>
                    @endif

                </div>
            </div>

            @php
                $parsePrice = function($amount) {
                    if (!$amount) return ['num' => '0', 'unit' => 'Rp / pax'];
                    if ($amount >= 1000000) {
                        $val = $amount / 1000000;
                        $formatted = number_format($val, (floor($val) == $val) ? 0 : 1, ',', '.');
                        return ['num' => $formatted, 'unit' => 'Juta / pax'];
                    } elseif ($amount >= 1000) {
                        $val = $amount / 1000;
                        $formatted = number_format($val, (floor($val) == $val) ? 0 : 1, ',', '.');
                        return ['num' => $formatted, 'unit' => 'Ribu / pax'];
                    }
                    return ['num' => number_format($amount, 0, ',', '.'), 'unit' => 'Rp / pax'];
                };
            @endphp

            <!-- Tour Cards Grid (Poster Reference Layout) -->
            @if($tours->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($tours as $tour)
                        @php
                            $currentPrice = ($tour->promo_price && $tour->promo_price < $tour->price) ? $tour->promo_price : $tour->price;
                            $priceData = $parsePrice($currentPrice);
                            $oldPriceData = ($tour->promo_price && $tour->promo_price < $tour->price) ? $parsePrice($tour->price) : null;
                        @endphp

                        <div onclick="window.location.href='/tour/{{ $tour->slug }}'" 
                             class="reveal-item reveal-up group bg-white rounded-3xl border border-slate-200/90 shadow-md hover:shadow-2xl hover:shadow-sky-950/15 hover:border-sky-300 transition-all duration-300 flex flex-col overflow-hidden relative cursor-pointer"
                             style="transition-delay: {{ ($loop->index % 6) * 80 }}ms"
                             x-data="{ copied: false }">
                            
                            @if($tour->status === 'penuh')
                                <!-- Sold Out / Penuh Translucent Gray Overlay Layer -->
                                <div class="absolute inset-0 bg-slate-900/40 backdrop-grayscale z-30 pointer-events-none rounded-3xl flex items-center justify-center">
                                    <span class="px-5 py-2.5 rounded-2xl bg-rose-600/95 text-white font-black text-sm tracking-widest uppercase shadow-2xl border-2 border-white/40 transform -rotate-3">
                                        KUOTA PENUH
                                    </span>
                                </div>
                            @endif
                            
                            <!-- 1. Top Season / Header Banner -->
                            <div class="bg-[#E6F0F8] border-b border-sky-100 py-2.5 px-4 text-center font-semibold text-xs sm:text-sm tracking-wider uppercase text-[#1B5A7A] flex items-center justify-center gap-2">
                                <span>{{ $tour->season ? strtoupper($tour->season) . ' SEASON' : 'SUPER VACATION TOUR' }}</span>
                            </div>

                            <!-- 2. Main Image Container -->
                            <div class="relative h-60 sm:h-64 overflow-hidden bg-slate-100">
                                @if($tour->thumbnail)
                                    <img src="{{ asset('storage/' . $tour->thumbnail) }}" 
                                         alt="{{ $tour->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                                @else
                                    <!-- Empty Placeholder State -->
                                    <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center p-6 text-slate-400 group-hover:scale-105 transition-transform duration-700 ease-out">
                                        <svg class="w-10 h-10 mb-2 text-slate-300 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-[11px] font-semibold text-slate-400 tracking-wider uppercase">Foto Belum Tersedia</span>
                                    </div>
                                @endif

                                <!-- Top Left Badges: Duration & Status -->
                                <div class="absolute top-3 left-3 flex flex-col gap-1.5 items-start z-10">
                                    <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[11px] font-semibold text-slate-800 shadow-sm border border-white/60 flex items-center gap-1">
                                        ⏱️ {{ $tour->duration }}
                                    </span>
                                    @if($tour->status === 'penuh')
                                        <span class="px-2.5 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-semibold uppercase tracking-wider shadow-sm">
                                            Penuh
                                        </span>
                                    @endif
                                </div>

                                <!-- Top Right Floating Quick Actions (Share, Download, WA) -->
                                <div class="absolute top-3 right-3 flex items-center gap-1.5 p-1 rounded-2xl bg-slate-900/60 backdrop-blur-md border border-white/20 shadow-md z-20">
                                    <!-- Share Button -->
                                    <button type="button" 
                                            @click.stop="
                                                if (navigator.share) {
                                                    navigator.share({ title: '{{ $tour->title }}', url: '{{ url('/tour/'.$tour->slug) }}' });
                                                } else {
                                                    navigator.clipboard.writeText('{{ url('/tour/'.$tour->slug) }}');
                                                    copied = true;
                                                    setTimeout(() => copied = false, 2000);
                                                }
                                            "
                                            class="relative p-1.5 rounded-xl hover:bg-white/20 text-white transition cursor-pointer"
                                            title="Bagikan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                        <span x-show="copied" x-cloak class="absolute -top-8 right-0 px-2 py-0.5 bg-slate-900 text-white text-[10px] font-medium rounded-md shadow-lg whitespace-nowrap z-30">Tersalin!</span>
                                    </button>

                                    <!-- Download Itinerary -->
                                    @if($tour->file_itinerary)
                                        <button type="button" 
                                                @click.stop="window.open('{{ asset('storage/' . $tour->file_itinerary) }}', '_blank')" 
                                                class="p-1.5 rounded-xl hover:bg-white/20 text-sky-200 transition cursor-pointer"
                                                title="Unduh Itinerary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </button>
                                    @else
                                        <button type="button" 
                                                @click.stop="window.open('https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode('Halo Super Vacation, boleh minta informasi itinerary lengkap untuk paket tour: ' . $tour->title) }}', '_blank')" 
                                                class="p-1.5 rounded-xl hover:bg-white/20 text-slate-300 transition cursor-pointer"
                                                title="Minta Itinerary via WA">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Chat WhatsApp -->
                                    <button type="button" 
                                            @click.stop="window.open('https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode('Halo Super Vacation, saya berminat dengan paket tour: ' . $tour->title) }}', '_blank')" 
                                            class="p-1.5 rounded-xl hover:bg-emerald-500/30 text-emerald-400 transition cursor-pointer"
                                            title="Chat WA">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Bottom Right Promo Oval Badge (Exact like reference image) -->
                                @if($tour->promo_price && $tour->promo_price < $tour->price)
                                    <div class="absolute bottom-3 right-3 z-10">
                                        <span class="px-4 py-1.5 rounded-full bg-[#0055D4] text-white font-semibold text-xs sm:text-sm tracking-wide shadow-lg border border-white/20">
                                            Promo
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- 3. Middle Section: Title & Date (Yellow/Amber Banner - Flex 1 to eliminate white gap) -->
                            <div class="bg-[#FA9E0B] p-4 text-center space-y-1.5 flex-1 flex flex-col justify-center items-center">
                                <h3 class="font-semibold text-white text-base sm:text-lg uppercase tracking-wide leading-tight line-clamp-2">
                                    {{ $tour->title }}
                                </h3>

                                @if($tour->start_date)
                                    <div class="text-[#0F355C] font-semibold text-xs sm:text-sm tracking-wider flex items-center justify-center gap-1 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-[#0F355C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $tour->start_date->format('d M Y') }}@if($tour->end_date) – {{ $tour->end_date->format('d M Y') }}@endif</span>
                                    </div>
                                @endif
                            </div>

                            <!-- 4. Bottom Section: Route Highlights & Big Price (Dark Blue Banner) -->
                            <div class="bg-[#1B5A7A] p-4 text-white flex items-center justify-between gap-3 shrink-0">
                                <!-- Left Column: Destination / Route -->
                                <div class="flex-1 min-w-0 flex flex-col justify-center min-h-[2.5rem]">
                                    <span class="text-[10px] uppercase font-semibold text-sky-200 tracking-wider block">Destinasi</span>
                                    <p class="font-semibold text-xs sm:text-sm text-white line-clamp-2 uppercase leading-tight mt-0.5">
                                        {{ $tour->destination }}
                                    </p>
                                </div>

                                <!-- Vertical Divider -->
                                <div class="border-l border-white/25 h-10 shrink-0"></div>

                                <!-- Right Column: Pricing Display -->
                                <div class="text-right shrink-0 flex flex-col justify-center">
                                    @if($oldPriceData)
                                        <span class="text-[11px] text-white/70 line-through font-semibold block leading-none mb-0.5">
                                            {{ $oldPriceData['num'] }} {{ $oldPriceData['unit'] }}
                                        </span>
                                    @endif
                                    <div class="text-2xl sm:text-3xl font-black text-white leading-none tracking-tight">
                                        {{ $priceData['num'] }}
                                    </div>
                                    <span class="text-[10px] font-semibold text-sky-100 uppercase tracking-wider block mt-1">
                                        {{ $priceData['unit'] }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Button Lihat Semua Tour Halaman Tour Schedule -->
                <div class="mt-12 text-center reveal-item reveal-up" style="transition-delay: 200ms">
                    <a href="{{ route('tour-schedule') }}" 
                       wire:navigate 
                       class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-[#1B5A7A] hover:bg-[#13425a] text-white text-sm font-normal shadow-lg hover:shadow-xl transition-all active:scale-95 cursor-pointer">
                        <span>Lihat Semua Jadwal Tour ({{ $totalToursCount }} Paket)</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-20 bg-slate-50 rounded-3xl border border-slate-200 space-y-3 reveal-item reveal-fade">
                    <p class="text-slate-600 text-sm">Tidak ada paket wisata yang sesuai dengan pencarian atau filter Anda.</p>
                    <button type="button" wire:click="resetFilters" class="text-xs text-blue-600 font-semibold underline cursor-pointer">Reset Semua Filter</button>
                </div>
            @endif

        </div>
    </section>
    <!-- 6. SECTION TESTIMONI (AVENIR TRAVEL STYLE: 3 DATA PER TAMPILAN & BISA DIGESER) -->
    <section id="testimonials" 
             x-data="{
                isDown: false,
                startX: 0,
                scrollLeft: 0,
                canScrollLeft: false,
                canScrollRight: true,
                init() {
                    this.$nextTick(() => this.updateScrollState());
                },
                updateScrollState() {
                    const el = this.$refs.testimonialSlider;
                    if (!el) return;
                    this.canScrollLeft = el.scrollLeft > 10;
                    this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 15);
                },
                scrollNext() {
                    const el = this.$refs.testimonialSlider;
                    const card = el.querySelector('.snap-start');
                    const scrollAmount = card ? card.offsetWidth + 32 : 380;
                    el.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    setTimeout(() => this.updateScrollState(), 350);
                },
                scrollPrev() {
                    const el = this.$refs.testimonialSlider;
                    const card = el.querySelector('.snap-start');
                    const scrollAmount = card ? card.offsetWidth + 32 : 380;
                    el.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                    setTimeout(() => this.updateScrollState(), 350);
                },
                startDrag(e) {
                    this.isDown = true;
                    this.startX = (e.pageX || (e.touches && e.touches[0].pageX)) - this.$refs.testimonialSlider.offsetLeft;
                    this.scrollLeft = this.$refs.testimonialSlider.scrollLeft;
                },
                stopDrag() {
                    this.isDown = false;
                    this.updateScrollState();
                },
                onDrag(e) {
                    if (!this.isDown) return;
                    e.preventDefault();
                    const x = (e.pageX || (e.touches && e.touches[0].pageX)) - this.$refs.testimonialSlider.offsetLeft;
                    const walk = (x - this.startX) * 1.3;
                    this.$refs.testimonialSlider.scrollLeft = this.scrollLeft - walk;
                    this.updateScrollState();
                }
             }"
             class="reveal-group py-20 sm:py-28 bg-white border-t border-slate-100 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Centered Minimalist Header -->
            <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-18 reveal-item reveal-up">
                <span class="text-xs font-bold tracking-[0.25em] text-[#1B5A7A] uppercase block mb-3.5">
                    TESTIMONIALS
                </span>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-semibold text-slate-900 tracking-tight leading-[1.12] max-w-xl mx-auto font-display">
                    Cerita dari yang<br>sudah pulang
                </h2>
            </div>

            @if($testimonials->count() > 0)
                <!-- Horizontal Slider with Exactly 3 Items Per View on Desktop -->
                <div class="relative reveal-item reveal-up" style="transition-delay: 150ms">
                    
                    <div x-ref="testimonialSlider" 
                         @scroll.debounce.50ms="updateScrollState()"
                         @mousedown="startDrag($event)"
                         @mouseleave="stopDrag()"
                         @mouseup="stopDrag()"
                         @mousemove="onDrag($event)"
                         class="flex gap-8 overflow-x-auto snap-x snap-mandatory scroll-smooth [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden pb-4 pt-2 -mx-4 px-4 sm:mx-0 sm:px-0 cursor-grab active:cursor-grabbing">
                        @foreach($testimonials as $testimonial)
                            <div class="snap-start shrink-0 w-[85%] sm:w-[calc((100%-32px)/2)] lg:w-[calc((100%-64px)/3)] border-t border-slate-200/90 pt-8 sm:pt-10 flex flex-col justify-between group select-none">
                                
                                <!-- Star Rating & Review Quote -->
                                <div>
                                    <!-- Orange Star Rating (5 Stars) -->
                                    <div class="flex items-center gap-1 text-[#E85D04] text-xs sm:text-sm mb-4">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($testimonial->rating ?? 5))
                                                <span>★</span>
                                            @else
                                                <span class="text-slate-200">★</span>
                                            @endif
                                        @endfor
                                    </div>

                                    <!-- Review Text in Clean Quotes -->
                                    <blockquote class="text-[13.5px] sm:text-[14.5px] text-slate-700 leading-relaxed font-normal mb-8">
                                        &ldquo;{{ $testimonial->story ?? $testimonial->title }}&rdquo;
                                    </blockquote>
                                </div>

                                <!-- Traveler Avatar & Info Footer -->
                                <div class="flex items-center gap-3 pt-2 mt-auto">
                                    <!-- Round Avatar / Initial Badge -->
                                    @php
                                        $colors = [
                                            ['bg' => '#EDE9FE', 'text' => '#6D28D9'], // Purple
                                            ['bg' => '#E0F2FE', 'text' => '#0369A1'], // Sky
                                            ['bg' => '#E0E7FF', 'text' => '#4338CA'], // Indigo
                                            ['bg' => '#FEF3C7', 'text' => '#B45309'], // Amber
                                            ['bg' => '#DCFCE7', 'text' => '#15803D'], // Green
                                            ['bg' => '#FCE7F3', 'text' => '#BE185D'], // Pink
                                        ];
                                        $palette = $colors[$loop->index % count($colors)];
                                        
                                        $nameParts = explode(' ', trim($testimonial->name ?? 'User'));
                                        $initials = '';
                                        foreach(array_slice($nameParts, 0, 2) as $p) {
                                            $initials .= strtoupper(substr($p, 0, 1));
                                        }
                                    @endphp

                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs shrink-0 overflow-hidden shadow-2xs"
                                         style="background-color: {{ $palette['bg'] }}; color: {{ $palette['text'] }};">
                                        @if($testimonial->avatar)
                                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover rounded-full" />
                                        @else
                                            <span>{{ $initials ?: 'U' }}</span>
                                        @endif
                                    </div>

                                    <!-- Name & Source Subtitle -->
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 leading-tight truncate">
                                            {{ $testimonial->name ?? 'Traveler Super Vacation' }}
                                        </h4>
                                        <p class="text-[10px] sm:text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5 truncate">
                                            {{ $testimonial->trip_date ? strtoupper($testimonial->trip_date) . ' · ' : '' }}ULASAN GOOGLE
                                        </p>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <!-- Clean Slider Controls (Centered Below) -->
                    @if($testimonials->count() > 3)
                        <div class="flex items-center justify-center gap-3 mt-10 reveal-item reveal-fade" style="transition-delay: 250ms">
                            <button @click="scrollPrev()" 
                                    type="button" 
                                    title="Geser Kiri"
                                    class="w-10 h-10 rounded-full bg-slate-50 hover:bg-[#1B5A7A] hover:text-white text-slate-700 border border-slate-200 flex items-center justify-center transition-all duration-200 shadow-2xs focus:outline-none active:scale-95 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="scrollNext()" 
                                    type="button" 
                                    title="Geser Kanan"
                                    class="w-10 h-10 rounded-full bg-slate-50 hover:bg-[#1B5A7A] hover:text-white text-slate-700 border border-slate-200 flex items-center justify-center transition-all duration-200 shadow-2xs focus:outline-none active:scale-95 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    @endif

                </div>
            @else
                <div class="text-center py-16 bg-slate-50 rounded-3xl border border-slate-100 reveal-item reveal-fade">
                    <p class="text-slate-500 text-sm">Belum ada ulasan yang ditampilkan saat ini.</p>
                </div>
            @endif

        </div>
    </section>

    <!-- 3. SECTION ARTIKEL & EDUKASI WISATA -->
    <section id="articles" class="reveal-group py-20 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 reveal-item reveal-up">
                <div class="space-y-2 max-w-2xl">
                    <p class="text-[12px] font-semibold tracking-[.12em] text-[#1B5A7A] uppercase">Artikel & Edukasi</p>
                    <h2 class="font-display text-3xl sm:text-4xl font-semibold tracking-[-.025em] text-slate-900">
                        Wawasan & Tips Liburan
                    </h2>
                    <p class="text-sm text-[#525B6B] leading-relaxed">
                        Temukan info visa terbaru, tips persiapan tour, dan panduan perjalanan terlengkap dari tim ahli kami.
                    </p>
                </div>

                <a href="{{ route('articles.index') }}" 
                   wire:navigate 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white border border-slate-200 text-xs font-bold text-[#1B5A7A] shadow-xs hover:bg-[#1B5A7A] hover:text-white transition-all cursor-pointer shrink-0">
                    <span>Lihat Semua Artikel</span>
                    <span>➔</span>
                </a>
            </div>

            <!-- Articles Cards Grid -->
            @if(isset($articles) && $articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($articles as $article)
                        <article onclick="window.location.href='/article/{{ $article->slug }}'" 
                                 class="reveal-item reveal-up group bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:shadow-sky-950/10 hover:border-sky-300 transition-all duration-300 flex flex-col overflow-hidden cursor-pointer"
                                 style="transition-delay: {{ ($loop->index % 3) * 120 + 100 }}ms">
                            
                            <!-- Thumbnail Image Container -->
                            <div class="relative h-48 overflow-hidden bg-slate-100">
                                @if($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                                         alt="{{ $article->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-sky-500 to-[#1B5A7A] flex flex-col items-center justify-center p-6 text-white group-hover:scale-105 transition-transform duration-700 ease-out">
                                        <svg class="w-10 h-10 mb-1.5 text-sky-200/80 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <span class="text-[11px] font-semibold tracking-wider uppercase text-sky-100">Travel Guide</span>
                                    </div>
                                @endif

                                <!-- Category Badge -->
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-[11px] font-bold text-[#1B5A7A] shadow-sm border border-white/60">
                                        {{ $article->category }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content Area -->
                            <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2.5 text-[11px] font-semibold text-slate-400">
                                        <span>📅 {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span>⏱️ {{ $article->reading_time }}</span>
                                    </div>

                                    <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-[#1B5A7A] transition-colors line-clamp-2">
                                        {{ $article->title }}
                                    </h3>

                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                                        {{ $article->excerpt }}
                                    </p>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                    <span class="font-semibold text-slate-600">{{ $article->author }}</span>
                                    <span class="font-bold text-[#1B5A7A] group-hover:translate-x-1 transition-transform flex items-center gap-1">
                                        Baca ➔
                                    </span>
                                </div>
                            </div>

                        </article>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <!-- 7. SECTION CONSULTATION CTA (CLEAN PROFESSIONAL STYLE) -->
    <section class="reveal-group py-20 sm:py-24 bg-white border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-item reveal-up">
            
            <!-- Category Tag -->
            <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-[#1b5a7a] mb-6">
                MASIH BINGUNG PILIH TOUR?
            </p>

            <!-- Main Headline -->
            <h2 class="font-display mb-7 text-[28px] leading-[1.12] font-semibold tracking-[-.025em] text-balance lg:text-[40px]">
                Ceritakan rencana perjalananmu.<br class="hidden sm:inline" /> Kami bantu pilihkan
            </h2>

            <!-- Subtitle Description -->
            <p class="mb-10 text-[15px] leading-[1.7] text-[#525B6B] lg:text-[18px]">
                Sampaikan destinasi yang diminati, waktu keberangkatan, durasi, dan kisaran budget. Tour Consultant kami akan membantu mencarikan pilihan yang paling sesuai.
            </p>

            <!-- Buttons Group -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 sm:gap-4">
                <!-- WhatsApp Button -->
                <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20konsultasi%20rencana%20perjalanan%20saya" 
                   target="_blank" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-full bg-[#1b5a7a] hover:bg-[#13425a] text-white font-medium text-sm transition-all duration-200 shadow-sm hover:shadow active:scale-95">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Konsultasi gratis via WhatsApp</span>
                </a>
            </div>

            <!-- Footer Small Note -->
            <p class="text-xs text-slate-400 mt-6 font-normal">
                Dibantu langsung oleh Tour Consultant kami.
            </p>

        </div>
    </section>

    <!-- JAVASCRIPT SCROLL INTERSECTION OBSERVER -->
    <script>
        (function() {
            function setupScrollAnimations() {
                if (!('IntersectionObserver' in window)) {
                    document.querySelectorAll('.reveal-item, .reveal-group').forEach(el => el.classList.add('is-revealed'));
                    return;
                }

                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -40px 0px'
                });

                document.querySelectorAll('.reveal-item, .reveal-group').forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight * 0.95 && rect.bottom > 0) {
                        el.classList.add('is-revealed');
                    } else {
                        observer.observe(el);
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupScrollAnimations);
            } else {
                setupScrollAnimations();
            }

            document.addEventListener('livewire:navigated', () => {
                setTimeout(setupScrollAnimations, 60);
            });

            document.addEventListener('livewire:initialized', () => {
                if (typeof Livewire !== 'undefined' && Livewire.hook) {
                    Livewire.hook('commit', ({ succeed }) => {
                        succeed(() => {
                            setTimeout(setupScrollAnimations, 50);
                        });
                    });
                }
            });
        })();
    </script>
</div>
