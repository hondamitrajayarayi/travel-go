<div class="min-h-screen bg-[#0F2A3F] text-slate-100 selection:bg-[#1B5A7A] selection:text-white overflow-hidden">
    
    <style>
        @keyframes pulseGlowSlow {
            0%, 100% { opacity: 0.25; transform: scale(1) translate(-50%, 0); }
            50% { opacity: 0.45; transform: scale(1.1) translate(-50%, -10px); }
        }
        @keyframes floatSubtle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        @keyframes floatSubtleReverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(6px); }
        }
        @keyframes shimmerSlow {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        .animate-pulse-glow {
            animation: pulseGlowSlow 7s ease-in-out infinite;
        }
        .animate-float-subtle {
            animation: floatSubtle 4.5s ease-in-out infinite;
        }
        .animate-float-reverse {
            animation: floatSubtleReverse 5.5s ease-in-out infinite;
        }
        .animate-shimmer {
            animation: shimmerSlow 3.5s infinite;
        }
    </style>

    <!-- 1. HERO SECTION & MINIMALIST PRIVATE TRIP CONFIGURATOR -->
    <section class="relative pt-28 pb-16 lg:pt-36 lg:pb-24 overflow-hidden bg-gradient-to-b from-[#091B29] via-[#0F2A3F] to-[#0A1D2C] border-b border-white/10"
             x-data="{ heroLoaded: false }"
             x-init="setTimeout(() => heroLoaded = true, 50)">
        
        <!-- Ambient Atmospheric Glows -->
        <div class="absolute -top-24 left-1/2 w-[700px] h-[400px] bg-[#1B5A7A]/30 rounded-full blur-[150px] pointer-events-none animate-pulse-glow"></div>
        <div class="absolute top-1/3 -right-20 w-[400px] h-[400px] bg-sky-500/10 rounded-full blur-[120px] pointer-events-none animate-float-subtle"></div>
        <div class="absolute bottom-10 -left-20 w-[450px] h-[350px] bg-[#0E3B53]/25 rounded-full blur-[130px] pointer-events-none animate-float-reverse"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-start">
                
                <!-- LEFT COLUMN: Brand Story & Minimalist Typography (7 Cols) -->
                <div class="lg:col-span-6 xl:col-span-7 space-y-6 lg:space-y-7">
                    
                    <!-- Tagline Badge with soft entrance -->
                    <div :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
                         class="transition-all duration-700 ease-out">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-400/10 border border-sky-400/20 text-[11px] sm:text-xs font-semibold tracking-[0.2em] text-sky-200 uppercase shadow-inner">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                            Private & Custom Travel
                        </span>
                    </div>

                    <!-- Main Headline with staggered delay -->
                    <h1 :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
                        class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-white tracking-tight leading-[1.14] transition-all duration-700 delay-150 ease-out">
                        Perjalanan privat yang dirancang lebih personal
                    </h1>

                    <!-- Description -->
                    <p :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
                       class="text-sm sm:text-base text-slate-300/90 leading-relaxed max-w-2xl font-normal transition-all duration-700 delay-300 ease-out">
                        Super Vacation Private Trip dirancang untuk Anda yang menginginkan keleluasaan penuh: liburan keluarga, perjalanan berdua, hingga small group sahabat dengan ritme santai. Kami menyusun rute, hotel pilihan bintang 4-5, serta mendampingi dari perencanaan sampai kembali ke rumah.
                    </p>

                    <!-- Minimalist Value Bullets with hover micro-animations -->
                    <div :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
                         class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 transition-all duration-700 delay-450 ease-out border-t border-white/10">
                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5 hover:border-white/20 hover:bg-white/10 transition-all duration-300 group hover:-translate-y-1">
                            <span class="text-xs font-semibold text-white tracking-wide block group-hover:text-sky-300 transition-colors">100% Fleksibel</span>
                            <span class="text-[12px] text-slate-400 block leading-snug mt-1">Rute dan jadwal disesuaikan kenyamanan Anda.</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5 hover:border-white/20 hover:bg-white/10 transition-all duration-300 group hover:-translate-y-1">
                            <span class="text-xs font-semibold text-white tracking-wide block group-hover:text-sky-300 transition-colors">Kendaraan Privat</span>
                            <span class="text-[12px] text-slate-400 block leading-snug mt-1">Mobil dan driver privat khusus rombongan Anda.</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5 hover:border-white/20 hover:bg-white/10 transition-all duration-300 group hover:-translate-y-1">
                            <span class="text-xs font-semibold text-white tracking-wide block group-hover:text-sky-300 transition-colors">Dedicated Support</span>
                            <span class="text-[12px] text-slate-400 block leading-snug mt-1">Didampingi tour consultant berpengalaman.</span>
                        </div>
                    </div>

                    <!-- Direct Consultation Action with scale on hover -->
                    <div :class="heroLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'" 
                         class="pt-2 flex items-center gap-4 text-xs text-slate-400 transition-all duration-700 delay-600 ease-out">
                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode('Halo Super Vacation, saya ingin konsultasi langsung mengenai Private Trip custom.') }}" 
                           target="_blank" 
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-white/10 hover:bg-white/20 text-white font-medium transition-all duration-300 border border-white/20 hover:border-white/40 shadow-sm hover:shadow-lg hover:-translate-y-0.5 active:scale-95 group">
                            <svg class="w-4 h-4 text-emerald-400 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Konsultasi Cepat via WhatsApp</span>
                        </a>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Clean Configurator Card (5 Cols) with Animated Card Entrance -->
                <div class="lg:col-span-6 xl:col-span-5 transition-all duration-800 delay-200 ease-out"
                     :class="heroLoaded ? 'opacity-100 translate-y-0 scale-100' : 'opacity-0 translate-y-8 scale-[0.98]'"
                     x-data="{
                        step: 1,
                        totalSteps: 5,
                        
                        // State Form
                        destination: 'Jepang',
                        customDestination: '',
                        tripType: 'Family Private Tour',
                        selectedYear: '{{ date('Y') }}',
                        selectedMonth: '{{ [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'][(int)date('n')] ?? 'Januari' }}',
                        adults: 4,
                        children: 0,
                        budget: 'Rp 25 – 40 Juta / orang',
                        
                        fullName: '',
                        originCity: '',
                        notes: '',

                        errorMessage: '',

                        setDestination(val) {
                            this.destination = val;
                            this.errorMessage = '';
                        },
                        setTripType(val) {
                            this.tripType = val;
                        },
                        setYear(val) {
                            this.selectedYear = val;
                        },
                        setMonth(val) {
                            this.selectedMonth = val;
                        },
                        setBudget(val) {
                            this.budget = val;
                        },

                        nextStep() {
                            this.errorMessage = '';
                            if (this.step === 1 && this.destination === 'Destinasi Lain' && !this.customDestination.trim()) {
                                this.errorMessage = 'Mohon sebutkan destinasi yang Anda inginkan.';
                                return;
                            }
                            if (this.step < this.totalSteps) {
                                this.step++;
                            }
                        },
                        prevStep() {
                            this.errorMessage = '';
                            if (this.step > 1) {
                                this.step--;
                            }
                        },

                        submitToWhatsapp() {
                            this.errorMessage = '';

                            const dest = this.destination === 'Destinasi Lain' ? (this.customDestination || 'Custom') : this.destination;
                            const totalPax = `${this.adults} Dewasa` + (this.children > 0 ? `, ${this.children} Anak` : '');

                            let message = `*HALO SUPER VACATION, SAYA INGIN KONSULTASI PRIVATE TRIP*\n\n` +
                                          `Berikut ringkasan preferensi perjalanan kami:\n\n` +
                                          `• Destinasi: ${dest}\n` +
                                          `• Kategori Trip: ${this.tripType}\n` +
                                          `• Rencana Waktu: ${this.selectedMonth} ${this.selectedYear}\n` +
                                          `• Jumlah Peserta: ${totalPax}\n` +
                                          `• Perkiraan Budget: ${this.budget}\n\n` +
                                          (this.fullName.trim() ? `• Nama Pemesan: ${this.fullName.trim()}\n` : '') +
                                          (this.originCity.trim() ? `• Kota Asal: ${this.originCity.trim()}\n` : '') +
                                          (this.notes.trim() ? `• Catatan: ${this.notes.trim()}\n` : '') +
                                          `\nMohon bantuannya untuk informasi rute & estimasi perjalanannya. Terima kasih.`;

                            const waNumber = '{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}';
                            const targetUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
                            window.open(targetUrl, '_blank');
                        }
                     }">
                    
                    <div class="relative rounded-3xl border border-white/15 bg-[#0B2132]/95 p-6 sm:p-7 shadow-2xl backdrop-blur-xl overflow-hidden transition-all duration-300">
                        
                        <!-- Top Accent Glow line -->
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-[#3372A1] to-transparent"></div>

                        <!-- Progress Indicator -->
                        <div class="mb-5 flex items-center justify-between gap-3 border-b border-white/10 pb-4">
                            <span class="text-[11px] font-medium tracking-wider text-white/60 uppercase transition-all duration-300" 
                                  x-text="`Langkah ${step} dari ${totalSteps}`"></span>
                            <div class="flex items-center gap-1.5">
                                <template x-for="i in totalSteps" :key="i">
                                    <div class="h-1.5 rounded-full transition-all duration-300 ease-out"
                                         :class="i === step ? 'w-6 bg-[#3372A1] shadow-sm shadow-sky-400/50' : (i < step ? 'w-2.5 bg-sky-300/70' : 'w-2 bg-white/20')"></div>
                                </template>
                            </div>
                        </div>

                        <!-- STEP 1: DESTINASI -->
                        <div x-show="step === 1" 
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-x-4 scale-[0.98]"
                             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                             x-cloak>
                            <h3 class="text-base sm:text-lg font-semibold text-white tracking-tight mb-3">
                                Anda ingin merencanakan trip ke mana?
                            </h3>

                            <div class="grid grid-cols-2 gap-2">
                                @php
                                    $destinations = [
                                        'Jepang',
                                        'Korea Selatan',
                                        'Eropa Barat',
                                        'Swiss',
                                        'Turki',
                                        'China',
                                        'Australia',
                                        'Selandia Baru',
                                        'USA & Canada',
                                        'Destinasi Lain',
                                    ];
                                @endphp

                                @foreach ($destinations as $item)
                                    <button type="button" 
                                            @click="setDestination('{{ $item }}')"
                                            class="px-3.5 py-2.5 rounded-xl border text-left text-xs font-medium transition-all duration-200 cursor-pointer active:scale-95 hover:-translate-y-0.5"
                                            :class="destination === '{{ $item }}' ? 'bg-[#1B5A7A] border-sky-400 text-white shadow-md shadow-sky-950/40 ring-1 ring-sky-400/40' : 'bg-white/5 border-white/10 text-slate-300 hover:bg-white/10 hover:border-white/25'">
                                        <span>{{ $item }}</span>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Input Destinasi Lain -->
                            <div x-show="destination === 'Destinasi Lain'" 
                                 x-transition:enter="transition ease-out duration-200 transform"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-cloak 
                                 class="mt-3">
                                <input type="text" 
                                       x-model="customDestination" 
                                       placeholder="Sebutkan negara / kota destinasi tujuan Anda..." 
                                       class="w-full px-3.5 py-2 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 text-xs focus:outline-none focus:border-sky-400 transition-all duration-200">
                            </div>
                        </div>

                        <!-- STEP 2: KATEGORI TRIP -->
                        <div x-show="step === 2" 
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-x-4 scale-[0.98]"
                             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                             x-cloak>
                            <h3 class="text-base sm:text-lg font-semibold text-white tracking-tight mb-3">
                                Kategori perjalanan yang Anda butuhkan
                            </h3>

                            <div class="space-y-2">
                                @php
                                    $tripTypes = [
                                        ['title' => 'Family Private Tour', 'desc' => 'Liburan keluarga santai, ramah anak dan orang tua.'],
                                        ['title' => 'Couple Trip / Honeymoon', 'desc' => 'Momen intim berdua dengan suasana tenang dan romantis.'],
                                        ['title' => 'Small Group Sahabat', 'desc' => 'Perjalanan privat 4–12 orang bersama teman atau keluarga.'],
                                        ['title' => 'Corporate & Executive', 'desc' => 'Perjalanan dinas atau reward insentif dengan standar VIP.'],
                                    ];
                                @endphp

                                @foreach ($tripTypes as $type)
                                    <button type="button" 
                                            @click="setTripType('{{ $type['title'] }}')"
                                            class="w-full p-3.5 rounded-xl border text-left transition-all duration-200 cursor-pointer block active:scale-[0.98] hover:-translate-y-0.5"
                                            :class="tripType === '{{ $type['title'] }}' ? 'bg-[#1B5A7A] border-sky-400 text-white shadow-md shadow-sky-950/40 ring-1 ring-sky-400/40' : 'bg-white/5 border-white/10 text-slate-300 hover:bg-white/10 hover:border-white/20'">
                                        <div class="text-xs font-semibold text-white">{{ $type['title'] }}</div>
                                        <div class="text-[11px] text-slate-300/80 mt-0.5">{{ $type['desc'] }}</div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- STEP 3: TAHUN & BULAN -->
                        <div x-show="step === 3" 
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-x-4 scale-[0.98]"
                             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                             x-cloak>
                            <h3 class="text-base sm:text-lg font-semibold text-white tracking-tight mb-3">
                                Kapan rencana keberangkatan Anda?
                            </h3>

                            <div class="space-y-4">
                                <!-- Pilih Tahun -->
                                <div>
                                    <span class="text-[11px] text-slate-400 block mb-1.5 font-medium">Pilih Tahun:</span>
                                    <div class="grid grid-cols-2 gap-2">
                                        @php
                                            $currentYear = (int)date('Y');
                                            $nextYear = $currentYear + 1;
                                        @endphp
                                        <button type="button" 
                                                @click="setYear('{{ $currentYear }}')"
                                                class="py-2.5 rounded-xl border text-center text-xs font-semibold transition-all duration-200 cursor-pointer active:scale-95 hover:-translate-y-0.5"
                                                :class="selectedYear == '{{ $currentYear }}' ? 'bg-[#1B5A7A] border-sky-400 text-white shadow-sm ring-1 ring-sky-400/40' : 'bg-white/5 border-white/10 text-slate-300 hover:bg-white/10'">
                                            Tahun {{ $currentYear }}
                                        </button>
                                        <button type="button" 
                                                @click="setYear('{{ $nextYear }}')"
                                                class="py-2.5 rounded-xl border text-center text-xs font-semibold transition-all duration-200 cursor-pointer active:scale-95 hover:-translate-y-0.5"
                                                :class="selectedYear == '{{ $nextYear }}' ? 'bg-[#1B5A7A] border-sky-400 text-white shadow-sm ring-1 ring-sky-400/40' : 'bg-white/5 border-white/10 text-slate-300 hover:bg-white/10'">
                                            Tahun {{ $nextYear }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Pilih Bulan -->
                                <div>
                                    <span class="text-[11px] text-slate-400 block mb-1.5 font-medium">Pilih Bulan:</span>
                                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-1.5">
                                        @php
                                            $months = [
                                                'Januari', 'Februari', 'Maret', 'April',
                                                'Mei', 'Juni', 'Juli', 'Agustus',
                                                'September', 'Oktober', 'November', 'Desember'
                                            ];
                                        @endphp
                                        @foreach ($months as $m)
                                            <button type="button" 
                                                    @click="setMonth('{{ $m }}')"
                                                    class="py-2 px-1 rounded-lg border text-center text-[11px] font-medium transition-all duration-150 cursor-pointer active:scale-95 hover:-translate-y-0.5"
                                                    :class="selectedMonth === '{{ $m }}' ? 'bg-[#1B5A7A] border-sky-400 text-white font-semibold ring-1 ring-sky-400/40' : 'bg-white/5 border-white/10 text-slate-300 hover:bg-white/10'">
                                                {{ $m }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 4: PESERTA -->
                        <div x-show="step === 4" 
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-x-4 scale-[0.98]"
                             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                             x-cloak>
                            <h3 class="text-base sm:text-lg font-semibold text-white tracking-tight mb-3">
                                Jumlah peserta yang akan ikut
                            </h3>

                            <div class="space-y-3 pt-1">
                                <!-- Dewasa -->
                                <div class="p-3.5 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between hover:border-white/20 transition-colors">
                                    <div>
                                        <div class="text-xs font-semibold text-white">Dewasa</div>
                                        <div class="text-[11px] text-slate-400">Usia 12 tahun ke atas</div>
                                    </div>
                                    <div class="flex items-center gap-2.5">
                                        <button type="button" @click="if (adults > 1) adults--" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition-all active:scale-90 flex items-center justify-center cursor-pointer">-</button>
                                        <span class="text-sm font-semibold text-white w-5 text-center" x-text="adults"></span>
                                        <button type="button" @click="adults++" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition-all active:scale-90 flex items-center justify-center cursor-pointer">+</button>
                                    </div>
                                </div>

                                <!-- Anak -->
                                <div class="p-3.5 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between hover:border-white/20 transition-colors">
                                    <div>
                                        <div class="text-xs font-semibold text-white">Anak-Anak</div>
                                        <div class="text-[11px] text-slate-400">Usia 0 – 11 tahun</div>
                                    </div>
                                    <div class="flex items-center gap-2.5">
                                        <button type="button" @click="if (children > 0) children--" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition-all active:scale-90 flex items-center justify-center cursor-pointer">-</button>
                                        <span class="text-sm font-semibold text-white w-5 text-center" x-text="children"></span>
                                        <button type="button" @click="children++" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition-all active:scale-90 flex items-center justify-center cursor-pointer">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 5: PERKIRAAN BUDGET & DETAIL KONTAK (LANGKAH TERAKHIR) -->
                        <div x-show="step === 5" 
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-x-4 scale-[0.98]"
                             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                             x-cloak>
                            <h3 class="text-base sm:text-lg font-semibold text-white tracking-tight mb-2">
                                Perkiraan budget & kontak Anda
                            </h3>
                            <p class="text-xs text-slate-400 mb-3">Bantu kami menyesuaikan rekomendasi akomodasi dan rute terbaik sesuai anggaran.</p>

                            <div class="space-y-3">
                                <!-- Pilihan Budget -->
                                <div>
                                    <label class="block text-[11px] font-medium text-slate-300 mb-1.5">Perkiraan Budget per Orang:</label>
                                    <div class="grid grid-cols-2 gap-1.5">
                                        @php
                                            $budgetOptions = [
                                                '< Rp 25 Juta / orang',
                                                'Rp 25 – 40 Juta / orang',
                                                'Rp 40 – 60 Juta / orang',
                                                '> Rp 60 Juta / orang',
                                                'Fleksibel / Sesuai Rute',
                                            ];
                                        @endphp
                                        @foreach ($budgetOptions as $opt)
                                            <button type="button" 
                                                    @click="setBudget('{{ $opt }}')"
                                                    class="p-2 rounded-lg border text-left text-[11px] font-medium transition-all duration-200 cursor-pointer active:scale-95 hover:-translate-y-0.5 {{ $loop->last ? 'col-span-2' : '' }}"
                                                    :class="budget === '{{ $opt }}' ? 'bg-[#1B5A7A] border-sky-400 text-white font-semibold ring-1 ring-sky-400/40 shadow-sm' : 'bg-white/5 border-white/10 text-slate-300 hover:bg-white/10'">
                                                {{ $opt }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Mini Summary Box -->
                                <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-[11px] space-y-1 text-slate-300">
                                    <div class="flex justify-between"><span class="text-slate-400">Tujuan & Kategori:</span> <span class="text-white font-medium" x-text="`${destination === 'Destinasi Lain' ? (customDestination || 'Custom') : destination} • ${tripType}`"></span></div>
                                    <div class="flex justify-between"><span class="text-slate-400">Waktu & Peserta:</span> <span class="text-white font-medium" x-text="`${selectedMonth} ${selectedYear} • ${adults} Dewasa${children > 0 ? ', ' + children + ' Anak' : ''}`"></span></div>
                                </div>

                                <!-- Form Inputs (Optional) -->
                                <div class="space-y-2">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-[11px] font-medium text-slate-300 mb-1">Nama Lengkap (Opsional)</label>
                                            <input type="text" 
                                                   x-model="fullName" 
                                                   placeholder="Contoh: Budi Santoso" 
                                                   class="w-full px-3 py-2 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 text-xs focus:outline-none focus:border-sky-400 transition-all duration-200">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-medium text-slate-300 mb-1">Kota Asal (Opsional)</label>
                                            <input type="text" 
                                                   x-model="originCity" 
                                                   placeholder="Jakarta" 
                                                   class="w-full px-3 py-2 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 text-xs focus:outline-none focus:border-sky-400 transition-all duration-200">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-medium text-slate-300 mb-1">Catatan Tambahan (Opsional)</label>
                                        <textarea x-model="notes" 
                                                  rows="2" 
                                                  placeholder="Tuliskan jika ada destinasi kota tertentu atau kebutuhan khusus..."
                                                  class="w-full px-3 py-1.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 text-xs focus:outline-none focus:border-sky-400 transition-all duration-200"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message with animation -->
                        <div x-show="errorMessage" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-cloak 
                             class="mt-3 p-2.5 rounded-xl bg-rose-500/20 border border-rose-500/30 text-rose-300 text-xs flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400 shrink-0"></span>
                            <span x-text="errorMessage"></span>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="mt-5 pt-4 border-t border-white/10 flex items-center justify-between gap-3">
                            <button type="button" 
                                    x-show="step > 1" 
                                    @click="prevStep()" 
                                    class="px-4 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-medium transition-all duration-200 active:scale-95 cursor-pointer">
                                Kembali
                            </button>
                            <div x-show="step === 1" class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Data tersimpan aman
                            </div>

                            <button type="button" 
                                    x-show="step < totalSteps" 
                                    @click="nextStep()" 
                                    class="ml-auto inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#1B5A7A] hover:bg-[#144761] text-white font-medium text-xs shadow-md shadow-sky-950/40 hover:shadow-lg transition-all duration-200 active:scale-95 group cursor-pointer">
                                <span>Lanjutkan</span>
                                <span class="group-hover:translate-x-1 transition-transform duration-200">→</span>
                            </button>

                            <button type="button" 
                                    x-show="step === totalSteps" 
                                    @click="submitToWhatsapp()" 
                                    class="relative ml-auto inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs shadow-md hover:shadow-lg hover:shadow-emerald-900/40 transition-all duration-200 active:scale-95 overflow-hidden group cursor-pointer">
                                <span class="absolute inset-0 w-1/2 h-full bg-white/20 skew-x-12 animate-shimmer pointer-events-none"></span>
                                <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span>Kirim via WhatsApp</span>
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. SECTION: UNTUK SIAPA PRIVATE TRIP? (CLEAN & ANIMATED) -->
    <section class="py-16 lg:py-24 bg-white text-slate-800 relative overflow-hidden"
             x-data="{ inView: false }"
             x-init="const obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { inView = true; obs.disconnect(); } }, { threshold: 0.15 }); obs.observe($el);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-12 transition-all duration-700 ease-out"
                 :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                <span class="text-[11px] font-semibold tracking-[0.2em] text-[#1B5A7A] uppercase block mb-2">
                    Layanan Reserve
                </span>
                <h2 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">
                    Untuk siapa Private Trip ini?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- 01. Family -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/80 hover:border-sky-300 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-500 ease-out group"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 100ms;">
                    <div class="w-8 h-1 bg-[#1B5A7A] rounded-full mb-4 group-hover:w-14 transition-all duration-300"></div>
                    <h3 class="text-lg font-semibold text-slate-900 tracking-tight group-hover:text-[#1B5A7A] transition-colors">Family Private Tour</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal mt-2">
                        Untuk keluarga yang ingin tanggal, tempo santai, dan kebutuhan perjalanan disesuaikan tanpa terikat jadwal rombongan umum.
                    </p>
                </div>

                <!-- 02. Couple -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/80 hover:border-sky-300 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-500 ease-out group"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 250ms;">
                    <div class="w-8 h-1 bg-[#1B5A7A] rounded-full mb-4 group-hover:w-14 transition-all duration-300"></div>
                    <h3 class="text-lg font-semibold text-slate-900 tracking-tight group-hover:text-[#1B5A7A] transition-colors">Couple & Honeymoon</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal mt-2">
                        Untuk momen berdua yang membutuhkan suasana lebih personal, tenang, dan tidak terburu-buru dengan hotel berpanorama indah.
                    </p>
                </div>

                <!-- 03. Small Group -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/80 hover:border-sky-300 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-500 ease-out group"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 400ms;">
                    <div class="w-8 h-1 bg-[#1B5A7A] rounded-full mb-4 group-hover:w-14 transition-all duration-300"></div>
                    <h3 class="text-lg font-semibold text-slate-900 tracking-tight group-hover:text-[#1B5A7A] transition-colors">Small Group Private</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal mt-2">
                        Untuk teman dekat atau grup kecil 4–12 orang yang ingin perjalanan eksklusif tanpa digabung peserta lain.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SECTION: 4 LANGKAH PROSES (ANIMATED TIMELINE) -->
    <section class="py-16 lg:py-24 bg-[#0A1D2C] text-white relative overflow-hidden"
             x-data="{ inView: false }"
             x-init="const obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { inView = true; obs.disconnect(); } }, { threshold: 0.15 }); obs.observe($el);">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-12 transition-all duration-700 ease-out"
                 :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                <span class="text-[11px] font-semibold tracking-[0.2em] text-sky-400 uppercase block mb-2">
                    Prosesnya
                </span>
                <h2 class="text-2xl sm:text-3xl font-semibold text-white tracking-tight">
                    Dari obrolan sampai berangkat
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- 01 -->
                <div class="space-y-2 p-5 rounded-2xl bg-white/5 border border-white/5 hover:border-white/20 hover:bg-white/10 transition-all duration-500 group hover:-translate-y-2"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 100ms;">
                    <span class="text-3xl sm:text-4xl font-light text-white/30 group-hover:text-sky-400 transition-colors block">01</span>
                    <h3 class="text-base font-semibold text-white tracking-tight">Ceritakan rencanamu</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                        Isi preferensi di formulir atau sampaikan garis besar liburan Anda langsung via WhatsApp ke tim kami.
                    </p>
                </div>

                <!-- 02 -->
                <div class="space-y-2 p-5 rounded-2xl bg-white/5 border border-white/5 hover:border-white/20 hover:bg-white/10 transition-all duration-500 group hover:-translate-y-2"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 250ms;">
                    <span class="text-3xl sm:text-4xl font-light text-white/30 group-hover:text-sky-400 transition-colors block">02</span>
                    <h3 class="text-base font-semibold text-white tracking-tight">Kami susun itinerary</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                        Dalam 1–2 hari kerja, tim kami mengirimkan draft rute, rekomendasi hotel, dan estimasi biaya.
                    </p>
                </div>

                <!-- 03 -->
                <div class="space-y-2 p-5 rounded-2xl bg-white/5 border border-white/5 hover:border-white/20 hover:bg-white/10 transition-all duration-500 group hover:-translate-y-2"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 400ms;">
                    <span class="text-3xl sm:text-4xl font-light text-white/30 group-hover:text-sky-400 transition-colors block">03</span>
                    <h3 class="text-base font-semibold text-white tracking-tight">Revisi sampai pas</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                        Itinerary dapat disesuaikan kembali hingga benar-benar sesuai dengan kenyamanan dan preferensi Anda.
                    </p>
                </div>

                <!-- 04 -->
                <div class="space-y-2 p-5 rounded-2xl bg-white/5 border border-white/5 hover:border-white/20 hover:bg-white/10 transition-all duration-500 group hover:-translate-y-2"
                     :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 550ms;">
                    <span class="text-3xl sm:text-4xl font-light text-white/30 group-hover:text-sky-400 transition-colors block">04</span>
                    <h3 class="text-base font-semibold text-white tracking-tight">Berangkat dengan tenang</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                        Semua tiket, visa, akomodasi, dan transportasi telah siap. Tour consultant mendampingi selama perjalanan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. SECTION: KEISTIMEWAAN LAYANAN (ANIMATED GRID) -->
    <section class="py-16 lg:py-20 bg-slate-50 text-slate-800 border-t border-slate-200/60"
             x-data="{ inView: false }"
             x-init="const obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { inView = true; obs.disconnect(); } }, { threshold: 0.15 }); obs.observe($el);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-10 transition-all duration-700 ease-out"
                 :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                <span class="text-[11px] font-semibold tracking-[0.2em] text-[#1B5A7A] uppercase block mb-2">
                    Standar Layanan
                </span>
                <h2 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">
                    Kenyamanan di setiap detail
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $features = [
                        ['title' => 'Kendaraan Privat & Driver', 'desc' => 'Transportasi privat full-time sesuai kapasitas rombongan untuk fleksibilitas mobilitas sepanjang trip.'],
                        ['title' => 'Kurasi Hotel Bintang 4 & 5', 'desc' => 'Pemilihan lokasi akomodasi strategis dengan standar kebersihan, kenyamanan, dan panorama terbaik.'],
                        ['title' => 'Kurasi Kuliner Halal / Otentik', 'desc' => 'Rekomendasi restoran halal-friendly maupun kuliner lokal terkemuka di setiap destinasi.'],
                        ['title' => 'Layanan Visa & Tiket Pesawat', 'desc' => 'Pendampingan dokumen visa perjalanan, asuransi, serta pemesanan tiket penerbangan resmi.'],
                        ['title' => 'Tour Guide Berpengalaman', 'desc' => 'Pilihan tour leader ramah berbahasa Indonesia atau local guide berlisensi resmi.'],
                        ['title' => 'Pendampingan 24/7', 'desc' => 'Tim support selalu siaga memberikan asistensi dan bantuan selama Anda berada di destinasi.'],
                    ];
                @endphp

                @foreach ($features as $index => $f)
                    <div class="p-6 rounded-2xl bg-white border border-slate-200/70 hover:border-sky-300 hover:shadow-lg transition-all duration-500 ease-out space-y-1.5 hover:-translate-y-1.5 group"
                         :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: {{ 80 * ($index + 1) }}ms;">
                        <h4 class="text-sm font-semibold text-slate-900 group-hover:text-[#1B5A7A] transition-colors">{{ $f['title'] }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            {{ $f['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. BOTTOM MINIMALIST CTA WITH GLOW -->
    <section class="relative py-16 lg:py-20 bg-[#091B29] text-white text-center border-t border-white/10 overflow-hidden"
             x-data="{ inView: false }"
             x-init="const obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { inView = true; obs.disconnect(); } }, { threshold: 0.15 }); obs.observe($el);">
        
        <!-- Background Ambient Glow -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[280px] bg-[#1B5A7A]/25 rounded-full blur-[140px] pointer-events-none animate-pulse-glow"></div>

        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5 transition-all duration-700 ease-out"
             :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
            <h2 class="text-2xl sm:text-3xl font-semibold text-white tracking-tight">
                Tidak harus tahu semua rencananya dulu
            </h2>

            <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto font-normal leading-relaxed">
                Ceritakan saja gambaran kasarnya. Tim konsultan Super Vacation siap membantu merancang perjalanan terbaik Anda.
            </p>

            <div class="pt-2">
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '6287887840636') }}?text={{ urlencode('Halo Super Vacation, saya ingin tanya soal private trip custom. Bisa bantu?') }}" 
                   target="_blank" 
                   class="inline-flex items-center justify-center gap-2.5 px-8 py-3.5 rounded-full bg-[#1B5A7A] hover:bg-[#144761] text-white font-semibold text-xs sm:text-sm transition-all duration-300 active:scale-95 shadow-lg hover:shadow-sky-900/50 hover:-translate-y-1 group">
                    <span>Mulai Obrolan via WhatsApp</span>
                    <span class="group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </div>
        </div>
    </section>

</div>
