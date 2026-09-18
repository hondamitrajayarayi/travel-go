<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $seoSettings = [
            [
                'key'         => 'seo_home_title',
                'label'       => 'Judul Halaman Utama (Title Tag)',
                'value'       => 'Super Vacation – Paket Wisata & Open Trip Terpercaya',
                'type'        => 'text',
                'group'       => 'SEO',
                'description' => 'Judul halaman yang muncul di tab browser & hasil pencarian Google. Idealnya 50–60 karakter.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'seo_home_description',
                'label'       => 'Meta Description Halaman Utama',
                'value'       => 'Super Vacation menyediakan paket wisata dan open trip ke berbagai destinasi impian. Temukan paket terbaik dengan harga terjangkau dan pelayanan profesional.',
                'type'        => 'textarea',
                'group'       => 'SEO',
                'description' => 'Deskripsi singkat halaman yang muncul di bawah judul di hasil Google. Idealnya 120–160 karakter.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'seo_home_keywords',
                'label'       => 'Meta Keywords Halaman Utama',
                'value'       => 'paket wisata, open trip, tour murah, wisata halal, travel agent, umroh, liburan keluarga',
                'type'        => 'text',
                'group'       => 'SEO',
                'description' => 'Kata kunci SEO, dipisahkan koma. Contoh: paket wisata, open trip, tour murah',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'seo_site_name',
                'label'       => 'Nama Website (Site Name)',
                'value'       => 'Super Vacation',
                'type'        => 'text',
                'group'       => 'SEO',
                'description' => 'Nama resmi website yang ditampilkan di media sosial saat halaman dibagikan.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'seo_og_title',
                'label'       => 'Open Graph Title (Share WA/FB)',
                'value'       => 'Super Vacation – Paket Wisata & Open Trip Terpercaya',
                'type'        => 'text',
                'group'       => 'SEO',
                'description' => 'Judul yang muncul saat link website dibagikan di WhatsApp, Facebook, atau Twitter.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'seo_og_description',
                'label'       => 'Open Graph Description (Share WA/FB)',
                'value'       => 'Temukan paket wisata impian Anda bersama Super Vacation. Open trip dan private trip ke berbagai destinasi menarik dengan harga terjangkau.',
                'type'        => 'textarea',
                'group'       => 'SEO',
                'description' => 'Deskripsi yang muncul saat link website dibagikan di media sosial.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'seo_og_image',
                'label'       => 'Open Graph Image URL (Thumbnail Share)',
                'value'       => '',
                'type'        => 'url',
                'group'       => 'SEO',
                'description' => 'URL gambar (1200x630px) yang muncul sebagai thumbnail saat link dibagikan di WA/FB/Twitter. Bisa diisi link gambar dari Google Drive atau hosting lain.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'seo_robots',
                'label'       => 'Robots Meta Tag',
                'value'       => 'index, follow',
                'type'        => 'text',
                'group'       => 'SEO',
                'description' => 'Instruksi untuk mesin pencari. Gunakan "index, follow" agar halaman diindeks, atau "noindex, nofollow" untuk menyembunyikan dari Google.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        // Hanya insert jika belum ada (safe untuk re-run)
        foreach ($seoSettings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keys = [
            'seo_home_title',
            'seo_home_description',
            'seo_home_keywords',
            'seo_site_name',
            'seo_og_title',
            'seo_og_description',
            'seo_og_image',
            'seo_robots',
        ];

        DB::table('settings')->whereIn('key', $keys)->delete();
    }
};
