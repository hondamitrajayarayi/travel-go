<div>
        <!-- 1. HERO BANNER SECTION DENGAN BACKGROUND SLIDER OTOMATIS -->
    <section id="hero" 
             x-data="{ 
                currentSlide: 0, 
                slides: [
                    'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=2000&q=80',
                    'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=2000&q=80',
                    'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=2000&q=80',
                    'https://images.unsplash.com/photo-1534008897995-27a23e859048?auto=format&fit=crop&w=2000&q=80'
                ],
                init() {
                    setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    }, 5000);
                }
             }"
             class="relative pt-32 pb-24 min-h-[90vh] flex items-center justify-center overflow-hidden">
        
        <!-- Background Slider Images dengan Transisi Fade Halus -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition opacity ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition opacity ease-in duration-1000"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 z-0">
                <img :src="slide" 
                     alt="Hero Background Travel Slide" 
                     class="w-full h-full object-cover object-center transform transition-transform duration-10000" />
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-950/60 to-slate-900"></div>
            </div>
        </template>

        <!-- Tombol Panah Navigasi Slider -->
        <button @click="currentSlide = (currentSlide - 1 + slides.length) % slides.length" 
                type="button" 
                class="absolute left-4 z-20 p-3 rounded-full bg-white/20 hover:bg-white/40 text-white backdrop-blur-md transition hidden sm:flex items-center justify-center shadow-lg">
            ❮
        </button>
        <button @click="currentSlide = (currentSlide + 1) % slides.length" 
                type="button" 
                class="absolute right-4 z-20 p-3 rounded-full bg-white/20 hover:bg-white/40 text-white backdrop-blur-md transition hidden sm:flex items-center justify-center shadow-lg">
            ❯
        </button>

        <!-- Hero Content Overlay -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
            <!-- Top Tagline Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600/30 border border-blue-400/40 backdrop-blur-md text-white text-xs sm:text-sm font-bold shadow-lg">
                <span class="flex h-2.5 w-2.5 rounded-full bg-blue-400 animate-ping"></span>
                #1 Spesialis Open Trip & Tour Indonesia
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white leading-tight max-w-5xl mx-auto drop-shadow-md">
                Liburan Impian <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-300 to-emerald-300">Tanpa Ribet</span> Bersama TravelGo
            </h1>

            <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-200 font-normal leading-relaxed drop-shadow-sm">
                Jelajahi surga destinasi wisata Indonesia dengan armada nyaman, tour guide ramah, serta dokumentasi foto & video premium gratis!
            </p>

            <!-- FLOATING SEARCH BAR (PUTIH BACKDROP OVER SLIDER) -->
            <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-xl p-4 sm:p-5 rounded-3xl border border-white/40 shadow-2xl space-y-4 text-left">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    
                    <!-- Search Input -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-600">
                            🔍
                        </div>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search"
                               placeholder="Cari destinasi / nama trip..." 
                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition" />
                    </div>

                    <!-- Destination Filter -->
                    <div class="relative">
                        <select wire:model.live="selectedDestination" 
                                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition appearance-none">
                            <option value="all">🌐 Semua Destinasi</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest }}">{{ $dest }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-xs">
                            ▼
                        </div>
                    </div>

                    <!-- Category Quick Select -->
                    <div class="relative">
                        <select wire:model.live="selectedCategory" 
                                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition appearance-none">
                            <option value="all">🎒 Semua Tipe Trip</option>
                            <option value="open_trip">👥 Open Trip (Gabungan)</option>
                            <option value="private_trip">👑 Private Trip (Eksklusif)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400 text-xs">
                            ▼
                        </div>
                    </div>

                </div>

                @if($search || $selectedCategory !== 'all' || $selectedDestination !== 'all')
                    <div class="flex justify-end pt-1">
                        <button type="button" 
                                wire:click="resetFilters" 
                                class="text-xs text-blue-600 hover:text-blue-800 font-bold underline cursor-pointer">
                            🔄 Reset Filter Search
                        </button>
                    </div>
                @endif
            </div>

            <!-- Dots Indicator Slider -->
            <div class="flex justify-center items-center gap-2 pt-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="currentSlide = index" 
                            type="button" 
                            :class="currentSlide === index ? 'w-8 bg-blue-500' : 'w-2.5 bg-white/50 hover:bg-white/80'" 
                            class="h-2.5 rounded-full transition-all duration-300 focus:outline-none shadow-sm"></button>
                </template>
            </div>

            <!-- Key Badges -->
            <div class="flex flex-wrap justify-center items-center gap-6 pt-2 text-xs font-bold text-white">
                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 shadow-sm">📸 Free Dokumentasi HD</span>
                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 shadow-sm">🛡️ Garansi 100% Berangkat</span>
                <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 shadow-sm">💳 DP Ringan & Transparan</span>
            </div>
        </div>
    </section>


    <!-- 2. SECTION VALUE PROPOSITION (MENGAPA MEMILIH KAMI) -->
    <section class="py-16 bg-white border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-3xl space-y-3 hover:border-blue-500 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl font-bold">
                        💎
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Harga Transparan</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Tanpa biaya tersembunyi! Semua rincian fasilitas include & exclude tertera jelas sebelum pemesanan.
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-3xl space-y-3 hover:border-blue-500 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-bold">
                        👨‍✈️
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Tour Guide Profesional</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Didampingi pemandu wisata lokal ramah, bersertifikat, dan paham spot foto terbaik.
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-3xl space-y-3 hover:border-blue-500 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl font-bold">
                        📸
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Free Dokumentasi Foto</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Abadikan setiap detik liburanmu dengan tim dokumentasi foto & video tanpa biaya tambahan.
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-200/80 p-6 rounded-3xl space-y-3 hover:border-blue-500 hover:shadow-lg transition">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl font-bold">
                        ⚡
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Respon WA Cepat</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Konsultasi dan bantuan instan kapan saja via Customer Service WhatsApp kami.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. SECTION DESTINASI TERPOPULER -->
    <section id="destinations" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Destinasi Pilihan</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Destinasi Wisata Terfavorit</h2>
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
                        <span class="text-[10px] uppercase font-bold text-sky-300 tracking-wider block">Nusa Tenggara Timur</span>
                        <h3 class="text-xl font-bold text-white">Labuan Bajo</h3>
                    </div>
                </div>

                <div wire:click="$set('selectedDestination', 'Raja Ampat')" class="group relative h-72 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1534008897995-27a23e859048?auto=format&fit=crop&w=800&q=80" 
                         alt="Raja Ampat" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="text-[10px] uppercase font-bold text-sky-300 tracking-wider block">Papua Barat</span>
                        <h3 class="text-xl font-bold text-white">Raja Ampat</h3>
                    </div>
                </div>

                <div wire:click="$set('selectedDestination', 'Bali')" class="group relative h-72 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80" 
                         alt="Bali" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="text-[10px] uppercase font-bold text-sky-300 tracking-wider block">Pulau Dewata</span>
                        <h3 class="text-xl font-bold text-white">Bali & Penida</h3>
                    </div>
                </div>

                <div wire:click="$set('selectedDestination', 'Bromo')" class="group relative h-72 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=800&q=80" 
                         alt="Bromo" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="text-[10px] uppercase font-bold text-sky-300 tracking-wider block">Jawa Timur</span>
                        <h3 class="text-xl font-bold text-white">Gunung Bromo</h3>
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
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Paket Wisata</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Daftar Trip Terbaru</h2>
                </div>

                <!-- Livewire Filter Tabs -->
                <div class="inline-flex p-1.5 rounded-2xl bg-slate-100 border border-slate-200">
                    <button type="button" 
                            wire:click="selectCategory('all')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-bold transition {{ $selectedCategory === 'all' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:text-slate-900' }}">
                        Semua Paket
                    </button>
                    <button type="button" 
                            wire:click="selectCategory('open_trip')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-bold transition {{ $selectedCategory === 'open_trip' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:text-slate-900' }}">
                        Open Trip
                    </button>
                    <button type="button" 
                            wire:click="selectCategory('private_trip')" 
                            class="px-5 py-2.5 rounded-xl text-xs font-bold transition {{ $selectedCategory === 'private_trip' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:text-slate-900' }}">
                        Private Trip
                    </button>
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
                                        <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[11px] font-bold text-slate-800 shadow-sm border border-slate-200">
                                            ⏱️ {{ $tour->duration }}
                                        </span>
                                    </div>

                                    <!-- Rating Tag -->
                                    <div class="absolute top-4 right-4">
                                        <span class="px-2.5 py-1 rounded-full bg-amber-400 text-slate-950 text-[11px] font-extrabold flex items-center gap-1 shadow-sm">
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
                                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
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
                                        <span class="text-base sm:text-lg font-extrabold text-blue-600">
                                            Rp {{ number_format($tour->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <a href="/tour/{{ $tour->slug }}" 
                                       class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/20 transition">
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
                    <button type="button" wire:click="resetFilters" class="text-xs text-blue-600 font-bold underline">Tampilkan Semua Paket</button>
                </div>
            @endif

        </div>
    </section>

    <!-- 5. SECTION 4 LANGKAH PEMESANAN -->
    <section class="py-20 bg-slate-50 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Cara Pemesanan</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">4 Langkah Mudah Liburan</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm space-y-3 relative">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-black text-sm flex items-center justify-center">1</div>
                    <h3 class="text-base font-bold text-slate-900">Pilih Paket Wisata</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Tentukan destinasi dan jenis paket trip sesuai dengan keinginanmu.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm space-y-3 relative">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-black text-sm flex items-center justify-center">2</div>
                    <h3 class="text-base font-bold text-slate-900">Konsultasi via WA</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Hubungi admin WhatsApp untuk verifikasi tanggal & rincian kuota.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm space-y-3 relative">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-black text-sm flex items-center justify-center">3</div>
                    <h3 class="text-base font-bold text-slate-900">DP & Konfirmasi</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Bayar DP aman dan terima e-voucher konfirmasi dari TravelGo.</p>
                </div>

                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm space-y-3 relative">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 text-white font-black text-sm flex items-center justify-center">4</div>
                    <h3 class="text-base font-bold text-slate-900">Selamat Berlibur!</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Nikmati perjalanan seru dan dokumentasi foto gratis selama trip.</p>
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
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-200">Dokumentasi</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Keseruan Wisatawan TravelGo</h2>
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
                                <h4 class="text-sm font-bold text-slate-900 line-clamp-1">{{ $testimonial->title }}</h4>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase shrink-0 {{ $testimonial->platform === 'youtube_short' ? 'bg-red-100 text-red-600 border border-red-200' : 'bg-pink-100 text-pink-600 border border-pink-200' }}">
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


    <!-- 7. PROMO BANNER / CTA WHATSAPP (GRADIENT BIRU ROYAL) -->
    <section class="py-16 bg-gradient-to-r from-blue-700 via-blue-600 to-sky-600 text-white">
        <div class="max-w-5xl mx-auto px-4 text-center space-y-6">
            <h2 class="text-3xl sm:text-5xl font-black">Ingin Rencanakan Private Trip Sendiri?</h2>
            <p class="text-blue-100 text-sm sm:text-base max-w-xl mx-auto">
                Bebas kustomisasi tanggal, jumlah peserta, dan destinasi impianmu bersama konsultan perjalanan TravelGo.
            </p>
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20TravelGo,%20saya%20ingin%20konsultasi%20private%20trip" 
               target="_blank"
               class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-sm sm:text-base shadow-xl shadow-blue-900/30 transition hover:-translate-y-0.5">
                💬 Konsultasi Trip Gratis via WhatsApp
            </a>
        </div>
    </section>
</div>
