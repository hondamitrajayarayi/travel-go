<div class="min-h-screen bg-[#FBFBFA] text-slate-900">

    {{-- ═══ ELEGANT EDITORIAL HEADER (CLEAN & NO SEARCH BAR) ═══ --}}
    <header class="pt-28 pb-10 sm:pb-14 px-4 sm:px-6 lg:px-8 border-b border-slate-200/60 bg-white">
        <div class="max-w-7xl mx-auto">

            <div class="space-y-3 max-w-3xl">
                <span class="inline-flex items-center gap-2 text-[11px] font-bold tracking-[0.25em] text-[#1B5A7A] uppercase">
                    Travel Journal & Portofolio
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-slate-900 tracking-tight leading-[1.15]">
                    Dokumentasi Perjalanan Mancanegara
                </h1>
                <p class="text-sm sm:text-base text-slate-500 leading-relaxed font-light">
                    Jelajahi potret autentik setiap momen berharga bersama Super Vacation. Pilih negara tujuan untuk melihat galeri foto dan jadwal keberangkatan yang tersedia.
                </p>
            </div>

        </div>
    </header>

    {{-- ═══ SECTION 1: DESTINATION CARDS ═══ --}}
    <section class="py-14 sm:py-20 bg-[#FBFBFA]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($countries->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-7">
                    @foreach($countries as $country)
                        @php
                            // 1. Cari cover foto dari country->image, atau foto pertama dari galerinya
                            $firstPhoto = null;
                            if ($country->galleries && $country->galleries->isNotEmpty()) {
                                foreach ($country->galleries as $g) {
                                    $photos = $g->getAllPhotos();
                                    if (!empty($photos)) {
                                        $firstPhoto = $photos[0];
                                        break;
                                    }
                                }
                            }

                            // 2. Fallback foto cover jika tidak ada
                            $coverImg = null;
                            if (!empty($country->image)) {
                                $coverImg = asset('storage/' . $country->image);
                            } elseif ($firstPhoto) {
                                $coverImg = asset('storage/' . $firstPhoto);
                            } else {
                                $coverImg = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80';
                            }

                            // 3. Format judul kartu sesuai referensi gambar (contoh: "Tour Jepang", "Tour Korea", "Tour China")
                            $countryName = trim($country->name);
                            $cardTitle = str_starts_with(strtolower($countryName), 'tour')
                                ? $countryName
                                : 'Tour ' . $countryName;

                            // 4. Slug negara untuk detail
                            $countrySlug = $country->slug ?: \Illuminate\Support\Str::slug($countryName);
                        @endphp

                        {{-- TALL VERTICAL CARD ADOPTED FROM DESTINASI LAINNYA STYLE --}}
                        <a href="{{ route('gallery.detail', $countrySlug) }}"
                           wire:navigate
                           style="min-height: 380px; aspect-ratio: 3/4;"
                           class="group relative flex flex-col justify-end w-full h-[380px] sm:h-[400px] rounded-2xl sm:rounded-3xl overflow-hidden bg-neutral-900 shadow-md hover:shadow-2xl transition-all duration-500 cursor-pointer block">

                            {{-- Full Cover Image --}}
                            <img src="{{ $coverImg }}"
                                 alt="{{ $countryName }}"
                                 loading="lazy"
                                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" />

                            {{-- Subtle Dark Gradient Overlay at Bottom for Perfect Text Readability --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent transition-opacity duration-300 pointer-events-none"></div>

                            {{-- Bottom Card Text --}}
                            <div class="relative z-10 p-5 sm:p-6">
                                <h2 class="text-lg sm:text-xl font-bold text-white leading-tight group-hover:text-sky-200 transition-colors mb-1">
                                    {{ $cardTitle }}
                                </h2>
                                <p class="text-xs font-medium text-white/80 flex items-center gap-1.5 group-hover:text-white transition-colors">
                                    <span>Lihat Jadwal</span>
                                    <span class="group-hover:translate-x-1.5 transition-transform duration-300">→</span>
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

            @else
                {{-- Fallback Empty State --}}
                <div class="py-20 text-center space-y-4 bg-white rounded-3xl border border-slate-200/80 p-8">
                    <p class="text-4xl font-serif text-slate-300">—</p>
                    <h3 class="text-base font-semibold text-slate-700">Belum ada galeri destinasi</h3>
                    <p class="text-sm text-slate-400 max-w-sm mx-auto font-light">
                        Dokumentasi perjalanan mancanegara sedang dalam proses kurasi.
                    </p>
                </div>
            @endif

        </div>
    </section>

    {{-- ═══ SECTION 2: CTA SECTION (SEPARATE DEDICATED SECTION) ═══ --}}
    <section class="bg-white border-t border-slate-200/80 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-[#1B5A7A] text-white overflow-hidden relative p-8 sm:p-12 lg:p-14 shadow-xl">
                <div class="absolute inset-0 opacity-15 pointer-events-none"
                     style="background: radial-gradient(circle at 85% 50%, #6EB5D4 0%, transparent 60%)">
                </div>
                <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                    <div class="space-y-3 max-w-xl">
                        <span class="text-[11px] font-bold tracking-[0.25em] text-sky-200 uppercase">
                            Rencanakan Perjalanan Impian
                        </span>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-bold text-white leading-tight">
                            Punya destinasi impian atau rencana liburan keluarga?
                        </h2>
                        <p class="text-sm text-sky-100/80 leading-relaxed font-light">
                            Konsultasikan langsung dengan travel consultant kami untuk jadwal open trip terbaru atau susun itinerary private trip yang fleksibel.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3.5 shrink-0 w-full sm:w-auto">
                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode('Halo Super Vacation, saya ingin konsultasi paket dan jadwal liburan.') }}"
                           target="_blank"
                           class="px-6 py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-white font-semibold text-sm transition-all duration-200 text-center shadow-lg shadow-emerald-950/20">
                            Chat WhatsApp Kami
                        </a>
                        <a href="{{ route('tour-schedule') }}"
                           wire:navigate
                           class="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/15 border border-white/20 text-white font-medium text-sm transition-all duration-200 text-center">
                            Lihat Seluruh Jadwal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
