<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Concession;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Studios
        $studioDolby = Studio::create([
            'name' => 'Studio 1 (Dolby Atmos)',
            'type' => 'atmos',
            'total_rows' => 6, // A-F
            'total_cols' => 8, // 1-8
            'row_labels' => 'A,B,C,D,E,F',
            'extra_fee' => 5000,
        ]);

        $studioRegular = Studio::create([
            'name' => 'Studio 2 (Regular Classic)',
            'type' => 'regular',
            'total_rows' => 6,
            'total_cols' => 8,
            'row_labels' => 'A,B,C,D,E,F',
            'extra_fee' => 0,
        ]);

        $studioVIP = Studio::create([
            'name' => 'Studio 3 (VIP Premiere Lounge)',
            'type' => 'vip',
            'total_rows' => 4, // A-D
            'total_cols' => 6, // 1-6
            'row_labels' => 'A,B,C,D',
            'extra_fee' => 20000,
        ]);

        // 2. Seed Movies (Now Playing & Upcoming)
        $moviesData = [
            [
                'title' => 'Dune: Part Two',
                'slug' => 'dune-part-two',
                'synopsis' => 'Paul Atreides bersatu dengan Chani dan Fremen untuk membalas dendam terhadap para konspirator yang menghancurkan keluarganya, sembari berusaha mencegah masa depan kelam yang hanya ia yang bisa lihat.',
                'genre' => 'Sci-Fi, Petualangan, Aksi',
                'duration' => 166,
                'rating' => '13+',
                'director' => 'Denis Villeneuve',
                'cast' => 'Timothée Chalamet, Zendaya, Rebecca Ferguson, Javier Bardem',
                'poster_url' => 'dune-part-two.jpg',
                'backdrop_url' => null,
                'trailer_url' => 'https://www.youtube.com/watch?v=Way9Dexny3w',
                'status' => 'now_playing',
                'release_date' => Carbon::now()->subDays(5),
                'base_price' => 45000,
            ],
            [
                'title' => 'Agak Laen',
                'slug' => 'agak-laen',
                'synopsis' => 'Empat sekawan penjaga rumah hantu pasar malam yang terancam bangkrut mencari cara agar wahana mereka kembali ramai, hingga terjadi insiden tak terduga yang mengubah nasib mereka secara kocak sekaligus menegangkan.',
                'genre' => 'Komedi, Horor',
                'duration' => 119,
                'rating' => '13+',
                'director' => 'Muhadkly Acho',
                'cast' => 'Bene Dion, Boris Bokir, Indra Jegel, Oki Rengga',
                'poster_url' => 'agak-laen.jpg',
                'backdrop_url' => null,
                'trailer_url' => null,
                'status' => 'now_playing',
                'release_date' => Carbon::now()->subDays(10),
                'base_price' => 40000,
            ],
            [
                'title' => 'Godzilla x Kong: The New Empire',
                'slug' => 'godzilla-x-kong-the-new-empire',
                'synopsis' => 'Pertarungan epik berlanjut! Kong dan Godzilla harus bersatu menghadapi ancaman kolosal tersembunyi di dalam perut bumi yang mengancam kepunahan spesies mereka dan umat manusia.',
                'genre' => 'Aksi, Fiksi Ilmiah',
                'duration' => 115,
                'rating' => '13+',
                'director' => 'Adam Wingard',
                'cast' => 'Rebecca Hall, Brian Tyree Henry, Dan Stevens',
                'poster_url' => 'godzilla-x-kong.jpg',
                'backdrop_url' => null,
                'trailer_url' => null,
                'status' => 'now_playing',
                'release_date' => Carbon::now()->subDays(2),
                'base_price' => 45000,
            ],
            [
                'title' => 'Siksa Kubur',
                'slug' => 'siksa-kubur',
                'synopsis' => 'Setelah kedua orang tuanya menjadi korban bom bunuh diri, Sita tidak lagi percaya pada agama dan mencari orang paling berdosa untuk membuktikan bahwa siksa kubur itu tidak ada—dengan konsekuensi yang mengerikan.',
                'genre' => 'Horor, Misteri, Religi',
                'duration' => 120,
                'rating' => '17+',
                'director' => 'Joko Anwar',
                'cast' => 'Faradina Mufti, Reza Rahadian, Christine Hakim, Slamet Rahardjo',
                'poster_url' => 'siksa-kubur.jpg',
                'backdrop_url' => null,
                'trailer_url' => null,
                'status' => 'now_playing',
                'release_date' => Carbon::now()->subDays(7),
                'base_price' => 45000,
            ],
            [
                'title' => 'Bila Esok Ibu Tiada',
                'slug' => 'bila-esok-ibu-tiada',
                'synopsis' => 'Kisah penuh haru tentang perjuangan seorang ibu yang merawat keempat anaknya seorang diri, hingga masing-masing tumbuh dewasa dengan kesibukan sendiri dan lupa bahwa waktu bersama sang ibu semakin berharga.',
                'genre' => 'Drama, Keluarga',
                'duration' => 104,
                'rating' => 'SU',
                'director' => 'Rudy Soedjarwo',
                'cast' => 'Christine Hakim, Adinia Wirasti, Fedi Nuril, Amanda Manopo',
                'poster_url' => 'bila-ibu-besok-tiada.jpg',
                'backdrop_url' => null,
                'trailer_url' => null,
                'status' => 'now_playing',
                'release_date' => Carbon::now()->subDays(1),
                'base_price' => 40000,
            ],
            [
                'title' => 'Moana 2',
                'slug' => 'moana-2',
                'synopsis' => 'Moana menerima panggilan mendadak dari para leluhur penjelajahnya. Bersama Maui dan kru pelaut baru, ia harus berlayar ke laut lepas Oseania menuju perairan berbahaya yang telah lama hilang.',
                'genre' => 'Animasi, Petualangan, Keluarga',
                'duration' => 100,
                'rating' => 'SU',
                'director' => 'David G. Derrick Jr.',
                'cast' => 'Auli\'i Cravalho, Dwayne Johnson, Alan Tudyk',
                'poster_url' => 'moana-2.jpg',
                'backdrop_url' => null,
                'trailer_url' => null,
                'status' => 'upcoming',
                'release_date' => Carbon::now()->addDays(14),
                'base_price' => 45000,
            ],
            [
                'title' => 'Gladiator II',
                'slug' => 'gladiator-ii',
                'synopsis' => 'Bertahun-tahun setelah menyaksikan kematian pahlawan Maximus di tangan pamannya, Lucius harus memasuki Colosseum setelah rumahnya ditaklukkan oleh kaisar tiran Roma.',
                'genre' => 'Aksi, Drama, Sejarah',
                'duration' => 148,
                'rating' => '17+',
                'director' => 'Ridley Scott',
                'cast' => 'Paul Mescal, Pedro Pascal, Denzel Washington, Connie Nielsen',
                'poster_url' => 'gladiator-2.jpg',
                'backdrop_url' => null,
                'trailer_url' => null,
                'status' => 'upcoming',
                'release_date' => Carbon::now()->addDays(20),
                'base_price' => 50000,
            ],
            [
                'title' => 'Wicked',
                'slug' => 'wicked',
                'synopsis' => 'Kisah Elphaba, seorang wanita muda dengan kulit hijau yang disalahpahami, dan Glinda, gadis populer beruntung. Persahabatan mereka di Negeri Oz membimbing mereka ke takdir luar biasa sebagai Penyihir Jahat dari Barat dan Glinda si Baik.',
                'genre' => 'Musikal, Fantasi, Romantis',
                'duration' => 160,
                'rating' => 'SU',
                'director' => 'Jon M. Chu',
                'cast' => 'Cynthia Erivo, Ariana Grande, Jonathan Bailey, Jeff Goldblum',
                'poster_url' => 'wicked.jpg',
                'backdrop_url' => null,
                'trailer_url' => null,
                'status' => 'upcoming',
                'release_date' => Carbon::now()->addDays(28),
                'base_price' => 45000,
            ],
        ];

        $createdMovies = [];
        foreach ($moviesData as $data) {
            $createdMovies[] = Movie::create($data);
        }

        // 3. Seed Concessions (Popcorn, Snacks, Beverages, Combos)
        $concessionsData = [
            [
                'name' => 'Popcorn Caramel Jumbo',
                'category' => 'popcorn',
                'description' => 'Jagung meletup renyah dibalut saus karamel manis keemasan khas balihfilm. Porsi besar cocok dinikmati berdua.',
                'price' => 45000,
                'image_url' => 'popcorn-caramel.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Popcorn Salted Butter',
                'category' => 'popcorn',
                'description' => 'Popcorn asin gurih klasik dipadu mentega leleh hangat yang wangi dan renyah di setiap gigitan.',
                'price' => 40000,
                'image_url' => 'popcorn-butter.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Crispy Nachos & Warm Cheese Dip',
                'category' => 'snack',
                'description' => 'Tortilla chips renyah gurih dilengkapi semangkuk saus keju cheddar hangat yang creamy dan salsa pedas.',
                'price' => 38000,
                'image_url' => 'nachos.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'French Fries Crispy Garlic',
                'category' => 'snack',
                'description' => 'Kentang goreng renyah bumbu tabur bawang gurih, disajikan dengan saus sambal pedas & mayones.',
                'price' => 32000,
                'image_url' => 'french-fries.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Coca-Cola Zero Cold 600ml',
                'category' => 'beverage',
                'description' => 'Kesegaran soda dingin berkarbonasi tanpa gula dengan sensasi dingin menyegarkan tenggorokan.',
                'price' => 18000,
                'image_url' => 'coca-cola.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Iced Brown Sugar Milk Tea',
                'category' => 'beverage',
                'description' => 'Paduan teh hitam wangi dengan susu segar gurih dan legit manis gula aren murni.',
                'price' => 25000,
                'image_url' => 'milk-tea.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Mineral Water Pristine 600ml',
                'category' => 'beverage',
                'description' => 'Air mineral murni pH seimbang dingin dan menyegarkan.',
                'price' => 12000,
                'image_url' => 'mineral-water.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Combo Berdua Asik',
                'category' => 'combo',
                'description' => '1 Popcorn Caramel Jumbo + 2 Minuman Dingin (Coca-Cola / Brown Sugar Milk Tea). Hemat 15%!',
                'price' => 72000,
                'image_url' => 'combo-berdua.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Combo Solo Premiere',
                'category' => 'combo',
                'description' => '1 Popcorn Butter Regular + 1 Nachos Keju + 1 Minuman Dingin. Teman sempurna untuk nonton sendiri.',
                'price' => 85000,
                'image_url' => 'combo-solo.jpg',
                'is_available' => true,
            ],
        ];

        $createdConcessions = [];
        foreach ($concessionsData as $concession) {
            $createdConcessions[] = Concession::create($concession);
        }

        // 4. Seed Showtimes for Now Playing Movies across today and the next 2 days
        $studios = [$studioDolby, $studioRegular, $studioVIP];
        $nowPlayingMovies = array_values(array_filter($createdMovies, fn ($m) => $m->status === 'now_playing'));

        $timeSlots = ['12:30:00', '15:15:00', '18:00:00', '20:45:00'];
        $createdShowtimes = [];

        foreach ($nowPlayingMovies as $movieIndex => $movie) {
            // Give each movie showtimes on today, tomorrow, and day after tomorrow
            for ($dayOffset = 0; $dayOffset < 3; $dayOffset++) {
                $date = Carbon::today()->addDays($dayOffset)->toDateString();

                // Select studio based on movie
                $assignedStudio = $studios[$movieIndex % count($studios)];
                $calculatedPrice = $movie->base_price + $assignedStudio->extra_fee;

                // Create 2 to 3 showtimes per day
                $selectedSlots = ($movieIndex % 2 === 0)
                    ? [$timeSlots[0], $timeSlots[2], $timeSlots[3]]
                    : [$timeSlots[1], $timeSlots[3]];

                foreach ($selectedSlots as $slotTime) {
                    $createdShowtimes[] = Showtime::create([
                        'movie_id' => $movie->id,
                        'studio_id' => $assignedStudio->id,
                        'show_date' => $date,
                        'start_time' => $slotTime,
                        'price' => $calculatedPrice,
                    ]);
                }
            }
        }

        // 5. Seed sample bookings so some seats are occupied
        if (! empty($createdShowtimes)) {
            $firstShowtime = $createdShowtimes[0];

            $sampleBooking1 = Booking::create([
                'booking_code' => 'BF-202610-7412',
                'showtime_id' => $firstShowtime->id,
                'customer_name' => 'Dimas Pratama',
                'customer_email' => 'dimas@example.com',
                'customer_phone' => '081234567890',
                'seats' => ['C3', 'C4'],
                'seat_count' => 2,
                'ticket_price' => $firstShowtime->price,
                'ticket_subtotal' => $firstShowtime->price * 2,
                'snack_subtotal' => 72000,
                'total_amount' => ($firstShowtime->price * 2) + 72000,
                'payment_method' => 'QRIS',
                'payment_status' => 'confirmed',
                'barcode' => 'BF-202610-7412-QRIS',
            ]);

            BookingItem::create([
                'booking_id' => $sampleBooking1->id,
                'concession_id' => $createdConcessions[7]->id, // Combo Berdua Asik
                'quantity' => 1,
                'unit_price' => 72000,
                'subtotal' => 72000,
            ]);

            $sampleBooking2 = Booking::create([
                'booking_code' => 'BF-202610-9104',
                'showtime_id' => $firstShowtime->id,
                'customer_name' => 'Siti Rahma',
                'customer_email' => 'siti@example.com',
                'customer_phone' => '081987654321',
                'seats' => ['D4', 'D5', 'D6'],
                'seat_count' => 3,
                'ticket_price' => $firstShowtime->price,
                'ticket_subtotal' => $firstShowtime->price * 3,
                'snack_subtotal' => 45000,
                'total_amount' => ($firstShowtime->price * 3) + 45000,
                'payment_method' => 'BCA Virtual Account',
                'payment_status' => 'confirmed',
                'barcode' => 'BF-202610-9104-BCA',
            ]);

            BookingItem::create([
                'booking_id' => $sampleBooking2->id,
                'concession_id' => $createdConcessions[0]->id, // Popcorn Caramel Jumbo
                'quantity' => 1,
                'unit_price' => 45000,
                'subtotal' => 45000,
            ]);
        }
    }
}
