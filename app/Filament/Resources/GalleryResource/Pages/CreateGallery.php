<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Models\Gallery;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGallery extends CreateRecord
{
    protected static string $resource = GalleryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Override the default single-record creation.
     * Process the repeater items and create one Gallery per item.
     */
    protected function handleRecordCreation(array $data): Model
    {
        $category       = $data['category'] ?? null;
        $documentations = $data['documentations'] ?? [];

        // Strip internal helper fields
        unset($data['_country_has_data']);

        $created    = [];
        $lastRecord = null;

        foreach ($documentations as $doc) {
            $lastRecord = Gallery::create([
                'category'    => $category,
                'title'       => $doc['title'] ?? '',
                'destination' => $doc['destination'] ?? null,
                'images'      => $doc['images'] ?? [],
                'image_path'  => isset($doc['images']) && is_array($doc['images']) ? ($doc['images'][0] ?? null) : null,
                'is_featured' => $doc['is_featured'] ?? false,
                'is_active'   => $doc['is_active'] ?? true,
            ]);

            $created[] = $lastRecord;
        }

        $count = count($created);

        if ($count > 0) {
            Notification::make()
                ->success()
                ->title("{$count} dokumentasi berhasil disimpan")
                ->body("Dokumentasi untuk negara \"{$category}\" telah berhasil ditambahkan.")
                ->send();
        }

        // Return a dummy record if nothing was created (shouldn't happen)
        return $lastRecord ?? Gallery::create([
            'category' => $category,
            'title'    => '-',
        ]);
    }
}
