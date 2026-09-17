<div class="pt-24 pb-20 bg-slate-50 min-h-screen">
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8" x-data="{ copied: false }">
        
        <!-- Breadcrumbs Navigation -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 uppercase tracking-wider pt-5">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-[#1B5A7A] transition">Home</a>
            <span>/</span>
            <a href="{{ route('articles.index') }}" wire:navigate class="hover:text-[#1B5A7A] transition">Artikel</a>
            <span>/</span>
            <span class="text-[#1B5A7A] font-bold truncate max-w-xs sm:max-w-md">{{ $article->title }}</span>
        </nav>

        <!-- Main Article Container -->
        <article class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-10 space-y-8">
            
            <!-- Article Header -->
            <div class="space-y-4 pb-6 border-b border-slate-100">
                <span class="inline-block px-3.5 py-1 rounded-full bg-sky-50 border border-sky-100 text-[#1B5A7A] text-xs font-bold uppercase tracking-wider">
                    {{ $article->category }}
                </span>

                <h1 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                    {{ $article->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-500 pt-2">
                    <span class="flex items-center gap-1.5 text-slate-700">
                        ✍️ {{ $article->author }}
                    </span>
                    <span>•</span>
                    <span>📅 {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                    <span>•</span>
                    <span>⏱️ {{ $article->reading_time }}</span>
                    <span>•</span>
                    <span>👁️ {{ number_format($article->views_count) }} kali dibaca</span>
                </div>
            </div>

            <!-- Featured Thumbnail -->
            @if($article->thumbnail)
                <div class="rounded-2xl overflow-hidden shadow-md max-h-[450px]">
                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover" />
                </div>
            @endif

            <!-- Excerpt Callout -->
            @if($article->excerpt)
                <div class="p-4 sm:p-5 rounded-2xl bg-sky-50/70 border-l-4 border-[#1B5A7A] text-slate-700 text-sm font-medium leading-relaxed italic">
                    "{{ $article->excerpt }}"
                </div>
            @endif

            <!-- Article HTML Content -->
            <div class="prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-p:text-slate-600 prose-p:leading-relaxed prose-a:text-[#1B5A7A] prose-a:font-semibold prose-img:rounded-2xl prose-ul:list-disc prose-ol:list-decimal">
                {!! $article->content !!}
            </div>

            <!-- Share Buttons Footer -->
            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Bagikan Artikel Ini:</span>
                <div class="flex items-center gap-3">
                    <!-- WhatsApp Share -->
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . url()->current()) }}" 
                       target="_blank" 
                       class="px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-200 text-xs font-semibold hover:bg-emerald-500 hover:text-white transition flex items-center gap-1.5 shadow-2xs">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>WhatsApp</span>
                    </a>

                    <!-- Copy URL Button -->
                    <button type="button" 
                            @click="
                                navigator.clipboard.writeText('{{ url()->current() }}');
                                copied = true;
                                setTimeout(() => copied = false, 2000);
                            " 
                            class="px-4 py-2 rounded-2xl bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold hover:bg-slate-200 transition flex items-center gap-1.5 shadow-2xs relative cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span x-text="copied ? 'Tersalin!' : 'Salin Link'"></span>
                    </button>
                </div>
            </div>

        </article>

        <!-- RELATED ARTICLES SECTION -->
        @if($relatedArticles->count() > 0)
            <div class="space-y-6 pt-6">
                <h3 class="text-xl font-extrabold text-slate-900">Artikel Terkait Lainnya</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                        <article onclick="window.location.href='/article/{{ $rel->slug }}'" 
                                 class="group bg-white rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-lg hover:border-sky-300 transition duration-300 p-4 space-y-3 cursor-pointer">
                            <span class="text-[10px] font-bold text-[#1B5A7A] uppercase bg-sky-50 px-2 py-0.5 rounded-md">
                                {{ $rel->category }}
                            </span>
                            <h4 class="font-bold text-slate-900 text-sm group-hover:text-[#1B5A7A] transition-colors line-clamp-2">
                                {{ $rel->title }}
                            </h4>
                            <p class="text-[11px] text-slate-500 line-clamp-2">
                                {{ $rel->excerpt }}
                            </p>
                            <span class="text-[10px] font-bold text-[#1B5A7A] block pt-1">Baca Artikel ➔</span>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</div>
