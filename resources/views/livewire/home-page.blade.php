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
            <div class="w-full max-w-3xl mx-auto bg-white rounded-[28px] sm:rounded-full border border-slate-200/90 shadow-2xl p-3 sm:p-2 sm:pl-8 text-left transition-all">
                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-0">
                    
                    <!-- 1. TUJUAN -->
                    <div class="flex-1 w-full sm:w-auto px-3 sm:px-4 py-1 sm:border-r border-slate-200">
                        <label for="search-destination" class="block text-[11px] font-semibold tracking-[.18em] text-slate-500 uppercase mb-0.5">
                            TUJUAN
                        </label>
                        <div class="relative flex items-center">
                            <select id="search-destination" 
                                    wire:model.live="selectedDestination" 
                                    class="w-full bg-transparent font-normal text-slate-900 text-[15px] sm:text-[16px] outline-none cursor-pointer appearance-none pr-7 py-0.5">
                                <option value="all">Semua destinasi</option>
                                @foreach($destinations as $dest)
                                    <option value="{{ $dest }}">{{ $dest }}</option>
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
                                    wire:model.live="selectedMonth" 
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
                        <a href="#tours" 
                           class="w-full sm:w-auto inline-flex items-center justify-center bg-[#1B5A7A] hover:bg-[#12425B] text-white font-semibold text-[14px] sm:text-[15px] tracking-tight px-8 sm:px-10 py-3.5 sm:py-3.5 rounded-full transition-all duration-200 shadow-md hover:shadow-lg active:scale-95">
                            Cari Tour
                        </a>
                    </div>

                </div>
            </div>

            <!-- Reset Filter Active Indicator -->
            @if($selectedDestination !== 'all' || $selectedMonth !== 'all' || $search !== '')
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
    <section id="why-us" class="relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50/50 py-16 sm:py-20 lg:py-24 border-b border-slate-200/70 scroll-mt-20">
        <!-- Background Ambient Glow Accents -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
                
                <!-- SISI KIRI: MULTI-LAYER VISUAL SHOWCASE DENGAN FLOATING TRUST BADGES -->
                <div class="lg:col-span-5 relative">
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
                    <div class="space-y-3">
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
                        <div class="group p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-blue-300 hover:-translate-y-1 transition-all duration-300">
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
                        <div class="group p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300">
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
                        <div class="group p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-sky-300 hover:-translate-y-1 transition-all duration-300">
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
                        <div class="group p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:shadow-md hover:border-amber-300 hover:-translate-y-1 transition-all duration-300">
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
       <!-- 6. SECTION TESTIMONI & DOKUMENTASI (HORIZONTAL CAROUSEL SLIDER) -->
    <section id="testimonials" 
             x-data="{
                scrollNext() {
                    $refs.testimonialContainer.scrollBy({ left: 340, behavior: 'smooth' });
                },
                scrollPrev() {
                    $refs.testimonialContainer.scrollBy({ left: -340, behavior: 'smooth' });
                }
             }"
             class="py-20 bg-white border-t border-slate-200 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header & Nav Buttons -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-200">Dokumentasi</span>
                    <h2 class="text-3xl sm:text-4xl font-semibold text-slate-900 mt-2">Keseruan Wisatawan TravelGo</h2>
                    <p class="text-slate-600 text-sm mt-1">Lihat video testimoni dan momen bahagia para traveler di setiap destinasi.</p>
                </div>

                <!-- Tombol Navigasi Slider Kiri & Kanan -->
                <div class="flex items-center gap-3">
                    <button @click="scrollPrev()" 
                            type="button" 
                            title="Geser Kiri"
                            class="w-11 h-11 rounded-full bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 flex items-center justify-center transition shadow-sm focus:outline-none active:scale-95">
                        ❮
                    </button>
                    <button @click="scrollNext()" 
                            type="button" 
                            title="Geser Kanan"
                            class="w-11 h-11 rounded-full bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 flex items-center justify-center transition shadow-sm focus:outline-none active:scale-95">
                        ❯
                    </button>
                </div>
            </div>

            @if($testimonials->count() > 0)
                <!-- Container Carousel Horizontal (Geser Samping) -->
                <div x-ref="testimonialContainer" 
                     class="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-none pb-6 pt-2 -mx-4 px-4 sm:mx-0 sm:px-0">
                    @foreach($testimonials as $testimonial)
                        <div class="snap-start shrink-0 w-[290px] sm:w-[330px] bg-slate-50 border border-slate-200 rounded-3xl p-4 flex flex-col justify-between shadow-sm hover:shadow-md transition duration-300">
                            <div class="mb-3 flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-slate-900 line-clamp-1">{{ $testimonial->title }}</h4>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase shrink-0 {{ $testimonial->platform === 'youtube_short' ? 'bg-red-100 text-red-600 border border-red-200' : 'bg-pink-100 text-pink-600 border border-pink-200' }}">
                                    {{ $testimonial->platform === 'youtube_short' ? 'YouTube' : 'Instagram' }}
                                </span>
                            </div>

                            <!-- Responsive Vertical Video Embed -->
                            <div class="relative w-full rounded-2xl overflow-hidden bg-slate-900 border border-slate-200" style="aspect-ratio: 9/16; max-height: 480px;">
                                @if($testimonial->platform === 'youtube_short')
                                    @php
                                        $embedUrl = $testimonial->embed_url;
                                        if (str_contains($embedUrl, 'shorts/')) {
                                            $videoId = explode('shorts/', $embedUrl)[1];
                                            $videoId = explode('?', $videoId)[0];
                                            $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                                        }
                                    @endphp
                                    <iframe class="w-full h-full" src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                                @else
                                    @php
                                        $igUrl = rtrim($testimonial->embed_url, '/');
                                        if (!str_contains($igUrl, '/embed')) {
                                            $igUrl .= '/embed';
                                        }
                                    @endphp
                                    <iframe class="w-full h-full" src="{{ $igUrl }}" frameborder="0" scrolling="no"></iframe>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-slate-50 rounded-3xl border border-slate-200">
                    <p class="text-slate-600 text-sm">Belum ada video testimoni aktif saat ini.</p>
                </div>
            @endif

        </div>
    </section>

    <!-- 2. SECTION VALUE PROPOSITION (MENGAPA MEMILIH KAMI) -->
    <!-- <section class="py-16 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-3xl space-y-3 hover:border-blue-500 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl font-semibold">
                        💎
                    </div>
                    <h3 class="text-base font-semibold text-slate-900">Harga Transparan</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Tanpa biaya tersembunyi! Semua rincian fasilitas include & exclude tertera jelas sebelum pemesanan.
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-3xl space-y-3 hover:border-blue-500 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-semibold">
                        👨‍✈️
                    </div>
                    <h3 class="text-base font-semibold text-slate-900">Tour Guide Profesional</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Didampingi pemandu wisata lokal ramah, bersertifikat, dan paham spot foto terbaik.
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-3xl space-y-3 hover:border-blue-500 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl font-semibold">
                        📸
                    </div>
                    <h3 class="text-base font-semibold text-slate-900">Free Dokumentasi Foto</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Abadikan setiap detik liburanmu dengan tim dokumentasi foto & video tanpa biaya tambahan.
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-3xl space-y-3 hover:border-blue-500 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl font-semibold">
                        ⚡
                    </div>
                    <h3 class="text-base font-semibold text-slate-900">Respon WA Cepat</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Konsultasi dan bantuan instan kapan saja via Customer Service WhatsApp kami.
                    </p>
                </div>

            </div>
        </div>
    </section> -->

    <!-- 3. SECTION DESTINASI TERPOPULER -->
    <section id="destinations" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Destinasi Pilihan</span>
                <h2 class="text-3xl sm:text-4xl font-semibold text-slate-900">Destinasi Wisata Terfavorit</h2>
                <p class="text-slate-600 text-sm">
                    Pilih lokasi liburan impianmu dan nikmati promo eksklusif paket wisata kami.
                </p>
            </div>

            <!-- Grid Cards Destinasi -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                
                <div wire:click="$set('selectedDestination', 'Labuan Bajo')" class="group relative h-72 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?auto=format&fit=crop&w=800&q=80" 
                         alt="Labuan Bajo" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="text-[10px] uppercase font-semibold text-sky-300 tracking-wider block">Nusa Tenggara Timur</span>
                        <h3 class="text-xl font-semibold text-white">Labuan Bajo</h3>
                    </div>
                </div>

                <div wire:click="$set('selectedDestination', 'Raja Ampat')" class="group relative h-72 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1534008897995-27a23e859048?auto=format&fit=crop&w=800&q=80" 
                         alt="Raja Ampat" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="text-[10px] uppercase font-semibold text-sky-300 tracking-wider block">Papua Barat</span>
                        <h3 class="text-xl font-semibold text-white">Raja Ampat</h3>
                    </div>
                </div>

                <div wire:click="$set('selectedDestination', 'Bali')" class="group relative h-72 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80" 
                         alt="Bali" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="text-[10px] uppercase font-semibold text-sky-300 tracking-wider block">Pulau Dewata</span>
                        <h3 class="text-xl font-semibold text-white">Bali & Penida</h3>
                    </div>
                </div>

                <div wire:click="$set('selectedDestination', 'Bromo')" class="group relative h-72 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=800&q=80" 
                         alt="Bromo" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="text-[10px] uppercase font-semibold text-sky-300 tracking-wider block">Jawa Timur</span>
                        <h3 class="text-xl font-semibold text-white">Gunung Bromo</h3>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. SECTION PAKET WISATA (LIVEWIRE FILTER TABS PUTIH-BIRU) -->
    <section id="tours" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header & Filter Tabs -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="mx-auto mb-8 max-w-3xl text-center lg:mb-12"><p class="mb-5 text-[12px] font-semibold tracking-[.12em] text-[#1B5A7A] uppercase">Tour pilihan kami</p><h2 class="font-display text-[32px] leading-[1.15] font-semibold tracking-[-.025em] text-balance lg:text-[44px]">Tour yang pasti berangkat</h2><p class="mx-auto mt-5 max-w-xl text-[15px] leading-[1.7] font-normal text-[#525B6B] lg:text-[16px]">Jelajahi berbagai destinasi impian anda</p>
                </div>
                
            </div>

            <!-- Tour Cards Grid -->
            @if($tours->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($tours as $tour)
                        <div class="group bg-white border border-slate-200/80 rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-blue-900/10 hover:border-blue-300 transition-all duration-300 flex flex-col justify-between">
                            
                            <div>
                                <!-- Image Thumbnail -->
                                <div class="relative h-64 overflow-hidden bg-slate-100">
                                    @if($tour->thumbnail)
                                        <img src="{{ Storage::url($tour->thumbnail) }}" 
                                             alt="{{ $tour->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                    @else
                                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80" 
                                             alt="{{ $tour->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                    @endif

                                    <!-- Duration Tag -->
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[11px] font-semibold text-slate-800 shadow-sm border border-slate-200">
                                            ⏱️ {{ $tour->duration }}
                                        </span>
                                    </div>

                                    <!-- Rating Tag -->
                                    <div class="absolute top-4 right-4">
                                        <span class="px-2.5 py-1 rounded-full bg-amber-400 text-slate-950 text-[11px] font-semibold flex items-center gap-1 shadow-sm">
                                            ⭐ 4.9
                                        </span>
                                    </div>

                                    <!-- Destination -->
                                    <div class="absolute bottom-4 left-4">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-blue-600/90 text-white text-xs font-semibold backdrop-blur-sm shadow-sm">
                                            📍 {{ $tour->destination }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-6 space-y-3">
                                    <h3 class="text-lg font-semibold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                                        {{ $tour->title }}
                                    </h3>
                                    <p class="text-slate-600 text-xs line-clamp-2 leading-relaxed">
                                        {{ $tour->description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Card Footer Price & CTA -->
                            <div class="p-6 pt-0">
                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[11px] text-slate-400 block font-medium">Harga / Pax</span>
                                        <span class="text-base sm:text-lg font-semibold text-blue-600">
                                            Rp {{ number_format($tour->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <a href="/tour/{{ $tour->slug }}" 
                                       class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-md shadow-blue-600/20 transition">
                                        Detail Trip &rarr;
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-slate-50 rounded-3xl border border-slate-200 space-y-3">
                    <p class="text-slate-600 text-sm">Tidak ada paket wisata yang sesuai dengan pencarian Anda.</p>
                    <button type="button" wire:click="resetFilters" class="text-xs text-blue-600 font-semibold underline">Tampilkan Semua Paket</button>
                </div>
            @endif

        </div>
    </section>

    <!-- 5. SECTION 4 LANGKAH PEMESANAN -->
    <section class="py-20 bg-slate-50 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Cara Pemesanan</span>
                <h2 class="text-3xl sm:text-4xl font-semibold text-slate-900">4 Langkah Mudah Liburan</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm space-y-3 relative">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-semibold text-sm flex items-center justify-center">1</div>
                    <h3 class="text-base font-semibold text-slate-900">Pilih Paket Wisata</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Tentukan destinasi dan jenis paket trip sesuai dengan keinginanmu.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm space-y-3 relative">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-semibold text-sm flex items-center justify-center">2</div>
                    <h3 class="text-base font-semibold text-slate-900">Konsultasi via WA</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Hubungi admin WhatsApp untuk verifikasi tanggal & rincian kuota.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm space-y-3 relative">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-semibold text-sm flex items-center justify-center">3</div>
                    <h3 class="text-base font-semibold text-slate-900">DP & Konfirmasi</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Bayar DP aman dan terima e-voucher konfirmasi dari TravelGo.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm space-y-3 relative">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 text-white font-semibold text-sm flex items-center justify-center">4</div>
                    <h3 class="text-base font-semibold text-slate-900">Selamat Berlibur!</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Nikmati perjalanan seru dan dokumentasi foto gratis selama trip.</p>
                </div>

            </div>
        </div>
    </section>

     


    <!-- 7. SECTION CONSULTATION CTA (CLEAN PROFESSIONAL STYLE) -->
    <section class="py-20 sm:py-24 bg-white border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
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
</div>
