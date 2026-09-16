<div>
    <style>
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-7px); }
        }
        @keyframes floatSlowReverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(7px); }
        }
        @keyframes glowPulse {
            0%, 100% { opacity: 0.25; transform: scale(1); }
            50% { opacity: 0.45; transform: scale(1.06); }
        }
        .animate-float-slow {
            animation: floatSlow 4.5s ease-in-out infinite;
        }
        .animate-float-reverse {
            animation: floatSlowReverse 5s ease-in-out infinite;
        }
        .animate-glow-pulse {
            animation: glowPulse 6s ease-in-out infinite;
        }
    </style>

    <!-- 1. HERO HEADER SECTION -->
    <section id="history" class="relative pt-32 pb-16 lg:pt-36 lg:pb-20 bg-gradient-to-b from-slate-50 via-white to-slate-50 border-b border-slate-100 overflow-hidden"
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 50)">
        
        <!-- Ambient Decorative Glows -->
        <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[650px] h-[360px] bg-sky-200/40 rounded-full blur-3xl pointer-events-none animate-glow-pulse"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Header Badge -->
            <div :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
                 class="transition-all duration-700 ease-out">
                <span class="inline-block text-[12px] font-semibold tracking-[.16em] text-[#1B5A7A] uppercase mb-4 px-3.5 py-1 rounded-full bg-sky-50 border border-sky-100/80">
                    SUPER VACATION
                </span>
            </div>

            <!-- Main Title -->
            <h1 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
                class="text-3xl sm:text-4xl font-semibold text-slate-900 tracking-tight text-slate-900 leading-[1.18] max-w-4xl mx-auto transition-all duration-700 delay-150 ease-out">
                Membuka Jendela Dunia untuk Setiap Impian Anda
            </h1>

            <!-- Subtitle -->
            <p :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
               class="mt-6 text-sm sm:text-base lg:text-[17px] text-[#525B6B] leading-relaxed max-w-2xl mx-auto font-normal transition-all duration-700 delay-300 ease-out">
                Super Vacation hadir untuk memberikan perjalanan internasional yang nyaman, aman, berkualitas, dan lebih terjangkau bagi semua orang.
            </p>
        </div>
    </section>

    <!-- 2. CERITA KAMI (OUR STORY & HERITAGE) -->
    <section class="scroll-mt-24 sm:scroll-mt-28 py-16 sm:py-20 lg:py-24 bg-white border-b border-slate-100 overflow-hidden"
             x-data="{ inView: false }"
             x-init="const obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { inView = true; obs.disconnect(); } }, { threshold: 0.15 }); obs.observe($el);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- SISI KIRI: FOTO & FLOATING HERITAGE BADGE -->
                <div class="lg:col-span-5 relative transition-all duration-1000 ease-out"
                     :class="inView ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
                    
                    <div class="relative rounded-[32px] overflow-hidden shadow-2xl shadow-blue-950/10 border-4 border-white bg-slate-100 aspect-[4/5] group">
                        <img src="https://images.unsplash.com/photo-1539635278303-d4002c07eae3?auto=format&fit=crop&w=1000&q=80" 
                             alt="Super Vacation Story" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
                    </div>

                    <!-- Floating Badge: Experience Heritage (Continuous Soft Floating) -->
                    <div class="absolute -bottom-6 -right-2 sm:right-6 bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-xl shadow-slate-900/10 border border-slate-100 flex items-center gap-3.5 z-10 animate-float-slow hover:scale-105 transition-transform duration-300">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-200/80 flex items-center justify-center text-blue-600 text-xl font-semibold shrink-0">
                            🏛️
                        </div>
                        <div>
                            <span class="font-semibold text-slate-900 text-sm block">Pengalaman Sejak 2003</span>
                            <p class="text-[11px] font-medium text-slate-500">Sister Brand Terpercaya</p>
                        </div>
                    </div>

                    <!-- Floating Badge: Google Rating (Continuous Soft Floating Reverse) -->
                    <div class="absolute -top-4 -left-2 sm:left-4 bg-white/95 backdrop-blur-md rounded-2xl px-4 py-3 shadow-lg shadow-slate-900/10 border border-slate-100 flex items-center gap-3 z-10 animate-float-reverse hover:scale-105 transition-transform duration-300">
                        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200/80 shadow-xs flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-900 block">5.0 / 5.0 Rating</span>
                            <span class="text-[10px] text-amber-500 font-semibold">★★★★★ Google Review</span>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN: KONTEN SEJARAH & DESKRIPSI -->
                <div class="lg:col-span-7 space-y-6 transition-all duration-1000 delay-150 ease-out"
                     :class="inView ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'">
                    <div>
                        <p class="text-[12px] font-semibold tracking-[.14em] text-[#1B5A7A] uppercase mb-3">
                            CERITA KAMI
                        </p>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-slate-900 tracking-tight leading-snug">
                            Lahir dari Keyakinan bahwa Semua Orang Berhak Menjelajahi Dunia
                        </h2>
                    </div>

                    <div class="space-y-4 text-slate-600 text-[15px] sm:text-base leading-[1.8] font-normal text-justify sm:text-left">
                        <p>
                            <strong class="text-slate-900 font-semibold">Super Vacation</strong> lahir dari keyakinan bahwa pengalaman menjelajahi dunia seharusnya dapat dinikmati oleh semua orang. Berbekal tim yang telah berpengalaman di industri perjalanan sejak tahun 2003 sebagai sister brand dari grup pariwisata terkemuka, kami hadir untuk memberikan layanan travel yang terpercaya, nyaman, dan tetap terjangkau.
                        </p>
                        <p>
                            Kami percaya setiap perjalanan adalah impian yang layak diwujudkan. Karena itu, Super Vacation berkomitmen membantu lebih banyak orang mengunjungi destinasi impian mereka dengan pengalaman perjalanan yang aman, menyenangkan, dan penuh kenangan tak terlupakan.
                        </p>
                    </div>

                    <!-- Statistik Card Ringan dengan Staggered Hover & Entrance -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center hover:bg-white hover:border-blue-200 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                            <span class="block text-2xl sm:text-3xl font-semibold text-[#1B5A7A] group-hover:scale-105 transition-transform duration-300">2003</span>
                            <span class="text-[11px] font-medium text-slate-500">Dedikasi Pengalaman</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center hover:bg-white hover:border-blue-200 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                            <span class="block text-2xl sm:text-3xl font-semibold text-[#1B5A7A] group-hover:scale-105 transition-transform duration-300">50+</span>
                            <span class="text-[11px] font-medium text-slate-500">Destinasi Populer</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center hover:bg-white hover:border-blue-200 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                            <span class="block text-2xl sm:text-3xl font-semibold text-[#1B5A7A] group-hover:scale-105 transition-transform duration-300">100%</span>
                            <span class="text-[11px] font-medium text-slate-500">Pasti Berangkat</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center hover:bg-white hover:border-blue-200 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group">
                            <span class="block text-2xl sm:text-3xl font-semibold text-[#1B5A7A] group-hover:scale-105 transition-transform duration-300">24/7</span>
                            <span class="text-[11px] font-medium text-slate-500">Layanan Responsif</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 3. VISI & MISI SECTION -->
    <section class="py-16 sm:py-20 lg:py-24 bg-slate-50/70 border-b border-slate-100 overflow-hidden"
             x-data="{ inView: false }"
             x-init="const obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { inView = true; obs.disconnect(); } }, { threshold: 0.12 }); obs.observe($el);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Visi Misi -->
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3 transition-all duration-700 ease-out"
                 :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <p class="text-[12px] font-semibold tracking-[.14em] text-[#1B5A7A] uppercase">
                    VISI & MISI KAMI
                </p>
                <h2 class="text-3xl sm:text-4xl font-semibold text-slate-900 tracking-tight">
                    Komitmen & Arah Langkah Kami
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Kami percaya bahwa setiap orang berhak merasakan pengalaman menjelajahi dunia. Dengan tim yang berpengalaman dan pelayanan yang terpercaya, Super Vacation hadir untuk memberikan perjalanan internasional yang nyaman, berkualitas, dan lebih terjangkau bagi semua orang.
                </p>
            </div>

            <!-- Bento Vision & Mission Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                
                <!-- VISION CARD (Highlight Besar Kiri) -->
                <div class="lg:col-span-5 p-8 sm:p-10 rounded-3xl bg-[#1B5A7A] text-white flex flex-col justify-between shadow-xl shadow-[#1B5A7A]/15 relative overflow-hidden group hover:shadow-2xl hover:shadow-[#1B5A7A]/25 transition-all duration-700 ease-out"
                     :class="inView ? 'opacity-100 translate-y-0 scale-100' : 'opacity-0 translate-y-10 scale-95'">
                    <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full blur-2xl pointer-events-none animate-pulse"></div>
                    
                    <div class="space-y-6 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                            🔭
                        </div>
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-widest text-sky-200">ARAH MASA DEPAN</span>
                            <h3 class="text-2xl sm:text-3xl font-semibold mt-1 text-white tracking-tight">
                                VISI
                            </h3>
                        </div>
                        <p class="text-blue-50 text-sm sm:text-base leading-relaxed font-normal">
                            "Menjadi perusahaan perjalanan terpercaya yang membantu lebih banyak orang mewujudkan impian menjelajahi dunia melalui layanan yang berkualitas dan harga yang terjangkau."
                        </p>
                    </div>

                    <div class="pt-8 border-t border-white/15 mt-8 flex items-center gap-3">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-xs font-semibold text-blue-100 uppercase tracking-wider">Super Vacation Commitment</span>
                    </div>
                </div>

                <!-- MISSION CARDS (4 Pilar Misi Kanan) -->
                <div class="lg:col-span-7 flex flex-col justify-between space-y-4">
                    <div class="mb-2 transition-all duration-700 delay-100 ease-out"
                         :class="inView ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-6'">
                        <span class="text-xs font-semibold uppercase tracking-widest text-[#1B5A7A]">LANGKAH NYATA</span>
                        <h3 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">
                            MISI
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Misi 1 -->
                        <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition-all duration-300 space-y-2 group"
                             :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                             style="transition-delay: 150ms;">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-semibold text-sm group-hover:bg-[#1B5A7A] group-hover:text-white transition-colors duration-300">
                                01
                            </div>
                            <h4 class="text-[15px] font-semibold text-slate-900 group-hover:text-[#1B5A7A] transition-colors">Kenyamanan & Keamanan</h4>
                            <p class="text-xs sm:text-[13px] text-slate-500 leading-relaxed font-normal">
                                Memberikan pengalaman perjalanan yang nyaman, aman, dan berkesan di setiap destinasi.
                            </p>
                        </div>

                        <!-- Misi 2 -->
                        <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 space-y-2 group"
                             :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                             style="transition-delay: 250ms;">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-semibold text-sm group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                                02
                            </div>
                            <h4 class="text-[15px] font-semibold text-slate-900 group-hover:text-emerald-700 transition-colors">Nilai & Harga Terbaik</h4>
                            <p class="text-xs sm:text-[13px] text-slate-500 leading-relaxed font-normal">
                                Menghadirkan pilihan perjalanan berkualitas dengan harga yang kompetitif dan terjangkau.
                            </p>
                        </div>

                        <!-- Misi 3 -->
                        <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-sky-300 hover:-translate-y-1 transition-all duration-300 space-y-2 group"
                             :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                             style="transition-delay: 350ms;">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-semibold text-sm group-hover:bg-sky-600 group-hover:text-white transition-colors duration-300">
                                03
                            </div>
                            <h4 class="text-[15px] font-semibold text-slate-900 group-hover:text-sky-700 transition-colors">Pelayanan Ahli & Ramah</h4>
                            <p class="text-xs sm:text-[13px] text-slate-500 leading-relaxed font-normal">
                                Memberikan pelayanan terbaik melalui tim profesional yang berdedikasi dan berpengalaman.
                            </p>
                        </div>

                        <!-- Misi 4 -->
                        <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-amber-300 hover:-translate-y-1 transition-all duration-300 space-y-2 group"
                             :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                             style="transition-delay: 450ms;">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-semibold text-sm group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                                04
                            </div>
                            <h4 class="text-[15px] font-semibold text-slate-900 group-hover:text-amber-700 transition-colors">Wujudkan Impian Anda</h4>
                            <p class="text-xs sm:text-[13px] text-slate-500 leading-relaxed font-normal">
                                Membantu lebih banyak orang mewujudkan perjalanan impian mereka ke berbagai belahan dunia.
                            </p>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- 4. KEUNGGULAN KAMI (WHY US) -->
    <section id="why-us" class="scroll-mt-24 sm:scroll-mt-28 py-16 sm:py-20 lg:py-24 bg-white border-b border-slate-100 overflow-hidden"
             x-data="{ inView: false }"
             x-init="const obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { inView = true; obs.disconnect(); } }, { threshold: 0.12 }); obs.observe($el);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header & Narrative Intro -->
            <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-16 space-y-4 transition-all duration-700 ease-out"
                 :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <p class="text-[12px] font-semibold tracking-[.14em] text-[#1B5A7A] uppercase">
                    KEUNGGULAN KAMI
                </p>
                <h2 class="text-3xl sm:text-4xl font-semibold text-slate-900 tracking-tight leading-tight">
                    Mengapa Memilih Super Vacation?
                </h2>
                <p class="text-sm sm:text-base text-[#525B6B] leading-relaxed font-normal">
                    Super Vacation hadir dengan tim profesional yang telah berpengalaman di industri perjalanan. Kami percaya bahwa perjalanan luar negeri tidak harus terasa rumit atau sulit dijangkau. Dengan pelayanan yang ramah, proses yang mudah, dan pilihan paket yang bernilai, kami siap membantu Anda mewujudkan perjalanan impian dengan penuh percaya diri.
                </p>
            </div>

            <!-- 4 Value Pillar Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- 1. EXPERIENCED TEAM -->
                <div class="group p-6 sm:p-7 rounded-3xl bg-slate-50/80 border border-slate-200/80 hover:bg-white hover:border-blue-300 shadow-xs hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     style="transition-delay: 100ms;">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-[#1B5A7A] group-hover:text-white group-hover:border-[#1B5A7A] group-hover:scale-105 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-blue-700 bg-blue-100/70 px-2.5 py-1 rounded-full">
                                01 / EXPERT
                            </span>
                        </div>
                        <h3 class="text-base sm:text-[17px] font-semibold text-slate-900 group-hover:text-[#1B5A7A] transition-colors tracking-tight mb-2.5">
                            EXPERIENCED TEAM
                        </h3>
                        <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed font-normal">
                            Didukung oleh tim yang telah berpengalaman dalam menangani berbagai perjalanan domestik maupun internasional.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-200/60 flex items-center gap-1.5 text-xs font-semibold text-slate-400 group-hover:text-[#1B5A7A] transition-colors">
                        <span>Layanan Profesional</span>
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- 2. BEST VALUE TRIP -->
                <div class="group p-6 sm:p-7 rounded-3xl bg-slate-50/80 border border-slate-200/80 hover:bg-white hover:border-emerald-300 shadow-xs hover:shadow-xl hover:shadow-emerald-900/5 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     style="transition-delay: 200ms;">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 group-hover:scale-105 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-emerald-700 bg-emerald-100/70 px-2.5 py-1 rounded-full">
                                02 / VALUE
                            </span>
                        </div>
                        <h3 class="text-base sm:text-[17px] font-semibold text-slate-900 group-hover:text-emerald-700 transition-colors tracking-tight mb-2.5">
                            BEST VALUE TRIP
                        </h3>
                        <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed font-normal">
                            Menghadirkan paket perjalanan dengan harga yang kompetitif tanpa mengurangi kualitas pelayanan dan pengalaman perjalanan.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-200/60 flex items-center gap-1.5 text-xs font-semibold text-slate-400 group-hover:text-emerald-700 transition-colors">
                        <span>Kualitas Terjamin</span>
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- 3. DESTINATION MADE ACCESSIBLE -->
                <div class="group p-6 sm:p-7 rounded-3xl bg-slate-50/80 border border-slate-200/80 hover:bg-white hover:border-sky-300 shadow-xs hover:shadow-xl hover:shadow-sky-900/5 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     style="transition-delay: 300ms;">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white group-hover:border-sky-600 group-hover:scale-105 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 012 2v2.945M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-sky-700 bg-sky-100/70 px-2.5 py-1 rounded-full">
                                03 / ACCESS
                            </span>
                        </div>
                        <h3 class="text-base sm:text-[17px] font-semibold text-slate-900 group-hover:text-sky-700 transition-colors tracking-tight mb-2.5">
                            DESTINATION MADE ACCESSIBLE
                        </h3>
                        <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed font-normal">
                            Kami membantu lebih banyak orang mewujudkan impian mengunjungi destinasi favorit dengan proses yang mudah dan nyaman.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-200/60 flex items-center gap-1.5 text-xs font-semibold text-slate-400 group-hover:text-sky-700 transition-colors">
                        <span>Kemudahan Destinasi</span>
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- 4. CUSTOMER CENTERED SERVICE -->
                <div class="group p-6 sm:p-7 rounded-3xl bg-slate-50/80 border border-slate-200/80 hover:bg-white hover:border-amber-300 shadow-xs hover:shadow-xl hover:shadow-amber-900/5 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     style="transition-delay: 400ms;">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white group-hover:border-amber-600 group-hover:scale-105 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-amber-800 bg-amber-100/70 px-2.5 py-1 rounded-full">
                                04 / SERVICE
                            </span>
                        </div>
                        <h3 class="text-base sm:text-[17px] font-semibold text-slate-900 group-hover:text-amber-700 transition-colors tracking-tight mb-2.5">
                            CUSTOMER CENTERED SERVICE
                        </h3>
                        <p class="text-xs sm:text-[13px] text-slate-600 leading-relaxed font-normal">
                            Memberikan pelayanan yang responsif, transparan, dan selalu siap mendampingi pelanggan sebelum, selama, hingga setelah perjalanan.
                        </p>
                    </div>
                    <div class="pt-5 mt-5 border-t border-slate-200/60 flex items-center gap-1.5 text-xs font-semibold text-slate-400 group-hover:text-amber-700 transition-colors">
                        <span>Pendampingan Penuh</span>
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. KONSULTASI CTA SECTION -->
    <section class="py-20 sm:py-24 bg-gradient-to-b from-white to-slate-50 border-t border-slate-100 overflow-hidden relative"
             x-data="{ inView: false }"
             x-init="const obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { inView = true; obs.disconnect(); } }, { threshold: 0.2 }); obs.observe($el);">
        
        <!-- Ambient Background Glow -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[500px] h-[250px] bg-sky-200/30 rounded-full blur-3xl pointer-events-none animate-glow-pulse"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center transition-all duration-700 ease-out"
             :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-[#1b5a7a] mb-6">
                MASIH BINGUNG PILIH TOUR?
            </p>
            <h2 class="font-display mb-7 text-[28px] leading-[1.12] font-semibold tracking-[-.025em] text-balance lg:text-[40px] text-slate-900">
                Ceritakan rencana perjalananmu.<br class="hidden sm:inline" /> Kami bantu pilihkan
            </h2>
            <p class="mb-10 text-[15px] leading-[1.7] text-[#525B6B] lg:text-[18px]">
                Sampaikan destinasi yang diminati, waktu keberangkatan, durasi, dan kisaran budget. Tour Consultant kami akan membantu mencarikan pilihan yang paling sesuai.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 sm:gap-4">
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Super%20Vacation,%20saya%20ingin%20konsultasi%20rencana%20perjalanan%20saya" 
                   target="_blank" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-full bg-[#1b5a7a] hover:bg-[#13425a] text-white font-medium text-sm transition-all duration-300 shadow-md shadow-[#1b5a7a]/20 hover:shadow-xl hover:shadow-[#1b5a7a]/30 hover:-translate-y-0.5 active:scale-95 group">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Konsultasi gratis via WhatsApp</span>
                </a>
            </div>
            <p class="text-xs text-slate-400 mt-6 font-normal">
                Dibantu langsung oleh Tour Consultant kami.
            </p>
        </div>
    </section>
</div>
