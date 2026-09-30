@php
    $departuresList = $tour->departures->map(function($d) {
        $dLabel = $d->start_date->format('d M Y') . ($d->end_date ? ' – ' . $d->end_date->format('d M Y') : '');
        return [
            'id'           => (string)$d->id,
            'label'        => $dLabel,
            'start_date'   => $d->start_date->format('d M Y'),
            'end_date'     => $d->end_date ? $d->end_date->format('d M Y') : null,
            'status'       => $d->status ?: 'Tour Package Ready',
            'status_color' => $d->status_color ?: 'green',
        ];
    })->values()->all();

    $initialDep = !empty($departuresList) ? $departuresList[0] : null;
    $initialDate = $initialDep ? $initialDep['label'] : ($tour->start_date ? $tour->start_date->format('d M Y') . ($tour->end_date ? ' – ' . $tour->end_date->format('d M Y') : '') : 'Jadwal Fleksibel');
    $initialStatus = $initialDep ? $initialDep['status'] : 'Tour Package Ready';
    $initialColor = $initialDep ? $initialDep['status_color'] : 'green';

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

    $currentPrice = ((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price) ? $tour->promo_price : $tour->price;
    $priceData = $parsePrice($currentPrice);
    $oldPriceData = ((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price) ? $parsePrice($tour->price) : null;
    $includes = $tour->facilities->where('type', 'include');
    $excludes = $tour->facilities->where('type', 'exclude');
@endphp

<div class="pt-20 pb-20 bg-slate-50 min-h-screen text-slate-800" 
     x-data="{ 
         activeImage: '{{ $tour->thumbnail ? asset('storage/' . $tour->thumbnail) : '' }}', 
         copied: false,
         departures: {{ json_encode($departuresList) }},
         selectedDepId: '{{ $initialDep ? $initialDep['id'] : '' }}',
         selectedDate: '{{ $initialDate }}',
         selectedStatus: '{{ $initialStatus }}',
         selectedColor: '{{ $initialColor }}',
         onDepartureChange(id) {
             const found = this.departures.find(d => String(d.id) === String(id));
             if (found) {
                 this.selectedDepId = String(found.id);
                 this.selectedDate = found.label;
                 this.selectedStatus = found.status;
                 this.selectedColor = found.status_color;
             }
         }
     }">

    {{-- ===== JSON-LD STRUCTURED DATA (SEO Rich Snippets untuk Google) ===== --}}
    @once
    @php
        $seoTourTitle = $tour->meta_title ?: $tour->title;
        $seoTourDesc  = strip_tags($tour->meta_description ?: substr($tour->description ?? '', 0, 300));
        $seoTourImage = $tour->og_image ?: ($tour->thumbnail ? asset('storage/' . $tour->thumbnail) : '');
        $seoTourPrice = (int) (((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price) ? $tour->promo_price : $tour->price);
        $seoTourUrl   = request()->url();

        $additionalProps = [
            ['@type' => 'PropertyValue', 'name' => 'Durasi', 'value' => $tour->duration],
        ];
        if ($tour->destination) {
            $additionalProps[] = ['@type' => 'PropertyValue', 'name' => 'Destinasi', 'value' => $tour->destination];
        }
        if ($tour->season) {
            $additionalProps[] = ['@type' => 'PropertyValue', 'name' => 'Musim', 'value' => $tour->season];
        }
        if ($tour->departures && $tour->departures->isNotEmpty()) {
            $datesStr = $tour->departures->map(fn($d) => $d->start_date->format('d M Y'))->join(', ');
            $additionalProps[] = ['@type' => 'PropertyValue', 'name' => 'Tanggal Berangkat', 'value' => $datesStr];
        } elseif ($tour->start_date) {
            $additionalProps[] = ['@type' => 'PropertyValue', 'name' => 'Tanggal Berangkat', 'value' => $tour->start_date->format('d M Y')];
        }
        if ($tour->country) {
            $additionalProps[] = ['@type' => 'PropertyValue', 'name' => 'Negara', 'value' => $tour->country->name];
        }

        $productSchema = [
            '@context'           => 'https://schema.org',
            '@type'              => 'Product',
            'name'               => $seoTourTitle,
            'description'        => $seoTourDesc,
            'image'              => $seoTourImage,
            'url'                => $seoTourUrl,
            'brand'              => ['@type' => 'Brand', 'name' => 'Super Vacation'],
            'offers'             => [
                '@type'          => 'Offer',
                'priceCurrency'  => 'IDR',
                'price'          => $seoTourPrice,
                'availability'   => 'https://schema.org/InStock',
                'url'            => $seoTourUrl,
                'seller'         => ['@type' => 'Organization', 'name' => 'Super Vacation'],
            ],
            'category'           => 'Paket Wisata' . ($tour->country ? ' ' . $tour->country->name : ''),
            'additionalProperty' => $additionalProps,
        ];

        $breadcrumbSchema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',       'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Paket Tour', 'item' => url('/tour-schedule')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $seoTourTitle,'item' => $seoTourUrl],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($productSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
    <script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
    @endonce

    <!-- 1. HERO HEADER BANNER (CLEAN, MINIMALIST & EDITORIAL) -->
    <section class="pt-8 pb-8 sm:pt-12 sm:pb-10 bg-white border-b border-slate-100 mb-8 sm:mb-10"
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 50)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <!-- Breadcrumbs Navigation -->
            <div :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'" 
                 class="transition-all duration-700 ease-out">
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-[#1B5A7A] transition">Home</a>
                    <span class="text-slate-300">/</span>
                    <a href="{{ route('tour-schedule') }}" wire:navigate class="hover:text-[#1B5A7A] transition">Jadwal Tour</a>
                    @if($tour->country)
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-600">{{ $tour->country->name }}</span>
                    @endif
                    <span class="text-slate-300">/</span>
                    <span class="text-slate-900 truncate max-w-[200px] sm:max-w-md">{{ $tour->title }}</span>
                </nav>
            </div>

            <!-- Category & Title -->
            <div :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'" 
                 class="transition-all duration-700 delay-100 ease-out space-y-2 pt-1">
                <!-- Clean Category Subtitle -->
                <span class="text-xs font-bold tracking-[0.2em] text-[#1B5A7A] uppercase block">
                    {{ $tour->country->name ?? 'PAKET WISATA' }} · {{ $tour->duration }}
                    @if($tour->season) · {{ strtoupper($tour->season) }} SEASON @endif
                </span>

                <!-- Main Editorial Title -->
                <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-[-0.025em] text-slate-900 leading-[1.18] max-w-5xl">
                    {{ $tour->title }}
                </h1>
            </div>

            <!-- Clean Metadata Info Strip (Rapi, Terstruktur, Dropdown Select Tanggal & Status Terupdate) -->
            <div :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'" 
                 class="transition-all duration-700 delay-200 ease-out flex flex-wrap items-center gap-y-4 gap-x-8 pt-5 border-t border-slate-100 text-xs sm:text-sm">
                <div class="flex-1 min-w-[280px] sm:min-w-[340px] max-w-md">
                    <label for="departure_select" class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1.5">Pilih Tanggal Keberangkatan</label>
                    @if($tour->departures && $tour->departures->count() > 1)
                        <div class="relative w-full">
                            <select id="departure_select" 
                                    x-model="selectedDepId" 
                                    @change="onDepartureChange($event.target.value)"
                                    class="appearance-none w-full bg-sky-50/90 hover:bg-sky-100/90 border border-sky-200 text-slate-900 font-bold rounded-xl text-xs sm:text-sm pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] focus:border-[#1B5A7A] transition cursor-pointer shadow-xs">
                                @foreach($tour->departures as $dep)
                                    <option value="{{ $dep->id }}">
                                        {{ $dep->start_date->format('d M Y') }}@if($dep->end_date) – {{ $dep->end_date->format('d M Y') }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#1B5A7A]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    @elseif($tour->departures && $tour->departures->count() === 1)
                        <span class="font-bold text-slate-800 text-sm">
                            {{ $tour->departures->first()->start_date->format('d M Y') }}@if($tour->departures->first()->end_date) – {{ $tour->departures->first()->end_date->format('d M Y') }}@endif
                        </span>
                    @elseif($tour->start_date)
                        <span class="font-bold text-slate-800 text-sm">
                            {{ $tour->start_date->format('d M Y') }}@if($tour->end_date) – {{ $tour->end_date->format('d M Y') }}@endif
                        </span>
                    @else
                        <span class="font-bold text-slate-800 text-sm">Jadwal Fleksibel</span>
                    @endif
                </div>

                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>

                <div>
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Rute & Destinasi</span>
                    <span class="font-bold text-slate-800">{{ $tour->destination }}</span>
                </div>

                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>

                <div>
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Durasi Trip</span>
                    <span class="font-bold text-slate-800">{{ $tour->duration }}</span>
                </div>

                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>

                <div>
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Status Kuota</span>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full animate-pulse shrink-0"
                              :class="{
                                  'bg-rose-500': selectedColor === 'red',
                                  'bg-amber-500': selectedColor === 'orange',
                                  'bg-emerald-500': selectedColor === 'green' || !['red','orange'].includes(selectedColor)
                              }"></span>
                        <span class="font-bold text-xs sm:text-sm"
                              :class="{
                                  'text-rose-600': selectedColor === 'red',
                                  'text-amber-600': selectedColor === 'orange',
                                  'text-emerald-600': selectedColor === 'green' || !['red','orange'].includes(selectedColor)
                              }"
                              x-text="selectedStatus">
                            {{ $initialStatus }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. MAIN CONTAINER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- 3. TOP MEDIA & BOOKING SIDEBAR GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: FEATURED PHOTO WITH OVERLAID DESTINATION NAME & THUMBNAILS (Col-span 8) -->
            <div class="lg:col-span-8 space-y-4">
                
                <!-- BINGKAI FOTO MEWAH DENGAN OVERLAY BERSIH & ELEGAN -->
                <div class="relative h-80 sm:h-[480px] lg:h-[520px] rounded-3xl overflow-hidden bg-slate-900 shadow-2xl border border-slate-200/90 group">
                    
                    <!-- Foto Utama -->
                    <template x-if="activeImage">
                        <img :src="activeImage" alt="{{ $tour->title }}" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105" />
                    </template>
                    <template x-if="!activeImage">
                        <div class="w-full h-full bg-slate-800 flex flex-col items-center justify-center text-slate-400 p-6">
                            <svg class="w-16 h-16 mb-2 text-slate-600 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs uppercase font-semibold tracking-wider">Foto Belum Tersedia</span>
                        </div>
                    </template>

                    <!-- Cinematic Vignette & Dark Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent pointer-events-none"></div>

                    <!-- Top Left Promo Badge -->
                    @if((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price)
                        <div class="absolute top-5 left-5 z-10">
                            <span class="px-4 py-1.5 rounded-full bg-[#0055D4] text-white font-bold text-xs shadow-lg border border-white/20 uppercase tracking-wider">
                                PROMO DISKON HARGA
                            </span>
                        </div>
                    @endif

                    <!-- Caption Destinasi di Bagian Bawah Foto (Elegan, Tidak Berlebihan) -->
                    <div class="absolute bottom-6 left-6 right-6 sm:bottom-8 sm:left-8 sm:right-8 z-10 text-white flex items-end justify-between">
                        <div>
                            <span class="text-[11px] font-bold tracking-[0.2em] text-sky-300 uppercase block mb-1">
                                {{ $tour->country ? $tour->country->name : 'DESTINASI' }}
                            </span>
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold uppercase tracking-wide text-white drop-shadow-md leading-tight">
                                {{ $tour->destination }}
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Thumbnail Navigation Carousel Grid -->
                @if($tour->galleries->count() > 0)
                    <div class="flex items-center gap-3 overflow-x-auto pb-2 custom-scrollbar">
                        @if($tour->thumbnail)
                            <button type="button" 
                                    @click="activeImage = '{{ asset('storage/' . $tour->thumbnail) }}'" 
                                    :class="activeImage === '{{ asset('storage/' . $tour->thumbnail) }}' ? 'ring-2 ring-[#1B5A7A] scale-105 opacity-100 shadow-md' : 'opacity-70 hover:opacity-100'"
                                    class="w-20 h-16 sm:w-24 sm:h-20 rounded-2xl overflow-hidden shrink-0 transition-all duration-200 cursor-pointer bg-slate-200 border border-slate-200">
                                <img src="{{ asset('storage/' . $tour->thumbnail) }}" alt="Thumbnail Utama" class="w-full h-full object-cover" />
                            </button>
                        @endif

                        @foreach($tour->galleries as $gal)
                            <button type="button" 
                                    @click="activeImage = '{{ asset('storage/' . $gal->image_path) }}'" 
                                    :class="activeImage === '{{ asset('storage/' . $gal->image_path) }}' ? 'ring-2 ring-[#1B5A7A] scale-105 opacity-100 shadow-md' : 'opacity-70 hover:opacity-100'"
                                    class="w-20 h-16 sm:w-24 sm:h-20 rounded-2xl overflow-hidden shrink-0 transition-all duration-200 cursor-pointer bg-slate-200 border border-slate-200">
                                <img src="{{ asset('storage/' . $gal->image_path) }}" alt="Galeri {{ $loop->iteration }}" class="w-full h-full object-cover" />
                            </button>
                        @endforeach
                    </div>
                @endif

            </div>

            <!-- RIGHT COLUMN: STICKY BOOKING CARD SIDEBAR (Col-span 4) -->
            <div class="lg:col-span-4 sticky top-28 space-y-6">
                
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl p-6 space-y-6">
                    
                    <div class="p-5 rounded-2xl bg-gradient-to-br from-[#1B5A7A] to-[#0F355C] text-white space-y-2 relative overflow-hidden shadow-inner">
                        <span class="text-[11px] font-semibold text-sky-200 uppercase tracking-wider block">Harga Mulai Dari / Pax</span>
                        
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl sm:text-4xl font-semibold tracking-tight text-white">
                                Rp {{ number_format($currentPrice, 0, ',', '.') }}
                            </span>
                        </div>

                        @if((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price)
                            <div class="text-xs text-sky-200/80 line-through font-medium">
                                Rp {{ number_format($tour->price, 0, ',', '.') }}
                            </div>
                        @endif

                        <span class="text-[10px] text-sky-200 font-medium block">
                            *Harga nett per orang
                        </span>
                    </div>

                    <div class="space-y-3 text-xs text-slate-700">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jadwal Keberangkatan Terpilih</span>
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-bold text-slate-900 text-xs sm:text-sm" x-text="selectedDate">
                                    {{ $initialDate }}
                                </span>
                                <span class="text-[10px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider border shrink-0"
                                      :class="{
                                          'bg-rose-50 text-rose-700 border-rose-200': selectedColor === 'red',
                                          'bg-amber-50 text-amber-800 border-amber-200': selectedColor === 'orange',
                                          'bg-emerald-50 text-emerald-800 border-emerald-200': selectedColor === 'green' || !['red','orange'].includes(selectedColor)
                                      }"
                                      x-text="selectedStatus">
                                    {{ $initialStatus }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <a :href="'https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text=' + encodeURIComponent('Halo Super Vacation, saya berminat untuk memesan paket tour: {{ $tour->title }}' + (selectedDate ? ' (Jadwal: ' + selectedDate + ' - ' + selectedStatus + ')' : '') + ' (Harga: Rp {{ number_format($currentPrice, 0, ',', '.') }})')" 
                           target="_blank" 
                           class="w-full flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg hover:shadow-xl transition-all duration-200 active:scale-95 cursor-pointer">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Pesan via WhatsApp</span>
                        </a>

                        @if($tour->file_itinerary)
                            <a href="{{ asset('storage/' . $tour->file_itinerary) }}" 
                               target="_blank" 
                               class="w-full flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-sky-50 border border-sky-200 text-[#1B5A7A] hover:bg-[#1B5A7A] hover:text-white font-semibold text-xs transition duration-200 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Unduh Broshur / PDF Itinerary</span>
                            </a>
                        @endif

                        <button type="button" 
                                @click="
                                    if (navigator.share) {
                                        navigator.share({ title: '{{ $tour->title }}', url: '{{ url()->current() }}' });
                                    } else {
                                        navigator.clipboard.writeText('{{ url()->current() }}');
                                        copied = true;
                                        setTimeout(() => copied = false, 2000);
                                    }
                                " 
                                class="w-full flex items-center justify-center gap-2 px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            <span x-text="copied ? 'Link Paket Tersalin!' : 'Bagikan Paket Ini'"></span>
                        </button>
                    </div>

                </div>

                <div class="p-5 rounded-3xl bg-slate-900 text-white space-y-3 shadow-md">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-semibold shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-xs text-white">Konsultasi Gratis</h4>
                            <p class="text-[11px] text-slate-400">Tanyakan detail itinerary, ketersediaan grup & custom trip dengan tim kami.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- 4. SUB-NAV SECTION JUMPER CARD -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-2.5 shadow-sm flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2 overflow-x-auto custom-scrollbar py-1">
                <a href="#itinerary-section" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold bg-[#1B5A7A] text-white shadow-xs hover:bg-[#0F355C] transition whitespace-nowrap">
                    Itinerary Harian
                </a>
                <a href="#facilities-section" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 hover:text-[#1B5A7A] hover:bg-slate-100 transition whitespace-nowrap">
                    Fasilitas Include & Exclude
                </a>
            </div>

            @if($tour->file_itinerary)
                <a href="{{ asset('storage/' . $tour->file_itinerary) }}" target="_blank" class="text-xs font-bold text-[#1B5A7A] hover:underline px-3 hidden sm:inline-flex items-center gap-1">
                    <span>Unduh Brosur PDF</span>
                    <span>➔</span>
                </a>
            @endif
        </div>

        <!-- 5. SECTION: DAILY ITINERARY (EXACT AVENIR TRAVEL REFERENCE LAYOUT) -->
        <section id="itinerary-section" class="scroll-mt-28 pt-2">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12 items-start">
                
                <!-- LEFT HEADER & METADATA (Col-span 4 out of 12) - EXACT MATCH WITH AVENIR SCREENSHOT -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="space-y-3">
                        <span class="text-[11px] font-bold text-[#1B5A7A] uppercase tracking-[0.2em] block">
                            DAILY ITINERARY
                        </span>
                        
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                            {{ $tour->destination }}, hari per hari
                        </h2>
                    </div>

                    <div class="border-t border-slate-200 pt-6 space-y-4">
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Rencana perjalanan lengkap dan terstruktur hari demi hari untuk memastikan liburan Anda nyaman, aman, dan berkesan bersama Super Vacation.
                        </p>
                        @if($tour->file_itinerary)
                            <a href="{{ asset('storage/' . $tour->file_itinerary) }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-[#1B5A7A] hover:underline pt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Unduh Itinerary Lengkap (PDF)</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- RIGHT CARDS STACK (Col-span 8 out of 12) - EXACT MATCH WITH AVENIR SCREENSHOT -->
                <div class="lg:col-span-8 space-y-5">
                    @if($tour->itineraries->count() > 0)
                        @foreach($tour->itineraries->sortBy('day_number') as $itin)
                            <div x-data="{ expanded: true }" class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-8 shadow-xs space-y-4 transition hover:border-slate-300">
                                <!-- Card Header -->
                                <button type="button" 
                                        @click="expanded = !expanded" 
                                        class="w-full flex items-start justify-between gap-4 text-left group cursor-pointer">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3">
                                            <span class="text-lg sm:text-xl font-bold text-[#1B5A7A]">
                                                Day {{ sprintf('%02d', $itin->day_number) }}
                                            </span>
                                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 group-hover:text-[#1B5A7A] transition-colors">
                                                {{ $itin->title }}
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-slate-500 group-hover:bg-[#1B5A7A] group-hover:text-white transition">
                                        <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>

                                <!-- Day Content -->
                                <div x-show="expanded" x-transition class="pt-2 border-t border-slate-100 text-slate-600 text-xs sm:text-sm leading-relaxed space-y-3">
                                    <div class="prose prose-slate max-w-none text-xs sm:text-sm leading-relaxed prose-p:text-slate-600 prose-ul:list-disc">
                                        {!! $itin->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-white rounded-3xl border border-slate-200 p-8 text-center text-slate-400 text-xs font-semibold uppercase tracking-wider">
                            Rincian itinerary harian akan disampaikan langsung oleh tim tour consultant.
                        </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- 7. SECTION: FASILITAS INCLUDE & EXCLUDE -->
        <section id="facilities-section" class="scroll-mt-28 pt-8 border-t border-slate-200">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-4 space-y-2">
                    <span class="text-[11px] font-bold text-[#1B5A7A] uppercase tracking-[0.2em] block">
                        FASILITAS PAKET
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        Include & Exclude Tour
                    </h2>
                </div>

                <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Include Card -->
                    <div class="bg-white rounded-3xl border border-slate-200/90 p-6 space-y-4 shadow-xs">
                        <div class="flex items-center gap-2 pb-3 border-b border-slate-100 text-emerald-800 font-extrabold text-sm sm:text-base">
                            <span class="w-6 h-6 rounded-md bg-emerald-100 flex items-center justify-center text-emerald-600 font-semibold text-xs">✓</span>
                            <span>Termasuk Paket (Include)</span>
                        </div>
                        
                        @if($includes->count() > 0)
                            <ul class="space-y-3 text-xs sm:text-sm text-slate-700">
                                @foreach($includes as $inc)
                                    <li class="flex items-start gap-2.5">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="font-medium leading-relaxed">{{ $inc->description }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-xs text-slate-400 font-medium italic">Fasilitas terlampir sesuai konfirmasi pemesanan.</p>
                        @endif
                    </div>

                    <!-- Exclude Card -->
                    <div class="bg-white rounded-3xl border border-slate-200/90 p-6 space-y-4 shadow-xs">
                        <div class="flex items-center gap-2 pb-3 border-b border-slate-100 text-rose-800 font-extrabold text-sm sm:text-base">
                            <span class="w-6 h-6 rounded-md bg-rose-100 flex items-center justify-center text-rose-600 font-semibold text-xs">✕</span>
                            <span>Tidak Termasuk (Exclude)</span>
                        </div>

                        @if($excludes->count() > 0)
                            <ul class="space-y-3 text-xs sm:text-sm text-slate-700">
                                @foreach($excludes as $exc)
                                    <li class="flex items-start gap-2.5">
                                        <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span class="font-medium leading-relaxed">{{ $exc->description }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-xs text-slate-400 font-medium italic">Pengeluaran pribadi & pembuatan paspor belum termasuk.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. RELATED TOURS SECTION (RECOMMENDED TRIPS) -->
        @if($relatedTours->count() > 0)
            <div class="pt-12 border-t border-slate-200 space-y-8">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-semibold text-[#1B5A7A] uppercase tracking-wider block">Rekomendasi Lainnya</span>
                        <h3 class="font-display text-2xl sm:text-3xl font-extrabold text-slate-900">
                            Paket Tour Serupa
                        </h3>
                    </div>
                    <a href="{{ route('tour-schedule') }}" wire:navigate class="text-xs font-extrabold text-[#1B5A7A] hover:underline">
                        Lihat Semua ➔
                    </a>
                </div>

                <!-- 3 Card Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedTours as $relTour)
                        @php
                            $relCurrentPrice = ($relTour->promo_price && $relTour->promo_price < $relTour->price) ? $relTour->promo_price : $relTour->price;
                            $relPriceData = $parsePrice($relCurrentPrice);
                            $relOldPriceData = ($relTour->promo_price && $relTour->promo_price < $relTour->price) ? $parsePrice($relTour->price) : null;
                        @endphp

                        <div onclick="window.location.href='/tour/{{ $relTour->slug }}'" 
                             class="group bg-white rounded-3xl border border-slate-200/90 shadow-md hover:shadow-2xl hover:shadow-sky-950/15 hover:border-sky-300 transition-all duration-300 flex flex-col overflow-hidden relative cursor-pointer">
                            
                            <div class="bg-[#E6F0F8] border-b border-sky-100 py-2.5 px-4 text-center font-semibold text-xs sm:text-sm tracking-wider uppercase text-[#1B5A7A]">
                                {{ $relTour->season ? strtoupper($relTour->season) . ' SEASON' : 'SUPER VACATION TOUR' }}
                            </div>

                            <div class="relative h-56 overflow-hidden bg-slate-100">
                                @if($relTour->thumbnail)
                                    <img src="{{ asset('storage/' . $relTour->thumbnail) }}" alt="{{ $relTour->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 font-semibold text-xs">Foto Belum Tersedia</div>
                                @endif

                                <div class="absolute top-3 left-3 z-10">
                                    <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[11px] font-semibold text-slate-800 shadow-sm border border-white/60">
                                        {{ $relTour->duration }}
                                    </span>
                                </div>
                            </div>

                            <div class="bg-[#FA9E0B] p-4 text-center space-y-1.5 flex-1 flex flex-col justify-center items-center">
                                <h3 class="font-semibold text-white text-base uppercase tracking-wide leading-tight line-clamp-2">
                                    {{ $relTour->title }}
                                </h3>
                                @if($relTour->departures && $relTour->departures->isNotEmpty())
                                    <div class="text-[#0F355C] font-semibold text-xs flex items-center justify-center gap-1">
                                        <span>{{ $relTour->departures->first()->start_date->format('d M Y') }}@if($relTour->departures->count() > 1) (+{{ $relTour->departures->count() - 1 }})@endif</span>
                                    </div>
                                @elseif($relTour->start_date)
                                    <div class="text-[#0F355C] font-semibold text-xs flex items-center justify-center gap-1">
                                        <span>{{ $relTour->start_date->format('d M Y') }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="bg-[#1B5A7A] p-4 text-white flex items-center justify-between gap-3 shrink-0">
                                <div class="flex-1 min-w-0">
                                    <span class="text-[10px] uppercase font-semibold text-sky-200 tracking-wider block">Destinasi</span>
                                    <p class="font-semibold text-xs text-white line-clamp-1 uppercase leading-tight">
                                        {{ $relTour->destination }}
                                    </p>
                                </div>

                                <div class="text-right shrink-0">
                                    @if($relOldPriceData)
                                        <span class="text-[10px] text-white/70 line-through block leading-none">
                                            {{ $relOldPriceData['num'] }} {{ $relOldPriceData['unit'] }}
                                        </span>
                                    @endif
                                    <div class="text-xl font-semibold text-white leading-none">
                                        {{ $relPriceData['num'] }}
                                    </div>
                                    <span class="text-[9px] font-semibold text-sky-100 uppercase block">
                                        {{ $relPriceData['unit'] }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <!-- 9. FLOATING QUICK-JUMP SECTION NAVIGATOR BUTTON (BOTTOM LEFT ACCESSIBLE ANYWHERE) -->
    <div x-data="{ open: false }" class="fixed bottom-20 left-4 z-40 sm:bottom-8 sm:left-8">
        
        <!-- Popup Menu Sheet -->
        <div x-show="open" 
             @click.away="open = false" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
             x-cloak
             class="absolute bottom-14 left-0 w-64 bg-white rounded-2xl border border-slate-200 shadow-2xl p-3 space-y-1 text-slate-800">
            
            <div class="flex items-center justify-between px-3 py-1.5 border-b border-slate-100 mb-1">
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                    Navigasi Cepat Halaman
                </span>
                <button type="button" @click="open = false" class="text-slate-400 hover:text-slate-600 text-xs font-bold">✕</button>
            </div>

            <a href="#itinerary-section" @click="open = false" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-[#1B5A7A] transition">
                <span>Itinerary Harian</span>
                <span class="text-[10px] bg-sky-100 text-[#1B5A7A] px-2 py-0.5 rounded-full font-bold">{{ $tour->itineraries->count() }} Hari</span>
            </a>

            <a href="#facilities-section" @click="open = false" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-[#1B5A7A] transition">
                <span>Fasilitas Include/Exclude</span>
                <span class="text-slate-400">→</span>
            </a>

            @if($tour->file_itinerary)
                <div class="border-t border-slate-100 pt-1.5 mt-1">
                    <a href="{{ asset('storage/' . $tour->file_itinerary) }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-[#1B5A7A] bg-sky-50 hover:bg-sky-100 transition">
                        <span>Unduh Brosur PDF</span>
                        <span>→</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Floating Action Button (FAB) -->
        <button type="button" 
                @click="open = !open" 
                class="flex items-center gap-2 px-4 py-3 rounded-full bg-[#1B5A7A] hover:bg-[#0F355C] text-white font-extrabold text-xs shadow-xl hover:shadow-2xl transition-all duration-200 active:scale-95 cursor-pointer border-2 border-white">
            <svg class="w-4 h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            <span class="hidden sm:inline">Navigasi Halaman</span>
            <span class="sm:hidden">Menu</span>
        </button>
    </div>

    <!-- 10. FIXED MOBILE BOTTOM BOOKING CTA BAR -->
    <div class="fixed bottom-0 inset-x-0 bg-white border-t border-slate-200 px-5 py-3 z-50 lg:hidden shadow-2xl flex items-center justify-between gap-4">
        <div>
            <span class="text-[10px] text-slate-400 font-semibold block uppercase tracking-wider">Harga Per Pax</span>
            <div class="text-xl font-extrabold text-[#1B5A7A] leading-tight">
                Rp {{ number_format($currentPrice, 0, ',', '.') }}
            </div>
            @if((float)$tour->promo_price > 0 && (float)$tour->promo_price < (float)$tour->price)
                <span class="text-xs text-slate-400 line-through font-medium block">
                    Rp {{ number_format($tour->price, 0, ',', '.') }}
                </span>
            @endif
        </div>

        <a :href="'https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text=' + encodeURIComponent('Halo Super Vacation, saya berminat dengan paket tour: {{ $tour->title }}' + (selectedDate ? ' (Jadwal: ' + selectedDate + ' - ' + selectedStatus + ')' : '') + ' (Harga: Rp {{ number_format($currentPrice, 0, ',', '.') }})')" 
           target="_blank" 
           class="w-12 h-12 rounded-2xl bg-[#25D366] hover:bg-[#20bd5a] text-white shadow-lg shadow-emerald-500/25 flex items-center justify-center transition-all duration-200 active:scale-95 cursor-pointer shrink-0"
           title="Pesan via WhatsApp">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
        </a>
    </div>

</div>
