@include('livewire.gallery-lightbox')

    <!-- Main Viewport: Hero Image Stage -->
    <div class="relative flex-1 flex items-center justify-center p-3 sm:p-6 overflow-hidden">
            
        <!-- Previous Button -->
        <button type="button" 
                @click="prevPhoto()" 
                class="absolute left-3 sm:left-6 z-20 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/50 hover:bg-white/20 text-white flex items-center justify-center transition-all duration-200 backdrop-blur-md border border-white/20 hover:scale-105 cursor-pointer shadow-xl focus:outline-none"
                aria-label="Foto sebelumnya">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <div class="relative max-w-5xl max-h-full flex flex-col items-center justify-center">
                <img :src="currentPhoto.image" 
                     :alt="currentPhoto.title" 
                     class="max-h-[58vh] sm:max-h-[64vh] w-auto max-w-full object-contain rounded-xl shadow-2xl transition-all duration-300" />



            <!-- Metadata & WA Action Bar -->
            <div class="mt-3.5 sm:mt-4 w-full flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left bg-white/5 backdrop-blur-md px-4 sm:px-6 py-2.5 rounded-2xl border border-white/10">
                <div class="space-y-0.5 min-w-0">
                    <h4 class="text-sm sm:text-base font-serif font-semibold text-slate-900 tracking-tight truncate" x-text="currentPhoto.title"></h4>
                    <p class="text-xs text-slate-700 font-sans tracking-wide truncate" x-text="currentPhoto.destination"></p>
                </div>

                <a :href="'https://wa.me/{{ \App\Models\Setting::get(\'whatsapp_number\', \'6287887840636\') }}?text=' + encodeURIComponent('Halo Super Vacation, saya ingin konsultasi paket wisata seperti dokumentasi: ' + (currentPhoto.title || '') + ' (' + (currentPhoto.destination || countryName) + ').')" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-xs shadow-md transition-all duration-200 shrink-0">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.586 1.884.878 2.796.879 3.182 0 5.768-2.587 5.768-5.766.001-3.181-2.585-5.766-5.768-5.766zm9.969 5.766c0 5.514-4.486 10-10 10-1.748 0-3.385-.45-4.818-1.238l-7.182 1.882 1.914-6.994c-.886-1.488-1.396-3.228-1.396-5.086 0-5.514 4.486-10 10-10s10 4.486 10 10z"/>
                    </svg>
                    <span>Konsultasi Destinasi Ini</span>
                </a>
            </div>
        </div>

        <!-- Next Button -->
        <button type="button" 
                @click="nextPhoto()" 
                class="absolute right-3 sm:right-6 z-20 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/50 hover:bg-white/20 text-white flex items-center justify-center transition-all duration-200 backdrop-blur-md border border-white/20 hover:scale-105 cursor-pointer shadow-xl focus:outline-none"
                aria-label="Foto selanjutnya">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

    </div>


                    ❯
                </button>

                <!-- Overlay Destination Badge -->
                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between gap-2 pointer-events-none">
                    <span class="px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-sky-200 text-xs font-semibold border border-white/10">
                        📍 <span x-text="currentPhoto.destination"></span>
                    </span>

                    <span class="px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-amber-300 text-xs font-bold border border-white/10">
                        ⭐ <span x-text="currentPhoto.rating || 5"></span>.0
                    </span>
                </div>
            </div>

            <!-- Photo Story & Testimonial Details -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs space-y-4">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div class="space-y-1 flex-1">
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug" x-text="currentPhoto.title"></h3>
                        <div class="flex items-center gap-3 text-xs text-slate-500 font-medium flex-wrap">
                            <span>Peserta: <strong class="text-slate-800" x-text="currentPhoto.customer_name"></strong></span>
                            <span>•</span>
                            <span>Waktu: <strong class="text-slate-800" x-text="currentPhoto.trip_date"></strong></span>
                        </div>
                    </div>

                    <!-- WhatsApp Action CTA -->
                    <a :href="'https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text=' + encodeURIComponent('Halo Super Vacation, saya tertarik dengan dokumentasi foto perjalanan di ' + countryName + ': ' + currentPhoto.title + ' (' + currentPhoto.destination + '). Tolong infokan paket tour serupa.')" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition active:scale-95 shrink-0">
                        <span>💬 Tanya Trip Ini via WA</span>
                    </a>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-xs sm:text-sm text-slate-700 italic leading-relaxed" x-text="'“' + currentPhoto.customer_review + '”'"></p>
                </div>
            </div>

            <!-- SCROLLABLE THUMBNAIL REEL ("banyak foto bisa digulir") -->
            <div class="space-y-2">
                <div class="flex items-center justify-between text-xs text-slate-600 px-1">
                    <span class="font-bold">
                        Gulir Koleksi Foto di <span class="text-[#1B5A7A]" x-text="countryName"></span> (<span x-text="photos.length"></span> Foto):
                    </span>
                    <span class="text-[11px] text-slate-400 hidden sm:inline">
                        Gunakan panah kiri/kanan keyboard atau klik foto di bawah
                    </span>
                </div>

                <div class="relative bg-slate-900 p-3 rounded-2xl border border-slate-800">
                    <div class="flex items-center gap-3 overflow-x-auto custom-scrollbar py-1 scroll-smooth">
                        <template x-for="(item, idx) in photos" :key="item.id || idx">
                            <button type="button" 
                                    :id="'thumb-' + idx"
                                    @click="selectPhoto(idx)"
                                    class="relative shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-xl overflow-hidden transition-all duration-200 cursor-pointer border-2"
                                    :class="currentIndex === idx ? 'border-sky-400 ring-2 ring-sky-400 scale-105 opacity-100 shadow-md' : 'border-transparent opacity-60 hover:opacity-100'">
                                <img :src="item.image" 
                                     :alt="item.title" 
                                     class="w-full h-full object-cover" />
                                <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-black/70 text-[10px] text-white font-bold" x-text="idx + 1"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-5 py-3.5 bg-white border-t border-slate-100 flex items-center justify-between shrink-0">
            <span class="text-xs text-slate-400">
                Super Vacation Documentation Gallery
            </span>
            <button type="button" 
                    @click="closeModal()" 
                    class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition cursor-pointer">
                Tutup Galeri
            </button>
        </div>

    </div>

</div>
