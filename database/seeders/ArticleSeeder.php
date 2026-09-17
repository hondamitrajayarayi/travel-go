<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title'        => 'Panduan Lengkap Syarat & Cara Pengajuan Visa Jepang Terbaru 2026',
                'slug'         => 'panduan-lengkap-syarat-cara-pengajuan-visa-jepang-2026',
                'category'     => 'Info Visa',
                'thumbnail'    => null,
                'excerpt'      => 'Ingin liburan ke Jepang? Simak panduan komprehensif mengenai persyaratan dokumen, bebas visa e-paspor, dan tips agar visa disetujui.',
                'content'      => '<p>Liburan ke Jepang adalah impian banyak wisatawan Indonesia. Mulai dari keindahan bunga Sakura di musim semi hingga megahnya Gunung Fuji, Jepang menawarkan pengalaman yang tak terlupakan.</p><h3>1. Paspor & E-Paspor Bebas Visa</h3><p>Bagi pemegang e-paspor Indonesia (paspor elektronik), Anda bisa mengajukan registrasi bebas visa (Visa Waiver) yang berlaku selama 3 tahun atau hingga masa berlaku paspor habis.</p><h3>2. Dokumen Persyaratan Visa Regulary</h3><p>Bagi pemegang paspor biasa (non-elektronik), beberapa dokumen utama yang wajib disiapkan adalah:</p><ul><li>Paspor asli yang masih berlaku minimal 6 bulan</li><li>Formulir permohonan visa yang sudah diisi lengkap</li><li>Pasfoto terbaru ukuran 4.5 x 3.5 cm latar belakang putih</li><li>Fotokopi KTP & Kartu Keluarga (KK)</li><li>Rekening koran 3 bulan terakhir dengan saldo mencukupi</li><li>Itinerary / jadwal perjalanan selama di Jepang</li></ul><h3>3. Waktu Pembuatan & Tips Lolos Visa</h3><p>Proses pengajuan visa biasa membutuhkan waktu 4 - 5 hari kerja di Japan Visa Application Center (JVAC). Pastikan seluruh data keuangan transparan dan konsisten dengan durasi liburan Anda.</p>',
                'author'       => 'Tim Visa Super Vacation',
                'reading_time' => '6 min baca',
                'published_at' => now()->subDays(2),
                'is_published' => true,
                'views_count'  => 1420,
            ],
            [
                'title'        => '7 Tips Persiapan Pertama Kali Mengikuti Open Trip Luar Negeri',
                'slug'         => '7-tips-persiapan-pertama-kali-mengikuti-open-trip-luar-negeri',
                'category'     => 'Tips Tour',
                'thumbnail'    => null,
                'excerpt'      => 'Mengikuti Open Trip adalah pilihan tepat untuk liburan hemat dan menambah teman baru. Ini 7 hal wajib yang harus Anda perhatikan.',
                'content'      => '<p>Open Trip merupakan tren perjalanan yang makin populer di kalangan solo traveler maupun grup kecil. Selain lebih praktis karena itinerary sudah diatur profesional, biaya perjalanan juga jauh lebih ekonomis.</p><h3>1. Pilih Tour Operator Terpercaya</h3><p>Pastikan agen travel memiliki rekam jejak legalitas jelas dan ulasan positif dari peserta sebelumnya.</p><h3>2. Pelajari Fasilitas Include & Exclude</h3><p>Periksa dengan cermat apa saja yang sudah termasuk dalam harga paket, seperti tiket pesawat, hotel, makan, tiket masuk wisata, dan uang tip tour guide.</p><h3>3. Bawa Pakaian Sesuai Musim</h3><p>Cek prakiraan cuaca negara tujuan. Apabila bepergian saat Musim Dingin (Winter), persiapkan jaket thermal, thermal inner, dan sarung tangan.</p><h3>4. Gunakan Asuransi Perjalanan</h3><p>Asuransi perjalanan internasional sangat krusial untuk mengantisipasi risiko penundaan penerbangan, kehilangan bagasi, atau kondisi medis mendadak.</p>',
                'author'       => 'Travel Specialist',
                'reading_time' => '5 min baca',
                'published_at' => now()->subDays(5),
                'is_published' => true,
                'views_count'  => 980,
            ],
            [
                'title'        => 'Aturan & Persyaratan Visa Schengen untuk Keliling Eropa',
                'slug'         => 'aturan-persyaratan-visa-schengen-untuk-keliling-eropa',
                'category'     => 'Info Visa',
                'thumbnail'    => null,
                'excerpt'      => 'Menjelajahi Prancis, Swiss, hingga Italia cukup menggunakan 1 visa Schengen. Pelajari tips pengajuannya agar disetujui dengan cepat.',
                'content'      => '<p>Visa Schengen membuka akses ke 27 negara anggota di benua Eropa tanpa perlu pemeriksaan perbatasan berulang kali. Ini panduan cara mengajukannya.</p><h3>Negara Mana Tempat Mengajukan Visa Schengen?</h3><p>Aturan utamanya adalah Anda harus mengajukan visa di kedutaan negara tempat Anda menginap paling lama (*main destination*). Jika durasinya sama, ajukan di negara tempat Anda pertama kali mendarat.</p><h3>Dokumen Keuangan yang Kuat</h3><p>Kedutaan Eropa menekankan bukti keuangan yang stabil. Rekening koran 3-6 bulan terakhir wajib menunjukkan transaksi rutin yang sehat.</p>',
                'author'       => 'Tim Visa Super Vacation',
                'reading_time' => '7 min baca',
                'published_at' => now()->subDays(8),
                'is_published' => true,
                'views_count'  => 2100,
            ],
            [
                'title'        => 'Musim Terbaik Mengunjungi Korea Selatan: Spring vs Autumn',
                'slug'         => 'musim-terbaik-mengunjungi-korea-selatan-spring-vs-autumn',
                'category'     => 'Panduan Travel',
                'thumbnail'    => null,
                'excerpt'      => 'Bingung memilih antara bunga Sakura di Musim Semi atau dedaunan merah di Musim Gugur Korea Selatan? Simak perbandingannya di sini.',
                'content'      => '<p>Korea Selatan memikat dengan keindahan 4 musimnya. Namun dua musim yang paling dicintai wisatawan Indonesia adalah Spring (Musim Semi) dan Autumn (Musim Gugur).</p><h3>Musim Semi (Spring): April - Mei</h3><p>Udara sejuk dengan suhu 10-18°C. Pemandangan hamparan bunga Cherry Blossom di Namsan Park dan Yeouido Park menjadi daya tarik utama.</p><h3>Musim Gugur (Autumn): September - November</h3><p>Langit biru cerah dengan dedaunan ginkgo kuning keemasan dan maple merah di Nami Island serta Gyeongbokgung Palace.</p>',
                'author'       => 'Destination Expert',
                'reading_time' => '4 min baca',
                'published_at' => now()->subDays(12),
                'is_published' => true,
                'views_count'  => 1650,
            ],
        ];

        foreach ($articles as $art) {
            Article::updateOrCreate(['slug' => $art['slug']], $art);
        }
    }
}
