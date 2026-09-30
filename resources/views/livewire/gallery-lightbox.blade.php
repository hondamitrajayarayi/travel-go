@teleport('body')
<div x-show="modalOpen" 
     x-cloak
     @click.away="closeModal()"
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

        <div class="flex items-center gap-3">
            <button type="button" 
                    @click="closeModal()" 
                    class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition border border-white/15 cursor-pointer">
                ✕
            </button>
        </div>
    </div>

    <!-- Main Viewport -->
    <div class="relative flex-1 flex items-center justify-center p-3 sm:p-6 overflow-hidden">
        <button type="button" 
                @click="prevPhoto()" 
                class="absolute left-3 sm:left-6 z-20 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/50 hover:bg-white/20 text-white flex items-center justify-center transition backdrop-blur-md border border-white/20 cursor-pointer shadow-xl text-lg">
            ‹
        </button>

        <div class="relative max-w-5xl max-h-full flex flex-col items-center justify-center">
            <img :src="currentPhoto.image" 
                 :alt="currentPhoto.title" 
                 class="max-h-[58vh] sm:max-h-[64vh] w-auto max-w-full object-contain rounded-xl shadow-2xl transition-all duration-300" />
            
            <div class="mt-3.5 w-full flex flex-col sm:flex-row items-center justify-between gap-3 bg-white/5 backdrop-blur-md px-4 sm:px-6 py-2.5 rounded-2xl border border-white/10">
                <div class="space-y-0.5 min-w-0 text-center sm:text-left">
                    <h4 class="text-sm sm:text-base font-serif font-semibold text-white tracking-tight truncate" x-text="currentPhoto.title"></h4>
                    <p class="text-xs text-slate-300 font-sans tracking-wide truncate" x-text="currentPhoto.destination"></p>
                </div>

                <a :href="'https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text=' + encodeURIComponent('Halo Super Vacation, saya ingin konsultasi paket wisata dokumentasi: ' + (currentPhoto.title || '') + ' (' + (currentPhoto.destination || countryName) + ').')" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs shadow-md transition shrink-0">
                    <span>Konsultasi Destinasi Ini</span>
                </a>
            </div>
        </div>

        <button type="button" 
                @click="nextPhoto()" 
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
