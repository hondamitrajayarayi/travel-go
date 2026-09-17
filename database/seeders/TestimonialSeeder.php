<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $stories = [
            [
                'name'       => 'Bapak Hendrawan & Ibu Maya',
                'tour_title' => 'Favorite Autumn in China (Beijing & Shanghai)',
                'trip_date'  => 'Oktober 2026',
                'rating'     => 5,
                'story'      => 'Pengalaman trip musim gugur ke Beijing & Shanghai bersama Super Vacation benar-benar di luar ekspektasi kami! Tour leader-nya sangat ramah, sabar membimbing orang tua, dan penjelasan pemandu lokalnya sangat detail. Makanan yang disajikan selalu lezat dan hotel bintang 5-nya nyaman sekali. Pasti akan ikut trip berikutnya!',
                'avatar'     => null,
                'photo'      => null,
                'is_active'  => true,
                'sort_order' => 1,
            ],
            [
                'name'       => 'dr. Kevin Pratama & Rekan',
                'tour_title' => 'Japan Golden Route & Mt. Fuji Experience',
                'trip_date'  => 'September 2026',
                'rating'     => 5,
                'story'      => 'Sangat puas dengan itinerary yang rapi dan tidak terburu-buru. Waktu bebas di Tokyo dan Kyoto sangat cukup untuk eksplor kuliner dan belanja. Pelayanan fast-response sejak pendaftaran sampai tiba kembali di Jakarta. Recommended travel partner!',
                'avatar'     => null,
                'photo'      => null,
                'is_active'  => true,
                'sort_order' => 2,
            ],
            [
                'name'       => 'Keluarga Ibu Ratna Sari',
                'tour_title' => 'Magical Turkey & Hot Air Balloon Cappadocia',
                'trip_date'  => 'Agustus 2026',
                'rating'     => 5,
                'story'      => 'Impian naik balon udara di Cappadocia akhirnya terwujud dengan lancar. Super Vacation mengurus semua kebutuhan visa, tiket, dan akomodasi tanpa ribet sama sekali. Momen sunrise di atas lembah Goreme tidak akan pernah kami lupakan!',
                'avatar'     => null,
                'photo'      => null,
                'is_active'  => true,
                'sort_order' => 3,
            ],
            [
                'name'       => 'Anindya Putri & Sahabat',
                'tour_title' => 'Autumn in Korea & Nami Island Romance',
                'trip_date'  => 'Oktober 2026',
                'rating'     => 5,
                'story'      => 'Trip pertama kali ke Korea bareng sahabat jadi sangat berkesan dan seru. Suasana daun musim gugur di Nami Island indah banget. Terima kasih tim Super Vacation sudah mengatur rute belanja dan spot foto yang estetik!',
                'avatar'     => null,
                'photo'      => null,
                'is_active'  => true,
                'sort_order' => 4,
            ],
            [
                'name'       => 'Bapak Suryadi & Istri',
                'tour_title' => 'West Europe Highlights 7 Countries',
                'trip_date'  => 'Juli 2026',
                'rating'     => 5,
                'story'      => 'Perjalanan keliling Eropa selama 12 hari terasa sangat menyenangkan dan tidak melelahkan. Bus pariwisatanya luas dan nyaman, jadwal selalu on-time, dan pilihan restorannya sangat variatif. Luar biasa profesional!',
                'avatar'     => null,
                'photo'      => null,
                'is_active'  => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($stories as $story) {
            Testimonial::updateOrCreate(
                ['name' => $story['name'], 'tour_title' => $story['tour_title']],
                $story
            );
        }
    }
}
