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
                    KEBIJAKAN & LAYANAN RESMI
                </span>
            </div>

            <!-- Title -->
            <h1 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
                class="text-3xl sm:text-4xl lg:text-[42px] font-semibold text-slate-900 tracking-tight leading-[1.2] transition-all duration-700 delay-150 ease-out">
                Terms & Conditions
            </h1>

            <!-- Subtitle -->
            <p :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
               class="mt-4 sm:mt-5 text-sm sm:text-base text-slate-500 leading-relaxed max-w-2xl mx-auto font-normal transition-all duration-700 delay-300 ease-out">
                Syarat dan ketentuan perjalanan ini berlaku untuk seluruh paket tour Super Vacation demi menjamin keamanan, kenyamanan, dan transparansi perjalanan Anda.
            </p>
        </div>
    </section>

    <!-- 2. MAIN CONTENT TERMS -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="space-y-6">

            <!-- Card 1 & 2: Kuota & Pembayaran Deposit -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow duration-300">
                <div class="flex items-start gap-4 sm:gap-5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-sky-50 border border-sky-100 text-[#1B5A7A] flex items-center justify-center font-bold text-base sm:text-lg shrink-0">
                        01
                    </div>
                    <div class="flex-1 space-y-2">
                        <h2 class="text-base sm:text-lg font-semibold text-slate-900 tracking-tight">
                            Minimum Kuota Keberangkatan Group
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Group akan diberangkatkan apabila jumlah peserta telah mencapai <strong class="text-slate-900 font-semibold">minimum 20 orang dewasa per group</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Pendaftaran & Rekening Resmi Pembayaran -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow duration-300">
                <div class="flex items-start gap-4 sm:gap-5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-sky-50 border border-sky-100 text-[#1B5A7A] flex items-center justify-center font-bold text-base sm:text-lg shrink-0">
                        02
                    </div>
                    <div class="flex-1 space-y-4">
                        <div>
                            <h2 class="text-base sm:text-lg font-semibold text-slate-900 tracking-tight">
                                Pendaftaran & Uang Muka (Deposit)
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal mt-1.5">
                                Pendaftaran harus disertai pembayaran uang muka sebesar <strong class="text-[#1B5A7A] font-semibold">IDR 10.000.000 / peserta (Non-refundable deposit)</strong>. Pembayaran uang muka hanya menjamin keikutsertaan Anda dalam paket tour pilihan.
                            </p>
                        </div>

                        <!-- Rekening Bank Resmi Box -->
                        <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/90 border border-slate-200/90 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                             x-data="{ copied: false }">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] font-semibold tracking-wider text-slate-500 uppercase">Rekening Resmi Pembayaran</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-100 text-blue-700">{{ \App\Models\Setting::get('bank_name', 'Bank BCA') }}</span>
                                </div>
                                <div class="text-sm sm:text-base font-semibold text-slate-900">
                                    {{ \App\Models\Setting::get('bank_account_name', 'PT. BINTANG BUANA WISATA') }}
                                </div>
                                <div class="text-xs sm:text-sm font-mono font-bold text-[#1B5A7A] tracking-wider">
                                    NO. ACC : {{ \App\Models\Setting::get('bank_account_number', '5910 844484') }}
                                </div>
                            </div>

                            <button type="button" 
                                    @click="navigator.clipboard.writeText('{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('bank_account_number', '5910844484')) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200 shadow-2xs transition active:scale-95 shrink-0">
                                <svg x-show="!copied" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                                <svg x-show="copied" x-cloak class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span x-text="copied ? 'Tersalin!' : 'Salin No. Rekening'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 & 4: Pembatalan & Perubahan Harga -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- 03. Pembatalan Pihak Tamu -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center font-bold text-base shrink-0">
                            03
                        </div>
                        <div class="space-y-2">
                            <h2 class="text-base font-semibold text-slate-900 tracking-tight">
                                Pembatalan Uang Muka
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                                Bila terdapat pembatalan dari pihak tamu, maka uang muka tidak dapat dikembalikan dan akan dianggap <strong class="text-rose-600 font-semibold">hangus</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 04. Perubahan Harga Tour -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-sky-50 border border-sky-100 text-[#1B5A7A] flex items-center justify-center font-bold text-base shrink-0">
                            04
                        </div>
                        <div class="space-y-2">
                            <h2 class="text-base font-semibold text-slate-900 tracking-tight">
                                Perubahan Harga Tour
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                                Harga tour dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu sebelum pelunasan biaya tour dilakukan, meskipun pembayaran uang muka telah disetorkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 5: Biaya Pembatalan Berdasarkan Waktu (Tabel Highlight) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow duration-300">
                <div class="flex items-start gap-4 sm:gap-5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center font-bold text-base sm:text-lg shrink-0">
                        05
                    </div>
                    <div class="flex-1 space-y-4">
                        <div>
                            <h2 class="text-base sm:text-lg font-semibold text-slate-900 tracking-tight">
                                Skema Biaya Pembatalan oleh Peserta
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal mt-1">
                                Apabila peserta melakukan pembatalan sebelum jadwal keberangkatan, rincian biaya yang dikenakan adalah sebagai berikut:
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 pt-1">
                            <!-- A. 15-30 Hari -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-center space-y-1.5">
                                <span class="text-[11px] font-semibold tracking-wider text-slate-500 uppercase block">15 – 30 Hari Sebelum</span>
                                <div class="text-2xl font-bold text-slate-900">50%</div>
                                <span class="text-[11px] text-slate-500 block">dari harga total tour</span>
                            </div>

                            <!-- B. 7-15 Hari -->
                            <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-center space-y-1.5">
                                <span class="text-[11px] font-semibold tracking-wider text-amber-700 uppercase block">7 – 15 Hari Sebelum</span>
                                <div class="text-2xl font-bold text-amber-700">80%</div>
                                <span class="text-[11px] text-amber-600 block">dari harga total tour</span>
                            </div>

                            <!-- C. < 7 Hari -->
                            <div class="p-4 rounded-2xl bg-rose-50/70 border border-rose-200/80 text-center space-y-1.5">
                                <span class="text-[11px] font-semibold tracking-wider text-rose-700 uppercase block">Kurang dari 7 Hari</span>
                                <div class="text-2xl font-bold text-rose-700">100%</div>
                                <span class="text-[11px] text-rose-600 block">dari harga total tour</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 6 & 7: Force Majeure & Perubahan Acara Perjalanan -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow duration-300 space-y-6">
                <!-- 06. Force Majeure -->
                <div class="flex items-start gap-4 sm:gap-5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-sky-50 border border-sky-100 text-[#1B5A7A] flex items-center justify-center font-bold text-base sm:text-lg shrink-0">
                        06
                    </div>
                    <div class="flex-1 space-y-2">
                        <h2 class="text-base sm:text-lg font-semibold text-slate-900 tracking-tight">
                            Keadaan Kahar (Force Majeure)
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Dalam keadaan Force Majeure / terpaksa / tidak teratasi karena bencana alam, kerusuhan, suasana mencekam dan lain-lain, rencana perjalanan dapat dirubah baik susunan maupun jadwalnya tanpa pemberitahuan terlebih dahulu demi kepentingan dan keamanan seluruh rombongan.
                        </p>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Dalam hal ini, <strong class="text-slate-900 font-semibold">SUPER VACATION</strong> tidak bertanggung jawab dalam pengembalian biaya atau uang atas service yang sudah dibayarkan yang tidak digunakan, termasuk dan tidak terbatas pada timbulnya biaya tambahan.
                        </p>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- 07. Perubahan Acara Perjalanan -->
                <div class="flex items-start gap-4 sm:gap-5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-sky-50 border border-sky-100 text-[#1B5A7A] flex items-center justify-center font-bold text-base sm:text-lg shrink-0">
                        07
                    </div>
                    <div class="flex-1 space-y-2">
                        <h2 class="text-base sm:text-lg font-semibold text-slate-900 tracking-tight">
                            Kelancaran Acara Perjalanan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Demi kelancaran jalannya tour, susunan dan acara perjalanan dapat disesuaikan tanpa pemberitahuan terlebih dahulu.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 8: Perlindungan Asuransi Perjalanan (Premium Feature Box) -->
            <div class="bg-gradient-to-br from-[#1B5A7A] to-[#0f3b52] rounded-3xl p-6 sm:p-8 lg:p-10 text-white shadow-md relative overflow-hidden">
                <!-- Background Accent Graphic -->
                <div class="absolute -right-10 -bottom-10 w-52 h-52 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative flex items-start gap-4 sm:gap-5">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white/10 text-white flex items-center justify-center font-bold text-base sm:text-lg shrink-0 border border-white/20">
                        08
                    </div>
                    <div class="flex-1 space-y-4">
                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-widest text-sky-200">PROTEKSI MAKSIMAL</span>
                            <h2 class="text-lg sm:text-xl font-semibold text-white tracking-tight mt-1">
                                Perlindungan Asuransi Perjalanan
                            </h2>
                            <p class="text-xs sm:text-sm text-sky-50/90 leading-relaxed font-normal mt-1.5">
                                Produk paket tour ini dilindungi oleh <strong class="text-white font-semibold">Asuransi Perjalanan</strong> untuk memberikan rasa aman dan kenyamanan peserta atas hal-hal tak terduga selama perjalanan.
                            </p>
                        </div>

                        <!-- Manfaat Yang Dijamin Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                            <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/10 border border-white/15 text-xs text-white">
                                <span class="text-emerald-300 text-sm">✓</span>
                                <span>Kematian & Cacat Tetap Akibat Kecelakaan</span>
                            </div>
                            <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/10 border border-white/15 text-xs text-white">
                                <span class="text-emerald-300 text-sm">✓</span>
                                <span>Biaya Medis Perjalanan</span>
                            </div>
                            <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/10 border border-white/15 text-xs text-white">
                                <span class="text-emerald-300 text-sm">✓</span>
                                <span>Biaya Evakuasi Darurat</span>
                            </div>
                            <div class="flex items-center gap-2.5 p-3 rounded-xl bg-white/10 border border-white/15 text-xs text-white">
                                <span class="text-emerald-300 text-sm">✓</span>
                                <span>Repatriasi Medis & Repatriasi Jenazah</span>
                            </div>
                        </div>

                        <p class="text-[11px] text-sky-200/90 italic pt-1">
                            * Syarat & ketentuan polis asuransi berlaku.
                        </p>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Assistance Box -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
                <div class="space-y-1">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-900 tracking-tight">
                        Ada Pertanyaan Terkait Ketentuan Perjalanan?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 font-normal">
                        Tim konsultan kami siap membantu menjelaskan rincian paket dan ketentuan yang berlaku.
                    </p>
                </div>
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode(\App\Models\Setting::get('whatsapp_default_message', 'Halo Admin Super Vacation, saya ingin bertanya mengenai Terms and Conditions')) }}" 
                   target="_blank" 
                   class="inline-flex items-center justify-center gap-2.5 px-6 py-3.5 rounded-2xl bg-[#1B5A7A] hover:bg-[#13425a] text-white font-medium text-xs sm:text-sm shadow-sm transition active:scale-95 shrink-0">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Konsultan</span>
                </a>
            </div>

        </div>
    </section>

</div>
