<x-filament-panels::page>
    <form wire:submit="updatePassword" class="space-y-6">
        {{ $this->form }}

        <div class="flex items-center gap-3">
            <x-filament::button type="submit">
                Simpan Password Baru
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
