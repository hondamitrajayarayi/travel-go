<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, email, url, number
            $table->string('group')->default('general'); // contact, social, address, payment, general
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Seed default initial settings
        $defaultSettings = [
            // Group: Kontak
            [
                'key'         => 'whatsapp_number',
                'label'       => 'Nomor WhatsApp (Link)',
                'value'       => '6287887840636',
                'type'        => 'text',
                'group'       => 'Kontak',
                'description' => 'Format angka tanpa simbol/spasi untuk link wa.me (contoh: 6287887840636)',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'whatsapp_display',
                'label'       => 'Tampilan Nomor WhatsApp',
                'value'       => '+62 878-8784-0636',
                'type'        => 'text',
                'group'       => 'Kontak',
                'description' => 'Teks nomor telepon yang tampil di website',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'whatsapp_default_message',
                'label'       => 'Template Pesan WhatsApp',
                'value'       => 'Halo Admin Super Vacation, saya ingin konsultasi rencana perjalanan saya',
                'type'        => 'textarea',
                'group'       => 'Kontak',
                'description' => 'Pesan default saat pengunjung menekan tombol WhatsApp',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'email',
                'label'       => 'Alamat Email Resmi',
                'value'       => 'supervacationtour@gmail.com',
                'type'        => 'email',
                'group'       => 'Kontak',
                'description' => 'Alamat email yang ditampilkan di halaman kontak dan footer',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            // Group: Media Sosial
            [
                'key'         => 'instagram_url',
                'label'       => 'Link Akun Instagram',
                'value'       => 'https://instagram.com',
                'type'        => 'url',
                'group'       => 'Media Sosial',
                'description' => 'Tautan ke profil Instagram resmi',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'tiktok_url',
                'label'       => 'Link Akun TikTok',
                'value'       => 'https://tiktok.com',
                'type'        => 'url',
                'group'       => 'Media Sosial',
                'description' => 'Tautan ke profil TikTok resmi',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            // Group: Alamat & Operasional
            [
                'key'         => 'address',
                'label'       => 'Alamat Kantor',
                'value'       => 'Jl. Pahlawan Raya, Gg Galery No 5A, Cinangka, Sawangan, Depok, Jawa Barat, 16516',
                'type'        => 'textarea',
                'group'       => 'Alamat & Operasional',
                'description' => 'Alamat lengkap kantor fisik Super Vacation',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'operating_hours',
                'label'       => 'Jam Layanan / Operasional',
                'value'       => 'Senin – Minggu: 08.00 – 21.00 WIB',
                'type'        => 'text',
                'group'       => 'Alamat & Operasional',
                'description' => 'Waktu operasional layanan konsultasi dan kantor',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            // Group: Rekening Pembayaran
            [
                'key'         => 'bank_name',
                'label'       => 'Nama Bank',
                'value'       => 'Bank BCA',
                'type'        => 'text',
                'group'       => 'Rekening Bank',
                'description' => 'Nama bank untuk rekening resmi pembayaran',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'bank_account_name',
                'label'       => 'Atas Nama Rekening',
                'value'       => 'PT. BINTANG BUANA WISATA',
                'type'        => 'text',
                'group'       => 'Rekening Bank',
                'description' => 'Nama pemilik rekening resmi',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'bank_account_number',
                'label'       => 'Nomor Rekening',
                'value'       => '5910 844484',
                'type'        => 'text',
                'group'       => 'Rekening Bank',
                'description' => 'Nomor rekening bank tujuan transfer',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('settings')->insert($defaultSettings);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
