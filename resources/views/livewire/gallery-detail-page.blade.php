<div class="min-h-screen bg-[#FBFBFA] text-slate-900"
     x-data="{
         lightboxOpen: false,
         currentIndex: 0,
         countryName: '{{ addslashes($country->name) }}',
         photos: {{ Js::from($allPhotos) }},

         openLightbox(index) {
             this.currentIndex = index;
             this.lightboxOpen = true;
             document.body.classList.add('overflow-hidden');
             this.scrollToActiveThumb();
         },

         closeLightbox() {
             this.lightboxOpen = false;
             document.body.classList.remove('overflow-hidden');
         },

         nextPhoto() {
             if (this.photos.length > 0) {
                 this.currentIndex = (this.currentIndex + 1) % this.photos.length;
                 this.scrollToActiveThumb();
             }
         },

         prevPhoto() {
             if (this.photos.length > 0) {
                 this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length;
                 this.scrollToActiveThumb();
             }
         },

         selectPhoto(index) {
             this.currentIndex = index;
             this.scrollToActiveThumb();
         },

         scrollToActiveThumb() {
             this.$nextTick(() => {
                 const el = document.getElementById('thumb-' + this.currentIndex);
                 if (el) {
                     el.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                 }
             });
         },

         get currentPhoto() {
             return this.photos[this.currentIndex] || {};
         }
     }"
     @keydown.escape.window="closeLightbox()"
     @keydown.arrow-right.window="if(lightboxOpen) nextPhoto()"
     @keydown.arrow-left.window="if(lightboxOpen) prevPhoto()">

    {{-- ═══ HERO / HEADER ═══ --}}
    <header class="pt-28 pb-12 sm:pb-16 px-4 sm:px-6 lg:px-8 bg-white border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                <div class="space-y-3 max-w-2xl">
                    <span class="inline-flex items-center gap-2 text-[11px] font-bold tracking-[0.25em] text-[#1B5A7A] uppercase">
                        Dokumentasi Resmi & Jadwal Trip
                    </span>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-slate-900 tracking-tight leading-[1.15]">
                        Tour {{ $country->name }}
                    </h1>
                    <p class="text-sm sm:text-base text-slate-500 leading-relaxed font-light">
                        Kumpulan dokumentasi foto autentik perjalanan tamu Super Vacation dan jadwal keberangkatan tour yang sedang dibuka untuk destinasi {{ $country->name }}.
                    </p>
                </div>

                {{-- Fast Navigation Pills --}}
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="#galeri-foto"
                       class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-slate-700 text-xs sm:text-sm font-medium transition flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ count($allPhotos) }} Foto Galeri</span>
                    </a>

                    <a href="#jadwal-keberangkatan"
                       class="px-5 py-2.5 rounded-xl bg-[#1B5A7A] hover:bg-[#154660] text-white text-xs sm:text-sm font-medium transition flex items-center gap-2 shadow-sm">
                        <svg class="w-4 h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $relatedTours->count() }} Jadwal Tersedia</span>
                        <span>↓</span>
                    </a>
                </div>
            </div>

        </div>
    </header>

    {{-- ═══ SECTION 1: PHOTO GALLERY ═══ --}}
    <section id="galeri-foto" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-16">
        <div class="flex items-center justify-between gap-4 mb-12 sm:mb-14">
            <div>
                <span class="text-[11px] font-bold tracking-[0.2em] text-[#1B5A7A] uppercase block mb-1">
                    Portofolio Visual
                </span>
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-slate-900 tracking-tight">
                    Dokumentasi Foto di {{ $country->name }}
                </h2>
            </div>
        </div>

        @if(!empty($allPhotos))
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($allPhotos as $index => $photo)
                    <div @click="openLightbox({{ $index }})"
                         style="min-height: 220px; aspect-ratio: 4/3;"
                         class="group relative h-52 sm:h-60 w-full rounded-2xl overflow-hidden bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer">

                        <img src="{{ $photo['image'] }}"
                             alt="{{ $photo['title'] }}"
                             loading="lazy"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-106" />

                        {{-- Subtle Dark Gradient on Hover --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/15 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            @if(!empty($photo['destination']))
                                <span class="text-[10px] uppercase font-bold text-sky-300 tracking-wider">
                                    {{ $photo['destination'] }}
                                </span>
                            @endif
                            <h4 class="text-xs sm:text-sm font-semibold text-white leading-tight truncate">
                                {{ $photo['title'] }}
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-16 bg-white rounded-3xl border border-slate-200/80 text-center p-8">
                <p class="text-slate-400 text-sm">Belum ada foto dokumentasi yang diunggah untuk {{ $country->name }}.</p>
            </div>
        @endif
    </section>

    {{-- ═══ SECTION 2: RELATED TOUR SCHEDULES (EXACT COPY OF TOUR SCHEDULE CARD STYLE) ═══ --}}
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

    <section id="jadwal-keberangkatan" class="bg-white border-y border-slate-200/80 py-14 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Title --}}
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-10">
                <div class="space-y-2 max-w-xl">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold tracking-[0.25em] text-[#1B5A7A] uppercase">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Jadwal Pemberangkatan Tersedia
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-bold text-slate-900 tracking-tight leading-tight">
                        Paket Tour & Jadwal Ke {{ $country->name }}
                    </h2>
                    <p class="text-sm text-slate-500 font-light">
                        Pilih paket liburan impian Anda dengan jadwal pasti dan fasilitas lengkap bersama Super Vacation.
                    </p>
                </div>

                <a href="{{ route('tour-schedule') }}"
                   wire:navigate
                   class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-[#1B5A7A] hover:text-[#154660] transition group self-start sm:self-auto">
                    <span>Lihat Seluruh Jadwal Mancanegara</span>
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            {{-- Tour Cards Grid (Identical to Tour Schedule Page) --}}
            @if($relatedTours->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($relatedTours as $tour)
                        @php
                            $currentPrice = ((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price) ? $tour->promo_price : $tour->price;
                            $priceData = $parsePrice($currentPrice);
                            $oldPriceData = ((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price) ? $parsePrice($tour->price) : null;
                        @endphp

                        <div onclick="window.location.href='/tour/{{ $tour->slug }}'"
                             class="group bg-white rounded-3xl border border-slate-200/90 shadow-md hover:shadow-2xl hover:shadow-sky-950/15 hover:border-sky-300 transition-all duration-300 flex flex-col overflow-hidden relative cursor-pointer"
                             x-data="{ copied: false }">

                            <!-- 1. Top Season / Header Banner -->
                            <div class="bg-[#E6F0F8] border-b border-sky-100 py-2.5 px-4 text-center font-semibold text-xs sm:text-sm tracking-wider uppercase text-[#1B5A7A] flex items-center justify-center gap-2">
                                <span>{{ $tour->season ? strtoupper($tour->season) . ' SEASON' : 'SUPER VACATION TOUR PACKAGE' }}</span>
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

                                <!-- Top Left Badges: Duration & Departure Status -->
                                <div class="absolute top-3 left-3 flex flex-col gap-1.5 items-start z-10">
                                    <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[11px] font-semibold text-slate-800 shadow-sm border border-white/60 flex items-center gap-1">
                                        ⏱️ {{ $tour->duration }}
                                    </span>
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
                                @if((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price)
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

                                @if($tour->departures && $tour->departures->isNotEmpty())
                                    <div class="text-[#0F355C] font-semibold text-xs sm:text-sm tracking-wider flex items-center justify-center gap-1 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-[#0F355C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        @if($tour->departures->count() === 1)
                                            <span>{{ $tour->departures->first()->start_date->format('d M Y') }}@if($tour->departures->first()->end_date) – {{ $tour->departures->first()->end_date->format('d M Y') }}@endif</span>
                                        @else
                                            <span>{{ $tour->departures->first()->start_date->format('d M Y') }} <span class="bg-[#0F355C] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ml-1">+{{ $tour->departures->count() - 1 }} Other</span></span>
                                        @endif
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
                                    <span class="text-[10px] uppercase font-semibold text-sky-200 tracking-wider block mb-0.5">Start From</span>
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

            @else
                {{-- No Tours Scheduled Yet --}}
                <div class="bg-[#FBFBFA] rounded-3xl border border-slate-200 p-8 sm:p-12 text-center max-w-2xl mx-auto space-y-4">
                    <div class="w-12 h-12 rounded-full bg-sky-50 text-[#1B5A7A] flex items-center justify-center mx-auto text-xl font-bold">
                        ✈
                    </div>
                    <h3 class="text-lg font-serif font-bold text-slate-800">
                        Jadwal Reguler {{ $country->name }} Sedang Disiapkan
                    </h3>
                    <p class="text-sm text-slate-500 font-light leading-relaxed">
                        Kami sedang menyusun paket keberangkatan musim berikutnya untuk {{ $country->name }}. Anda juga dapat memesan paket Private Trip atau Custom Tour sesuai preferensi tanggal dan rombongan Anda.
                    </p>
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode('Halo Super Vacation, saya ingin menanyakan jadwal atau private trip ke ' . $country->name) }}"
                           target="_blank"
                           class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs sm:text-sm transition text-center">
                            Konsultasi via WhatsApp
                        </a>
                        <a href="{{ route('tour-schedule') }}"
                           wire:navigate
                           class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 font-medium text-xs sm:text-sm hover:bg-slate-50 transition text-center">
                            Lihat Jadwal Lainnya
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>

    {{-- ═══ SECTION 3: JELAJAHI NEGARA LAINNYA (1 BARIS 4 CARD) ═══ --}}
    @if($otherCountries->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <span class="text-[11px] font-bold tracking-[0.2em] text-[#1B5A7A] uppercase block mb-1">
                        Destinasi Lainnya
                    </span>
                    <h3 class="text-xl sm:text-2xl font-serif font-bold text-slate-900">
                        Jelajahi Dokumentasi Negara Lain
                    </h3>
                </div>
                <a href="{{ route('gallery') }}" wire:navigate class="text-xs sm:text-sm font-semibold text-[#1B5A7A] hover:underline">
                    Semua Galeri →
                </a>
            </div>

            {{-- 1 BARIS 4 CARD DI DESKTOP --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-7">
                @foreach($otherCountries as $oc)
                    @php
                        $ocFirst = null;
                        foreach ($oc->galleries as $og) {
                            $op = $og->getAllPhotos();
                            if (!empty($op)) { $ocFirst = $op[0]; break; }
                        }
                        $ocCover = $oc->image
                            ? asset('storage/' . $oc->image)
                            : ($ocFirst ? asset('storage/' . $ocFirst) : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80');

                        $ocName = trim($oc->name);
                        $ocTitle = str_starts_with(strtolower($ocName), 'tour') ? $ocName : 'Tour ' . $ocName;
                        $ocSlug = $oc->slug ?: \Illuminate\Support\Str::slug($ocName);
                    @endphp
                    <a href="{{ route('gallery.detail', $ocSlug) }}"
                       wire:navigate
                       style="min-height: 380px; aspect-ratio: 3/4;"
                       class="group relative flex flex-col justify-end w-full h-[380px] sm:h-[400px] rounded-2xl sm:rounded-3xl overflow-hidden bg-neutral-900 shadow-md hover:shadow-2xl transition-all duration-500 cursor-pointer block">

                        <img src="{{ $ocCover }}"
                             alt="{{ $ocName }}"
                             loading="lazy"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" />

                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent pointer-events-none"></div>

                        <div class="relative z-10 p-5 sm:p-6">
                            <h4 class="text-lg sm:text-xl font-bold text-white leading-tight group-hover:text-sky-200 transition-colors mb-1">
                                {{ $ocTitle }}
                            </h4>
                            <p class="text-xs font-medium text-white/80 flex items-center gap-1.5 group-hover:text-white transition-colors">
                                <span>Lihat Jadwal</span>
                                <span class="group-hover:translate-x-1.5 transition-transform duration-300">→</span>
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ═══ FULLSCREEN LIGHTBOX MODAL (RESTORED PREVIOUS LAYOUT WITH CURRENT PERFECT IMAGE SIZING) ═══ --}}
    @teleport('body')
    <div x-show="lightboxOpen" 
         x-cloak
         @click.away="closeLightbox()"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[99999] bg-black/95 backdrop-blur-xl flex flex-col justify-between overflow-hidden select-none">

        <!-- Top Nav -->
        <div class="px-4 sm:px-8 py-3.5 flex items-center justify-between border-b border-white/10 shrink-0 bg-black/40">
            <div class="flex items-center gap-3">
                <div>
                    <h3 class="text-lg sm:text-2xl font-serif font-bold text-white tracking-tight" x-text="countryName"></h3>
                    <p class="text-[11px] text-slate-400 tracking-wider uppercase">Arsip Dokumentasi Wisata</p>
                </div>
                <template x-if="currentPhoto && currentPhoto.is_featured">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-semibold uppercase">
                        ★ Highlight
                    </span>
                </template>
            </div>

            <div class="text-xs font-mono text-slate-300 tracking-widest hidden sm:block">
                <span class="text-white font-bold text-sm" x-text="String(currentIndex + 1).padStart(2, '0')"></span>
                <span class="text-slate-500 mx-1">/</span>
                <span class="text-slate-400" x-text="String(photos.length).padStart(2, '0')"></span>
            </div>

            <div class="flex items-center gap-2.5">
                <!-- Open original image in new tab -->
                <a :href="currentPhoto.image"
                   target="_blank"
                   class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition border border-white/15 cursor-pointer"
                   title="Buka Gambar Asli">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <!-- Close button -->
                <button type="button" 
                        @click="closeLightbox()" 
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition border border-white/15 cursor-pointer"
                        title="Tutup (ESC)">
                    ✕
                </button>
            </div>
        </div>

        <!-- Main Viewport -->
        <div class="relative flex-1 min-h-0 flex items-center justify-center p-3 sm:p-5 overflow-hidden"
             @click.self="closeLightbox()">
            <button type="button" 
                    @click.stop="prevPhoto()" 
                    class="absolute left-3 sm:left-6 z-20 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/50 hover:bg-white/20 text-white flex items-center justify-center transition backdrop-blur-md border border-white/20 cursor-pointer shadow-xl text-lg">
                ‹
            </button>

            <div class="relative max-w-5xl max-h-full flex flex-col items-center justify-center">
                <!-- Gambar Utuh dengan ukuran sekarang (tidak terpotong) -->
                <img :src="currentPhoto.image" 
                     :alt="currentPhoto.title" 
                     style="max-height: calc(100vh - 240px); max-width: min(92vw, 1100px);"
                     class="w-auto h-auto object-contain rounded-xl shadow-2xl transition-all duration-300 block select-none pointer-events-auto" />
                
                <div class="mt-3.5 w-full flex flex-col sm:flex-row items-center justify-between gap-3 bg-white/5 backdrop-blur-md px-4 sm:px-6 py-2.5 rounded-2xl border border-white/10">
                    <div class="space-y-0.5 min-w-0 text-center sm:text-left">
                        <h4 class="text-sm sm:text-base font-serif font-semibold text-white tracking-tight truncate max-w-lg" x-text="currentPhoto.title"></h4>
                        <p class="text-xs text-slate-300 font-sans tracking-wide truncate" x-text="currentPhoto.destination ? currentPhoto.destination : countryName"></p>
                    </div>

                    <a :href="'https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text=' + encodeURIComponent('Halo Super Vacation, saya ingin konsultasi paket wisata dokumentasi: ' + (currentPhoto.title || '') + ' (' + (currentPhoto.destination || countryName) + ').')" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs shadow-md transition shrink-0">
                        <span>Konsultasi Destinasi Ini</span>
                    </a>
                </div>
            </div>

            <button type="button" 
                    @click.stop="nextPhoto()" 
                    class="absolute right-3 sm:right-6 z-20 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/50 hover:bg-white/20 text-white flex items-center justify-center transition backdrop-blur-md border border-white/20 cursor-pointer shadow-xl text-lg">
                ›
            </button>
        </div>

        <!-- Bottom Thumbnail Reel -->
        <div class="px-4 sm:px-8 py-3 bg-black/60 backdrop-blur-md border-t border-white/10 shrink-0">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-center gap-2.5 overflow-x-auto py-1 scroll-smooth">
                    <template x-for="(item, idx) in photos" :key="item.id || idx">
                        <button type="button" 
                                :id="'thumb-' + idx"
                                @click="selectPhoto(idx)"
                                class="relative shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-lg overflow-hidden transition-all duration-200 cursor-pointer border-2"
                                :class="currentIndex === idx ? 'border-white ring-2 ring-white/50 scale-105 opacity-100' : 'border-transparent opacity-40 hover:opacity-80'">
                            <img :src="item.image" 
                                 :alt="item.title" 
                                 class="w-full h-full object-cover" />
                            <template x-if="item.is_featured">
                                <span class="absolute top-1 left-1 w-2 h-2 rounded-full bg-amber-400"></span>
                            </template>
                        </button>
                    </template>
                </div>
            </div>
        </div>

    </div>
    @endteleport

</div>
