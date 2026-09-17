<div class="pt-20 pb-20 bg-slate-50 min-h-screen">
    
    <!-- 1. HERO HEADER BANNER (ULTRA CLEAN & PREMIUM) -->
    <section class="relative pt-12 pb-10 sm:pt-16 sm:pb-14 bg-gradient-to-b from-slate-50 via-white to-slate-50 border-b border-slate-100/80 mb-12 overflow-hidden"
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 50)">
        
        <!-- Ambient Decorative Glow -->
        <div class="absolute top-4 left-1/2 -translate-x-1/2 w-[650px] h-[260px] bg-sky-200/30 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Header Badge -->
            <div :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'" 
                 class="transition-all duration-700 ease-out">
                <span class="inline-flex items-center gap-2 text-[11px] font-semibold tracking-[.14em] text-[#1B5A7A] uppercase px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-100/90 shadow-2xs mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#1B5A7A]"></span>
                    Pusat Informasi & Panduan Wisata
                </span>
            </div>

            <!-- Main Title -->
            <h1 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
                class="transition-all duration-700 delay-100 ease-out font-display text-3xl sm:text-5xl lg:text-5xl font-semibold tracking-[-.025em] text-slate-900 leading-[1.15]">
                Artikel & Wawasan Travel
            </h1>

            <!-- Subtitle -->
            <p :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" 
               class="transition-all duration-700 delay-200 ease-out mt-3 text-sm sm:text-base text-slate-500 font-normal max-w-2xl mx-auto leading-relaxed">
                Temukan panduan lengkap visa, tips persiapan liburan, serta syarat keberangkatan terbaru untuk kenyamanan perjalanan Anda.
            </p>

        </div>
    </section>

    <!-- 2. MAIN CONTAINER (FILTER & ARTICLES GRID) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- SEARCH & CATEGORY FILTER BAR -->
        <div class="bg-white border border-slate-200/90 rounded-3xl p-4 sm:p-6 shadow-sm space-y-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                
                <!-- Category Pills -->
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    @foreach($categories as $catKey => $catLabel)
                        <button type="button" 
                                wire:click="selectCategory('{{ $catKey }}')" 
                                class="px-4 py-2 rounded-2xl text-xs font-semibold transition-all duration-200 cursor-pointer select-none {{ $selectedCategory === $catKey ? 'bg-[#1B5A7A] text-white shadow-md scale-105' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $catLabel }}
                        </button>
                    @endforeach
                </div>

                <!-- Search Input -->
                <div class="relative w-full md:w-72">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cari artikel / tips..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1B5A7A] focus:border-transparent transition" />
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

            </div>
        </div>

        <!-- ARTICLES GRID -->
        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                    <article onclick="window.location.href='/article/{{ $article->slug }}'" 
                             class="group bg-white rounded-3xl border border-slate-200/90 shadow-md hover:shadow-2xl hover:shadow-sky-950/10 hover:border-sky-300 transition-all duration-300 flex flex-col overflow-hidden cursor-pointer">
                        
                        <!-- Thumbnail Image Container -->
                        <div class="relative h-52 overflow-hidden bg-slate-100">
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                                     alt="{{ $article->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-sky-500 to-[#1B5A7A] flex flex-col items-center justify-center p-6 text-white group-hover:scale-105 transition-transform duration-700 ease-out">
                                    <svg class="w-12 h-12 mb-2 text-sky-200/80 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span class="text-xs font-semibold tracking-wider uppercase text-sky-100">Travel Guide</span>
                                </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-[11px] font-bold text-[#1B5A7A] shadow-sm border border-white/60">
                                    {{ $article->category }}
                                </span>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-3 text-[11px] font-semibold text-slate-400">
                                    <span>📅 {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span>⏱️ {{ $article->reading_time }}</span>
                                </div>

                                <h3 class="font-bold text-slate-900 text-lg leading-snug group-hover:text-[#1B5A7A] transition-colors line-clamp-2">
                                    {{ $article->title }}
                                </h3>

                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                    {{ $article->excerpt }}
                                </p>
                            </div>

                            <!-- Footer Author & Action Link -->
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="font-semibold text-slate-600">✍️ {{ $article->author }}</span>
                                <span class="font-bold text-[#1B5A7A] group-hover:translate-x-1 transition-transform flex items-center gap-1">
                                    Baca ➔
                                </span>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="pt-6">
                {{ $articles->links() }}
            </div>
        @else
            <!-- EMPTY STATE -->
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-xl mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Artikel Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                    Belum ada artikel yang cocok dengan kata kunci pencarian Anda.
                </p>
            </div>
        @endif

    </div>

</div>
