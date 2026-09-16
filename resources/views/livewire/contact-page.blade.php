<div class="min-h-screen bg-slate-50/60 pb-20">
    
    <!-- 1. HERO HEADER -->
    <section class="relative pt-32 pb-16 lg:pt-36 lg:pb-20 bg-gradient-to-b from-white via-slate-50/80 to-slate-50 border-b border-slate-100 overflow-hidden"
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 50)">
        
        <!-- Ambient Decorative Glow -->
        <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-sky-100/50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Badge -->
            <div :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
                 class="transition-all duration-700 ease-out">
                <span class="inline-block text-[11px] sm:text-xs font-semibold tracking-[.18em] text-[#1B5A7A] uppercase mb-4 px-4 py-1.5 rounded-full bg-sky-50 border border-sky-100/90 shadow-2xs">
                    LAYANAN KONSULTASI RESMI
                </span>
            </div>

            <!-- Title -->
            <h1 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
                class="text-3xl sm:text-4xl lg:text-[42px] font-semibold text-slate-900 tracking-tight leading-[1.2] transition-all duration-700 delay-150 ease-out">
                Hubungi Tim Super Vacation
            </h1>

            <!-- Subtitle -->
            <p :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
               class="mt-4 sm:mt-5 text-sm sm:text-base text-slate-500 leading-relaxed max-w-2xl mx-auto font-normal transition-all duration-700 delay-300 ease-out">
                Ada pertanyaan mengenai paket wisata, custom itinerary, atau jadwal keberangkatan? Kami siap mendampingi perencanaan liburan impian Anda.
            </p>
        </div>
    </section>

    <!-- 2. MAIN CONTENT GRID (2 COLUMNS) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 sm:mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

            <!-- LEFT COLUMN: Contact Information Cards (5 Cols) -->
            <div class="lg:col-span-5 space-y-5">
                
                <!-- Quick WhatsApp Action Card -->
                <div class="p-6 sm:p-7 rounded-3xl bg-gradient-to-br from-[#1B5A7A] to-[#13425a] text-white shadow-md relative overflow-hidden space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-semibold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>Online • Respons Cepat</span>
                        </span>
                        <div class="w-9 h-9 rounded-2xl bg-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white tracking-tight">Konsultasi WhatsApp Langsung</h3>
                        <p class="text-xs text-sky-100/90 mt-1 leading-relaxed">
                            Dapatkan rekomendasi destinasi, estimasi biaya, dan jadwal terbaru langsung dari travel consultant kami.
                        </p>
                    </div>
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode(\App\Models\Setting::get('whatsapp_default_message', 'Halo Admin Super Vacation, saya ingin konsultasi paket tour')) }}" 
                       target="_blank" 
                       class="inline-flex items-center justify-center gap-2 w-full py-3 rounded-2xl bg-white hover:bg-sky-50 text-[#1B5A7A] font-semibold text-xs sm:text-sm shadow-sm transition active:scale-98">
                        <span>Chat WhatsApp ({{ \App\Models\Setting::get('whatsapp_display', '+62 878-8784-0636') }})</span>
                    </a>
                </div>

                <!-- Info Cards -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-xs space-y-6">
                    
                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Email Resmi</span>
                            <a href="mailto:{{ \App\Models\Setting::get('email', 'supervacationtour@gmail.com') }}" class="text-xs sm:text-sm font-semibold text-slate-800 hover:text-[#3372A1] transition">
                                {{ \App\Models\Setting::get('email', 'supervacationtour@gmail.com') }}
                            </a>
                        </div>
                    </div>

                    <!-- Kantor Layanan -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 text-rose-500 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Alamat Kantor</span>
                            <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed mt-0.5">
                                {{ \App\Models\Setting::get('address', 'Jl. Pahlawan Raya, Gg Galery No 5A, Cinangka, Sawangan, Depok, Jawa Barat, 16516') }}
                            </p>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Jam Layanan</span>
                            <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed mt-0.5">
                                {{ \App\Models\Setting::get('operating_hours', 'Senin – Minggu: 08.00 – 21.00 WIB') }}
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            <!-- RIGHT COLUMN: Interactive Form (7 Cols) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-slate-200/80 shadow-xs">
                    
                    @if ($isSubmitted)
                        <!-- Success Feedback State -->
                        <div class="py-10 text-center space-y-4" x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })">
                            <div class="w-16 h-16 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-2xl font-bold shadow-xs animate-bounce">
                                ✓
                            </div>
                            <div class="space-y-1.5 max-w-md mx-auto">
                                <h3 class="text-xl font-semibold text-slate-900 tracking-tight">
                                    Pesan Berhasil Terkirim!
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed">
                                    Terima kasih telah menghubungi Super Vacation. Tim kami akan segera meninjau pesan Anda dan merespons melalui email / WhatsApp.
                                </p>
                            </div>
                            <div class="pt-3">
                                <button type="button" 
                                        wire:click="resetForm"
                                        class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition active:scale-95">
                                    Kirim Pesan Lainnya
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Contact Form -->
                        <form wire:submit.prevent="submit" class="space-y-5">
                            <div>
                                <h2 class="text-lg sm:text-xl font-semibold text-slate-900 tracking-tight">
                                    Kirim Pesan Langsung
                                </h2>
                                <p class="text-xs text-slate-500 font-normal mt-1">
                                    Isi formulir di bawah dan konsultan kami akan menghubungi Anda sesegera mungkin.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Nama Lengkap <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           wire:model.defer="name" 
                                           placeholder="Contoh: Budi Santoso"
                                           class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5A7A]/20 focus:border-[#1B5A7A] transition @error('name') border-rose-400 bg-rose-50/30 @enderror">
                                    @error('name')
                                        <span class="text-[11px] text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Alamat Email <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           wire:model.defer="email" 
                                           placeholder="budi@example.com"
                                           class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5A7A]/20 focus:border-[#1B5A7A] transition @error('email') border-rose-400 bg-rose-50/30 @enderror">
                                    @error('email')
                                        <span class="text-[11px] text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- WhatsApp / Phone -->
                                <div>
                                    <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Nomor WhatsApp / Telp
                                    </label>
                                    <input type="text" 
                                           id="phone" 
                                           wire:model.defer="phone" 
                                           placeholder="081234567890"
                                           class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5A7A]/20 focus:border-[#1B5A7A] transition @error('phone') border-rose-400 bg-rose-50/30 @enderror">
                                    @error('phone')
                                        <span class="text-[11px] text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Subject -->
                                <div>
                                    <label for="subject" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Subjek / Kategori Pesan <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="subject" 
                                           wire:model.defer="subject" 
                                           placeholder="Tanya Paket Jepang / Custom Trip"
                                           class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5A7A]/20 focus:border-[#1B5A7A] transition @error('subject') border-rose-400 bg-rose-50/30 @enderror">
                                    @error('subject')
                                        <span class="text-[11px] text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Isi Pesan <span class="text-rose-500">*</span>
                                </label>
                                <textarea id="message" 
                                          wire:model.defer="message" 
                                          rows="5" 
                                          placeholder="Tuliskan pertanyaan atau rencana perjalanan Anda secara rinci (destinasi, perkiraan tanggal, jumlah peserta, dll)..."
                                          class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-800 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#1B5A7A]/20 focus:border-[#1B5A7A] transition @error('message') border-rose-400 bg-rose-50/30 @enderror"></textarea>
                                @error('message')
                                    <span class="text-[11px] text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        class="inline-flex items-center justify-center gap-2.5 w-full py-4 rounded-2xl bg-[#1B5A7A] hover:bg-[#13425a] text-white font-semibold text-xs sm:text-sm shadow-sm transition active:scale-98 disabled:opacity-75 cursor-pointer">
                                    <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="submit">Kirim Pesan Sekarang</span>
                                    <span wire:loading wire:target="submit">Mengirimkan Pesan...</span>
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </section>

</div>
