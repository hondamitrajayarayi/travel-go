@php
    $galleries = $country->galleries;
    $allPhotos = [];

    foreach ($galleries as $gallery) {
        $photoPaths = $gallery->getAllPhotos();
        foreach ($photoPaths as $idx => $photoPath) {
            $allPhotos[] = [
                'id'          => $gallery->id . '-' . $idx,
                'gallery_id'  => $gallery->id,
                'title'       => $gallery->title,
                'destination' => $gallery->destination ?: $country->name,
                'image'       => asset('storage/' . $photoPath),
                'is_featured' => (bool) $gallery->is_featured,
            ];
        }
    }

    $totalPhotosCount = count($allPhotos);
    $firstPhoto = $allPhotos[0]['image'] ?? null;
    $coverImg = $country->image
        ? asset('storage/' . $country->image)
        : ($firstPhoto ?: asset('images/logo/LOGO HORIZONTAL.png'));

    $hasFeatured = $galleries->contains('is_featured', true);
    $photosJson = json_encode($allPhotos);
@endphp

<div class="group relative bg-white rounded-2xl overflow-hidden cursor-pointer
            border border-slate-200/70 hover:border-slate-300
            shadow-sm hover:shadow-lg
            transition-all duration-400"
     @click="openCountryGallery('{{ addslashes($country->name) }}', {{ $photosJson }})">

    {{-- Cover Image --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-slate-900">
        <img src="{{ $coverImg }}"
             alt="{{ $country->name }}"
             loading="lazy"
             class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-106" />

        {{-- Gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

        {{-- Top right: photo count --}}
        @if($totalPhotosCount > 0)
            <div class="absolute top-3.5 right-3.5 z-10">
                <span class="px-2.5 py-1 rounded-full bg-black/50 backdrop-blur-sm text-white text-[11px] font-medium tracking-wide border border-white/10">
                    {{ $totalPhotosCount }} foto
                </span>
            </div>
        @endif

        {{-- Top left: Highlight badge --}}
        @if($hasFeatured)
            <div class="absolute top-3.5 left-3.5 z-10">
                <span class="px-2.5 py-1 rounded-full bg-amber-500 text-white text-[11px] font-semibold tracking-wide">
                    Pilihan
                </span>
            </div>
        @endif

        {{-- Bottom: Country name --}}
        <div class="absolute bottom-0 left-0 right-0 z-10 p-5">
            <h3 class="text-xl sm:text-2xl font-serif font-bold text-white group-hover:text-sky-100 transition-colors duration-200 leading-tight">
                {{ $country->name }}
            </h3>
            @if($galleries->count() > 0)
                <p class="text-xs text-white/60 mt-0.5 font-medium">
                    {{ $galleries->count() }} {{ $galleries->count() === 1 ? 'dokumentasi' : 'dokumentasi' }}
                </p>
            @endif
        </div>
    </div>

    {{-- Footer strip --}}
    <div class="px-5 py-3.5 flex items-center justify-between bg-white border-t border-slate-100">
        <span class="text-xs text-slate-400 font-medium">Klik untuk membuka galeri</span>
        <svg class="w-4 h-4 text-slate-400 group-hover:text-[#1B5A7A] group-hover:translate-x-1 transition-all duration-200"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    </div>

</div>
