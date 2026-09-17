<div class="pt-20 pb-20 bg-slate-50 min-h-screen">
    
    <!-- 1. HERO HEADER BANNER (ULTRA CLEAN & PREMIUM) -->
    <section class="relative pt-12 pb-10 sm:pt-16 sm:pb-14 bg-gradient-to-b from-slate-50 via-white to-slate-50 border-b border-slate-100/80 mb-10 overflow-hidden"
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 50)">
        
        <!-- Ambient Decorative Glow -->
        <div class="absolute top-4 left-1/2 -translate-x-1/2 w-[650px] h-[260px] bg-sky-200/30 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Header Badge -->
            <div :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'" 
                 class="transition-all duration-700 ease-out">
                <span class="inline-flex items-center gap-2 text-[11px] font-semibold tracking-[.14em] text-[#1B5A7A] uppercase px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-100/90 shadow-2xs mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#1B5A7A]"></span>
                    Jadwal Pemberangkatan {{ date('Y') }} – {{ date('Y') + 1 }}
                </span>
            </div>

            <!-- Main Title -->
            <h1 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
                class="transition-all duration-700 delay-100 ease-out font-display text-3xl sm:text-5xl lg:text-5xl font-semibold tracking-[-.025em] text-slate-900 leading-[1.15]">
                Jadwal Pemberangkatan Tour
            </h1>

            <!-- Subtitle -->
            <p :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
               class="transition-all duration-700 delay-200 ease-out mt-3 text-sm sm:text-base text-slate-500 font-normal max-w-2xl mx-auto leading-relaxed">
                Jelajahi seluruh pilihan paket wisata pilihan dengan kepastian tanggal keberangkatan dan kuota terjamin.
            </p>

        </div>
    </section>

    <!-- 2. MAIN CONTAINER (FILTER & TOUR CARDS) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- FILTER TOOLBAR CONTAINER (SAMAKAN DENGAN HOME PAGE) -->
        <div x-data="{ mobileFilterOpen: false }" wire:ignore.self class="bg-white border border-slate-200/90 rounded-3xl p-4 sm:p-6 shadow-sm space-y-4">
            
            <!-- Mobile Filter Toggle Bar (Visible only on mobile < sm) -->
            <div class="sm:hidden">
                <button type="button" 
                        @click="mobileFilterOpen = !mobileFilterOpen"
                        class="w-full flex items-center justify-between px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 shadow-xs active:scale-98 transition">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#1B5A7A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Filter & Pencarian Tour</span>
                        @if($search !== '' || $selectedCountry !== 'all' || !empty($selectedMonths) || !empty($selectedYears) || $selectedCategory !== 'all')
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
                                   class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] focus:border-transparent transition" />
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- 2. Filter Destinasi (Negara) -->
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Destinasi / Negara</label>
                        <select wire:model.live="selectedCountry" 
                                class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] focus:border-transparent transition cursor-pointer">
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
                                class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] transition flex items-center justify-between gap-2 shadow-xs cursor-pointer">
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
                                class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] transition flex items-center justify-between gap-2 shadow-xs cursor-pointer">
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
            @if($search !== '' || $selectedCountry !== 'all' || !empty($selectedMonths) || !empty($selectedYears) || $selectedCategory !== 'all')
                <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs font-medium">
                    <span class="text-slate-600">
                        Menampilkan hasil filter paket tour (Total: <strong class="text-[#1B5A7A] font-semibold">{{ $totalToursCount }}</strong>)
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

        <!-- TOUR CARDS GRID (POSTER REFERENCE LAYOUT IDENTICAL TO HOME) -->
        @if($tours->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($tours as $tour)
                    @php
                        $currentPrice = ($tour->promo_price && $tour->promo_price < $tour->price) ? $tour->promo_price : $tour->price;
                        $priceData = $parsePrice($currentPrice);
                        $oldPriceData = ($tour->promo_price && $tour->promo_price < $tour->price) ? $parsePrice($tour->price) : null;
                    @endphp

                    <div onclick="window.location.href='/tour/{{ $tour->slug }}'" 
                         class="group bg-white rounded-3xl border border-slate-200/90 shadow-md hover:shadow-2xl hover:shadow-sky-950/15 hover:border-sky-300 transition-all duration-300 flex flex-col overflow-hidden relative cursor-pointer"
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

                            <!-- Bottom Right Promo Oval Badge -->
                            @if($tour->promo_price && $tour->promo_price < $tour->price)
                                <div class="absolute bottom-3 right-3 z-10">
                                    <span class="px-4 py-1.5 rounded-full bg-[#0055D4] text-white font-semibold text-xs sm:text-sm tracking-wide shadow-lg border border-white/20">
                                        Promo
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- 3. Middle Section: Title & Date (Yellow/Amber Banner - Flex 1) -->
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

            <!-- PAGINATION LINKS FITUR -->
            <div class="pt-6">
                {{ $tours->links() }}
            </div>
        @else
            <!-- EMPTY STATE -->
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-xl mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Paket Tour Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                    Tidak ada paket wisata yang cocok dengan kriteria filter pencarian Anda. Coba ubah kata kunci atau reset filter.
                </p>
                <div class="mt-6">
                    <button type="button" 
                            wire:click="resetFilters" 
                            class="px-6 py-2.5 rounded-full bg-[#1B5A7A] text-white font-semibold text-xs hover:bg-[#13425a] transition">
                        Reset Filter
                    </button>
                </div>
            </div>
        @endif

    </div>

</div>
