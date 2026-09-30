<div class="flex items-center mr-2 sm:mr-3">
    <button type="button" 
            wire:click="clearCache" 
            wire:loading.attr="disabled"
            title="Bersihkan Cache Aplikasi (View, Config, Route, Cache)"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100/90 text-amber-800 border border-amber-200/80 text-xs font-bold shadow-xs transition duration-200 active:scale-95 cursor-pointer focus:outline-none focus:ring-2 focus:ring-amber-500">
        
        <!-- Normal State -->
        <span wire:loading.remove wire:target="clearCache" class="inline-flex items-center gap-1.5">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <span class="hidden sm:inline">Clear Cache</span>
        </span>

        <!-- Loading State -->
        <span wire:loading wire:target="clearCache" class="inline-flex items-center gap-1.5 text-amber-900">
            <svg class="w-4 h-4 text-amber-600 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="hidden sm:inline">Clearing...</span>
        </span>
    </button>
</div>
