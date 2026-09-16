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
                    PUSAT INFORMASI & BANTUAN
                </span>
            </div>

            <!-- Title -->
            <h1 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
                class="text-3xl sm:text-4xl lg:text-[42px] font-semibold text-slate-900 tracking-tight leading-[1.2] transition-all duration-700 delay-150 ease-out">
                Frequently Asked Questions
            </h1>

            <!-- Subtitle -->
            <p :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
               class="mt-4 sm:mt-5 text-sm sm:text-base text-slate-500 leading-relaxed max-w-2xl mx-auto font-normal transition-all duration-700 delay-300 ease-out">
                Temukan jawaban atas pertanyaan yang sering diajukan mengenai pemesanan trip, kustomisasi itinerary, pembayaran, dan layanan Super Vacation.
            </p>
        </div>
    </section>

    <!-- 2. MAIN FAQ ACCORDION -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 sm:mt-10"
             x-data="{ 
                activeAccordion: 1,
                toggle(index) {
                    this.activeAccordion = this.activeAccordion === index ? null : index;
                }
             }">
        
        <div class="space-y-4">

            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-3xl border transition-all duration-200 overflow-hidden"
                 :class="activeAccordion === 1 ? 'border-[#3372A1]/40 shadow-sm ring-2 ring-[#3372A1]/5' : 'border-slate-200/80 shadow-2xs hover:border-slate-300'">
                <button type="button" 
                        @click="toggle(1)"
                        class="w-full p-6 sm:p-7 text-left flex items-start justify-between gap-4 focus:outline-none cursor-pointer">
                    <div class="flex items-start gap-3.5 sm:gap-4">
                        <span class="w-8 h-8 rounded-xl bg-sky-50 border border-sky-100 text-[#1B5A7A] text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">
                            Q1
                        </span>
                        <h2 class="text-sm sm:text-base font-semibold text-slate-900 tracking-tight leading-snug">
                            Bagaimana cara agar saya bisa memesan trip dari kami?
                        </h2>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-500 shrink-0 transition-transform duration-200"
                         :class="activeAccordion === 1 ? 'rotate-180 bg-sky-50 text-[#1B5A7A] border-sky-100' : ''">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div x-show="activeAccordion === 1" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="px-6 pb-6 sm:px-7 sm:pb-7 pt-0 border-t border-slate-100">
                    <div class="pl-11 sm:pl-12 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-4">
                        Anda dapat menghubungi Tim Supervacation melalui WhatsApp, menyampaikan kebutuhan perjalanan Anda (destinasi, jumlah peserta, tanggal, dan jenis perjalanan). Tim kami akan merespons dan membantu proses pemesanan secara langsung dan personal.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-3xl border transition-all duration-200 overflow-hidden"
                 :class="activeAccordion === 2 ? 'border-[#3372A1]/40 shadow-sm ring-2 ring-[#3372A1]/5' : 'border-slate-200/80 shadow-2xs hover:border-slate-300'">
                <button type="button" 
                        @click="toggle(2)"
                        class="w-full p-6 sm:p-7 text-left flex items-start justify-between gap-4 focus:outline-none cursor-pointer">
                    <div class="flex items-start gap-3.5 sm:gap-4">
                        <span class="w-8 h-8 rounded-xl bg-sky-50 border border-sky-100 text-[#1B5A7A] text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">
                            Q2
                        </span>
                        <h2 class="text-sm sm:text-base font-semibold text-slate-900 tracking-tight leading-snug">
                            Apakah saya dapat mengcustom itinerary trip sesuai kemauan saya?
                        </h2>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-500 shrink-0 transition-transform duration-200"
                         :class="activeAccordion === 2 ? 'rotate-180 bg-sky-50 text-[#1B5A7A] border-sky-100' : ''">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div x-show="activeAccordion === 2" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="px-6 pb-6 sm:px-7 sm:pb-7 pt-0 border-t border-slate-100">
                    <div class="pl-11 sm:pl-12 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-4">
                        Ya. Supervacation menyediakan layanan <strong class="text-slate-900 font-semibold">custom itinerary</strong> yang dapat disesuaikan dengan destinasi, durasi, jumlah peserta, gaya perjalanan, dan budget Anda secara personal.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-3xl border transition-all duration-200 overflow-hidden"
                 :class="activeAccordion === 3 ? 'border-[#3372A1]/40 shadow-sm ring-2 ring-[#3372A1]/5' : 'border-slate-200/80 shadow-2xs hover:border-slate-300'">
                <button type="button" 
                        @click="toggle(3)"
                        class="w-full p-6 sm:p-7 text-left flex items-start justify-between gap-4 focus:outline-none cursor-pointer">
                    <div class="flex items-start gap-3.5 sm:gap-4">
                        <span class="w-8 h-8 rounded-xl bg-sky-50 border border-sky-100 text-[#1B5A7A] text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">
                            Q3
                        </span>
                        <h2 class="text-sm sm:text-base font-semibold text-slate-900 tracking-tight leading-snug">
                            Apakah saya dapat berkonsultasi terlebih dahulu sebelum mengikuti trip?
                        </h2>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-500 shrink-0 transition-transform duration-200"
                         :class="activeAccordion === 3 ? 'rotate-180 bg-sky-50 text-[#1B5A7A] border-sky-100' : ''">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div x-show="activeAccordion === 3" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="px-6 pb-6 sm:px-7 sm:pb-7 pt-0 border-t border-slate-100">
                    <div class="pl-11 sm:pl-12 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-4">
                        Tim kami sangat menyarankan Anda untuk <strong class="text-slate-900 font-semibold">berkonsultasi gratis melalui WhatsApp</strong> sebelum menentukan pilihan paket. Tim Supervacation siap membantu menjawab pertanyaan dan mendampingi perencanaan perjalanan Anda dari awal hingga akhir.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-3xl border transition-all duration-200 overflow-hidden"
                 :class="activeAccordion === 4 ? 'border-[#3372A1]/40 shadow-sm ring-2 ring-[#3372A1]/5' : 'border-slate-200/80 shadow-2xs hover:border-slate-300'">
                <button type="button" 
                        @click="toggle(4)"
                        class="w-full p-6 sm:p-7 text-left flex items-start justify-between gap-4 focus:outline-none cursor-pointer">
                    <div class="flex items-start gap-3.5 sm:gap-4">
                        <span class="w-8 h-8 rounded-xl bg-sky-50 border border-sky-100 text-[#1B5A7A] text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">
                            Q4
                        </span>
                        <h2 class="text-sm sm:text-base font-semibold text-slate-900 tracking-tight leading-snug">
                            Bagaimana cara saya membayar perjalanan trip yang akan saya ikuti?
                        </h2>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-500 shrink-0 transition-transform duration-200"
                         :class="activeAccordion === 4 ? 'rotate-180 bg-sky-50 text-[#1B5A7A] border-sky-100' : ''">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div x-show="activeAccordion === 4" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="px-6 pb-6 sm:px-7 sm:pb-7 pt-0 border-t border-slate-100">
                    <div class="pl-11 sm:pl-12 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-4">
                        Metode pembayaran resmi akan diinformasikan oleh tim Super Vacation sesuai dengan jenis layanan dan ketentuan pemesanan (seperti deposit pembayaran berjangka). Semua proses pembayaran dilakukan secara transparan, aman, dan terdokumentasi dengan invoice resmi.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="bg-white rounded-3xl border transition-all duration-200 overflow-hidden"
                 :class="activeAccordion === 5 ? 'border-[#3372A1]/40 shadow-sm ring-2 ring-[#3372A1]/5' : 'border-slate-200/80 shadow-2xs hover:border-slate-300'">
                <button type="button" 
                        @click="toggle(5)"
                        class="w-full p-6 sm:p-7 text-left flex items-start justify-between gap-4 focus:outline-none cursor-pointer">
                    <div class="flex items-start gap-3.5 sm:gap-4">
                        <span class="w-8 h-8 rounded-xl bg-sky-50 border border-sky-100 text-[#1B5A7A] text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">
                            Q5
                        </span>
                        <h2 class="text-sm sm:text-base font-semibold text-slate-900 tracking-tight leading-snug">
                            Bagaimana jika ingin membatalkan perjalanan trip saya?
                        </h2>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-500 shrink-0 transition-transform duration-200"
                         :class="activeAccordion === 5 ? 'rotate-180 bg-sky-50 text-[#1B5A7A] border-sky-100' : ''">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div x-show="activeAccordion === 5" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="px-6 pb-6 sm:px-7 sm:pb-7 pt-0 border-t border-slate-100">
                    <div class="pl-11 sm:pl-12 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal pt-4">
                        Ketentuan pembatalan akan mengikuti kebijakan yang berlaku pada paket, vendor, hotel, transportasi, maskapai, dan peraturan yang berlaku. Tim kami akan membantu menjelaskan opsi dan prosedur pembatalan secara rinci.
                    </div>
                </div>
            </div>

        </div>

        <!-- 3. STILL HAVE QUESTIONS CTA BOX -->
        <div class="mt-10 sm:mt-12 bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-xs text-center space-y-5">
            
            <div class="space-y-1.5 max-w-lg mx-auto">
                <h3 class="text-lg sm:text-xl font-semibold text-slate-900 tracking-tight">
                    Masih Memiliki Pertanyaan?
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 font-normal leading-relaxed">
                    Jangan ragu untuk menghubungi kami. Tim konsultan Super Vacation siap membantu merencanakan liburan terbaik Anda.
                </p>
            </div>
            
            <div>
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode(\App\Models\Setting::get('whatsapp_default_message', 'Halo Admin Super Vacation, saya ingin bertanya seputar paket tour')) }}" 
                   target="_blank" 
                   class="inline-flex items-center justify-center gap-2.5 px-8 py-3.5 rounded-full bg-[#1B5A7A] hover:bg-[#13425a] text-white font-medium text-sm shadow-sm transition active:scale-95">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Kami via WhatsApp</span>
                </a>
            </div>
        </div>

    </section>

</div>
